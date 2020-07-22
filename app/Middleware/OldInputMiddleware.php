<?php

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

/**
 * OldInputMiddleware
 *
 * @author    Haven Shen <havenshen@gmail.com>
 * @copyright    Copyright (c) Haven Shen
 */
class OldInputMiddleware extends Middleware
{

	public function __invoke(Request $request, RequestHandler $handler): Response
	{
		$this->container->get('view')->getEnvironment()->addGlobal('old', isset($_SESSION['old']) ? $_SESSION['old'] : '');
		$_SESSION['old'] = $request->getParsedBody();

		$response = $handler->handle($request);
		return $response;
	}
}