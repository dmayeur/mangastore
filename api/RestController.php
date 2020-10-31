<?php
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

set_exception_handler('RestException::customException');


// we create a request object that contains all the request info
$request = new Request();


// we instantiate all the controllers because I didn't find any other way to have objects with my router
$serieController = new SerieController();
$categoryController = new CategoryController();
$editorController = new EditorController();
$userController = new UserController();
$authorController = new AuthorController();
$mangaController = new MangaController();
$orderController = new OrderController();

//the routes of our router
include 'config/routes.php';

//special rule for our vue front server
header("Access-Control-Allow-Origin: http://localhost:80");
// header("Content-Type: application/json");

//Match the URL to a route
$router->run();

exit();
