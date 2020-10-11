<?php

require_once("CoreModel.php");

class CoreModel {

    /**
     * [transformParameters transform the raw parameters into their where text associated with the values in the right orders]
     * @param  Array  $whereParameters [description]
     * @return [array]                  [array with the query text and the values associated]
     */
    private function transformParameters(Array $whereParameters){

        if(empty($whereParameters)){
            return [
                'text'=>"",
                'values'=>[]
            ];
        }

        //initialization
        $values=[];
        $whereQuery=" WHERE ";

        //the search is different from the others
        if(isset($whereParameters['search'])){
            $whereQuery .= "series.name LIKE ? ";
            $values[]='%'.$whereParameters['search'].'%';

            if(count($whereParameters)>1){
                $whereQuery .= " AND ";
            }

        }

        $text=[];
        foreach ($whereParameters as $columnName => $columnValues) {
            if($columnName != 'search'){
                $textInter = [];

                foreach ($columnValues as $value) {
                    $textInter[] .= ' ? ';
                    $values[] = $value;
                }

                $text[]= $columnName . ' IN (' . implode(', ', $textInter) . ')';

            }
        }

        // we separe each query part by AND
        $whereQuery .=  implode(' AND ', $text);
        return [
            'text'=>$whereQuery,
            'values'=>$values
        ];
    }
    
}
