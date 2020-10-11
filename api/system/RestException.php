<?php

class RestException extends Exception {
    public function __construct($message, $code){
        parent::__construct($message, $code);
    }

    public function toJSON(){
        $message = [
            'error'=>$this->message
        ];

        return json_encode($message, JSON_FORCE_OBJECT);
    }
}
