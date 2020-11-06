<?php

class UserModel {
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function getByUsername($username){
        $query = "SELECT username, email, password, role, id FROM users
                WHERE username = ?";

        return $this->db->getQueryOne($query,[$username]);
    }

    public function getByEmail($email){
        $query = "SELECT username, email,  password, role, id FROM users
                WHERE email = ?";

        return $this->db->getQueryOne($query,[$email]);
    }

    public function getById($id){
        $query = "SELECT username, email,  password, role, id FROM users
                WHERE id = ?";

        return $this->db->getQueryOne($query,[$id]);
    }

    public function createAccount($values){
        $query = "INSERT INTO users (username, password, email, firstname, lastname, address, zip_code, city, created_at)
                VALUES (?, ? ,?, ?, ?, ?, ?, ?, ?)
        ;";
        $values[]=date("Y-m-d H:i:s");
        return $this->db->postQuery($query,$values);
    }

    public function getDetails($id) {
        $query = "SELECT username, email, firstname, lastname, address, zip_code, city, country FROM users
                WHERE id = ?";

        return $this->db->getQueryOne($query,[$id]);
    }
}
