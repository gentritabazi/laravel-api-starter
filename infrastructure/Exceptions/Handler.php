<?php

namespace Infrastructure\Exceptions;

use Throwable;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
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

    /**
    * Render an exception into an HTTP response.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \Throwable  $exception
    * @return \Symfony\Component\HttpFoundation\Response
    *
    * @throws \Throwable
    */
    public function render($request, Throwable $e)
    {
        $status = 400;

        if ($this->isHttpException($e)) {
            $status = $e->getStatusCode();
        }

        switch ($status) {
            case 422:
                $decoded = json_decode($e->getMessage(), true);
        
                if (json_last_error() !== JSON_ERROR_NONE) {
                    $decoded = [[$e->getMessage()]];
                }

                $data = array_reduce($decoded, function ($carry, $item) use ($e) {
                    return array_merge($carry, array_map(function ($current) use ($e) {
                        return ['message' => $current];
                    }, $item));
                }, []);

                $json = [
                    'status' => $status,
                    'errors' => $data
                ];
                break;

            default:
                $json = [
                    'success' => $status,
                    'errors' => [[
                        'message' => $e->getMessage(),
                        'exception' => (string) $e,
                        'line' => $e->getLine(),
                        'file' => $e->getFile()
                    ]],
                ];
        }

        return response()->json($json, $status);
        
        return parent::render($request, $e);
    }
}
