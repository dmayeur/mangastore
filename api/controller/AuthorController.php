<?php

class AuthorController extends CoreController{
    protected $model;
    protected $request;

    public function __construct($request) {
        $this->request = $request;
        $this->model = new AuthorModel();
    }

    function getAll(){
        $results = $this->model->getAll();
        if($results) {
            $this->sendResponse(200, $results);
        } else {
            $this->sendResponse(404, [
                'errorMessage' => 'Aucun résultat'
            ]);
        }
    }
}
