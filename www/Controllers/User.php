<?php

namespace App\Controllers;

use App\Core\View;
use App\Core\User as U;
use App\Model\UserModel;
use App\Validator\UserValidator;
use App\Validator\DataPostValidator;

class User
{

    public function register(): void
    {
        $errors = [];
        if(count($_POST) == 0) {
            $view = new View("User/register.php", "front.php");
            return;
        }
        $errors = DataPostValidator::validate(
            $_POST,
            [
                'email',
                'firstname',
                'lastname',
                'password',
                'passwordConfirm',
                'country'
            ],
            6
        ); //Verifie si les champs existe et le nombre d'agument requise

        if (empty($errors)) {
            $user = new UserModel(); // la table user le champ email est unique, voir userMigration.php et le ficher Readme
            $user->setFirstname($_POST['firstname']);
            $user->setLastname($_POST['lastname']);
            $user->setEmail($_POST['email']);
            $user->setPwd($_POST['password']);
            $user->setCountry($_POST['country']);

            $validator = new UserValidator($user, $_POST['passwordConfirm']); //valide les données de chaque champ

            if (empty($validator->getErrors())) {
                $array_data = $user->save(); //return un taleau d'erreur ou id
                if (!$array_data["error"]) {
                    session_start();
                    $_SESSION["user_id"] = $array_data["user_id"];
                    $_SESSION["user_firstname"] = $user->getFirstname();
                    $_SESSION["user_lastname"] = $user->getLastname();
                    header("Location: /Home");
                    return;
                }

                $errors[] = "L'email est déjà utilser";
            } else {
                $errors = $validator->getErrors();
            }
        }
        $view = new View("User/register.php", "front.php");
        $view->addData('errors', $errors);
        return;
    }

    public function login(): void
    {
        new View("User/login.php", "front.php");
    }


    public function logout(): void
    {
        $user = new U();
        session_start();
        $user->logout();
        header("Location: /se-connecter");
        return;
    }
}
