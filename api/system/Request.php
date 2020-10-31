<?php
// namespace dmayeur\mangastore\Request;

/**
 * [Request class that contains the informations of the REQUEST_METHOD
 *  Like the method used, or the request
 * ]
 */
class Request{

    protected $method;

    function __construct() {
        $method = "";

        if ($_SERVER['REQUEST_METHOD']==='GET') {
            $method="GET";
        }

        if ($_SERVER['REQUEST_METHOD']==='POST') {
            $method="POST";
            //the method is a post parameter for PUT and DELETE since html has poor support of it
            if(isset($_POST['method'])){
                $method = strtoupper($_POST['method']);
            }
        }

        $this->method=$method;
    }

    function getRequest() {
        if($this->method == "GET") {
            // we build it that way because we want the user to be able to call ?category=x&category=y so $_GET is no good
            $this->queryArray=[];
            if( isset($_SERVER['REDIRECT_QUERY_STRING']) && !empty($_SERVER['REDIRECT_QUERY_STRING']) ) {
                $queryString = urldecode($_SERVER['REDIRECT_QUERY_STRING']);
                return explode("&",$queryString);
            }

        } else {

            if($_SERVER['CONTENT_TYPE'] == "application/json"){
                return json_decode(file_get_contents('php://input'));
            } else {
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
    }


    /**
     * Get the method
     *
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

}
