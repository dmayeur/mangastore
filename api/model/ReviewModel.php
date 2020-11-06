<?php

class ReviewModel {
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function getAll($serieId) {
        $query = "SELECT reviews.id, rating, content, username FROM reviews
                LEFT JOIN users ON reviews.user_id = users.id
                WHERE serie_id = ? and content IS NOT NULL
        ";

        return $this->db->getQuery($query, [$serieId]);
    }

    public function getAllAdmin() {
        $query = "SELECT reviews.id, username as pseudo, rating as note, content as critique, series.name as serie FROM reviews
                LEFT JOIN users ON reviews.user_id = users.id
                LEFT JOIN series ON reviews.serie_id = series.id
                WHERE content IS NOT NULL
        ";

        return $this->db->getQuery($query);
    }

    public function create($serieId, $userId, $rating) {
        $query = "INSERT INTO reviews (serie_id, user_id, rating)
                 VALUES (?, ?, ?)
        ";

        return $this->db->postQuery($query,[$serieId, $userId, $rating]);
    }

    public function modifyRating($serieId, $userId, $rating) {

        $query = "UPDATE reviews
                 SET rating = ?
                 WHERE user_id = ? AND serie_id = ?
        ";

        return $this->db->postQuery($query, [$rating,$userId,$serieId]);
    }

    public function modifyReview($serieId, $userId, $review) {

        $query = "UPDATE reviews
                 SET content = ?
                 WHERE user_id = ? AND serie_id = ?
        ";

        return $this->db->postQuery($query, [$review, $userId, $serieId]);
    }

    public function getReview($serieId,$userId) {
        $query = "SELECT id, rating, content FROM reviews
                WHERE serie_id = ? AND user_id = ?;";

        return $this->db->getQueryOne($query, [$serieId, $userId]);
    }
}
