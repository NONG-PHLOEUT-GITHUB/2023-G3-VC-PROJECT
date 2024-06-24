<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Database\QueryException;
use Illuminate\Database\ConnectionException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Client\ConnectionException as ClientConnectionException;

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
        $this->reportable(function (Throwable $e) {
            //
        });
    }
   /**
     * Handle unauthenticated user exceptions.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Auth\AuthenticationException $exception
     * @return \Illuminate\Http\JsonResponse
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return response()->json(['message' => 'Unauthenticated'], 401);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $exception
     * @return \Illuminate\Http\Response
     */
    // public function render($request, Throwable $exception)
    // {
    //     if ($exception instanceof ClientConnectionException || $exception instanceof QueryException) {
    //         return response()->json([
    //             'message' => 'Could not connect to the database. Please check your database server.'
    //         ], 500);
    //     }

    //     return parent::render($request, $exception);
    // }
}
