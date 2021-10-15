<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class Handler extends ExceptionHandler
{
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
    }

    public function render($request, Throwable $e) {
        if($request->wantsJson()) {
            if ($e instanceof ModelNotFoundException) {
                return response()->json(['message' => 'Specified resource of type ' . Str::afterLast($e->getModel(), '\\') . ' was not found.'], 404);
            } elseif ($e instanceof AuthorizationException) {
                return response()->json(['message' => 'You don\'t have the permission to ' . $request->method() . ' the specified resource.'], 401);
            } elseif ($e instanceof ValidationException) {
                return $this->convertValidationExceptionToResponse($e, $request); 
            }
        }

        return parent::render($request, $e);
    }
}
