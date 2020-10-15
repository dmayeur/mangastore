<?php

class AuthorController extends CoreController{
    protected $model;
    protected $request;
    protected $author;

    public function __construct($request) {
        $this->request = $request;
        $this->model = new AuthorModel();
    }

    public function getAll() {
        $results = $this->model->getAll();
        if($results) {
            $this->sendResponse(200, $results);
        } else {
            $this->sendResponse(404, [
                'errorMessage' => 'Aucun résultat'
            ]);
        }
    }

    public function getById($id) {
        $results = $this->model->getById((int) $id);
        if($results) {
            $this->sendResponse(200, $results);
        } else {
            $this->sendResponse(404, [
                'errorMessage' => 'Aucun résultat'
            ]);
        }
    }

    public function bodyRequestToParameters($body){
        foreach ($body as $key => $value) {
            switch ($key) {
                case 'author':
                    $this->author=htmlspecialchars($value);
                    break;
            }
        }
    }

    public function create() {
        $this->bodyRequestToParameters($this->request->getBody());

        $result = $this->model->create($this->author);
        if(!$result) {
            throw new RestException('Erreur SQL',400);
        } else {
            $this->sendResponse(201,$result);
        }
    }

    public function modify($id) {
        $this->bodyRequestToParameters($this->request->getBody());

        $result = $this->model->modify($this->author,(int) $id);
        if(!$result) {
            throw new RestException('Erreur SQL',400);
        } else {
            $this->sendResponse(201,"Modification réussie");
        }
    }

    public function delete($id) {
        $result = $this->model->delete($id);
        if(!$result) {
            throw new RestException('Erreur SQL',400);
        } else {
            $this->sendResponse(201,'Supression réussie');
        }
    }
}
