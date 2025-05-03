<?php

namespace App\Http\Requests\AuthRequest;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'in:user,admin',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên không được để trống',
            'username.required' => 'Tên đăng nhập không được để trống',
            'email.required' => 'Email không được để trống',
            'password.required' => 'Mật khẩu không được để trống',
            'role.in' => 'Vai trò không hợp lệ',
        ];
    }
}
