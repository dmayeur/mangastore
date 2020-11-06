<?php

class OrderController extends CoreController {
    protected $model;
    protected $request;

    public function __construct() {
        $this->model = new OrderModel();
    }

    public function getAll() {
        $results = $this->model->getAll();

        if($results) {
            $this->sendResponse(200, $results);
        } else {
            $this->sendResponse(404, [
                'errorMessage' => 'Aucune commande'
            ]);
        }
    }

    public function getById($id) {
        $result = $this->model->getbyId($id);

        if($result) {
            $this->sendResponse(200, $result);
        } else {
            $this->sendResponse(404, [
                'errorMessage' => 'Aucune commande'
            ]);
        }
    }

    public function create($body) {
        $auth = new Auth();

        try {
            $user = $auth->getUser($body->token);
        } catch (Exception $e) {
            throw new RestException("Erreur d'authentication",401);
        }

        $orderId = $this->model->create($user->id, date("Y-m-d H:i:s"), null, "In process");

        $mangaModel = new MangaModel();

        //putting orderLines
        foreach($body->items as $item) {
            $this->model->createOrderline($orderId, $item->id, $item->quantity);
        }

        //we calculate the total price with a SQL request
        $totalPrice = $this->model->getTotalPrice($orderId);

        //we finally save the price in the DB
        $this->model->changeTotalPrice($totalPrice['total_price'], $orderId);

        $this->sendResponse(200, 'Création de la commande réussie');
    }
}
