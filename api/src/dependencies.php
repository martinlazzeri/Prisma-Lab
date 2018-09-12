<?php
// DIC configuration

use Medoo\Medoo;

$container = $app->getContainer();

// Register AuthServer services
$container->register(new Auth\OAuth2ServerProvider());

// App database adapter
$container['db'] = function ($c){
		$settings = $c->get('settings')['db'];
		$database = new Medoo($settings);
		return $database;
};

// OAuth database adapter
$container['dbOauth'] = function ($c) {
    $db = $c->get('settings')['db'];

    $pdo = new PDO('mysql:host='.$db['server'].';dbname='.$db['database_name'], $db['username'], $db['password']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    return $pdo;
};

$container['AuditController'] = function($c){
	return new \App\Presentation\Controllers\AuditController($c);
};

$container['DoctorController'] = function($c){
	return new \App\Presentation\Controllers\DoctorController($c);
};

$container['LoginController'] = function($c){
	return new \App\Presentation\Controllers\LoginController($c);
};

$container['PatientController'] = function($c){
	return new \App\Presentation\Controllers\PatientController($c);
};

$container['UserController'] = function($c){
	return new \App\Presentation\Controllers\UserController($c);
};

$container['WelfareController'] = function($c){
	return new \App\Presentation\Controllers\WelfareController($c);
};