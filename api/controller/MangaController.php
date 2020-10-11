<?php

class MangaController extends CoreController{
    protected $model;

    protected $editors=[];
    protected $categories=[];
    protected $value=null;

    public function __construct($queryURL) {
        $this->model = new MangaModel();
        $this->queryURLtoParameters($queryURL);
    }

    public function queryURLtoParameters($queryURL) {
        if(empty($queryURL)){
            return;
        }

        //the main controller already split each query part into an array
        foreach ($queryURL as $queryPart) {

            //The parts of the query are separated by an =
            list($key,$value) = explode("=",$queryPart);

            //we do a switch to do a whitelist of acceptable parameters (others are just ignored)
            switch ($key) {
                case 'sort':
                    $this->sort=$value;
                    break;
            }
        }
    }


    public function parametersToArrays(){
        $whereQuery = [];

        if(!empty($this->editors)){
            $whereQuery['editors.name'] = $this->editors;
        }

        if(!empty($this->categories)){
            $whereQuery['categories.name'] = $this->categories;
        }

        return $whereQuery;
    }

    public function getById($id) {
        $serie = $this->model->getById($id);
    }


    public function handleRequest($parameters) {

        $this->parametersToArrays();
        $results = null;
        if(!empty($this))
        switch( count($parameters) ) {
            case 1:

                $results = $this->model->getAllSorted();;
                break;
            case 2:
                $id = $parameters[1];
                $results = $this->model->getById($id);
                if( !empty($results) && $results ){
                    $mangaModel = new MangaModel();
                    $results['mangas'] = $mangaModel->getAllBySerie($id);
                }
                break;
            case 3:
                $id = $parameters[1];
                switch($parameters[2]){
                    case 'mangas':
                        $mangaModel = new MangaModel();
                        $results = $mangaModel->getAllBySerie($id);
                        break;
                    case 'reviews':
                        break;
                }
                break;
        }

        $this->checkResponse($results);


    }
}
