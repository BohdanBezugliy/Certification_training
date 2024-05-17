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
    <a class="nav-link" href="Certification.php">Підвищення кваліфікації</a>
    <a class="nav-link" href="logout.php"><img width="20px" src="/media/sign-out-alt.svg" alt="logout"></a>
</nav>
  </header>
<table class="table">
  <tr>
    <th>Найменування закладу</th>
    <th>Вид документа</th>
    <th>Тема</th>
    <th>Дата початку</th>
    <th>Дата кінця</th>
    <th>Кількість навчальних кредитів (годин)</th>
    <th><button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addCertificationModal">
    Додати запис
  </button></th>
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
            $certificationId = $document_and_event['ct_id'];
            $institution = $document_and_event['institution'];
            $documentType = $document_and_event['document_type'];
            $topic = $document_and_event['topic'];
            $dateBegin = $document_and_event['date_begin'];
            $dateEnd = $document_and_event['date_end'];
            $creditHours = $document_and_event['credit_hours'];
            $dataAttributes = "data-certification-id='$certificationId' data-institution='$institution' data-document-type='$documentType' data-topic='$topic' data-date-begin='$dateBegin' data-date-end='$dateEnd' data-credit-hours='$creditHours'";
            ?>
            <tr>
            <td><?php echo $institution; ?></td>
            <td><?php echo $documentType; ?></td>
            <td><?php echo $topic; ?></td>
            <td><?php echo $dateBegin; ?></td>
            <td><?php echo $dateEnd; ?></td>
            <td><?php echo $creditHours; ?></td>
              <td>
              <button type="button" class="btn btn-secondary mx-2 edit-certification-btn" data-bs-toggle="modal" data-bs-target="#addCertificationModal" <?php echo $dataAttributes; ?>>Змінити</button>
              <form action='delete.php' method='post'>
              <button type='submit' class='btn btn-danger mx-2' onclick='window.location.href=$hrefDelete' name='Delete' value=<?php echo $ct_id;?>>Видалити</button>
              </form>
              </td>
            </tr>
            <?php 
            }
        } catch (PDOException $e) {
          echo $e->getMessage();
        } 
        ?>
</table>
<div class="modal fade" id="addCertificationModal" tabindex="-1" aria-labelledby="addCertificationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCertificationModalLabel">Додати запис</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="Certification.php" method="post">
                        <label for="institution" class="form-label">Найменування закладу:</label>
                        <input type="text" id="institution" name="institution" class="form-control" required>

                        <label for="document_type" class="form-label mt-2">Вид документа:</label>
                        <input type="text" id="document_type" name="document_type" class="form-control" required>

                        <label for="topic" class="form-label mt-2">Тема:</label>
                        <input type="text" id="topic" name="topic" class="form-control" required>

                        <label for="date_begin" class="form-label mt-2">Дата початку:</label>
                        <input type="date" id="date_begin" name="date_begin" class="form-control" required>

                        <label for="date_end" class="form-label mt-2">Дата кінця:</label>
                        <input type="date" id="date_end" name="date_end" class="form-control" required>

                        <label for="credit_hours" class="form-label mt-2">Кількість навчальних кредитів (годин):</label>
                        <input type="number" id="credit_hours" name="credit_hours" class="form-control" required>

                        <div class="buttons my-2">
                            <button id="btnFrom" type="submit" name="add" class="btn btn-primary">Додати</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
const addCertificationModal = document.getElementById('addCertificationModal');
const editCertificationBtns = document.querySelectorAll('.edit-certification-btn');
const institution = document.getElementById('institution');
const document_type = document.getElementById('document_type');
const topic = document.getElementById('topic');
const date_begin = document.getElementById('date_begin');
const date_end = document.getElementById('date_end');
const credit_hours = document.getElementById('credit_hours');
const btnFrom = document.getElementById('btnFrom');
const addCertificationModalLabel = document.getElementById('addCertificationModalLabel');
addCertificationModal.addEventListener('hidden.bs.modal', function() {
    institution.value = "";
    document_type.value = "";
    topic.value = "";
    date_begin.value = "";
    date_end.value = "";
    credit_hours.value = "";
    btnFrom.name = 'add';
    btnFrom.value = null;
    btnFrom.innerText = "Додати";
    addCertificationModalLabel.innerText = "Додати запис"; 
});
editCertificationBtns.forEach(button => {
  button.addEventListener('click', function() {
    institution.value = this.dataset.institution;
    document_type.value = this.dataset.documentType;
    topic.value = this.dataset.topic;
    date_begin.value = this.dataset.dateBegin;
    date_end.value = this.dataset.dateEnd;
    credit_hours.value = this.dataset.creditHours;
    btnFrom.name = 'change';
    btnFrom.value = this.dataset.certificationId;
    btnFrom.innerText = "Змінити";
    addCertificationModalLabel.innerText = "Змінити запис"; 
  });
});
</script>
<?php
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
}else if(isset($_POST['change'])){
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
  $sql = "UPDATE training
  SET institution = :institution,
      document_type = :document_type,
      topic = :topic,
      date_begin = :date_begin,
      date_end = :date_end,
      credit_hours = :credit_hours
  WHERE id_lecture = :id AND ct_id = :ct_id;";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':institution', $institution);
  $stmt->bindParam(':document_type', $documentType);
  $stmt->bindParam(':topic', $topic);
  $stmt->bindParam(':date_begin', $date_begin);
  $stmt->bindParam(':date_end', $date_end);
  $stmt->bindParam(':credit_hours', $creditHours);
  $stmt->bindParam(':id', $_SESSION['id']);
  $stmt->bindParam(':ct_id', $_POST['change']);
  $stmt->execute();
  header("Location: Certification.php");
  }
}
?>
</body>
</html>