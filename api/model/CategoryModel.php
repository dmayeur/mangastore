<?php

class CategoryModel {
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    function getChilds($idParent){
        $query = "SELECT name, category_parent FROM categories
                WHERE category_parent = ?
        ;";

        $results = $this->db->getQuery($query,[$idParent]);

        return $results;

    }

    function getAll(){
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
}
