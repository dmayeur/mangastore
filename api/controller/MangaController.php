<?php

class MangaController extends CoreController {
    protected $model;
    protected $request;
    protected $id=[];

    //the default sorting
    protected $sort="series.name";


    public function __construct($request) {
        $this->request = $request;
        $this->model = new MangaModel();

        if($request->getMethod()=='GET'){
            $this->queryToParameters($request->getBody());
        }
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

    public function getAll(){

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
