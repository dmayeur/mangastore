<?php

class PriceController extends CoreController{
    protected $model;
    protected $request;

    public function __construct($request) {
        $this->model = new PriceModel();
        $this->request = $request;
    }

    public function getByEditor($editor) {
        $serie = $this->model->getByEditor($editor);
    }


    public function handleGetRequest() {

        $results = null;

        switch( count($this->request->getUrlParts()) ) {
            case 2:

        }

        $this->checkResponse($results);


    }
}
