<?php

namespace App\Models;

use App\Components\DB\Model;

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
}
