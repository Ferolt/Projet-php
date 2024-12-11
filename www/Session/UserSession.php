<?php

namespace App\Session;

use Exception;

class UserSession {
    static public function startUserSession(int $id, string $firstname, string $lastname) : bool 
    {
        try {
            session_start();
            $_SESSION['user_id'] = $id;
            $_SESSION['user_firstname'] = $firstname;
            $_SESSION['user_lastname'] = $lastname;
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}