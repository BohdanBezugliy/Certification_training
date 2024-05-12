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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Зміна відомостей про підвищення</title>
</head>
<body>
    <div class="container" style="width: 80%;">
    <form action="Change.php" method="post">
            <label for="institution" class="form-label">Найменування закладу:</label>
            <input type="text" id="institution" name="institution" class="form-control">

            <label for="document_type" class="form-label mt-2">Вид документа:</label>
            <input type="text" id="document_type" name="document_type" class="form-control">

            <label for="topic" class="form-label mt-2">Тема:</label>
            <input type="text" id="topic" name="topic" class="form-control">

            <label for="issue_date" class="form-label mt-2">Дата видачі:</label>
            <input type="date" id="issue_date" name="issue_date" class="form-control">

            <label for="credit_hours" class="form-label mt-2">Кількість навчальних кредитів (годин):</label>
            <input type="number" id="credit_hours" name="credit_hours" class="form-control">

            <div class="buttons my-2">
            <button type="submit" class="btn btn-primary" name="Change">Змінити</button>
            <button type="button" class="btn btn-secondary" onclick="window.location.href='/Home_user/Certification.php'">Повернутися</button>
            </div>
        </form>
    </div>
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
      
      if(isset($_POST['Change'])){
        if(!empty($_POST['institution'])){
          $stmt = $pdo->prepare("UPDATE Certification_training SET institution = :institution WHERE id_lecture = :id  AND ct_id = :ct");
          $stmt->bindParam(':institution',$_POST['institution']);
          $stmt->bindParam(':id',$_SESSION['id']);
          $stmt->bindParam(':ct',$_SESSION['ct_id']);
          $stmt->execute();
        }
        if(!empty($_POST['topic'])){
          $stmt = $pdo->prepare("UPDATE Certification_training SET topic = :topic WHERE id_lecture = :id  AND ct_id = :ct");
          $stmt->bindParam(':topic',$_POST['topic']);
          $stmt->bindParam(':id',$_SESSION['id']);
          $stmt->bindParam(':ct',$_SESSION['ct_id']);
          $stmt->execute();
        }
        if(!empty($_POST['document_type'])){
          $stmt = $pdo->prepare("UPDATE Certification_training SET document_type = :document_type WHERE id_lecture = :id  AND ct_id = :ct");
          $stmt->bindParam(':document_type',$_POST['document_type']);
          $stmt->bindParam(':id',$_SESSION['id']);
          $stmt->bindParam(':ct',$_SESSION['ct_id']);
          $stmt->execute();
        }
        if(!empty($_POST['issue_date'])){
          $stmt = $pdo->prepare("UPDATE Certification_training SET issue_date = :issue_date WHERE id_lecture = :id  AND ct_id = :ct");
          $stmt->bindParam(':issue_date',$_POST['issue_date']);
          $stmt->bindParam(':id',$_SESSION['id']);
          $stmt->bindParam(':ct',$_SESSION['ct_id']);
          $stmt->execute();
        }
        if(!empty($_POST['credit_hours'])){
          $stmt = $pdo->prepare("UPDATE Certification_training SET credit_hours = :credit_hours WHERE id_lecture = :id  AND ct_id = :ct");
          $stmt->bindParam(':credit_hours',$_POST['credit_hours']);
          $stmt->bindParam(':id',$_SESSION['id']);
          $stmt->bindParam(':ct',$_SESSION['ct_id']);
          $stmt->execute();
        }
        $_SESSION['ct_id'] = NULL;
        header("Location: Certification.php");
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
    
    ?>
</body>
</html>
