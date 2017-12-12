<?php

namespace App\Middleware;

/**
 * Middleware
 *
 * @author    Haven Shen <havenshen@gmail.com>
 * @copyright    Copyright (c) Haven Shen
 */
class Middleware
{
	protected $container;

	public function __construct($container)
	{
		$this->container = $container;
	}
}