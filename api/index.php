<?php
session_start();
date_default_timezone_set('America/Argentina/Buenos_Aires');

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';

use Slim\Http\UploadedFile;

use Medoo\Medoo;

$settings = require __DIR__ . '/src/settings.php';

$app = new \Slim\App($settings);

require __DIR__ . '/src/dependencies.php';
require __DIR__ . '/src/routes.php';

$app->run();