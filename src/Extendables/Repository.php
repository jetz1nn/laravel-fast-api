<?php

namespace Mathaus\LaravelFastApi\Extendables;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

abstract class Repository {

    private $model;
    private $query;

    protected $filter_map = [];
    protected $bigger_equal = [];
    protected $less_equal = [];
    protected $in_filter = [];


    public function __construct(Model $model) {
        $this->model = $model;
    }

    public function applyCustomFilters(array $filters) {

    }

    public function filterExists($filter): bool {
        return in_array($filter, array_keys($this->filter_map)) ||
            in_array($filter, Schema::getColumnListing($this->model->getTable()));
    }

    public function find(int $id, array $relationships = []) {
        $this->query = $this->model->newQuery();
        $this->query->with($relationships);
        return $this->query->find($id);
    }

    public function findMany(array $filters = [], array $relationships = []) {
        $this->query = $this->model->newQuery();
        $this->query->with($relationships);
        $this->applyFilters($filters);
        $this->applyCustomFilters($filters);

        return $this->query->get();


    }

    public function dd(array $filters, array $relationships = []) {
        $this->query = $this->model->newQuery();
        $this->query->with($relationships);
        $this->applyFilters($filters);
        $this->applyCustomFilters($filters);

        return $this->query->dd();

    }

    public function applyFilters(array $filters) {

        foreach ($filters as $filter => $filter_value) {

            if (!$this->filterExists($filter)) {
                continue;
            }

            $filter_name = in_array($filter, array_keys($this->filter_map)) ? $this->getTableName() . "." .
                $this->filter_map[$filter] :
                $this->getTableName() . "." . $filter;

            if (in_array($filter, $this->bigger_equal)) {
                $this->query->where($filter_name, ">=", $filter_value);
                continue;
            }

            if (in_array($filter, $this->less_equal)) {
                $this->query->where($filter_name, "<=", $filter_value);
                continue;
            }

            if (in_array($filter, $this->in_filter)) {
                $this->query->whereIn($filter_name, $filter_value);
                continue;
            }

            $this->query->where($filter_name, "=", $filter_value);

        }
    }

    public function getTableName() {
        return with(new $this->model)->getTable();
    }


    public function destroy(int $id) {
        return $this->model::destroy($id);
    }

    public function storeOrUpdate(array $data, $id = null) {

        if (is_null($id)) {
            $model = new ($this->model);
        } else {
            $model = $this->model->find($id);
        }

        $model->fill($data);

        $model->save();

        return $model;
    }
}
