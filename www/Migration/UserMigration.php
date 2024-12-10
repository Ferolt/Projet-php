<?php

namespace App\Migration;

$db = new \PDO("mysql:host=mariadb;dbname=esgi", "esgi", "esgipwd");

if ($argv[1] == "up") {
    $db->query("
            CREATE TABLE IF NOT EXISTS user (
                id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
                email varchar(300),
                firstname varchar(32),
                lastname varchar(32),
                password varchar(100),
                country varchar(100),
                CONSTRAINT email_unique UNIQUE (email)
            )
        ");
} else if ($argv[1] == "down") {
    $db->query("
        DROP TABLE IF EXISTS user
    ");
}
