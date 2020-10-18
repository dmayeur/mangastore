<?php

class EditorController extends CoreController{
    protected $model;
    protected $request;

    public function __construct($request) {
        $this->model = new EditorModel();
        $this->request = $request;
    }

    public function getById($id) {
        $serie = $this->model->getById($id);
    }

    public function getAll() {
        $results = $this->model->getAll();
        $this->checkResponse($results);
    }

    public function getPrice($id) {
        $results = $this->model->getPrices($id);
        $this->checkResponse($results);
    }

    public function create($id) {
        if(isset($_POST['editor'])){
            throw new RestException('Paramètre manquant',400);
        }

        $result = $this->model->create($_POST['editor']);
        if(!$result) {
            throw new RestException('Erreur SQL',400);
        } else {
            $this->sendResponse(201,$result);
        }
    }
}
