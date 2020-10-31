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

    public function getById($id){
        $results = $this->model->getById($id);
        $this->checkResponse($results);
    }

    public function getAdmin() {
        $results = $this->model->getAdmin();

        $this->checkResponse($results);
    }

    public function create($body) {

        if (empty($body['category']) ){
            throw new RestException('Paramètre manquant: category',401);
        }

        $categoryParent = null;
        if (isset($body['categoryParent'])) {
            $categoryParent = $body['categoryParent'];
        }

        $result = $this->model->create($body['category'], $categoryParent);

        $this->sendResponse(201,$result);
    }

    public function delete ($id) {
        $result = $this->model->delete($id);

        $this->sendResponse(201,'Supression réussie');
    }

    public function modify($id, $body) {
        if (empty($body['category']) ){
            throw new RestException('Paramètre manquant: category',401);
        }

        $categoryParent = null;
        if (isset($body['categoryParent'])) {
            $categoryParent = $body['categoryParent'];
        }

        $result = $this->model->modify($id, $body['category'], $categoryParent);

        $this->sendResponse(201,'Modification de la catégorie réussie');
    }
}
