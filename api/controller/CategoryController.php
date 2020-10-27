<?php

class CategoryController extends CoreController{
    protected $model;

    public function __construct() {
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

    public function create($body) {
        var_dump($body);
        exit();
    }
}
