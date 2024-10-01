<?php 

namespace App\Repositories\InterfaceRepositories;

interface BaseRepositoryInterface
{
    public function all();

    public function create(array $data);

    public function update($id,array $attributes);

    public function delete($id);

    public function findBy($field, $value);
}

