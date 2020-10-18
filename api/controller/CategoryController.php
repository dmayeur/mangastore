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

    public function getAdmin() {
        $results = $this->model->getAdmin();

        $this->checkResponse($results);
    }

}
