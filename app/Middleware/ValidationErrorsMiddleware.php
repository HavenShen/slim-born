<?php

namespace App\Middleware;

/**
 * ValidationErrorsMiddleware
 *
 * @author    Haven Shen <havenshen@gmail.com>
 * @copyright    Copyright (c) Haven Shen
 */
class ValidationErrorsMiddleware extends Middleware
{

	public function __invoke($request, $response, $next)
	{
		$this->container->view->getEnvironment()->addGlobal('errors', isset($_SESSION['errors']) ? $_SESSION['errors'] : '');
		unset($_SESSION['errors']);

		$response = $next($request, $response);
		return $response;
	}
}