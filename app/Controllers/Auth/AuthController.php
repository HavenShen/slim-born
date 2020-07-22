<?php

namespace App\Controllers\Auth;

use App\Models\User;
use App\Controllers\Controller;
use Respect\Validation\Validator as v;

/**
 * AuthController
 *
 * @author    Haven Shen <havenshen@gmail.com>
 * @copyright    Copyright (c) Haven Shen
 */
class AuthController extends Controller
{
	public function getSignOut($request, $response)
	{
		$this->auth->logout();
		return $response->withHeader('Location', $this->router->urlFor('home'));
	}

	public function getSignIn($request, $response)
	{
		return $this->view->render($response, 'auth/signin.twig');
	}

	public function postSignIn($request, $response)
	{
		$data = $request->getParsedBody();
		$auth = $this->auth->attempt(
			$data['email'],
			$data['password']
		);

		if (! $auth) {
			$this->flash->addMessage('error', 'Could not sign you in with those details');
			return $response->withHeader('Location', $this->router->urlFor('auth.signin'));
		}

		return $response->withHeader('Location', $this->router->urlFor('home'));
	}

	public function getSignUp($request, $response)
	{
		return $this->view->render($response, 'auth/signup.twig');
	}

	public function postSignUp($request, $response)
	{

		$validation = $this->validator->validate($request, [
			'email' => v::noWhitespace()->notEmpty()->email()->emailAvailable(),
			'name' => v::noWhitespace()->notEmpty()->alpha(),
			'password' => v::noWhitespace()->notEmpty(),
		]);

		if ($validation->failed()) {
			return $response->withHeader('Location', $this->router->urlFor('auth.signup'));
		}

		$data = $request->getParsedBody();

		$user = User::create([
			'email' => $data['email'],
			'name' => $data['name'],
			'password' => password_hash($data['password'], PASSWORD_DEFAULT),
		]);

		$this->flash->addMessage('info', 'You have been signed up');

		$this->auth->attempt($user->email, $data['password']);

		return $response->withHeader('Location', $this->router->urlFor('home'));
	}
}