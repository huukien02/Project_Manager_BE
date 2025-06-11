<?php

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    public function create(array $data)
    {
        return User::create($data);
    }

    public function getAll(array $filters)
    {
        $query = User::query();

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('username', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('name', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('email', 'like', '%' . $filters['search'] . '%');
            });
        }

        return $query->paginate(5);
    }

    public function find($id)
    {
        return User::find($id);
    }

    public function update($id, array $data)
    {
        $user = User::find($id);
        if ($user) {
            $user->update($data);
            return $user;
        }
        return null;
    }

    public function delete($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return true;
        }
        return false;
    }
}
