<?php

namespace App\Middleware;

/**
 * AuthMiddleware
 *
 * @author    Haven Shen <havenshen@gmail.com>
 * @copyright    Copyright (c) Haven Shen
 */
class AuthMiddleware extends Middleware
{

	public function __invoke($request, $response, $next)
	{
		if(! $this->container->auth->check()) {
			$this->container->flash->addMessage('error', 'Please sign in before doing that');
			return $response->withRedirect($this->container->router->pathFor('auth.signin'));
		}

		$response = $next($request, $response);
		return $response;
	}
}