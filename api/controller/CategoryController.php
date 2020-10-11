<?php

class CategoryController extends CoreController{
    protected $model;
    protected $request;

    public function __construct($request) {
        $this->request = $request;
        $this->model = new CategoryModel();
    }

    public function getAll(){
        $results = $this->model->getAll();
        $this->checkResponse($results);
    }

    public function handleGetRequest() {

        $results = null;

        if(count($this->request->getUrlParts())==1) {
            $results = $this->model->getAll();
        }

        $this->checkResponse($results);

    }
}
