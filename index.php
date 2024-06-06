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
  <title>Вхід</title>
</head>
<body>
<div class="container">
<form action="index.php" method="post">
  <div class="mb-3">
    <label for="name" class="form-label">ПІБ</label>
    <input type="text" class="form-control" id="name" name="name">
  </div>
  <div class="mb-3">
    <label for="InputPassword1" class="form-label">Пароль</label>
    <input type="password" class="form-control" id="InputPassword1" name = "password">
  </div>
  <div class="buttons">
    <button type="submit" class="btn btn-primary" name="submit">Вхід</button>
    <button type="button" class="btn btn-secondary" onclick="window.location.href='Registration.php'">Реєстрація</button>
  </div>
</form>
<?php
    include('Home_user/ConnectToDb.php');
    $name = $_POST['name'];
    $password = $_POST['password'];
    if(isset($_POST['submit']))
    {
      if(!empty($name) && !empty($password)){
        if(!empty($name)){
          if(!empty($password)){
             $pdo = ConnectToDb();
              $stmt = $pdo->prepare("SELECT full_name, password_hash, id_lecture FROM Lecture WHERE full_name = :name");
              $stmt->execute([
                'name' => $name
              ]);
              $lectures = $stmt->fetchAll(PDO::FETCH_ASSOC);
              if(count($lectures)!=0){
                foreach($lectures as $key =>$lecture){
                if(password_verify($password,$lecture['password_hash'])){
                  session_start();
                  $_SESSION['id'] = $lecture['id_lecture'];
                  header("Location: Home_user/Lecture.php");
                  exit;
                }
              }
                echo '<br><div class="alert alert-danger" role="alert">
                Пароль введено не коректно!
                </div>';
              }else{
                echo '<br><div class="alert alert-danger" role="alert">
                Такого користувача не має в системі!
                </div>';
                exit;
              }
          }else{
            echo '<br><div class="alert alert-danger" role="alert">
            Введіть пароль!
            </div>';
            exit;
          }
        }
        else{
          echo '<br><div class="alert alert-danger" role="alert">
            Введіть ПІБ!
            </div>';
            exit;
        }
      }else{
        echo '<br><div class="alert alert-danger" role="alert">
            Введіть дані у поля входу!
            </div>';
            exit;
      }
    }
?>
</div>
</body>
</html>