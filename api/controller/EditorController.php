<?php

class EditorController extends CoreController{
    protected $model;
    protected $request;

    public function __construct() {
        $this->model = new EditorModel();
    }

    public function getById($id) {
        $result = $this->model->getById($id);
        if (!$result) {
            throw new RestException('Editeur non trouvé',404);
        }

        $result['prices'] = $this->model->getPrices($id);

        $this->sendResponse(200,$result);
    }

    public function getAll() {
        $results = $this->model->getAll();
        $this->checkResponse($results);
    }

    public function getPrice($id) {
        $results = $this->model->getPrices($id);
        $this->checkResponse($results);
    }

    public function create($body) {
        if(!isset($body['editor'])){
            throw new RestException('Paramètre manquant',400);
        }

        $result = $this->model->create($body['editor']);

        $this->sendResponse(201,$result);
    }

    public function createPrice($id, $body) {
        if( empty($body['price']) || empty($body['priceCode']) ){
                throw new RestException('Paramètres attendu: "price" et "priceCode"',400);
        }

        $id = $this->model->createPrice($id, $body['price'], $body['priceCode']);

        $this->sendResponse(201,[
            'id' => $id,
            'price' => $body['price'],
            'price_code' => $body['priceCode']
        ]);
    }

    public function modify($id, $body) {
        if(!isset($body['editor'])){
            throw new RestException('Paramètre manquant',400);
        }

        $this->model->modify($id, $body['editor']);

        $this->sendResponse(201,"Modification réalisée avec succès");
    }
}
