<?php
class Router {

    private $url;
    private $routes = [];
    private $namedRoutes = [];

    public function __construct($url){
        $this->url = $url;
        $this->method = $_SERVER['REQUEST_METHOD'];
        if(isset($_POST['method'])){
            $this->method = strtoupper($_POST['method']);
        }
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
        if(is_string($callable)){
            $name = $callable;
        }
        return $route;
    }

    public function run(){
        // var_dump($this->routes);
        if(!isset($this->routes[$this->method])){
            throw new RestException('REQUEST_METHOD does not exist',400);
        }
        foreach($this->routes[$this->method] as $route){
            if($route->match($this->url)){
                return $route->call();
            }
        }
        throw new RestException('No matching routes', 400);
    }

}
