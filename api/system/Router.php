<?php
class Router {

    private $url;
    private $routes = [];
    private $namedRoutes = [];

    public function __construct($url){
        $this->url = $url;

    }

    public function get($path, $callable){
        return $this->add($path, $callable, 'GET');
    }

    public function post($path, $callable){
        return $this->add($path, $callable, 'POST');
    }

    public function put($path, $callable){
        return $this->add($path, $callable, 'PUT');
    }

    public function delete($path, $callable){
        return $this->add($path, $callable, 'DELETE');
    }

    private function add($path, $callable, $method){
        $route = new Route($path, $callable);
        $this->routes[$method][] = $route;
        return $route;
    }

    public function run(){
        $request = new Request();

        if(!isset($this->routes[$request->getMethod()])){
            throw new RestException('REQUEST_METHOD does not exist',400);
        }

        foreach($this->routes[$request->getMethod()] as $route){
            if($route->match($this->url,$request->getRequest())){
                return $route->call();
            }
        }
        throw new RestException('No matching routes', 400);
    }

}
