<?php

class EditorModel {
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    function getPrices($editor) {
        $query = "SELECT name as editor, code as price_code, price FROM editors
                INNER JOIN prices on prices.editor_id=editors.id
                WHERE editors.id = ?
                ;";

        return $this->db->getQuery($query, [$editor]);
    }

    function getAll(){

        $query = "SELECT id, name FROM editors
                ;";

        $results = $this->db->getQuery($query);

        return $results;
    }

    function getById($id) {
        $query = "SELECT id, name FROM editors
                WHERE id = ?
                ;";

        $results = $this->db->getQueryOne($query, [$id]);

        return $results;
    }

    function createPrice($editor, $price, $code) {
        $query = "INSERT INTO prices (editor_id, price, code)
                VALUES (?, ?, ?)
        ";

        return $this->db->postQuery($query, [$editor, $price, $code]);
    }

    function create($name) {
        $query = "INSERT INTO editors (name)
                 VALUES (?)
        ";

        return $this->db->postQuery($query, [$name]);
    }

    function modify($id, $name) {
        $query = "UPDATE editors
                 SET name = ?
                 WHERE id = ?";
        return $this->db->executeSQL($query, [$name, $id]);
    }
}
