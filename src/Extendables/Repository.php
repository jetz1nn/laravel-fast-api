<?php

namespace Mathaus\LaravelFastApi\Extendables;

use Illuminate\Database\Eloquent\Model;

abstract class Repository {

    private $model;
    private $query;

    protected $filter_map = [];
    protected $bigger_equal = [];
    protected $less_equal = [];

    public function __construct(Model $model) {
        $this->model = $model;
    }

    public function applyCustomFilters(array $filters) {

    }

    public function find(int $id) {
        return $this->model->find($id);
    }

    public function findMany(array $filters, array $relationships = []) {
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
        dump($this->filter_map, array_keys($this->filter_map));
        foreach ($filters as $filter => $filter_value) {
            dump(array_key_exists($filter, array_keys($this->filter_map)), $this->filter_map[$filter], $filter);
            $filter_name = array_key_exists($filter, array_keys($this->filter_map)) ? $this->filter_map[$filter] : $filter;

            if (in_array($filter, $this->bigger_equal)) {
                $this->query->where($this->filter_map[$filter], ">=", $filter_value);
                continue;
            }

            if (in_array($filter, $this->less_equal)) {
                $this->query->where($this->filter_map[$filter], "<=", $filter_value);
                continue;
            }

            $this->query->where($filter, "=", $filter_value);

        }
    }


}
