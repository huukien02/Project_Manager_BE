<?php

namespace App\Exceptions;

use App\Traits\ApiResponseTrait;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    use ApiResponseTrait;

    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ValidationException) {
            return $this->apiResponse(null, 'Dữ liệu không hợp lệ', 422, $exception->errors());
        }

        if ($exception instanceof AuthenticationException) {
            return $this->apiResponse(null, 'Chưa xác thực người dùng', 401);
        }

        if ($exception instanceof AuthorizationException) {
            return $this->apiResponse(null, 'Không có quyền truy cập', 403);
        }

        if ($exception instanceof HttpException) {
            return $this->apiResponse(null, $exception->getMessage(), $exception->getStatusCode(), []);
        }

        if ($exception instanceof QueryException) {
            return $this->apiResponse(null, 'Lỗi truy vấn cơ sở dữ liệu', 500, [
                'error' => $exception->getMessage()
            ]);
        }

        return $this->apiResponse(null, 'Lỗi hệ thống', 500, ['error' => $exception->getMessage()]);
    }

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return response()->json([
            'message' => 'Token không hợp lệ hoặc đã hết hạn',
        ], 401);
    }
}
