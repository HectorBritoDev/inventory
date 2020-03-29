<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    //Importing our own ErrorResponse
    use ApiResponser;

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
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($exception, $request);
        }
        if ($exception instanceof ModelNotFoundException) {
            $model = strtolower(class_basename($exception->getModel()));
            return $this->errorResponse('no ' . $model . ' matches with the given id', 404);
        }
        if ($exception instanceof AuthenticationException) {
            return $this->errorResponse('unathenticated', 401);
        }
        if ($exception instanceof AuthorizationException) {
            return $this->errorResponse('forbidden, you dont have the permissions to execute this action', 403);
        }
        if ($exception instanceof NotFoundHttpException) {
            return $this->errorResponse('url not found', 404);
        }
        if ($exception instanceof MethodNotAllowedHttpException) {
            return $this->errorResponse($exception->getMessage(), 404);
        }
        if ($exception instanceof HttpResponseException) {
            return $this->errorResponse($exception->getMessage(), $exception->getStatusCode());
        }
        if ($exception instanceof QueryException) {
            $errorCode = $exception->errorInfo[1];
            if ($errorCode === 1451) {
                return $this->errorResponse('imposible to delete. foreing constraint violation', 409);
            }
        }
        // if (config('app.debug')) {
        //     return parent::render($request, $exception);
        // }
        // return $this->errorResponse('internal server error', 500)
        return parent::render($request, $exception);
    }

    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        $errors = $e->validator->errors()->getMessages();

        return $this->errorResponse($errors, 422);
    }

}
