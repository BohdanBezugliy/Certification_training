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
    <title>Домашня сторінка</title>
</head>
<body>
  <header>
  <nav>
    <a class="nav-link active" href="/Home_user/Lecture.php">Домашня сторінка</a>
    <a class="nav-link" href="/Home_user/Certification.php">Підвищення кваліфікації</a>
    <a class="nav-link" href="/Home_user/logout.php"><img width="20px" src="/media/sign-out-alt.svg" alt="logout"></a>
</nav>
  </header>
<table class="table">
  <tr>
    <th>ПІБ</th>
    <th>Позиція</th>
    <th>Наукове звання</th>
    <th>Факультет</th>
  </tr>
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
          $stmt = $pdo->prepare("SELECT * FROM Lecture WHERE id_lecture = :id;");
          $stmt->execute([
            'id'=>$_SESSION['id']
          ]);
          $lectures = $stmt->fetchAll(PDO::FETCH_ASSOC);
          foreach($lectures as $key => $lecture){
            echo"<tr>
              <td>{$lecture['full_name']}</td>
              <td>{$lecture['position']}</td>
              <td>{$lecture['rank']} </td>
              <td>{$lecture['department']}</td>
            </tr>
            ";
          }
        } catch (PDOException $e) {
          echo $e->getMessage();
        }
        if(isset($_POST['Change'])){
            if(!empty($_POST['position'])){
            $stmtUpdate = $pdo->prepare("UPDATE Lecture SET position =:pos WHERE id_lecture = :id;");
            $stmtUpdate->execute([
              'pos'=>$_POST['position'],
              'id'=>$_SESSION['id']
            ]);
            header("Location: Lecture.php");
          }
          if(!empty($_POST['rank'])){
            $stmtUpdate = $pdo->prepare("UPDATE Lecture SET rank =:rank WHERE id_lecture = :id;");
            $stmtUpdate->execute([
              'rank'=>$_POST['rank'],
              'id'=>$_SESSION['id']
            ]);
            header("Location: Lecture.php");
          }
          if(!empty($_POST['department'])){
            $stmtUpdate = $pdo->prepare("UPDATE Lecture SET department =:depart WHERE id_lecture = :id;");
            $stmtUpdate->execute([
              'depart'=>$_POST['department'],
              'id'=>$_SESSION['id']
            ]);
            header("Location: Lecture.php");
          }
          if(!empty($_POST['name'])){
            $stmtUpdate = $pdo->prepare("UPDATE Lecture SET full_name =:chName WHERE id_lecture = :id;");
            $stmtUpdate->execute([
              'chName'=>$_POST['name'],
              'id'=>$_SESSION['id']
            ]);
            header("Location: Lecture.php");
          }
        }
    ?>
</table>
<div class="container" style="width: 80%;">
<form action="Lecture.php" method="post">
    <div class="mb-2">
    <label for="name" class="form-label">ПІБ</label>
    <input type="text" class="form-control" id="name" name="name">
    </div>
    <div class="mb-2">
    <label for="position" class="form-label">Позиція</label>
    <input type="text" class="form-control" id="position" name="position">
    </div>

    <div class="mb-2">
    <label for="rank" class="form-label">Наукове звання</label>
    <input type="text" class="form-control" id="rank" name="rank">
    </div>

    <div class="mb-2">
    <label for="department" class="form-label">Факультет</label>
    <input type="text" class="form-control" id="department" name="department">
    </div>
    <div class="buttons my-2">
    <button type="submit" class="btn btn-primary" name="Change">Змінити</button>
    </div>
    </form>
</div>
</body>
</html>