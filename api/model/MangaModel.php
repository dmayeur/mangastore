<?php
require_once("CoreModel.php");


class MangaModel {
    private $db;

    private $table_name = "mangas";


    public function __construct(){
        $this->db = new Database();
    }

    function getAllBySerie($idSerie){
        $query = "SELECT id, image, release_date, stock, volume
                  FROM $this->table_name
                  WHERE serie_id = ?
                  ORDER BY volume DESC
        ";
        $results = $this->db->getQuery($query, [$idSerie]);

        return $results;
    }

}
