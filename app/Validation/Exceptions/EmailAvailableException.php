<?php

namespace App\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

/**
 * EmailAvailableException
 *
 * @author    Haven Shen <havenshen@gmail.com>
 * @copyright    Copyright (c) Haven Shen
 */
class EmailAvailableException extends ValidationException
{

	public static $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => '{{name}} is already taken',
        ],
        self::MODE_NEGATIVE => [
            self::STANDARD => '{{name}} is not already taken',
        ]
    ];
}