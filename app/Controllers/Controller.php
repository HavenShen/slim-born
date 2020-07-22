<?php

namespace App\Controllers;

use DI\Container;

/**
 * Controller
 *
 * @author    Haven Shen <havenshen@gmail.com>
 * @copyright    Copyright (c) Haven Shen
 */
class Controller
{
	protected $container;

	public function __construct(Container $container)
	{
		$this->container = $container;
	}

	public function __get($property)
	{
		if ($this->container->get($property)) {
			return $this->container->get($property);
		}
	}
}