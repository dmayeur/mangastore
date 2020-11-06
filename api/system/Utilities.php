<?php

class Utilities {
    public function __construct(){

    }

    //clean string in a meaninfulway for prettier filenames
    public function hyphenize($string) {
        return strtolower(
            preg_replace(
              array( '#[\\s-]+#', '#[^A-Za-z0-9. -]+#' ),
              array( '-', '' ),
              $this->cleanString(
                 $string
              )
            )
        );
    }

    public function cleanString($text) {
        $utf8 = array(
            '/[áàâãªä]/u'   =>   'a',
            '/[ÁÀÂÃÄ]/u'    =>   'A',
            '/[ÍÌÎÏ]/u'     =>   'I',
            '/[íìîï]/u'     =>   'i',
            '/[éèêë]/u'     =>   'e',
            '/[ÉÈÊË]/u'     =>   'E',
            '/[óòôõºö]/u'   =>   'o',
            '/[ÓÒÔÕÖ]/u'    =>   'O',
            '/[úùûü]/u'     =>   'u',
            '/[ÚÙÛÜ]/u'     =>   'U',
            '/ç/'           =>   'c',
            '/Ç/'           =>   'C',
            '/ñ/'           =>   'n',
            '/Ñ/'           =>   'N',
            '/–/'           =>   '-', // UTF-8 hyphen to "normal" hyphen
            '/[’‘‹›‚]/u'    =>   ' ', // Literally a single quote
            '/[“”«»„]/u'    =>   ' ', // Double quote
            '/ /'           =>   ' ', // nonbreaking space (equiv. to 0x160)
        );
        return preg_replace(array_keys($utf8), array_values($utf8), $text);
    }

    //basic filecheck
    function checkImage($file){
        $taille_maxi = 100000000;
        $taille = filesize($file['tmp_name']);

        $extensions = [
            '.png' => 1,
            '.gif' => 1,
            '.jpg' => 1,
            '.jpeg' => 1
        ];

        $extension = strrchr($file['name'], '.');

        if(!isset($extensions[$extension])){ //If wrong extension
            throw new RestException("Seulement les fichiers png,gif,jpg ou jpeg sont acceptés",400);
        }

        if($taille>$taille_maxi){ //If file is too big
            throw new RestException("Le fichier envoyé est trop gros",400);
        }
    }


    public function uploadImage($file,$title,$fullpath){
        $dir = "../front/src/media/covers/";

        //create the serie directory if it doesn't exist
        //since we name it ourselves, we don't really care about replacing existing file, it will only happen in case you replace the file for an existing volume, which is fine
        if (!file_exists($dir. $title .'/')) {
            mkdir($dir . $title, 0755, true);
        }


        if (move_uploaded_file($file['tmp_name'],$dir . $fullpath)){
            return true;
        } else {
            throw new RestException("Erreur lors de l'upload du fichier", 500);
        }
    }
}
