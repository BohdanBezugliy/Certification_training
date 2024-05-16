  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
    crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
    crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/styles/style.css">
    <title>Помилка</title>
  </head>
  <body>
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
      $dateChange = true;
      if(isset($_POST['ChangeCert'])){
        if(!empty($_POST['institution'])){
          $stmt = $pdo->prepare("UPDATE training SET institution = :institution WHERE id_lecture = :id  AND ct_id = :ct");
          $stmt->bindParam(':institution',$_POST['institution']);
          $stmt->bindParam(':id',$_SESSION['id']);
          $stmt->bindParam(':ct',$_POST['ChangeCert']);
          $stmt->execute();
        }
        if(!empty($_POST['topic'])){
          $stmt = $pdo->prepare("UPDATE training SET topic = :topic WHERE id_lecture = :id  AND ct_id = :ct");
          $stmt->bindParam(':topic',$_POST['topic']);
          $stmt->bindParam(':id',$_SESSION['id']);
          $stmt->bindParam(':ct',$_POST['ChangeCert']);
          $stmt->execute();
        }
        if(!empty($_POST['document_type'])){
          $stmt = $pdo->prepare("UPDATE training SET document_type = :document_type WHERE id_lecture = :id  AND ct_id = :ct");
          $stmt->bindParam(':document_type',$_POST['document_type']);
          $stmt->bindParam(':id',$_SESSION['id']);
          $stmt->bindParam(':ct',$_POST['ChangeCert']);
          $stmt->execute();
        }
        if (!empty($_POST['date_begin']) && !empty($_POST['date_end'])) {
          $date_begin = $_POST['date_begin'];
          $date_end = $_POST['date_end'];
      
          if ($date_end >= $date_begin) {
              $stmt = $pdo->prepare("UPDATE training SET date_begin = :date_begin, date_end = :date_end WHERE id_lecture = :id AND ct_id = :ct");
              $stmt->bindParam(':date_begin', $_POST['date_begin']);
              $stmt->bindParam(':date_end', $_POST['date_end']);
              $stmt->bindParam(':id', $_SESSION['id']);
              $stmt->bindParam(':ct', $_POST['ChangeCert']);
              $stmt->execute();
          } else {
              echo '<br><div class="alert alert-danger" role="alert">
              Некоректно змінена дата!
              </div><br>';
              $dateChange = false;
          }
      } else {
          if (!empty($_POST['date_begin'])) {
              $stmt = $pdo->prepare("UPDATE training SET date_begin = :date_begin WHERE id_lecture = :id AND ct_id = :ct");
              $stmt->bindParam(':date_begin', $_POST['date_begin']);
              $stmt->bindParam(':id', $_SESSION['id']);
              $stmt->bindParam(':ct', $_POST['ChangeCert']);
              $stmt->execute();
          } else if (!empty($_POST['date_end'])) {
              $stmt = $pdo->prepare("UPDATE training SET date_end = :date_end WHERE id_lecture = :id AND ct_id = :ct");
              $stmt->bindParam(':date_end', $_POST['date_end']);
              $stmt->bindParam(':id', $_SESSION['id']);
              $stmt->bindParam(':ct', $_POST['ChangeCert']);
              $stmt->execute();
          }
        }      
        if(!empty($_POST['credit_hours'])){
          $stmt = $pdo->prepare("UPDATE training SET credit_hours = :credit_hours WHERE id_lecture = :id  AND ct_id = :ct");
          $stmt->bindParam(':credit_hours',$_POST['credit_hours']);
          $stmt->bindParam(':id',$_SESSION['id']);
          $stmt->bindParam(':ct',$_POST['ChangeCert']);
          $stmt->execute();
        }
        if ($dateChange) {
          header("Location: Certification.php");
        }else{
          echo'<a class="btn btn-secondary my-2" href="Certification.php">Повернутися на попередню сторінку</a>';
        }
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
    ?>
  </body>
</html>