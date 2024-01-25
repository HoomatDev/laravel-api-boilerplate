<?php

namespace App\Exceptions;

use Hoomat\Base\App\Http\Controllers\Controller;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;


class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (Throwable $th, $request) {
            if ($request->is('api/*')) {

                if ($th instanceof ValidationException) {
                    return (new Controller())->errorResponse(
                        [], 400, $th->getMessage()
                    );
                }

                if ($th instanceof AuthenticationException) {
                    return (new Controller())->errorResponse(
                        [], 401, 'لطفا ابتدا به حساب کاربری خود وارد شوید!'
                    );
                }

                if ($th instanceof AccessDeniedHttpException) {
                    return (new Controller())->errorResponse(
                        [], 403, 'شما دسترسی لازم برای انجام این عملیات را ندارید!'
                    );
                }

                if ($th instanceof NotFoundHttpException) {
                    return (new Controller())->errorResponse(
                        [], 404, 'یافت نشد!'
                    );
                }

                return (new Controller())->errorResponse(
                    ['message' => $th->getMessage()],
                    500,
                    'متاسفانه مشکلی در سرور رخ داده است، پس از مدتی دوباره تلاش کنید.'
                );
            }
        });
    }
}
