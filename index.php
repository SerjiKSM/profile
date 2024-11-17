<?php

require 'vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use app\router\Router;
use Dotenv\Dotenv;

// Load the .env file
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$container = require 'container/container.php';

$request = Request::createFromGlobals();
$router = new Router($container);

$response = $router->handle($request);
$response->send();