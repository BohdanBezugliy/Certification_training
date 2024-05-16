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
    <title>Документи та події</title>
</head>
<body>
<header class="sticky-top">
  <nav>
    <a class="nav-link active" href="Lecture.php">Домашня сторінка</a>
    <a class="nav-link" href="Certification.php">Відомості про підвищення кваліфікації</a>
    <a class="nav-link" href="Report.php">Вибірка відомостей та формування звіту</a>
    <a class="nav-link" href="logout.php"><img width="20px" src="/media/sign-out-alt.svg" alt="logout"></a>
</nav>
  </header>
  <div style="opacity: 1; border-radius:20px;" class="position-fixed bottom-0 end-0 m-5 bg-secondary-subtle"><a href="#form"><img width="80px" src="/media/edit.png" alt="Переміщення до форми"></a></div>
<table class="table">
  <tr>
    <th>Найменування закладу</th>
    <th>Вид документа</th>
    <th>Тема</th>
    <th>Дата початку</th>
    <th>Дата кінця</th>
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
          $stmt = $pdo->prepare("SELECT * FROM `training` WHERE id_lecture = :id;");
          $stmt->execute([
            'id'=>$_SESSION['id']
          ]);
          $documents_and_events = $stmt->fetchAll(PDO::FETCH_ASSOC);
          $hrefDelete = "/Home_user/delete.php";
          foreach($documents_and_events as $key => $document_and_event){
            $ct_id = $document_and_event['ct_id'];
            $hrefUpdate = "#form";
            echo "<tr>
              <td>{$document_and_event['institution']}</td>
              <td>{$document_and_event['document_type']}</td>
              <td>{$document_and_event['topic']} </td>
              <td>{$document_and_event['date_begin']} </td>
              <td>{$document_and_event['date_end']} </td>
              <td>{$document_and_event['credit_hours']}</td>
              <td>
              <form action='Certification.php' method='post'>
              <button type='submit' class='btn btn-secondary mx-2' onclick='window.location.href=$hrefUpdate' name='Change' value=$ct_id>Змінити</button>
              </form>
              <form action='delete.php' method='post'>
              <button type='submit' class='btn btn-danger mx-2' onclick='window.location.href=$hrefDelete' name='Delete' value=$ct_id>Видалити</button>
              </form>
              </td>
            </tr>
            ";
          }
        } catch (PDOException $e) {
          echo $e->getMessage();
        }
    ?>
</table>
<section id="form">
    <?php
    if(isset($_POST['Change'])){
      $stmt= $pdo->prepare("SELECT * FROM training WHERE ct_id = :ct_id AND id_lecture = :id;");
      $stmt->execute([
        'id' => $_SESSION['id'],
        'ct_id' => $_POST['Change']
      ]);
      $certification = $stmt->fetch(PDO::FETCH_ASSOC);
      echo "<div id='FormForChange' class='container' style='width: 80%;''>";
    echo '<form action="Change.php" method="post">';

    echo '  <label for="institution" class="form-label">Найменування закладу:</label>';
    echo '  <input type="text" id="institution" name="institution" class="form-control" required value="' . $certification['institution'] . '">';

    echo '  <label for="document_type" class="form-label mt-2">Вид документа:</label>';
    echo '  <input type="text" id="document_type" name="document_type" class="form-control" required value="' . $certification['document_type'] . '">';

    echo '  <label for="topic" class="form-label mt-2">Тема:</label>';
    echo '  <input type="text" id="topic" name="topic" class="form-control" required value="' . $certification['topic'] . '">';

    echo '  <label for="date_begin" class="form-label mt-2">Дата початку:</label>';
    echo '  <input type="date" id="date_begin" name="date_begin" class="form-control" required value="' . $certification['date_begin'] . '">';

    echo '  <label for="date_end" class="form-label mt-2">Дата кінця:</label>';
    echo '  <input type="date" id="date_end" name="date_end" class="form-control" required value="' . $certification['date_end'] . '">';

    echo '  <label for="credit_hours" class="form-label mt-2">Кількість навчальних кредитів (годин):</label>';
    echo '  <input type="number" id="credit_hours" name="credit_hours" class="form-control" required value="' . $certification['credit_hours'] . '">'; 

    echo '  <div class="buttons my-2">';  
    echo '    <button type="submit" class="btn btn-primary" name="ChangeCert" value="'. $certification['ct_id'].'">Змінити</button>';
    echo '  </div>';

    echo '</form>';
    }else
    {
      echo "<div id='FormAdd' class='container' style='width: 80%;'>";
      echo '<form action="Certification.php" method="post">';

      echo '  <label for="institution" class="form-label">Найменування закладу:</label>';
      echo '  <input type="text" id="institution" name="institution" class="form-control" required value="' . $certification['institution'] . '">';

      echo '  <label for="document_type" class="form-label mt-2">Вид документа:</label>';
      echo '  <input type="text" id="document_type" name="document_type" class="form-control" required value="' . $certification['document_type'] . '">';

      echo '  <label for="topic" class="form-label mt-2">Тема:</label>';
      echo '  <input type="text" id="topic" name="topic" class="form-control" required value="' . $certification['topic'] . '">';

      echo '  <label for="date_begin" class="form-label mt-2">Дата початку:</label>';
      echo '  <input type="date" id="date_begin" name="date_begin" class="form-control" required value="' . $certification['date_begin'] . '">';
  
      echo '  <label for="date_end" class="form-label mt-2">Дата кінця:</label>';
      echo '  <input type="date" id="date_end" name="date_end" class="form-control" required value="' . $certification['date_end'] . '">';

      echo '  <label for="credit_hours" class="form-label mt-2">Кількість навчальних кредитів (годин):</label>';
      echo '  <input type="number" id="credit_hours" name="credit_hours" class="form-control" required value="' . $certification['credit_hours'] . '">'; 

      echo '  <div class="buttons my-2">';  
      echo '    <button type="submit" class="btn btn-primary" name="add" value="'. $certification['ct_id'].'">Додати</button>';
      echo '  </div>';

      echo '</form>';
    }
      if(isset($_POST['add'])){
      $institution = $_POST['institution'];
      $documentType = $_POST['document_type'];
      $topic = $_POST['topic'];
      $date_begin = $_POST['date_begin'];
      $date_end = $_POST['date_end'];
      if($date_begin>$date_end){
        echo '<br><div class="alert alert-danger" role="alert">
                Некоректно введена дата!
                </div>';
        exit;
      }else{
        $creditHours = $_POST['credit_hours'];
      $sql = "INSERT INTO training (institution, document_type, topic, date_begin, date_end, credit_hours, id_lecture) 
               VALUES (:institution, :document_type, :topic, :date_begin, :date_end, :credit_hours, :id_lecture)";
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(':institution', $institution);
      $stmt->bindParam(':document_type', $documentType);
      $stmt->bindParam(':topic', $topic);
      $stmt->bindParam(':date_begin', $date_begin);
      $stmt->bindParam(':date_end', $date_end);
      $stmt->bindParam(':credit_hours', $creditHours);
      $stmt->bindParam(':id_lecture', $_SESSION['id']);
      $stmt->execute();
      header("Location: Certification.php");
      }
    }
    ?>
    </div>
</section>
</body>
</html>