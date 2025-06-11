<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest\RegisterUserRequest;
use App\Http\Requests\UserRequest\UpdateUserRequest;
use App\Http\Requests\UserRequest\UserFilterRequest;
use App\Repositories\User\UserRepositoryInterface;
use App\Traits\ApiResponseTrait;

class UsersController extends Controller
{
    use ApiResponseTrait;
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(UserFilterRequest $request)
    {
        $filters = $request->only(['search']);

        $users = $this->userRepository->getAll($filters);

        return $this->apiResponse($users, 'Lấy danh sách người dùng', 200);
    }

    public function register(RegisterUserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($request->password);
        $user = $this->userRepository->create($data);
        return $this->apiResponse($user, 'Tạo tài khoản thành công', 201);
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

    public function show($id)
    {
        $user = $this->userRepository->find($id);

        if (!$user) {
            return $this->apiResponse(null, 'Không tìm thấy người dùng', 404);
        }

        $user->load('projects');

        return $this->apiResponse($user, 'Lấy thông tin người dùng thành công', 200);
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $data = $request->validated();
        $user = $this->userRepository->update($id, $data);
        return $this->apiResponse($user, 'Cap nhật người dùng thành công', 200);
    }
}
