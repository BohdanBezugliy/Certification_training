<?php
function ConnectToDb(){
    $host = "localhost";
    $port = "8889";
    $dbname = "Certification_training";
    $usernameDb = "root";
    $passwordDb = "root";
    $dsn = "mysql:host={$host}:{$port};dbname={$dbname}";
    try {
    $pdo = new PDO($dsn,$usernameDb,$passwordDb);
    return $pdo;
    } catch (PDOException $e) {
    echo $e->getMessage();
    }
}
