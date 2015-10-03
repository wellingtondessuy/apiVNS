<?php 

require 'vendor/autoload.php';
require_once('controllers/Orders.php');

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

$app = new \Slim\Slim();

// API group
$app->group('/api', function () use ($app) {
 	
    $app->post('/:controller', function ($controller) use ($app) {
    	$controller = ucfirst($controller);
    	$controller = new $controller($app->request, $app->response);
    	$controller->insert();
    });

	$app->get('/:controller', function ($controller) use ($app) {
    	$controller = ucfirst($controller);
    	$controller = new $controller($app->request, $app->response);
    	$controller->findAll();
    });    

    $app->get('/:controller/:id', function ($controller, $id) use ($app) {
    	$controller = ucfirst($controller);
    	$controller = new $controller($app->request, $app->response);
    	$controller->findById($id);
    });

    $app->put('/:controller/:id', function ($controller, $id) use ($app) {
    	$controller = ucfirst($controller);
    	$controller = new $controller($app->request, $app->response);
    	$controller->update($id);
    });

    $app->delete('/:controller/:id', function ($controller, $id) use ($app) {
    	$controller = ucfirst($controller);
    	$controller = new $controller($app->request, $app->response);
    	$controller->delete($id);
    });	    

});

$app->run();

?>