<?php

namespace App\Repositories\User;

interface UserRepositoryInterface
{
    public function create(array $data);
    public function getAll();
    public function find($id);
    public function update($id, array $data);
    public function delete($id);
}
