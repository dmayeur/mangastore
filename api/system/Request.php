<?php
// namespace dmayeur\mangastore\Request;

/**
 * [Request class that contains the informations of the REQUEST_METHOD
 *  Like the method used, the url parts, the body of the request
 * ]
 */
class Request{

    protected $method;
    protected $queryArray;

    function __construct() {
        $this->request();
    }

    function request() {

        // this is for GET method only
        // we build it that way because we want the user to be able to call ?category=x&category=y so $_GET is no good
        $this->queryArray=[];
        if( isset($_SERVER['REDIRECT_QUERY_STRING']) && !empty($_SERVER['REDIRECT_QUERY_STRING']) ) {
            $queryString = urldecode($_SERVER['REDIRECT_QUERY_STRING']);
            $this->queryArray=explode("&",$queryString);
        }

        $method = "";

        if ($_SERVER['REQUEST_METHOD']==='GET') {
            $method="GET";
        }

        if ($_SERVER['REQUEST_METHOD']==='POST') {
            $method="POST";
            //the method is a post parameter for PUT and DELETE
            if(isset($_POST['method'])){
                $method = strtoupper($_POST['method']);
            }
        }

        $this->method=$method;
    }

    public function getJSON() {

        if($_SERVER['CONTENT_TYPE'] == "application/json") {
            return json_decode(file_get_contents('php://input'));
        } else {
            throw new RestException("Le serveur s'attend a une requête du type application/json",400);
        }

    }

    public function getBody() {
        if($this->method === "GET") {
            return $this->queryArray;
        }

        if ($this->method === "POST" || $this->method === "PUT" || $this->method === "DELETE" ) {
            $body = [];
            foreach($_POST as $key => $value) {
                if(is_array($value)){
                    $body[$key] = explode(',',htmlspecialchars(implode(',', $value)));
                } else {
                    $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }

            }
            return $body;
        }
    }


    /**
     * Get the value of [Request class that contains the informations of the REQUEST_METHOD
     *
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Set the value of [Request class that contains the informations of the REQUEST_METHOD
     *
     * @param mixed $method
     *
     * @return self
     */
    public function setMethod($method)
    {
        $this->method = $method;

        return $this;
    }


}
