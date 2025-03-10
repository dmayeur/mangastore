<?php

class MangaController extends CoreController {
    protected $model;
    protected $request;
    protected $id = [];
    protected $categories = [];

    //the default sorting
    protected $sort="series.name";


    public function __construct() {
        $this->model = new MangaModel();

    }

    public function queryToParameters($queryURL) {
        if(empty($queryURL)){
            return;
        }

        //the main controller already split each query part into an array
        foreach ($queryURL as $queryPart) {

            //The parts of the query are separated by an =
            list($key,$value) = explode("=",$queryPart);
            //we do a switch to do a whitelist of acceptable parameters (others are just ignored)
            switch ($key) {
                case 'id':
                    $this->id[]=$value;
                    break;
                case 'category';
                    $this->categories[]=$value;
            }
        }
    }


    public function parametersToArrays(){
        $whereQuery = [];

        if(!empty($this->id)){
            $whereQuery['mangas.id'] = $this->id;
        }

        return $whereQuery;
    }

    public function getAll($request){
        $this->queryToParameters($request);

        $results = $this->model->getAll($this->parametersToArrays());

        if($results) {
            $this->sendResponse(200, $results);
        } else {
            $this->sendResponse(404, [
                'errorMessage' => 'Aucun résultat'
            ]);
        }
    }
}
