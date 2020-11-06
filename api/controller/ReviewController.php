<?php

class ReviewController extends CoreController{
    protected $model;

    public function __construct() {
        $this->model = new ReviewModel();
    }

    public function getAll() {

        $results = $this->model->getAllAdmin();
        if($results) {
            $this->sendResponse(200, $results);
        } else {
            $this->sendResponse(404, [
                'errorMessage' => 'Aucun résultat'
            ]);
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
