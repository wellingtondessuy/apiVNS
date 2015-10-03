<?php 

require 'vendor/autoload.php';
require_once('controllers/Orders.php');

$app = new \Slim\Slim();

// API group
$app->group('/api', function () use ($app) {
 	
    $app->post('/:controller', function ($controller) {
    	$controller = ucfirst($controller);
    	$controller = new $controller();
    	$controller->insert();
    });

	$app->get('/:controller', function ($controller) {
    	$controller = ucfirst($controller);
    	$controller = new $controller();
    	$controller->findAll();
    });    

    $app->get('/:controller/:id', function ($controller, $id) {
    	$controller = ucfirst($controller);
    	$controller = new $controller();
    	$controller->findById($id);
    });

    $app->put('/:controller/:id', function ($controller, $id) {
    	$controller = ucfirst($controller);
    	$controller = new $controller();
    	$controller->update($id);
    });

    $app->delete('/:controller/:id', function ($controller, $id) {
    	$controller = ucfirst($controller);
    	$controller = new $controller();
    	$controller->delete($id);
    });	    

});

$app->run();

?>