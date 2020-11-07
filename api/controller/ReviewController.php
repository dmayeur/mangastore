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


    /**
     * [delete the method just remove the review but keep the rating]
     */
    public function delete($id) {
        $result = $this->model->deleteReview($id);
        if(!$result) {
            throw new RestException('Erreur SQL',500);
        } else {
            $this->sendResponse(204,'Supression réussie');
        }
    }
}
