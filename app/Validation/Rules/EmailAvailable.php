<?php

namespace App\Validation\Rules;

use App\Models\User;
use Respect\Validation\Rules\AbstractRule;

/**
 * EmailAvailable
 *
 * @author    Haven Shen <havenshen@gmail.com>
 * @copyright    Copyright (c) Haven Shen
 */
class EmailAvailable extends AbstractRule
{

	public function validate($input)
	{
		return User::where('email',$input)->count() === 0;
	}
}