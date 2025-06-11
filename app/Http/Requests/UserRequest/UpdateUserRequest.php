<?php

namespace App\Http\Requests\UserRequest;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $userId = $this->route('id');

        return [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $userId,
            'email' => 'required|email|unique:users,email,' . $userId,
            'password' => 'nullable|string|min:6',
            'role' => 'in:user,admin',
        ];
    }
}
