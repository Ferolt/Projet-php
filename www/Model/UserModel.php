<?php

namespace App\Model;

use App\Core\SQL;
use PDOException;

class UserModel
{
    private String $firstname;
    private String $lastname;
    private String $email;
    private String $pwd;
    private string $country;

    /**
     * @return String
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param String $firstname
     */
    public function setFirstname(string $firstname): void
    {
        $this->firstname = ucwords(strtolower(trim($firstname)));
    }

    /**
     * @return String
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @param String $lastname
     */
    public function setLastname(string $lastname): void
    {
        $this->lastname = strtoupper(trim($lastname));
    }

    /**
     * @return String
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param String $email
     */
    public function setEmail(string $email): void
    {
        $this->email = strtolower(trim($email));
    }

    /**
     * @return String
     */
    public function getPwd(): string
    {
        return $this->pwd;
    }

    /**
     * @param String $pwd
     */
    public function setPwd(string $pwd): void
    {
        $this->pwd = password_hash($pwd, PASSWORD_BCRYPT);
    }

    /**
     * @return String
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param String $pwd
     */
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    public function save()
    {
        $db = new SQL();
        $stmt = $db->getPdo()->prepare("
            INSERT INTO user (
                email, 
                password, 
                firstname, 
                lastname, 
                country) 
            VALUES (
                :email, 
                :password, 
                :firstname, 
                :lastname, 
                :country
            )
        ");

        try {
            $stmt->execute([
                'email' => $this->email,
                'password' => $this->pwd,
                'firstname' => $this->firstname,
                'lastname' => $this->lastname,
                'country' => $this->country,
            ]);

            $stmt = $db->getPdo()->prepare("SELECT id FROM user WHERE email = :email");
            $stmt->execute([
                "email" => $this->email
            ]);
            $id = $stmt->fetch();
            return ["error" => false, "user_id" => $id['id']];

        } catch (PDOException $e) {
            return ["error" => true, "msg" => $e];
        }
    }
}
