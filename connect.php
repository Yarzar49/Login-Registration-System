<?php


try {
    $dbconnection = new PDO('mysql:dbhost=localhost;dbname=Login & Registration System', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    
    ]);
    echo "Database Connected Successfully!";
} catch(PDOException $e) {
    echo "Connection failed: ".$e->getMessage();
}