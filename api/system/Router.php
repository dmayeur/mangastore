<?php

class Router {

    private $url;
    private $routes = [];
    private $namedRoutes = [];

    public function __construct($url){
        $this->url = $url;

    }

    //the functions to create routes with appropriate methods
    public function get($path, $callable, $config = []){
        return $this->add($path, $callable, 'GET', $config);
    }

    public function post($path, $callable, $config = []){
        return $this->add($path, $callable, 'POST', $config);
    }

    public function put($path, $callable, $config = []){
        return $this->add($path, $callable, 'PUT', $config);
    }

    public function delete($path, $callable, $config = []){
        return $this->add($path, $callable, 'DELETE', $config);
    }



    private function add($path, $callable, $method, $config = []){
        $route = new Route($path, $callable, $config);
        $this->routes[$method][] = $route;
        return $route;
    }


    // the function to try to get a match
    public function run(){
        $request = new Request();

        if(!isset($this->routes[$request->getMethod()])){
            throw new RestException('REQUEST_METHOD does not exist',400);
        }

        //try to match a route
        foreach($this->routes[$request->getMethod()] as $route){
            if($route->match($this->url,$request->getRequest())){
                return $route->call($request);
            }
        }
        throw new RestException('No matching routes', 400);
    }

}
