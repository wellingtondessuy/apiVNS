<?php

use Helpers\Db;
use Helpers\Auth;
use Helpers\ValidationException;
use Controllers\Login;
use Controllers\Transaction;
use Controllers\User;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

$app = new \Slim\Slim();

$app->config('debug', false);

$app->error(function(\Exception $e) use ($app) {

    $app->response->setStatus($e->getCode());
    
    // file_put_contents(__DIR__ . '/../tmp/logs/error.log', 
    //     'Code: ' . $e->getCode() . ' - ' . $e->getMessage() . PHP_EOL .
    //     'File: ' . $e->getFile() . ' - Line: ' . $e->getLine() . PHP_EOL .
    //     $e->getTraceAsString() . PHP_EOL,
    //     FILE_APPEND
    //     );

});

$app->container->singleton('db', function () {

    return new \Helpers\Db();

});

$app->container->singleton('auth', function () {

    return new \Helpers\Auth();

});

$app->response->headers->set('Content-Type', 'application/json');

// API group
$app->group('/api', function () use ($app) {
    
    $app->post('/:controller', function ($controller) use ($app) {
        $app->auth->verifyAuthentication();
        $controller = ucfirst($controller);
        $controller = "\Controllers\\" . $controller;
        $controller = new $controller($app);
        $controller->insert();
    });

    $app->get('/:controller', function ($controller) use ($app) {
        $app->auth->verifyAuthentication();
        $controller = ucfirst($controller);
        $controller = "\Controllers\\" . $controller;
        $controller = new $controller($app);
        $controller->findAll();
    });    

    $app->get('/:controller/:id', function ($controller, $id) use ($app) {
        $app->auth->verifyAuthentication();
        $controller = ucfirst($controller);
        $controller = "\Controllers\\" . $controller;
        $controller = new $controller($app);
        $controller->findById($id);
    });

    $app->put('/:controller/:id', function ($controller, $id) use ($app) {
        $app->auth->verifyAuthentication();
        $controller = ucfirst($controller);
        $controller = "\Controllers\\" . $controller;
        $controller = new $controller($app);
        $controller->update($id);
    });

    $app->delete('/:controller/:id', function ($controller, $id) use ($app) {
        $app->auth->verifyAuthentication();
        $controller = ucfirst($controller);
        $controller = "\Controllers\\" . $controller;
    	$controller = new $controller($app);
    	$controller->delete($id);
    });	    

});

$app->run();