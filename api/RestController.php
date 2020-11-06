<?php
/**
 * RESTCONTROLLER
 * This is where all the request goes, so we just need to import everything and let the router decide where the stuff goes
 */

include 'vendor/autoload.php';

// load all the controllers, models and system classes
spl_autoload_register(function ($class) {
    if (file_exists('system/' . $class . '.php')) {
        include_once  './system/' . $class . '.php';
    } elseif (file_exists('controller/' . $class . '.php')){
        include_once  './controller/' . $class . '.php';
    } elseif (file_exists('model/' . $class . '.php')){
        include_once  './model/' . $class . '.php';
    }
});

set_exception_handler('RestException::customException'); //our custom exception handler

//the routes of our router
include 'config/routes.php';

//special rule for our vue front server
header("Access-Control-Allow-Origin: http://localhost:80");
header("Content-Type: application/json");

//Match the URL to a route
$router->run();

exit();
