<?php

class SerieController extends CoreController{
    protected $model;
    protected $request;
    protected $editors=[];
    protected $categories=[];
    protected $search="";
    protected $page=1;
    protected $content;

    //the default sorting
    protected $sort="series.name";


    public function __construct($request) {
        $this->request = $request;
        $this->model = new SerieModel();

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
                case 'editor':
                    $this->editors[]=$value;
                    break;
                case 'category':
                    $this->categories[]=$value;
                    break;
                case 'sort':
                    switch ($value) {
                        case 'date':
                            $this->sort="release_date DESC";
                            break;
                        default:
                            $this->sort="series.name";
                            break;
                    }
                    break;
                case 'search':
                    $this->search = $value;
                    break;
                case 'page':
                    $this->page = (int) $value;
                    break;
                case 'content':
                    //we sanatize even before putting them into the db
                    $this->content = htmlspecialchars($value);
                    break;
            }
        }

        if($this->page == 0){
            $this->page = 1;
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

        if(!empty($this->search)){
            $whereQuery['search'] = $this->search;
        }

        return $whereQuery;
    }

    public function getById($id) {
        $serie = $this->model->getById($id);
        if( !empty($serie) && $serie ){
            $mangaModel = new MangaModel();
            $serie['mangas'] = $mangaModel->getAllBySerie($id);
        }

        $this->checkResponse($serie);
    }

    public function getAllBasicInfos() {
        $results = $this->model->getAllBasicInfos($this->parametersToArrays(),$this->sort,$this->search,$this->page);

        if($results) {
            $response['data']=$results;
            $nbResults = $this->model->getAllPages($this->parametersToArrays(),$this->sort,$this->search);
            $response['nb_results']=$nbResults['nb_results'];
            $response['pages']=ceil($nbResults['nb_results']/15);
            $this->sendResponse(200, $response);
        } else {
            $this->sendResponse(404, [
                'errorMessage' => 'Aucun résultat pour cette recherche'
            ]);
        }
    }

    public function getAllAdmin() {
        $results = $this->model->getAllAdmin();
        if($results) {
            $this->sendResponse(200, $results);
        } else {
            $this->sendResponse(404, [
                'errorMessage' => 'Aucun résultat'
            ]);
        }
    }

    public function delete($id){
        var_dump($id);
    }
}
