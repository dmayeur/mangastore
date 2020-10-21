<?php

class OrderController extends CoreController {
    protected $model;
    protected $request;

    public function __construct($request) {
        $this->request = $request;
        $this->model = new SerieModel();
    }

    public function create() {
        // var_dump(json_decode(($_POST['mangas'])));
        // 
        var_dump($this->request->getJSON());
        // $test = json_decode($_POST[0]);
        // foreach ($test as $test2){
            // var_dump($test2->id);
        // }
        exit();
    }
}
