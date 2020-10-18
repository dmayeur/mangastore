<?php


class MangaModel extends CoreModel {
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


    function getAll($whereParameters){
        $where = $this->transformParameters($whereParameters);

        $query = "SELECT mangas.id, series.name, volume, image, price from mangas
        LEFT JOIN series ON mangas.serie_id = series.id
        LEFT JOIN prices on series.price_code = prices.code"
        . $where['text'];

        $results = $this->db->getQuery($query,$where['values']);
        return $results;
    }
}
