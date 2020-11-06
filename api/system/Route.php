<?php
class Route {

    private $path;
    private $callable;
    private $matches = [];
    private $params = [];
    private $config;

    public function __construct($path, $callable, $config = []){
        $this->path = trim($path, '/');  //removing trailing /
        $this->callable = $callable;
        $this->config = $config;
    }

    public function match($url, $request){
        //match a route while putting the :ids as parameters
        $url = trim($url, '/');
        $path = preg_replace('#:([\w]+)#', '([^/]+)', $this->path);
        $regex = "#^$path$#i";
        if(!preg_match($regex, $url, $matches)){
            return false;
        }
        array_shift($matches);

        //the request array that will be passed to the controller
        $matches[] = $request;

        $this->matches = $matches;
        return true;
    }

    public function call($request){
        //we check here for admin routes to avoid repeating the check in the controller
        if(isset($this->config['admin'])) {
            if($this->config['admin']){
                $auth = new Auth();
                try {
                    $user = $auth->isAdmin($request->getToken());
                } catch (Exception $e) {
                    throw new RestException("Erreur d'authentication",401);
                }
            }
        }

        //create a new class with the name passed in the route
        $classname = $this->callable[0];
        $this->callable[0] = new $classname();

        return call_user_func_array($this->callable, $this->matches);
    }
}
