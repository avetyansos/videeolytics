<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Analytics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AnalyticsController extends Controller
{
    protected function validator(array $data, array $extraRules = []) {
        $id = $data['id'] ?? null;

        $rules = [
            'sessionId' => ['bail', 'required', 'string', 'min:32', 'max:128', Rule::unique('analytics')->ignore($id)],
            'userIdentifier' => ['bail', 'required', 'string', 'min:3', 'max:255'],
            'startTime' => [
                'bail',
                'required',
                function($attribute, $value, $fail) {
                    $message = null;
                    if (strlen($value) > 10) {
                        $value /= 1000;
                    }
                    if ($value - 86400 >= microtime(true)) {
                        $message = 'Invalid startTime provided.';
                    }

                    return $message ? $fail($message) : null;
                }
            ],
            'duration' => ['bail', 'required', 'integer'],
            'deviceInfo' => ['bail', 'required', 'array'],

            'deviceInfo.deviceId' => ['bail', 'required', 'string'],
            'deviceInfo.deviceModel' => ['bail', 'required', 'string'],
            'deviceInfo.platform' => ['bail', 'required', 'string', 'in:ios,android'],
            'deviceInfo.osVersion' => ['bail', 'required', 'string'],


            // TODO check if video.mp4 and events.json files are exists in CDN
            'video' => [
                function($attribute, $value, $fail) {
                    $message = 'File video.mp4 can not be found for sessionId.';
                    //return $message ? $fail($message) : null;
                },
            ],
            'events' => [
                function($attribute, $value, $fail) {
                    $message = 'File events.json can not be found for sessionId.';
                    //return $message ? $fail($message) : null;
                },
            ],

            'crash' => ['array'],
        ];

        $rules = array_merge($rules, $extraRules);

        //var_dump($rules);die;

        return Validator::make($data, $rules, [
            'deviceInfo.platform.in' => 'deviceInfo.platform can be only ios or android.'
        ]);
    }
    
    public function store(Request $request) {
        /** @var Analytics $model */
        $model = Analytics::getModel();
        $data = $request->all();

        $data['video'] = $data['sessionId'] ?? null;
        $data['events'] = $data['sessionId'] ?? null;

        $validator = $this->validator($data);
        if ($validator->passes()) {
            if ($model->fill($data)->save()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data saved successfully.',
                ], 201);
            } else {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Failed to store data. Try again later',
                    'errors' => []
                ], 500);
            }
        } else {
            return response()->json([
                'status' => 'fail',
                'message' => 'Invalid request.',
                'errors' => $validator->errors()
            ], 400);
        }


    }
}