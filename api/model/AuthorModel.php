<?php

class AuthorModel {
    private $db;

    public function __construct(){
        $this->db = new Database();
    }



    function getAll(){
        $query ="SELECT id, name FROM authors
                ;";

        $results= $this->db->getQuery($query);
        
        return $results;
    }
}
