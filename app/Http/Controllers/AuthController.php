<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest\LoginRequest;
use App\Http\Requests\AuthRequest\RegisterUserRequest;
use App\Repositories\User\UserRepositoryInterface;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(RegisterUserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($request->password);
        $user = $this->userRepository->create($data);

        return $this->apiResponse($user, 'Tạo tài khoản thành công', 201);
    }


    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (!$token = JWTAuth::attempt($credentials)) {
            return $this->apiResponse(null, 'Tên đăng nhập hoặc mật khẩu không đúng', 401);
        }

        return $this->apiResponse($token, 'Đăng nhập thanh cong', 200);
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

    public function destroy($id)
    {
        $user = $this->userRepository->find($id);

        if (!$user) {
            return  $this->apiResponse(null, 'Người dùng không tồn tại', 404);
        }

        if ($user->role === 'admin') {
            return  $this->apiResponse(null, 'Bạn không thể xóa Admin khác', 403);
        }

        $this->userRepository->delete($id);
        return $this->apiResponse(null, 'Xóa người dùng thành công', 200);
    }

    public function index()
    {
        $users = $this->userRepository->getAll();
        return $this->apiResponse($users, 'Lấy danh sách người dùng', 200);
    }

    public function show($id)
    {
        $user = $this->userRepository->find($id);
        return $this->apiResponse($user, 'Lấy thông tin người dùng thành công', 200);
    }
}
