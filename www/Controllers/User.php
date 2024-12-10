<?php
namespace App\Controllers;

use App\Core\User as U;
use App\Core\View;
use App\Core\SQL;
use PDOException;

class User
{

public function register(): void
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        $passwordConfirm = $_POST['passwordConfirm'];
        $firstname = trim($_POST['firstname']);
        $lastname = trim($_POST['lastname']);
        $country = trim($_POST['country']);

        $errors = [];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email invalide.";
        }

        $db = new SQL();
        $query = "SELECT COUNT(*) FROM user WHERE email = :email";
        $stmt = $db->getPdo()->prepare($query);
        $stmt->execute(['email' => $email]);
        $emailExists = $stmt->fetchColumn();

        if ($emailExists) {
            $errors[] = "L'email est déjà utilisé.";
        }

        if ($password !== $passwordConfirm) {
            $errors[] = "Les mots de passe ne correspondent pas.";
        }
        if (strlen($password) < 5) {
            $errors[] = "Le mot de passe doit avoir 5 caractères.";
        }

        if (empty($errors)) {

            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            $query = "INSERT INTO user (email, password, firstname, lastname, country) VALUES (:email, :password, :firstname, :lastname, :country)";
            $stmt = $db->getPdo()->prepare($query);
            try {
                $db->getPdo()->beginTransaction();
                $stmt->execute([
                    'email' => $email,
                    'password' => $hashedPassword,
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'country' => $country,
                ]);
                $id = $db->getPdo()->lastInsertId();
                session_start();
                $_SESSION["user_id"] = $id;
                $_SESSION["user_firstname"] = $firstname;
                $_SESSION["user_lastname"] = $lastname;
                header("Location: /Home");
                exit();
            }catch( PDOException $e) {
                $errors[] = $e;
                $view = new View("User/register.php", "front.php");
                $view->addData('errors', $errors);
                return;                
            }
          
        } else {
            $view = new View("User/register.php", "front.php");
            $view->addData('errors', $errors);
            return;
        }
    }
        $view = new View("User/register.php", "front.php");
        echo $view;
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