<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\InvalidOrderException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    public function render($request, Throwable $exception)
    {
        $requestFromAjax = $request->ajax();
        if($requestFromAjax) {
            if ($exception instanceof MethodNotAllowedHttpException) {
                $data = [
                    'msg' => 'The HTTP method is not allowed for this route',
                    'data' => [],
                    'success' => false,
                    'msgType' => 'error',
                    'msgTitle' => '405 Method Not Allowed'
                ];
                return response()->json($data, 405);
            }else if ($exception instanceof NotFoundHttpException ) {
                $data = [
                    'msg' => 'Record not found.',
                    'data' => [],
                    'success' => false,
                    'msgType' => 'error',
                    'msgTitle' => 'Record not found.'
                ];
                return response()->json($data, 404);
            }else if ($exception instanceof InvalidOrderException ) {
                $data = [
                    'msg' => 'An error occured while processing your request. Please refresh the page and try again.',
                    'data' => [],
                    'success' => false,
                    'msgType' => 'error',
                    'msgTitle' => 'Error'
                ];
                return response()->json($data, 500);
            }
        }
        return parent::render($request, $exception);
    }
}
