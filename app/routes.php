<?php
use App\Controllers\Auth\AuthController;
use App\Controllers\Auth\PasswordController;
use App\Controllers\HomeController;
use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;

$app->get('/', HomeController::class . ':index')->setName('home');

$app->group('', function ($group) {
	$group->get('/auth/signup', AuthController::class . ':getSignUp')->setName('auth.signup');
	$group->post('/auth/signup', AuthController::class . ':postSignUp');
	$group->get('/auth/signin', AuthController::class . ':getSignIn')->setName('auth.signin');
	$group->post('/auth/signin', AuthController::class . ':postSignIn');
})->add(new GuestMiddleware($container));



$app->group('', function ($group) {
	$group->get('/auth/signout', AuthController::class . ':getSignOut')->setName('auth.signout');
	$group->get('/auth/password/change', PasswordController::class . ':getChangePassword')->setName('auth.password.change');
	$group->post('/auth/password/change', PasswordController::class . ':postChangePassword');
})->add(new AuthMiddleware($container));



