<?php

namespace App\Middleware;

/**
* 
*/
class CsrfViewMiddleware extends Middleware
{
	
	public function __invoke($request,$response,$next)
	{
		$this->container->view->getEnvironment()->addGlobal('csrf',[
			'field' => '
				<input type="hidden" name="'. $this->container->csrf->getTokenNameKey() .'"
				 value="'. $this->container->csrf->getTokenName() .'">
				<input type="hidden" name="'. $this->container->csrf->getTokenValueKey() .'"
				 value="'. $this->container->csrf->getTokenValue() .'">
			',
		]);
		$_SESSION['old'] = $request->getParams();

		$response = $next($request,$response);
		return $response;
		
	}
}