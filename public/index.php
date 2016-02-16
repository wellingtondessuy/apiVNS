<?php 

require '../vendor/autoload.php';
require_once('../controllers/Orders.php');

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

$app = new \Slim\Slim();

// API group
$app->group('/api', function () use ($app) {
 	
    $app->post('/:controller', function ($controller) use ($app) {
    	$controller = ucfirst($controller);
    	$controller = new $controller($app);
    	$controller->insert();
    });

	$app->get('/:controller', function ($controller) use ($app) {
    	$controller = ucfirst($controller);
    	$controller = new $controller($app);
    	$controller->findAll();
    });    

    $app->get('/:controller/:id', function ($controller, $id) use ($app) {
    	$controller = ucfirst($controller);
    	$controller = new $controller($app);
    	$controller->findById($id);
    });

    $app->put('/:controller/:id', function ($controller, $id) use ($app) {
    	$controller = ucfirst($controller);
    	$controller = new $controller($app);
    	$controller->update($id);
    });

    $app->delete('/:controller/:id', function ($controller, $id) use ($app) {
    	$controller = ucfirst($controller);
    	$controller = new $controller($app);
    	$controller->delete($id);
    });	    

});

$app->group('/', function () use ($app) {
    
    $app->post('/:controller', function ($controller) use ($app) {
        $controller = ucfirst($controller);
        $controller = new $controller($app);
        $controller->add();
    });

    $app->get('/:controller', function ($controller) use ($app) {
        $controller = ucfirst($controller);
        $controller = new $controller($app);
        $data = $controller->index();
        $app->render($controller . ".php", !$data? array():$data);
    });    

    $app->get('/:controller/:id', function ($controller, $id) use ($app) {
        $controller = ucfirst($controller);
        $controller = new $controller($app);
        $controller->edit($id);
    });

    $app->put('/:controller/:id', function ($controller, $id) use ($app) {
        $controller = ucfirst($controller);
        $controller = new $controller($app);
        $controller->update($id);
    });

    $app->delete('/:controller/:id', function ($controller, $id) use ($app) {
        $controller = ucfirst($controller);
        $controller = new $controller($app);
        $controller->delete($id);
    });     

});

$app->run();

?>