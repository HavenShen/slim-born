<?php

namespace App\Validation;

use Respect\Validation\Validator as Respect;
use Respect\Validation\Exceptions\NestedValidationException;

/**
 * Validator
 *
 * @author    Haven Shen <havenshen@gmail.com>
 * @copyright    Copyright (c) Haven Shen
 */
class Validator
{
	protected $errors;

	public function validate($request, array $rules)
	{
		$data = $request->getParsedBody();

		foreach ($rules as $field => $rule) {
			try {
				$rule->setName(ucfirst($field))->assert($data[$field]);
			} catch (NestedValidationException $e) {
				$this->errors[$field] = $e->getMessages();
			}
		}

		$_SESSION['errors'] = $this->errors;
		return $this;
	}

	public function failed()
	{
		return !empty($this->errors);
	}
}