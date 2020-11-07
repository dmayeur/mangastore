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


    public function __construct() {
        $this->model = new SerieModel();
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
                        case 'rating':
                            $this->sort = "avg(rating) DESC";
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
        if( $serie ){
            $mangaModel = new MangaModel();
            $serie['mangas'] = $mangaModel->getAllBySerie($id);
            $categoryModel = new CategoryModel();
            $serie['categories'] = $categoryModel->getAllBySerie($id);
            $authorModel = new AuthorModel();
            $serie['authors'] = $authorModel->getAllBySerie($id);
            $this->sendResponse(200, $serie);
        } else {
            $this->sendResponse(404, [
                'errorMessage' => 'Série non trouvé'
            ]);
        }
    }

    public function getAllBasicInfos($request) {
        $this->queryToParameters($request);
        $whereQuery = $this->parametersToArrays();
        $results = $this->model->getAllBasicInfos($whereQuery, $this->sort, $this->search, $this->page);

        if($results) {
            $response['data']=$results;
            $nbResults = $this->model->getAllPages($whereQuery, $this->sort, $this->search);
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


    public function create($body){

        if (empty($body['name']) || empty($body['categories'][0]) || empty($body['editor']) || empty($body['price']) || empty($body['authors'][0]) ){
            throw new RestException('Paramètres manquants',401);
        }

        $serieId = $this->model->create($body['name'],$body['editor'],$body['price']);

        if(!$serieId){
            throw new RestException("Erreur",400);
        }

        foreach ($body['categories'] as $category) {
            $this->model->createCategory($serieId,$category);
        }

        foreach ($body['authors'] as $author) {
            $this->model->createAuthor($serieId,$author);
        }

        $this->sendResponse(201,[
            'message' => 'Création réussie',
            'id' => $serieId
        ]);


    }

    public function createAuthor($id, $body) {
        $idAuthor = $this->model->createAuthor($id,$body['author']);

        $this->sendResponse(201,[
            'message' => 'Création réussie'
        ]);

    }

    public function deleteAuthor($id,$idAuthor) {
        $result = $this->model->deleteAuthor($id, $idAuthor);
        $this->sendResponse(201,'Supression réussie');
    }

    public function createCategories($id, $body) {
        foreach ($body['categories'] as $category) {
            $this->model->createCategory($id,$category);
        }

        $this->sendResponse(201,[
            'message' => 'Création réussie',
            'id' => $id
        ]);

    }


    public function deleteCategory($id) {
        $result = $this->model->deleteCategory($id, $body['category']);
        if(!$result) {
            throw new RestException('Erreur SQL',500);
        } else {
            $this->sendResponse(204,'Supression réussie');
        }
    }

    public function createManga($id, $body) {
        $serie = $this->model->getById($id);
        if( !$serie ){
            throw new RestException("Aucune série correspondant à l'id",404);
        }
        $filename = null;
        if (isset($_FILES['cover'])){
            $image = $_FILES['cover'];

            $utilities = new Utilities();
            try {
                $utilities->checkImage($image);
            } catch (RestException $e) {
                throw new RestException($e->getMessage(),$e->getCode());
            }

            $title = $utilities->hyphenize($serie['title']);
            $filename = $title . '/' . $title . '-' . $body['volume'] . strrchr($image['name'], '.') ;
            $utilities->uploadImage($image,$title,$filename);

        }
        $mangaModel = new MangaModel();
        $mangaModel->createManga($id, $body['volume'], $body['releaseDate'], $body['stock'], $filename);


    }

    public function modifyManga($idSerie, $idManga, $body) {
        $mangaModel = new MangaModel();
        $manga = $mangaModel->getById($idManga);

        //we initialize with the current value to not change it in case there's no new image uploaded
        $filename = $manga['image'];

        if (isset($_FILES['cover'])){
            $image = $_FILES['cover'];

            $utilities = new Utilities();
            try {
                $utilities->checkImage($image);
            } catch (RestException $e) {
                throw new RestException($e->getMessage(),$e->getCode());
            }

            $title = $utilities->hyphenize($manga['serie']);
            $filename = $title . '/' . $title . '-' . $manga['volume'] . strrchr($image['name'], '.') ;
            $utilities->uploadImage($image,$title,$filename);

        }

        $mangaModel = new MangaModel();
        $mangaModel->modifyManga($idSerie, $idManga, $body['release_date'], $body['stock'], $filename);
    }

    public function getReviews($id) {

        $reviewModel = new ReviewModel();

        $results = $reviewModel->getAll($id);

        if($results) {
            $this->sendResponse(200, $results);
        } else {
            $this->sendResponse(404, [
                'errorMessage' => 'Aucune critique pour cette série'
            ]);
        }
    }

    public function createReview($id, $body) {
        if( empty($body['token']) || empty($body['rating']) ) {
            throw new RestException('Paramètres attendu: "token" et "rating".', 401);
        }

        $auth = new Auth();

        try {
            $user = $auth->getUser($body['token']);
        } catch (Exception $e) {
            throw new RestException("Erreur avec le token", 401);
        }

        $reviewModel = new ReviewModel();

        try {
            $result = $reviewModel->create($id, $user->id, $body['rating']);
        } catch (Exception $e) {
            throw new RestException("Série ou utilisateur inexistant", 401);
        }

        $this->sendResponse(201, [
            'message' => 'Création de la note réussie',
            'rating' => $body['rating']
        ]);
    }

    public function modifyRating($id, $body) {

        if( empty($body['token']) || empty($body['rating']) ) {
            throw new RestException('Paramètres attendu: "token" et "rating".', 401);
        }

        $auth = new Auth();

        try {
            $user = $auth->getUser($body['token']);
        } catch (Exception $e) {
            throw new RestException("Erreur avec le token", 401);
        }

        $reviewModel = new ReviewModel();

        try {
            $result = $reviewModel->modifyRating($id, $user->id, $body['rating']);
        } catch (Exception $e) {
            throw new RestException("Série ou utilisateur inexistant", 401);
        }

        $this->sendResponse(201, [
            'message' => 'Modification de la note réussie',
            'rating' => $body['rating']
        ]);
    }

    public function modifyReview($id, $body) {

        $auth = new Auth();

        try {
            $user = $auth->getUser($body['token']);
        } catch (Exception $e) {
            throw new RestException("Erreur d'authentication", 401);
        }

        $reviewModel = new ReviewModel();

        $result = $reviewModel->modifyReview($id, $user->id, $body['content']);

        $this->sendResponse(201, [
            'message' => 'Modification de la critique réussie',
            'content' => $body['content']
        ]);

    }

    public function delete($id){
        $result = $this->model->delete($id);

        $this->sendResponse(201,'Supression réussie');
    }


}
