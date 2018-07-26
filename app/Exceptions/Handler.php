<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

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
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
      if (app()->environment() == 'testing') {
        return $exception;
      }
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
      if ($exception instanceof ModelNotFoundException) {
        return response()->json([
            'error' => 'Resource not found.'
        ], Response::HTTP_NOT_FOUND);
      } elseif ($exception instanceof NotFoundHttpException) {
          return response()->json([
              'error' => 'Bad request or incorect request parameters.'
          ], Response::HTTP_NOT_FOUND);
      } elseif ($exception instanceof QueryException) {
          return response()->json([
              'error' => 'The trequired data don\'t exist in the db.'
          ], Response::HTTP_NOT_FOUND);
      }

        return parent::render($request, $exception);
    }
}
