<?php

use DI\Container;
use Respect\Validation\Validator as v;
use Slim\Csrf\Guard;
use Slim\Factory\AppFactory;
use Slim\Handlers\Strategies\RequestResponseArgs;
use Slim\Psr7\Factory\UriFactory;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;
use Slim\Views\TwigRuntimeLoader;

session_start();

require __DIR__ . '/../vendor/autoload.php';

try {
	$dotenv = (new \Dotenv\Dotenv(__DIR__ . '/../'))->load();
} catch (\Dotenv\Exception\InvalidPathException $e) {
	//
}

$container = new Container();
// Set container to create App with on AppFactory
AppFactory::setContainer($container);

$app = AppFactory::create();
$responseFactory = $app->getResponseFactory();

$routeCollector = $app->getRouteCollector();
$routeCollector->setDefaultInvocationStrategy(new RequestResponseArgs());
$routeParser = $app->getRouteCollector()->getRouteParser();

$container->set('settings', function () {
    return [
    	'displayErrorDetails' => true,
        'app' => [
            'name' => getenv('APP_NAME')
        ]
    ];
});

require_once __DIR__ . '/database.php';

$container->set('router', function () use ($routeParser) {
    return $routeParser;
});

$container->set('db', function () use ($capsule) {
	return $capsule;
});

$container->set('auth', function() {
	return new \App\Auth\Auth;
});

$container->set('flash', function() {
	return new \Slim\Flash\Messages;
});

$container->set('view', function ($container) use ($app) {
	$view = Twig::create(__DIR__ . '/../resources/views', [
		'cache' => false,
	]);

	$runtimeLoader = new TwigRuntimeLoader(
        $app->getRouteCollector()->getRouteParser(),
        (new UriFactory)->createFromGlobals($_SERVER),
        '/'
    );

    $view->addRuntimeLoader($runtimeLoader);

	$view->addExtension(new TwigExtension(
		$app->getRouteCollector()->getRouteParser(),
        $app->getBasePath()
	));

	$view->getEnvironment()->addGlobal('auth', [
		'check' => $container->get('auth')->check(),
		'user' => $container->get('auth')->user()
	]);

	$view->getEnvironment()->addGlobal('flash', $container->get('flash'));

	return $view;
});

$container->set('validator', function ($container) {
	return new App\Validation\Validator;
});

$container->set('csrf', function($container) use ($responseFactory) {
	return new Guard($responseFactory);
});

$app->add(new \App\Middleware\ValidationErrorsMiddleware($container));
$app->add(new \App\Middleware\OldInputMiddleware($container));
$app->add(new \App\Middleware\CsrfViewMiddleware($container));

$app->add('csrf');

v::with('App\\Validation\\Rules\\');

require __DIR__ . '/../app/routes.php';
