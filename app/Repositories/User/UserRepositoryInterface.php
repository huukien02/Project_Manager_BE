<?php

namespace App\Repositories\User;

interface UserRepositoryInterface
{
    public function create(array $data);
    public function getAll(array $filters);
    public function find($id);
    public function update($id, array $data);
    public function delete($id);
}
