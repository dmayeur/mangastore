<?php


class SerieModel extends CoreModel {
    private $db;

    private $table_name = "series";


    public function __construct(){
        $this->db = new Database();
    }


    function getAllPages($whereParameters, $orderBy, $search){
        $where = $this->transformParameters($whereParameters);

        $query = "SELECT COUNT(*) as nb_results FROM series
                  INNER JOIN authors_series ON authors_series.serie_id = series.id
                  INNER JOIN authors ON authors.id = authors_series.author_id
                  LEFT JOIN prices on series.price_code = prices.code
                  LEFT JOIN series_categories ON series.id = series_categories.serie_id
                  LEFT JOIN categories ON categories.id = series_categories.category_id
                  LEFT JOIN editors on editors.id = series.editor_id"
                  . $where['text'] .
                ";";
        $results = $this->db->getQueryOne($query,$where['values']);

        return $results;
    }



    /**
     * [getAllBasicInfos description]
     * @param  [type] $whereParameters [where parameters for filter searches]
     * @param  [type] $orderBy         [whitelisted tested parameters to avoid SQL injection]
     * @return [type]                  [description]
     */
    function getAllBasicInfos($whereParameters, $orderBy, $search, $page){
        $limit = 15;
        $offset = $limit * ($page-1);
        $where = $this->transformParameters($whereParameters);
        //Get the last manga for each serie
        $queryLastMangas = "SELECT * from mangas m1
        INNER JOIN (
            SELECT max(volume) as vol, serie_id as serie
            FROM mangas
            GROUP BY serie_id
        ) m2
        ON m1.volume = m2.vol AND m1.serie_id=m2.serie
        ORDER BY volume DESC";


        $query = "SELECT series.id as id, series.name as title, image, GROUP_CONCAT(DISTINCT authors.name SEPARATOR ', ') as author, price  FROM series
                  INNER JOIN
                  (
                      $queryLastMangas
                  ) m
                  ON m.serie_id = series.id
                  INNER JOIN authors_series ON authors_series.serie_id = series.id
                  INNER JOIN authors ON authors.id = authors_series.author_id
                  LEFT JOIN prices on series.price_code = prices.code
                  LEFT JOIN series_categories ON series.id = series_categories.serie_id
                  LEFT JOIN categories ON categories.id = series_categories.category_id
                  LEFT JOIN editors on editors.id = series.editor_id"
                  . $where['text'] .
                  "
                  GROUP BY series.id
                  ORDER BY $orderBy
                  LIMIT $limit OFFSET $offset
                ;";
        $results = $this->db->getQuery($query,$where['values']);

        return $results;
    }


    function getAllAdmin(){
        $query = "SELECT series.id as id, series.name as Titre, COUNT(DISTINCT mangas.volume) as 'Nb volumes', GROUP_CONCAT(DISTINCT authors.name SEPARATOR ', ') as Auteur, editors.name as Editeur  FROM series
                  LEFT JOIN mangas ON mangas.serie_id = series.id
                  LEFT JOIN authors_series ON authors_series.serie_id = series.id
                  LEFT JOIN authors ON authors.id = authors_series.author_id
                  LEFT JOIN series_categories ON series.id = series_categories.serie_id
                  LEFT JOIN categories ON categories.id = series_categories.category_id
                  LEFT JOIN editors on editors.id = series.editor_id
                  GROUP BY series.id
                  ORDER BY series.id desc
                ;";
        $results = $this->db->getQuery($query);

        return $results;
    }


    public function getById($id) {
        $query = "SELECT series.id as id, series.name as title, COUNT(DISTINCT volume) as nbVolumes, image, GROUP_CONCAT(DISTINCT authors.name) as author, price, editors.name as editor  FROM series
                  LEFT JOIN mangas ON mangas.serie_id = series.id
                  LEFT JOIN authors_series ON authors_series.serie_id = series.id
                  LEFT JOIN authors ON authors.id = authors_series.author_id
                  LEFT JOIN prices on series.price_code = prices.code
                  LEFT JOIN editors on series.editor_id = editors.id
                  WHERE series.id = ?
                  GROUP BY series.id

                ;";

        return $this->db->getQueryOne($query, [$id]);
    }

    public function create($name, $editor, $price){
        $query = "INSERT INTO series (name, editor_id, price_code)
                 VALUES (?, ?, ?)
        ";

        return $this->db->postQuery($query,[$name, $editor, $price]);
    }


    public function createCategory($serie, $category){
        $query = "INSERT INTO series_categories (serie_id,category_id)
                 VALUES (?, ?)
        ";

        return $this->db->postQuery($query,[$serie, $category]);
    }

    public function createAuthor($serie, $author){
        $query = "INSERT INTO authors_series (serie_id,author_id)
                 VALUES (?, ?)
        ";

        return $this->db->postQuery($query,[$serie, $author]);
    }

    function delete($id) {
        $query = "DELETE FROM series
                 WHERE id = ?";

        return $this->db->executeSQL($query,[$id]);
    }
}
