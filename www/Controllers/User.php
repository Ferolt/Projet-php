<?php

namespace App\Controllers;

use App\Core\View;
use App\Core\User as U;
use App\Model\UserModel;
use App\Validator\UserValidator;
use App\Validator\DataPostValidator;
use App\Core\SQL;
use App\Session\UserSession;

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
                    $isStarted = UserSession::startUserSession($array_data['user_id'], $user->getFirstname(), $user->getLastname());
                    if($isStarted) {
                        header("Location: /");
                        return;
                    }
                    $errors[] = "problème de session";
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $email = trim($_POST['email']);
            $password = $_POST['password'];

            $errors = [];
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Email invalide.";
            }
            if (empty($errors)) {
                $db = new SQL();
                $query = "SELECT * FROM user WHERE email = :email";
                $stmt = $db->getPdo()->prepare($query);
                $stmt->execute(['email' => $email]);
                $user = $stmt->fetch();

                if ($user && password_verify($password, $user['password'])) {
                    $isStarted = UserSession::startUserSession($user['id'], $user['firstname'], $user['lastname']);
                    if($isStarted) {
                        header("Location: /");
                        return;
                    }
                } else {
                    $errors[] = "Identifiants incorrects.";
                }
            }
            $view = new View("User/login.php", "back.php");
            $view->addData('errors', $errors);
            return;
        }
        $view = new View("User/login.php", "back.php");
        echo $view;
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
