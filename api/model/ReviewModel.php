<?php

class ReviewModel {
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function create($serieId, $userId, $content){

    }

    public function getReview($serieId,$userId){
        $query = "SELECT id, rating, content FROM reviews
                WHERE serie_id = ? AND user_id = ?;";

        return $this->db->getQueryOne($query, [$serieId, $userId]);
    }
}
