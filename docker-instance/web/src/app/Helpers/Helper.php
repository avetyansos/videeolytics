<?php

namespace App\Helpers;


use App\Components\DB\Model;

class Helper
{
    /**
     * @param Model[]|\Illuminate\Database\Eloquent\Collection $models
     * @param string|null|false $keyName
     * @param string|null|false $valName
     *
     * @return array
     */
    public static function listData($models, $keyName = 'id', $valName = null) {
        $result = [];
        foreach ($models as $model) {
            $value = null;
            if ($valName) {
                if (is_string($valName) && (isset($model->$valName) || property_exists($model, $valName))) {
                    $value = $model->$valName;
                } elseif (is_callable($valName)) {
                    $value = $valName($model);
                }
            } else {
                $value = $model;
            }

            if ($keyName) {
                $result[$model->$keyName] = $value;
            } else {
                $result[] = $value;
            }
        }
        return $result;
    }

}