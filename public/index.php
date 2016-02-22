<?php 

require '../vendor/autoload.php';

require_once('../helpers/Db.php');

require_once('../controllers/Base.php');
require_once('../controllers/Login.php');

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

$app = new \Slim\Slim();

$app->config('debug', false);

$app->error(function(\Exception $e) use ($app) {

    file_put_contents('/vagrant/tmp/logs/error.log', 
        'Code: ' . $e->getCode() . ' - ' . $e->getMessage() . PHP_EOL .
        'File: ' . $e->getFile() . ' - Line: ' . $e->getLine() . PHP_EOL .
        $e->getTraceAsString()
        );

});

$app->container->singleton('db', function () {

    return new Db();

});

$app->response->headers->set('Content-Type', 'application/json');


// $config = new \Doctrine\DBAL\Configuration();

// $connectionParams = array(
//     'host' => '10.40.8.53',
//     'dbname' => 'desenv',
//     'user' => 'root',
//     'password' => 'vsadmin',
//     'driver' => 'pdo_mysql'
// );
// $conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);
// $data = $conn->fetchAll('select * from park_ticket limit 3');
// var_dump($data);
// die;

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