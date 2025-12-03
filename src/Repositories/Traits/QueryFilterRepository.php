<?php

namespace Txsoura\Core\Repositories\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait QueryFilterRepository
{
    public function checkDateColumns()
    {
        if (in_array($this->request['date_column'], $this->allow_between_dates)) {
            return true;
        }

        return false;
    }

    public function checkValueColumns()
    {
        if (in_array($this->request['value_column'], $this->allow_between_values)) {
            return true;
        }

        return false;
    }

    public function checkQueryColumns()
    {
        if (in_array($this->request['q'], $this->allow_like)) {
            return true;
        }

        return false;
    }

    public function checkSortColumns($columns)
    {
        foreach ($columns as $column) {
            if (Str::contains($column, '-')) {
                $column = substr($column, 1);
            }

            if (!in_array($column, $this->allow_order)) {
                return false;
            }
        }

        return true;
    }

    public function checkIncludeColumns()
    {
        $columns = explode(',', $this->request['include']);

        foreach ($columns as $column) {

            if (!in_array($column, $this->possibleRelationships)) {
                return false;
            }
        }
        return true;
    }

    public function checkWhereColumns()
    {
        $columns = [];

        foreach (array_keys($this->request) as $column) {
            if (in_array($column, $this->allow_where)) {
                Arr::set($columns, $column, $this->request[$column]);
            }
        }

        return $columns;
    }

    public function checkBooleanColumns()
    {
        $columns = [];

        foreach (array_keys($this->request) as $column) {
            if (in_array($column, $this->allow_boolean)) {
                Arr::set($columns, $column, $this->request[$column]);
            }
        }

        return $columns;
    }
}

