<?php

namespace App\Exceptions;

use App\Traits\ResponseTrait;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{

    use ResponseTrait;
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
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ValidationException) {
            $errors_array = $exception->errors();
            return $this->error422(
                $errors_array,
                ($errors_array[array_key_first($errors_array)])[0]
            );
        }
        if ($exception instanceof NotFoundHttpException) {
            return $this->error404();
        }

        if ($exception instanceof AccessDeniedHttpException || $exception instanceof AuthorizationException) {
            return $this->error403();
        }

     
        // dd($exception);
        return parent::render($request, $exception);
    }
}
