<?php

namespace App\Components\DB;


use Illuminate\Support\Facades\DB;

class Builder extends \Illuminate\Database\Eloquent\Builder
{
    public function addWhereCondition(array $fields, array $filter = [], array $filterHelper = []) {
        $datesArray = $fields['dates'] ?? [];
        $numbersArray = $fields['numbers'] ?? [];
        $stringsArray = $fields['strings'] ?? [];

        foreach ($stringsArray as $field) {
            if (isset($filter[$field])) {
                $this->where($field, '=', $filter[$field]);
            }
        }

        foreach ($numbersArray as $field) {
            if (isset($filterHelper[$field]['exp'])) {
                if ($filterHelper[$field]['exp'] === 'range') {
                    if (isset($filterHelper[$field]['min'])) {
                        $this->where($field, '>=', $filterHelper[$field]['min']);
                    }
                    if (isset($filterHelper[$field]['max'])) {
                        $this->where($field, '<=', $filterHelper[$field]['max']);
                    }
                } else {
                    $this->where($field, $filterHelper[$field]['exp'], $filter[$field]);
                }
            } elseif (isset($filter[$field])) {
                $this->where($field, '=', $filter[$field]);
            }
        }

        foreach ($datesArray as $field) {
            if (isset($filterHelper[$field]['exp'])) {
                if ($filterHelper[$field]['exp'] === 'range') {
                    if (isset($filterHelper[$field]['min'])) {
                        $this->where(DB::raw('DATE('.$field.')'), '>=', $filterHelper[$field]['min']);
                    }
                    if (isset($filterHelper[$field]['max'])) {
                        $this->where(DB::raw('DATE('.$field.')'), '<=', $filterHelper[$field]['max']);
                    }
                } else {
                    $this->where(DB::raw('DATE('.$field.')'), $filterHelper[$field]['exp'], $filter[$field]);
                }
            } elseif (isset($filter[$field])) {
                $this->where(DB::raw('DATE('.$field.')'), '=', $filter[$field]);
            }
        }
    }
}