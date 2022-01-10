<?php

    const SERVER = "localhost";
    const DB = "shop";
/*     const LOGIN = "root";
    const PASS = "root"; */
    const LOGIN = "postgres";
    const PASS = "postgres";

    //$connect = mysqli_connect(SERVER,LOGIN,PASS,DB);

    try {
        $db = new PDO("pgsql:host=".SERVER.";port=5432;dbname=".DB.";user=".LOGIN.";password=".PASS);
    }
    catch (PDOException $e) {
        die("Error: ".$e->getMessage());
    }
?>