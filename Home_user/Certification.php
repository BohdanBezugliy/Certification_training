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
    <title>Документи та події</title>
</head>
<body>
  <header>
  <nav>
    <a class="nav-link active" href="/Home_user/Lecture.php">Домашня сторінка</a>
    <a class="nav-link" href="/Home_user/Certification.php">Підвищення кваліфікації</a>
    <a class="nav-link" href="/Home_user/logout.php"><img width="20px" src="/media/sign-out-alt.svg" alt="logout"></a>
</nav>
  </header>
  <div class="container" style="width: 100%;">
    <form action="search.php" method="post">
    <label for="institution" class="form-label">Пошук за найменуванням закладу:</label>
    <input type="text" name="institution" class="form-control">
    <br>
    <label for="document_type" class="form-label">Пошук за типом документа:</label>
    <input type="text" name="document_type" class="form-control">
    <br>
    <label for="topic" class="form-label">Пошук за темою: Topic:</label>
    <input type="text" name="topic" class="form-control">
    <br>
    <label for="issue_date" class="form-label">Пошук за датою видачі:</label>
    <input type="text" name="issue_date" placeholder="YYYY-MM-DD" class="form-control">
    <br>
    <label for="credit_hours" class="form-label">Пошук за кількістю навчальних кредитів(годин):</label>
    <input type="text" name="credit_hours" class="form-control">
    <br>
    <input type="submit" class="btn btn-primary" value="Пошук">
</form>
</div>
<table class="table table-striped">
  <?php
  
  ?>
</table>
<table class="table">
  <tr>
    <th>Найменування закладу</th>
    <th>Вид документа</th>
    <th>Тема</th>
    <th>Дата видачі</th>
    <th>Кількість навчальних кредитів (годин)</th>
    <th></th>
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
          $stmt = $pdo->prepare("SELECT * FROM `Certification_training` INNER JOIN Lecture USING(id_lecture) WHERE id_lecture = :id;");
          $stmt->execute([
            'id'=>$_SESSION['id']
          ]);
          $documents_and_events = $stmt->fetchAll(PDO::FETCH_ASSOC);
          $hrefDelete = "/Home_user/delete.php";
          foreach($documents_and_events as $key => $document_and_event){
            $ct_id = $document_and_event['ct_id'];
            $hrefUpdate = "/Home_user/update.php?ct_id=$ct_id";
            echo "<tr>
              <td>{$document_and_event['institution']}</td>
              <td>{$document_and_event['document_type']}</td>
              <td>{$document_and_event['topic']} </td>
              <td>{$document_and_event['issue_date']} </td>
              <td>{$document_and_event['credit_hours']}</td>
              <td>
              <div style='display:flex;'><div>
              <a class='btn btn-secondary mx-2' href=$hrefUpdate>Змінити</a>
              </div>
              <form action='delete.php' method='post'>
              <button type='submit' class='btn btn-danger mx-2' onclick='window.location.href=$hrefDelete' name='Delete' value=$ct_id>Видалити</button>
              </form>
              </div>
              </td>
            </tr>
            ";
          }
        } catch (PDOException $e) {
          echo $e->getMessage();
        }
    ?>
</table>
<div class="container" style="width: 80%;">
<form action="Certification.php" method="post">
        <label for="institution" class="form-label">Найменування закладу:</label>
        <input type="text" id="institution" name="institution" class="form-control" required>

        <label for="document_type" class="form-label mt-2">Вид документа:</label>
        <input type="text" id="document_type" name="document_type" class="form-control" required>

        <label for="topic" class="form-label mt-2">Тема:</label>
        <input type="text" id="topic" name="topic" class="form-control" required>

        <label for="issue_date" class="form-label mt-2">Дата видачі:</label>
        <input type="date" id="issue_date" name="issue_date" class="form-control" required>

        <label for="credit_hours" class="form-label mt-2">Кількість навчальних кредитів (годин):</label>
        <input type="number" id="credit_hours" name="credit_hours" class="form-control" required>

        <div class="buttons my-2">
        <button type="submit" class="btn btn-primary"  name="add">Додати</button>
        </div>
    </form>
    <?php
      session_start();
      if(isset($_POST['add'])){
      $teacherId = $_POST['teacher_id'];
      $institution = $_POST['institution'];
      $documentType = $_POST['document_type'];
      $topic = $_POST['topic'];
      $issueDate = $_POST['issue_date'];
      $creditHours = $_POST['credit_hours'];
      $sql = "INSERT INTO Certification_training (institution, document_type, topic, issue_date, credit_hours, id_lecture) 
               VALUES (:institution, :document_type, :topic, :issue_date, :credit_hours, :id_lecture)";
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(':institution', $institution);
      $stmt->bindParam(':document_type', $documentType);
      $stmt->bindParam(':topic', $topic);
      $stmt->bindParam(':issue_date', $issueDate);
      $stmt->bindParam(':credit_hours', $creditHours);
      $stmt->bindParam(':id_lecture', $_SESSION['id']);
      $stmt->execute();
      header("Location: Certification.php");
      exit;
    }
    ?>
</div>
</body>
</html>