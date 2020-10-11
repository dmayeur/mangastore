<?php

$request = rtrim( $_SERVER['REDIRECT_URL'] , '/');
$request = explode("/",$request);
$request = array_splice($request, 3);
$request = implode("/",$request);


$router = new Router($request);

/**
* SERIES ROUTES
*/
$router->get('/series', [$serieController,"getAllBasicInfos"]);
$router->get('/series/:id', [$serieController,"getById"]);
$router->get('/admin/series', [$serieController,"getAllAdmin"]);

$router->post('series',[$serieController,"create"]);

$router->put('series/:id',[$serieController,"modify"]);

$router->delete('series/:id', [$serieController,"delete"]);

/**
* CATEGORIES ROUTES
*/
$router->get('/categories', [$categoryController,"getAll"]);
$router->post('/categories', [$categoryController,"create"]);
$router->put('/categories/:id', [$categoryController,"modify"]);
$router->delete('/categories/:id', [$categoryController,"delete"]);

/**
* EDITORS ROUTES
*/
$router->get('/editors', [$editorController,"getAll"]);
$router->get('/editors/:id/prices', [$editorController,"getPrice"]);
$router->post('/editors', [$editorController,"create"]);
$router->put('/editors/:id', [$editorController,"modify"]);
$router->delete('/editors/:id', [$editorController,"delete"]);

/**
*  AUTHORS ROUTES
*/
$router->get('/authors', [$authorController,"getAll"]);

/**
*  USERS ROUTES
*/
$router->post('/users/creation', [$userController,'createAccount']);
$router->post('/users/authentication', [$userController,'login']);
