<?php

class AuthorModel {
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    function getAll(){
        $query ="SELECT id, name FROM authors
                ORDER BY id DESC
                ;";

        $results= $this->db->getQuery($query);

        return $results;
    }

    function getById($id){
        $query ="SELECT id, name FROM authors
                WHERE id = ?
                ;";

        $results= $this->db->getQueryOne($query,[$id]);

        return $results;
    }

    function create($author) {
        $query = "INSERT INTO authors (name)
        VALUES (?)";

        return $this->db->postQuery($query,[$author]);
    }

    function modify($author,$id) {
        $query = "UPDATE AUTHORS
                 SET name = ?
                 WHERE id = ?";
        return $this->db->executeSQL($query,[$author,$id]);
    }

    function delete($id) {
        $query = "DELETE FROM authors
                 WHERE id = ?";

        return $this->db->executeSQL($query,[$id]);
    }
}
