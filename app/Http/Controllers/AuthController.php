<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest\LoginRequest;
use App\Http\Requests\AuthRequest\RegisterUserRequest;
use App\Repositories\User\UserRepositoryInterface;
use App\Traits\ApiResponseTrait;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    use ApiResponseTrait;
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (!$token = JWTAuth::attempt($credentials)) {
            return $this->apiResponse(null, 'Tên đăng nhập hoặc mật khẩu không đúng', 401);
        }

        return $this->apiResponse($token, 'Đăng nhập thành công', 200);
    }

    public function refresh()
    {
        $newToken = JWTAuth::parseToken()->refresh();
        return $this->apiResponse($newToken, 'Làm mới token thành công', 200);
    }

    public function profile()
    {

        $user = auth()->user();

        return $this->apiResponse($user, 'Lấy thông tin người dùng thành công', 200);
    }

    public function logout()
    {
        auth()->logout();
        return $this->apiResponse(null, 'Đăng xuất thành công', 200);
    }
}
