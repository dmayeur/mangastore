<?php

class CoreController{
    protected $httpVersion = "HTTP/1.1";
    protected $statusCode;
    protected $body;

    /**
     * [setHttpHeaders set the header appropriately]
     * @param [int] $statusCode [the code of the header]
     */
	public function setHttpHeaders($statusCode){

		$statusMessage = $this -> getHttpStatusMessage($statusCode);

		header($this->httpVersion. " ". $statusCode ." ". $statusMessage);

		header("Content-Type: application/json; charset=UTF-8");

	}

    /**
     * [getHttpStatusMessage easy way of having the string of the error code]
     * @param  [int] $statusCode [the status code]
     * @return [String]             [return the string to the corresponding code]
     */
	public function getHttpStatusMessage(int $statusCode){
		$httpStatus = array(
			100 => 'Continue',
			101 => 'Switching Protocols',
			200 => 'OK',
			201 => 'Created',
			202 => 'Accepted',
			203 => 'Non-Authoritative Information',
			204 => 'No Content',
			205 => 'Reset Content',
			206 => 'Partial Content',
			300 => 'Multiple Choices',
			301 => 'Moved Permanently',
			302 => 'Found',
			303 => 'See Other',
			304 => 'Not Modified',
			305 => 'Use Proxy',
			306 => '(Unused)',
			307 => 'Temporary Redirect',
			400 => 'Bad Request',
			401 => 'Unauthorized',
			402 => 'Payment Required',
			403 => 'Forbidden',
			404 => 'Not Found',
			405 => 'Method Not Allowed',
			406 => 'Not Acceptable',
			407 => 'Proxy Authentication Required',
			408 => 'Request Timeout',
			409 => 'Conflict',
			410 => 'Gone',
			411 => 'Length Required',
			412 => 'Precondition Failed',
			413 => 'Request Entity Too Large',
			414 => 'Request-URI Too Long',
			415 => 'Unsupported Media Type',
			416 => 'Requested Range Not Satisfiable',
			417 => 'Expectation Failed',
			500 => 'Internal Server Error',
			501 => 'Not Implemented',
			502 => 'Bad Gateway',
			503 => 'Service Unavailable',
			504 => 'Gateway Timeout',
			505 => 'HTTP Version Not Supported');
		return ($httpStatus[$statusCode]) ? $httpStatus[$statusCode] : $status[500];
	}


    public function sendResponse($status, $response = ""){
        $this->setHttpHeaders($status);
        $response = json_encode($response, JSON_FORCE_OBJECT);
        echo($response);
        exit();
    }

    /**
     * [checkResponse check is the response is empty or not and send it with the appropriate header]
     * @param  [mixed] $results [the result of the query]
     * @return [type]          [description]
     */
    public function checkPost($result){

            //no result
            if( empty($result) || !$result ) {
                $this->setHttpHeaders('404');
                exit();
            }

            $this->setHttpHeaders('201');

            exit();
    }




    /**
     * [checkResponse check is the response is empty or not and send it with the appropriate header]
     * @param  [mixed] $results [the result of the query]
     * @return [type]          [description]
     */
    public function checkResponse($results){

            //no result
            if( empty($results) || !$results ) {
                $this->setHttpHeaders('404');
                exit();
            }

            //We
            $results = json_encode($results, JSON_FORCE_OBJECT);
            $this->setHttpHeaders('200');
            echo $results;
            exit();
    }


}
