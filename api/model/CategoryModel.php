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
}
