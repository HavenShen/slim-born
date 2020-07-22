<?php

namespace App\Middleware;

use DI\Container;

/**
 * Middleware
 *
 * @author    Haven Shen <havenshen@gmail.com>
 * @copyright    Copyright (c) Haven Shen
 */
class Middleware
{
	protected $container;

	public function __construct(Container $container)
	{
		$this->container = $container;
	}
}