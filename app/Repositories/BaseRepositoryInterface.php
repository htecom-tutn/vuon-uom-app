<?php

namespace App\Repositories;

interface BaseRepositoryInterface
{
    /**
     * @param $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data);

    /**
     * @param int $id
     * @return mixed
     */
    public function delete(int $id);

    public function all(array $fields = ['*']);
    public function find(int $id, array $relationships = []);
    public function findOrFail(int $id);        
    public function updateOrCreate(array $condition, array $data);    
    public function findBy(string $column, $option);
    public function findByCondition(array $condition);
    public function removeNotExistColumns($input);
    public function getTableColumns();
    public function createMultiple(array $input);
    public function whereIn($field, $value);
    public function with($relationships);
    public function select($column);
    public function whereNotNull($column);
}