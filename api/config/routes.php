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
$router->get('series/:id/reviews', [$serieController,"getReviews"]);

$router->post('series',[$serieController,"create"]);
$router->post('series/:id/categories',[$serieController,"createCategories"]);
$router->post('series/:id/reviews', [$serieController,"postReview"]);
$router->post('series/:id/mangas',[$serieController,"postManga"]);

$router->put('series/:id',[$serieController,"modify"]);
$router->put('series/:id/ratings', [$serieController,"putRating"]);
$router->put('series/:id/reviews',[$serieController, "putReview"]);

$router->delete('series/:id', [$serieController,"delete"]);
$router->delete('series/:id/categories', [$serieController, "deleteCategory"]);


/**
* MANGAS ROUTES
*/

$router->get('/mangas', [$mangaController,"getAll"]);


/**
* CATEGORIES ROUTES
*/

$router->get('/categories', [$categoryController,"getAll"]);
$router->get('/categories/:id', [$categoryController,"getById"]);
$router->get('/admin/categories', [$categoryController,"getAdmin"]);

$router->post('/categories', [$categoryController,"create"]);

$router->put('/categories/:id', [$categoryController,"modify"]);

$router->delete('/categories/:id', [$categoryController,"delete"]);


/**
* EDITORS ROUTES
*/

$router->get('/editors', [$editorController,"getAll"]);
$router->get('/editors/:id', [$editorController,"getById"]);
$router->get('/editors/:id/prices', [$editorController,"getPrice"]);

$router->post('/editors', [$editorController,"create"]);
$router->post('/editors/:id/prices', [$editorController, "createPrice"]);

$router->put('/editors/:id', [$editorController,"modify"]);

$router->delete('/editors/:id', [$editorController,"delete"]);


/**
*  AUTHORS ROUTES
*/
$router->get('/authors', [$authorController,"getAll"]);
$router->get('/authors/:id', [$authorController,"getById"]);

$router->post('/authors', [$authorController,"create"]);

$router->put('/authors/:id', [$authorController,"modify"]);

$router->delete('/authors/:id', [$authorController,"delete"]);


/**
*  USERS ROUTES
*/

$router->get('users/series/:id/reviews', [$userController,"getReview"]);

$router->post('/users/admin', [$userController, 'isAdmin']);
$router->post('/users/creation', [$userController,'createAccount']);
$router->post('/users/authentication', [$userController,'login']);


$router->post('/orders', [$orderController,"create"]);
