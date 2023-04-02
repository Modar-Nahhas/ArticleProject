<?php

namespace App\Exceptions;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
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

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (\Exception $e) {
            //Here we should handle each type of the well-known exception separately
            //The code was simplified to save time
            $message = $e->getMessage();
            $trace = $e->getTraceAsString();
            if (env('APP_ENV') == 'production') {
                $message = 'Something went wrong';
                $trace = null;
            }
            switch ($e){
                case $e instanceof AuthenticationException:
                    $code = 401;
                    break;
                case $e instanceof AuthorizationException:
                    $code = 403;
                    break;
                case $e instanceof ValidationException :
                    $code = 422;
                    break;
                default:
                    $code = 500;
            }
            return Controller::getJsonResponse($message, null, false, $code, $trace);
        });
    }
}
