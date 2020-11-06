<?php

class PriceModel {
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    function getByEditor($editor) {
        $query = "SELECT code, price, editor_name FROM prices
                LEFT JOIN editors on prices.editor_id=editors.id;
                WHERE editor_id = ?
                ;";

        return $this->db->getQuery($query, [$editor]);
    }

    function getAll(){

        $query = "SELECT code, price, editor_id FROM prices
                ;";

        $results = $this->db->getQuery($query);

        return $results;
    }

}
