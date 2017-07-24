<?php namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Crypt;
use App\Exceptions\FlattenException;
use Symfony\Component\HttpKernel\Exception\HttpException;
class Handler extends ExceptionHandler {

	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		'Symfony\Component\HttpKernel\Exception\HttpException'
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception  $e
	 * @return void
	 */
	public function report(Exception $e)
	{
		return parent::report($e);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $e
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $e)
	{
		if(!$e instanceof HttpException && !config('app.debug')){
			return response()->view("errors.500", ["e"=>Crypt::encrypt($e->getMessage())], 500);
		}
		if($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException || $e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException){
	     			return response()->view('errors.404', ["e"=>Crypt::encrypt($e->getMessage())], 404);
	    }
		return parent::render($request, $e);
	}

}
