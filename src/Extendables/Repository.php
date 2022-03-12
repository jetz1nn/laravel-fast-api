<?php

namespace Mathaus\LaravelFastApi\Extendables;

use Illuminate\Database\Eloquent\Model;

abstract class Repository {

    private $model;
    private $query;

    private array $filter_map = [];
    private array $bigger_equal = [];
    private array $less_equal = [];

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

    public function applyFilters(array $filters) {

        foreach ($filters as $filter => $filter_value) {

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