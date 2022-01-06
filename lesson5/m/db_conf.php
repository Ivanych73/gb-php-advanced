<?php

    const SERVER = "localhost";
    const DB = "gallery";
    const LOGIN = "root";
    const PASS = "root"; 

    try {
        $db = new PDO("mysql:host=".SERVER.";dbname=".DB.";user=".LOGIN.";password=".PASS);
    }
    catch (PDOException $e) {
        die("Error: ".$e->getMessage());
    }
?>