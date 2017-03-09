<?php namespace App\Exceptions;


// Core
use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

// Helpers
use Kayex\HttpCodes;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
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
        return parent::render($request, $this->wrapException($exception));
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest('login');
    }

    /*
     * Wraps an exception in a suitable HttpException, so that the error handler
     * can automatically return the correct response code.
     *
     * Defaults to HTTP 500 Internal Server Error.
     */
    private function wrapException(Exception $e): HttpException
    {
        if ($e instanceof HttpException) {
            return $e;
        }

        if ($e instanceof TokenException) {
            return new HttpException(HttpCodes::HTTP_UNAUTHORIZED, $e->getMessage(), $e);
        } elseif ($e instanceof ModelNotFoundException) {
            return new HttpException(HttpCodes::HTTP_NOT_FOUND, $e->getMessage(), $e);
        } elseif ($e instanceof SlackException) {
            if ($e instanceof SlackTokenException) {
                return new HttpException(HttpCodes::HTTP_BAD_REQUEST, $e->getMessage(), $e);
            }
        }

        return new HttpException(HttpCodes::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage(), $e);
    }
}
