<?php

namespace App\Controllers;

use App\Core\User as U;
use App\Core\View;
use App\Validator\UserValidator;
use App\Model\UserModel;
use App\Validator\DataPostValidator;

class User
{

    public function register(): void
    {
        $errors = DataPostValidator::validate($_POST, ['email', 'firstname', 'lastname', 'pwd', 'pwdConfirme'], 5);
        if (empty($errors)) {
            $user = new UserModel();
            $user->setFirstname($_POST['firstname']);
            $user->setLastname($_POST['lastname']);
            $user->setEmail($_POST['email']);
            $user->setPwd($_POST['pwd']);

            $validator = new UserValidator($user, $_POST['pwdConfirme']);
            if(empty($validator->getErrors())) {
                
            }
        } else {
            var_dump($errors);
        }

        new View("User/register.php", "front.php");
        //echo $view;
    }

    public function login(): void
    {
        echo "Se connecter";
    }


    public function logout(): void
    {
        $user = new U();
        $user->logout();
        echo "Déconnexion";
    }
}
