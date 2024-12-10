<?php

namespace App\Controllers;

use App\Core\View;
use App\Core\SQL;
use App\Model\UserModel;

class HomeController {

    public function index() :void 
    {   
        session_start();
        if(empty($_SESSION["user_id"])) {
            header("Location: /se-connecter");
            return;
        }
        $view = new View("Home/index.php", "front.php");
    }

}