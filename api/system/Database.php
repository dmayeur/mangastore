<?php
/**
 * [Database class for all the PDO stuff]
 * functions are prefixed by the request method
 */
class Database{

    // specify your own database credentials
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $db_name = "mangastore";

    public $db;


    public function __construct() {
        $this->getConnection();
    }


    public function getConnection() {

        $this->db = null;

        $this->db = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name . ';charset=UTF8', $this->username , $this->password, [
                //tableau de config pour activer certaines options pour la base de données,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,  //ici affiche les erreurs sqls
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC //ici n'affiche pas les informations dupliquées
        ]);

        return $this->db;
    }

    public function getQuery($sql, $criteria = array()) {
        $query = $this->db->prepare($sql);
        $query->execute($criteria);
        return $query->fetchAll();
    }

    public function getQueryOne($sql, array $criteria = []) {
        $query = $this->db->prepare($sql);
        $query->execute($criteria);
        return $query->fetch();
    }

    public function postQuery(String $sql , $values) {
        $query = $this->db->prepare($sql);
        $query->execute($values);
        return $this->db->lastInsertId();
    }

    public function executeSQL(String $sql , $values) {
        $query = $this->db->prepare($sql);
        return $query->execute($values);
    }
}
