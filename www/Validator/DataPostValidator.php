<?php

namespace App\Validator;

class DataPostValidator {
    static public function validate(array $post, array $arrRegisterKeys, int $length_post,)
    {
        $errors = [];
        if(count($post) == $length_post) {
            foreach($arrRegisterKeys as $key) {
                if(empty($post[$key])) {
                    $errors[] = "le champ $key est obligatoire";
                }
            }
            return $errors;
        }
        $errors[] = 'champ manquant'; 
        return $errors;
    }
}