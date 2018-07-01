<?php

namespace Base\Exceptions;

use Psr\Log\LoggerInterface;
use MyApp\Exceptions\MyAppException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
     * @see \Illuminate\Foundation\Exceptions\Handler::report()
     *
     * @param  \Exception  $e
     * @return mixed
     *
     * @throws \Exception
     */
    public function report(\Exception $e)
    {
        if ($this->shouldntReport($e)) {
            return;
        }

        if (method_exists($e, 'report')) {
            return $e->report();
        }

        try {
            $logger = $this->container->make(LoggerInterface::class);
        } catch (\Exception $ex) {
            throw $e;
        }

        $additionalContext = [];
        if ($e instanceof MyAppException) {
            $additionalContext = array_merge($additionalContext, $e->getContext());
        }

        $logger->error(
            $e->getMessage(),
            array_merge($this->context(), $additionalContext, ['exception' => $e])
        );
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, \Exception $exception)
    {
        if (config('app.debug')) {
            // to display "Whoops" page
            ini_set('assert.active', false);

            // not to redirect
            if ($exception instanceof AuthenticationException || $exception instanceof ValidationException) {
                $request->headers->set('Accept', 'application/json');
            }
        } else {
            if ($exception instanceof MyAppException) {
                $exception = $exception->toHttpException();
            }

            $request->headers->set('Accept', 'application/json');
        }

        return parent::render($request, $exception);
    }
}
