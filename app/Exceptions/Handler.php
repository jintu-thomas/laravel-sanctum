<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernal\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use App\Traits\ApiResponser;
use illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    use ApiResponser;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernal\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Validation\ValidationException::class,
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
     *
     * @throws \Exception
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
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Exception
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof ValidationException){
            return $this->covertValidationExceptionToResponse($exception,$request);
        }

        if($exception instanceof ModelNotFoundException) {
            $modelName = strtolower(class_basename($exception->getModel()));

            return $this->errorResponse("Does not exist any {$modelName} with the specify identificator", 404);
        }

        if ($exception instanceof AuthenticationException){
            return $this->unauthenticated($request,$exception);
        }

        if ($exception instanceof AuthorizationException) {
            return $this -> errorResponse($exception->$getMessage(),403);
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            return $this -> errorResponse('The specefied method for the request is invalid',404);
        }

        if ($exception instanceof NotFoundHttpException) {
            return $this -> errorResponse('The specefied url can not found',404);
        }

        if ($exception instanceof HttpException) {
            return $this -> errorResponse($exception ->getMessage(), $exception->getStatusCode());
        }

        if ($exception instanceof QueryException) {
            $errorCode = $exception -> errorInfo[1];

            if ($errorCode == 1451) {
                return $this -> errorResponse('can not delete this resource permanently. It is reated with any other resources', 409);
            }
        }

        if ($exception instanceof TokenMismatchException) {
            return redirect()->back()->withInput($request->input());
        }
        
        if (config('app.debug')) {

            return parent::render($request, $exception);
            
        }
        
        return $this ->errorResponse('Unexpected Exception . Try later', 500);

    }
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($this->isFrontend($request)) {
            return redirect()->guest('login');
        }
        return $this -> errorResponse('unauthenticated',401);
    }
    /** 
     * Create a response  object from the given validation exception.
     * 
     * @param \Illuminate\Validation\validationException $e
     * @param \Illumainate\Http\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */

    protected function covertValidationExceptionToResponse(ValidationException $e, $request)
    {   
        $errors = $e ->validator->errors()->getMessages();
        if ($this->isFrontend($request)) {
            return $request->ajax()? response()->json($errors,422) : redirect()
            ->back()
            ->withInput($request->input())
            ->withErrors($errors);
        }

        return $this->errorResponse($errors,422);
    }

    private function isFrontend($request) 
    {
        return $request->acceptsHtml() && collect($request->route()->middleware())->contains('web');
    }
}
