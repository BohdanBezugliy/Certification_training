<?php
session_start();
$host = "localhost";
$port = "8889";
$dbname = "Certification_training";
$usernameDb = "root";
$passwordDb = "root";
$dsn = "mysql:host={$host}:{$port};dbname={$dbname}";
try {
  $pdo = new PDO($dsn,$usernameDb,$passwordDb);
  $stmtDelete = $pdo->prepare("DELETE FROM training WHERE id_lecture = :id AND ct_id = :ct_id;"); 
  $stmtDelete->execute([
      'id'=>$_SESSION['id'],
      'ct_id'=>$_POST['Delete']
    ]);
    header("Location: Certification.php");
} catch (PDOException $e) {
  echo $e->getMessage();
}