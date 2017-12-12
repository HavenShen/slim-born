<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * User
 *
 * @author    Haven Shen <havenshen@gmail.com>
 * @copyright    Copyright (c) Haven Shen
 */
class User extends Model
{
	protected $table = 'users';

	public $first_name;

	public $last_name;

	public $email;

	protected $fillable = [
		'email',
		'name',
		'password',
	];

	public function setPassword($password)
	{
		$this->update([
			'password' => password_hash($password, PASSWORD_DEFAULT)
		]);
	}

	public function setFirstName($firstName)
	{
		$this->first_name = trim($firstName);
	}

	public function getFirstName()
	{
		return $this->first_name;
	}

	public function setLastName($lastName)
	{
		$this->last_name = trim($lastName);
	}

	public function getLastName()
	{
		return $this->last_name;
	}

	public function setEmail($email)
	{
		$this->email = $email;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function getFullName()
	{
		return "$this->first_name $this->last_name";
	}

	public function getEmailVariables()
	{
		return [
			'full_name' => $this->getFullName(),
			'email' => $this->getEmail(),
		];
	}
}