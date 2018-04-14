<?php

namespace App\Components\DB;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Class Model
 *
 * @mixin \Eloquent
 */
class Model extends \Illuminate\Database\Eloquent\Model
{
    protected $beforeSaveAttributes = [];

    public static function boot() {
        parent::boot();

        self::saving(function($model) {
            /** @var self $model */
            // keep current attributes and clear model to save in DB
            $model->beforeSaveAttributes = $model->getAttributes();
            $model->attributes = $model->intersectWithColumns($model->beforeSaveAttributes);
        });

        self::saved(function($model) {
            /** @var self $model */
            // revert back model after saving
            $model->setAttributes($model->beforeSaveAttributes);
            $model->beforeSaveAttributes = [];
        });
    }

    public function newEloquentBuilder($query) {
        return new Builder($query);
    }

    protected function newBaseQueryBuilder() {
        $connection = $this->getConnection();

        return new QueryBuilder(
            $connection, $connection->getQueryGrammar(), $connection->getPostProcessor()
        );
    }

    public function newCollection(array $models = []) {
        return new Collection($models);
    }

    public function getValidationRules($scenario = 'save') {
        return [];
    }

    public function getTable($withPrefix = false) {
        $table = parent::getTable();
        return $withPrefix ? DB::getTablePrefix().$table : $table;
    }

    public function setAttributes(array $attributes) {
        foreach ($attributes as $key => $value) {
            $this->setAttribute($key, $value);
        }

        return $this;
    }

    public function getColumns() {
        return Schema::getColumnListing($this->getTable());
    }

    public function intersectWithColumns(array $params, $filterNull = true) {
        if ($filterNull) {
            $params = array_filter($params, function($item) {
                return $item !== null;
            });
        }
        return array_intersect_key($params, array_flip($this->getColumns()));
    }

    public function checkColumn($column, $default = null, $columns = null) {
        if (!$columns) {
            $columns = $this->getColumns();
        }
        return in_array($column, $columns) ? $column : $default;
    }

}
