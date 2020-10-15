<?php


class MangaModel {
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    function getAllBySerie($idSerie){
        $query = "SELECT id, image, release_date, stock, volume
                  FROM mangas
                  WHERE serie_id = ?
                  ORDER BY volume DESC
        ";
        $results = $this->db->getQuery($query, [$idSerie]);

        return $results;
    }

    public function createManga($serie,$volume,$releaseDate,$stock,$filename) {
        $query = "INSERT INTO mangas (serie_id,volume,release_date,stock,image)
                 VALUES (?, ?, ?, ?, ?)
        ";

        return $this->db->postQuery($query,[$serie, $volume, $releaseDate, $stock, $filename]);
    }
}
