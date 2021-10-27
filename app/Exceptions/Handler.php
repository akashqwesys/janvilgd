<?php

namespace App\Exceptions;

use App\Http\Traits\APIResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Throwable;

class Handler extends ExceptionHandler
{
    use APIResponse;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

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

        $this->renderable(function (Throwable $e, $request) {
            if (isset($request->header()['accept']) && $request->header()['accept'][0] == "application/json") {
                $response = $this->handleException($request, $e);
                return $response;
            }
        });
    }

    public function handleException($request, Throwable $exception)
    {
        if ($exception instanceof PostTooLargeException) {
            return $this->errorResponse(
                'Size of attached file should be less ' . ini_get("upload_max_filesize") . 'B',
                400
            );
        }
        if ($exception instanceof AuthenticationException) {
            return $this->errorResponse(
                'Unauthenticated or Token Expired, Please Login',
                401,
                9
            );
        }
        if ($exception instanceof ThrottleRequestsException) {
            return $this->errorResponse(
                'Too Many Requests, Please Slow Down',
                429
            );
        }
        if ($exception instanceof ModelNotFoundException) {
            return $this->errorResponse(
                'Entry for ' . $exception->getModel() . ' not found',
                404
            );
        }
        if ($exception instanceof RouteNotFoundException) {
            return $this->errorResponse(
                'Requested route doesn\'t exist',
                404
            );
        }
        if ($exception instanceof NotFoundHttpException) {
            return $this->errorResponse(
                'Requested resource doesn\'t exist',
                404
            );
        }
        if ($exception instanceof MethodNotAllowedHttpException) {
            return $this->errorResponse(
                $exception->getMessage(),
                405
            );
        }
        if ($exception instanceof ValidationException) {
            return $this->errorResponse(
                $exception->getMessage(),
                422
            );
        }
        if ($exception instanceof QueryException) {
            return $this->errorResponse(
                'There was an issue with the query',
                500,
                0,
                ['exception' => $exception],
            );
        }
        if ($exception instanceof HttpException) {
            return $this->errorResponse(
                $exception->getMessage(),
                $exception->getStatusCode()
            );
        }
        if ($exception instanceof HttpResponseException) {
            return $this->errorResponse(
                $exception->getMessage(),
                $exception->getStatusCode()
            );
        }
        if ($exception instanceof \Exception) {
            return $this->errorResponse(
                $exception->getMessage(),
                404
            );
        }
        if ($exception instanceof \Error) {
            return $this->errorResponse(
                'There was some internal error',
                500,
                0,
                ['exception' => $exception->getMessage()],
            );
        }
    }
}
