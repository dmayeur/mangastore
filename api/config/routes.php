<?php

/*
The place where we declare all the routes
 */

$request = rtrim( $_SERVER['REDIRECT_URL'] , '/');
$request = explode("/",$request);
$request = array_splice($request, 3);
$request = implode("/",$request);


$router = new Router($request);


/**
* SERIES ROUTES
*/

$router->get('/series', ['serieController',"getAllBasicInfos"]);
$router->get('/series/:id', ['serieController',"getById"]);
$router->get('/admin/series', ['serieController',"getAllAdmin"]); //this is just an admin route for prettier display purpose, no sensitive info is on there so the route isn't admin only
$router->get('/series/:id/reviews', ['serieController',"getReviews"]);

$router->post('series',['serieController',"create"], ['admin' => true]);
$router->post('series/:id/authors', ['serieController',"createAuthor"], ['admin' => true]);
$router->post('series/:id/categories',['serieController',"createCategories"], ['admin' => true]);
$router->post('series/:id/reviews', ['serieController',"createReview"]);
$router->post('series/:id/mangas',['serieController',"createManga"], ['admin' => true]);

$router->put('series/:id',['serieController',"modify"], ['admin' => true]);
$router->put('series/:id/mangas/:idManga',['serieController',"modifyManga"], ['admin' => true]);
$router->put('series/:id/ratings', ['serieController',"modifyRating"]);
$router->put('series/:id/reviews',['serieController', "modifyReview"]);

$router->delete('series/:id', ['serieController',"delete"]);
$router->delete('series/:id/authors/:idAuthor', ['serieController',"deleteAuthor"], ["admin" => true]);
$router->delete('series/:id/categories', ['serieController', "deleteCategory"], ["admin" => true]);


/**
* MANGAS ROUTES
*/

$router->get('/mangas', ['mangaController',"getAll"]);


/**
* CATEGORIES ROUTES
*/

$router->get('/categories', ['categoryController',"getAll"]);
$router->get('/categories/:id', ['categoryController',"getById"]);
$router->get('/admin/categories', ['categoryController',"getAdmin"]);

$router->post('/categories', ['categoryController',"create"], ['admin' => true]);

$router->put('/categories/:id', ['categoryController',"modify"], ['admin' => true]);

$router->delete('/categories/:id', ['categoryController',"delete"], ['admin' => true]);


/**
* EDITORS ROUTES
*/

$router->get('/editors', ['editorController',"getAll"]);
$router->get('/editors/:id', ['editorController',"getById"]);
$router->get('/editors/:id/prices', ['editorController',"getPrice"]);

$router->post('/editors', ['editorController',"create"], ['admin' => true]);
$router->post('/editors/:id/prices', ['editorController', "createPrice"], ['admin' => true]);

$router->put('/editors/:id', ['editorController',"modify"], ['admin' => true]);
$router->post('/editors/:id/prices/:idPrice', ['editorController', "modifyPrice"], ['admin' => true]);

$router->delete('/editors/:id', ['editorController',"delete"], ['admin' => true]);


/**
*  AUTHORS ROUTES
*/
$router->get('/authors', ['authorController',"getAll"]);
$router->get('/authors/:id', ['authorController',"getById"]);

$router->post('/authors', ['authorController',"create"], ['admin' => true]);

$router->put('/authors/:id', ['authorController',"modify"], ['admin' => true]);

$router->delete('/authors/:id', ['authorController',"delete"], ['admin' => true]);


/**
*  USERS ROUTES
*/
$router->get('/users', ['userController',"getUser"]);
$router->get('/users/series/:id/reviews', ['userController',"getReview"]);

$router->post('/users/admin', ['userController', 'isAdmin'], ['admin' => true]);
$router->post('/users/creation', ['userController','createAccount']);
$router->post('/users/authentication', ['userController','login']);


/**
*  ORDERS ROUTES
*/
$router->get('/orders', ['orderController',"getAll"]);
$router->get('/orders/:id', ['orderController', "getById"]);

$router->post('/orders', ['orderController',"create"]);

$router->put('/orders/:id',['orderController', "modify"], ['admin' => true]);

$router->delete('/orders/:id', ['orderController', 'delete'], ['admin' => true]);

/**
* reviews ROUTES
*/

$router->get('/reviews', ['reviewController',"getAll"]);

$router->delete('admin/reviews/:id', ['reviewController',"delete"], ['admin' => true]);
