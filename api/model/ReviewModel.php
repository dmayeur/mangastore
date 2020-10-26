<?php

class ReviewModel {
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function create($serieId, $userId, $rating){
        $query = "INSERT INTO reviews (serie_id, user_id, rating)
                 VALUES (?, ?, ?)
        ";

        return $this->db->postQuery($query,[$serieId, $userId, $rating]);
    }

    public function modifyRating($serieId, $userId, $rating){
        $query = "UPDATE reviews
                 SET rating = ?
                 WHERE user_id = ? AND serie_id = ?
        ";

        return $this->db->postQuery($query,[$rating,$userId,$serieId]);
    }

    public function getReview($serieId,$userId){
        $query = "SELECT id, rating, content FROM reviews
                WHERE serie_id = ? AND user_id = ?;";

        return $this->db->getQueryOne($query, [$serieId, $userId]);
    }
}
