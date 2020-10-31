<?php

class OrderController extends CoreController {
    protected $model;
    protected $request;

    public function __construct() {
        $this->model = new SerieModel();
    }

    public function create($body) {
        var_dump($body);
        // $test = json_decode($_POST[0]);
        foreach ($body as $item){
            var_dump($test2->id);
        }
        exit();
    }
}
