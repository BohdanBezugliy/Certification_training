<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
  rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
  crossorigin="anonymous">
  <link rel="stylesheet" href="/styles/style.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
  integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
  crossorigin="anonymous"></script>
  <title>Реєстрація</title>
</head>
<body>
<div class="container">
<form action="Registration.php" method="post">
  <div class="mb-3">
    <label for="name" class="form-label">ПІБ</label>
    <input type="text" class="form-control" id="name" name="name">
  </div>
  <div class="mb-3">
    <label for="InputPassword1" class="form-label">Пароль</label>
    <input type="password" class="form-control" id="InputPassword1" name="passwordFir">
  </div>
  <div class="mb-3">
    <label for="InputPassword1" class="form-label">Повторіть пароль</label>
    <input type="password" class="form-control" id="InputPassword2" name="passwordSec">
  </div>
  <div class="buttons">
    <input type="submit" class="btn btn-primary my-2" name="submit" value="Зареєструватися">
    <button type="button" class="btn btn-secondary my-2" onclick="window.location.href='index.php'">Відміна</button>
  </div>
</form>
<?php
    include('Home_user/ConnectToDb.php');
    $name = $_POST['name'];
    if(isset($_POST['submit']))
    {
      if(!empty($name) && !empty($_POST['passwordFir']) && !empty($_POST['passwordSec'])){
        if(!empty($name)){
            if(strlen($_POST['passwordFir']) >= 8 && strlen($_POST['passwordSec']) >= 8){
            if($_POST['passwordFir'] == $_POST['passwordSec']){
              $password = password_hash($_POST['passwordFir'],PASSWORD_DEFAULT);
              $pdo = ConnectToDb();
              $stmtReg = $pdo->prepare("INSERT INTO Lecture(full_name, password_hash) VALUE(:name, :password);");
                $stmtVerNotCopy = $pdo->prepare("SELECT full_name, password_hash FROM Lecture WHERE full_name = :name");
                $stmtVerNotCopy->execute([
                  'name' => $name
                ]);
                $lectures = $stmtVerNotCopy->fetchAll(PDO::FETCH_ASSOC);
                if(count($lectures)!=0){
                  foreach($lectures as $key =>$lecture){
                  if(password_verify($_POST['passwordFir'],$lecture['password_hash'])){
                    echo '<div class="alert alert-danger" role="alert">
                    Такий користувач існує!
                    </div>';
                    exit;
                  }
                }
                }
                $stmtReg->execute([
                  'name'=>$name,
                  'password'=>$password
                ]);
                  $stmtIdSearch = $pdo->prepare("SELECT * FROM Lecture WHERE full_name = :name AND password_hash = :password;");
                  $stmtIdSearch->execute([
                    'name'=>$name,
                    'password'=>$password
                  ]);
                  $lectureIdSearch = $stmtIdSearch->fetch(PDO::FETCH_ASSOC);
                  session_start();
                  $_SESSION['id'] = $lectureIdSearch['id_lecture'];
                  header("Location: Home_user/Lecture.php");
                  exit;
            }else{
            echo '<div class="alert alert-danger" role="alert">
            Введені паролі не збігаються!
            </div>';
            exit;
            }
        }else{
            echo '<div class="alert alert-danger" role="alert">
            Введені паролі закороткі (мінімум 8 символів)!
            </div>';
            exit;
        }
        }else{
          echo '<div class="alert alert-danger" role="alert">
            Введіть ПІБ!
            </div>';
            exit;
        }
      }else{
        echo '<div class="alert alert-danger" role="alert">
            Введіть дані у поля реєстрації!
            </div>';
            exit;
      }
    }
?>
</div>
</body>
</html>