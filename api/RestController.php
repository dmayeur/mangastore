<?php
// var_dump($_POST);
// exit();

function customException($e)
{
    //it's either an error we threw ourselves
    if($e instanceof RestException){
        $coreController = new CoreController();
        $coreController->setHttpHeaders($e->getCode());
        $error = [
            'errorMessage' => $e->getMessage(),
        ];
    //or an unplanned one
    } else {
        $coreController = new CoreController();
        $coreController->setHttpHeaders('500');
        $error = [
            'message' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile()
        ];
    }
    $error =  json_encode($error, JSON_FORCE_OBJECT);
    echo($error);
    exit();
}

include 'vendor/autoload.php';

spl_autoload_register(function ($class) {
    if (file_exists('system/' . $class . '.php')) {
        include_once  './system/' . $class . '.php';
    } elseif (file_exists('controller/' . $class . '.php')){
        include_once  './controller/' . $class . '.php';
    } elseif (file_exists('model/' . $class . '.php')){
            include_once  './model/' . $class . '.php';
    }
});

// we create a request object that contains all the request info
$request = new Request();

// we instantiate all the controllers because I didn't find any other way to have objects with my router
$serieController = new SerieController($request);
$categoryController = new CategoryController($request);
$editorController = new EditorController($request);
$userController = new UserController($request);
$authorController = new AuthorController($request);
$mangaController = new MangaController($request);
$orderController = new OrderController($request);

//the routes of our router
include 'config/routes.php';

set_exception_handler('customException');

//special rule for our vue front server
header("Access-Control-Allow-Origin: http://localhost:80");
// header("Content-Type: application/json");

//Match the URL to a route
$router->run();
exit();
