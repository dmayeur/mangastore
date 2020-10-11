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

}
