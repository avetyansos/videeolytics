<?php

namespace App\Models;

use App\Components\DB\Model;
use App\Helpers\Helper;

class Analytics extends Model
{
    protected $fillable = [
        'sessionId',
        'userIdentifier',
        'startTime',
        'duration',
        'deviceId',
        'deviceModel',
        'platform',
        'osVersion',
        'crash',

        'deviceInfo', // to set deviceInfo will trigger setDeviceInfoAttribute method which will set proper attributes
    ];

    protected $casts = [
        'crash' => 'array',
    ];

    protected $dates = [
        'startTime',
        'created_at',
        'updated_at',
    ];

    public function setDeviceInfoAttribute($data) {
        if (is_array($data)) {
            foreach ($data as $attr => $val) {
                if ($this->isFillable($attr)) {
                    $this->attributes[$attr] = $val;
                }
            }

        }

        return $this;
    }

    public function setStartTimeAttribute($data) {
        if (ctype_digit($data) && strlen($data) > 10) {
            $data = (int) ($data/1000);
        }
        $data = $this->fromDateTime($data);
        $this->attributes['startTime'] = $data;

        return $this;
    }

    public function getVideoAttribute() {
        if (!isset($this->attributes['video'])) {
            $path = str_finish(env('CDN_HOST'), '/') . $this->sessionId . '/video.mp4';
            $this->attributes['video'] = (Helper::isUriExists($path) ? $path : false);
        }
        return $this->attributes['video'];
    }

    public function getEventsAttribute() {
        if (!isset($this->attributes['events'])) {
            $path = str_finish(env('CDN_HOST'), '/') . $this->sessionId . '/events.json';
            if (!Helper::isUriExists($path)) {
                $this->attributes['events'] = false;
            } else {
                $data = $this->fromJson(file_get_contents($path) ?? '');
                $this->attributes['events'] = ($data ? $data : []);
            }
        }
        return $this->attributes['events'];
    }

}
