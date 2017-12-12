<?php

namespace App\Middleware;

/**
 * OldInputMiddleware
 *
 * @author    Haven Shen <havenshen@gmail.com>
 * @copyright    Copyright (c) Haven Shen
 */
class OldInputMiddleware extends Middleware
{

	public function __invoke($request, $response, $next)
	{
		$this->container->view->getEnvironment()->addGlobal('old', isset($_SESSION['old']) ? $_SESSION['old'] : '');
		$_SESSION['old'] = $request->getParams();

		$response = $next($request, $response);
		return $response;
	}
}