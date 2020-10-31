<?php

class CategoryModel {
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    function getChilds($idParent) {
        $query = "SELECT id, name, category_parent FROM categories
                WHERE category_parent = ?
        ;";

        $results = $this->db->getQuery($query,[$idParent]);

        return $results;

    }

    function getAllBySerie($id) {
        $query = "SELECT id, name FROM categories
                LEFT JOIN series_categories ON series_categories.category_id = categories.id
                WHERE serie_id = ?
        ;";

        $results = $this->db->getQuery($query,[$id]);

        return $results;
    }

    function getAll() {
        //get the parents categories, IE the ones without any parent
        $query ="SELECT name, id FROM categories
                WHERE category_parent IS NULL
                ;";

        $results= $this->db->getQuery($query);

        $categoriesParents=[];

        foreach ($results as $categoryParent) {
            $categoryParent['childs'] = $this->getChilds($categoryParent['id']);
            $categoriesParents[]=$categoryParent;
        }

        return $categoriesParents;
    }

    /**
     * [getAdmin return the list of all categories with CRUD intended display]
     * @return [mixed] [all categories or false if something wrong happened]
     */
    function getAdmin() {
        $query = "SELECT categories.id, categories.name as 'Catégorie', c2.name as 'Catégorie Parent' FROM categories
        LEFT JOIN categories c2 ON c2.id = categories.category_parent
        ORDER BY c2.name
        ;";

        return $this->db->getQuery($query);
    }

    function getById($id) {
        $query ="SELECT id, name, category_parent as parent FROM categories
                WHERE id = ?
                ;";

        $results= $this->db->getQueryOne($query,[$id]);

        return $results;
    }

    public function create($name, $categoryParent) {
        $query = "INSERT INTO categories (name, category_parent)
                 VALUES (?, ?)
        ";

        return $this->db->postQuery($query, [$name, $categoryParent]);
    }

    public function modify($id, $name, $categoryParent) {
        $query = "UPDATE categories
                 SET name = ?, category_parent = ?
                 WHERE id = ?
        ";

        return $this->db->postQuery($query, [$name, $categoryParent, $id]);
    }

    public function delete($id) {
        $query = "DELETE FROM categories
                 WHERE id = ?";

        return $this->db->executeSQL($query,[$id]);
    }
}
