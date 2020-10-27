<?php

class PriceController extends CoreController{
    protected $model;

    public function __construct() {
        $this->model = new PriceModel();
    }

    public function getByEditor($editor) {
        $serie = $this->model->getByEditor($editor);
    }

}
