<?php 

require '../vendor/autoload.php';

require_once('../helpers/Db.php');

require_once('../controllers/Base.php');
require_once('../controllers/Login.php');
require_once('../controllers/Transaction.php');

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

$app = new \Slim\Slim();

$app->config('debug', false);

$app->error(function(\Exception $e) use ($app) {

    file_put_contents('/vagrant/tmp/logs/error.log', 
        'Code: ' . $e->getCode() . ' - ' . $e->getMessage() . PHP_EOL .
        'File: ' . $e->getFile() . ' - Line: ' . $e->getLine() . PHP_EOL .
        $e->getTraceAsString() . PHP_EOL,
        FILE_APPEND
        );

    $app->response->setStatus($e->getCode());

});

$app->container->singleton('db', function () {

    return new Db();

});

$app->response->headers->set('Content-Type', 'application/json');

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

$app->run();

?>