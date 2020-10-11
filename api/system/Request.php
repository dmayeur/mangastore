<?php
// namespace dmayeur\mangastore\Request;

/**
 * [Request class that contains the informations of the REQUEST_METHOD
 *  Like the method used, the url parts, the body of the request
 * ]
 */
class Request{

    protected $method;
    protected $urlParts;
    protected $queryArray;

    function __construct() {
        $this->request();

        if(isset($_POST['token'])){
            
        }
    }

    function request() {
        //we remove trailing /
        $request = rtrim( $_SERVER['REDIRECT_URL'] , '/');

        //separate each part of the url
        $parameters = explode("/",$request);

        //we remove the useless first elements
        $this->urlParts = array_splice($parameters, 3);

        $request = implode("/",$parameters);


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

    public function getBody() {
        if($this->method === "GET") {
            return $this->queryArray;
        }


        if ($this->method === "POST" || $this->method === "PUT" || $this->method === "DELETE" ) {
            $body = [];
            foreach($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
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

    /**
     * Get the value of Url Parts
     *
     * @return mixed
     */
    public function getUrlParts()
    {
        return $this->urlParts;
    }

    /**
     * Set the value of Url Parts
     *
     * @param mixed $urlParts
     *
     * @return self
     */
    public function setUrlParts($urlParts)
    {
        $this->urlParts = $urlParts;

        return $this;
    }

    /**
     * Get the value of Query Array
     *
     * @return mixed
     */
    public function getQueryArray()
    {
        return $this->queryArray;
    }

    /**
     * Set the value of Query Array
     *
     * @param mixed $queryArray
     *
     * @return self
     */
    public function setQueryArray($queryArray)
    {
        $this->queryArray = $queryArray;

        return $this;
    }

}
