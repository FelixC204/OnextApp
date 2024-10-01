<?php

namespace App\Repositories;

use App\Repositories\InterfaceRepositories\BaseRepositoryInterface;

class BaseRepository implements BaseRepositoryInterface
{

    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function create(array $data)
    {
        return $this->model->create($data);   
    }

    public function update($id, array $attributes)
    {
        $record = $this->model->find($id);
        $record->update($attributes);
        return $record;
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function findBy($field, $value)
    {
        return $this->model->where($field, $value)->first();
    }

}
