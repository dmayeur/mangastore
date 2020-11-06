<?php
class RestException extends Exception {
    public function __construct($message, $code){
        parent::__construct($message, $code);
    }

    function customException($e) {
        //it's either an error we threw ourselves
        if($e instanceof RestException){
            $coreController = new CoreController();
            $coreController->setHttpHeaders($e->getCode());
            $error = [
                'errorMessage' => $e->getMessage(),
            ];
        //or an unplanned one
        } else {
            $coreController = new CoreController();
            $coreController->setHttpHeaders('500');
            $error = [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ];
        }
        $error =  json_encode($error, JSON_FORCE_OBJECT);
        echo($error);
        exit();
    }
}
