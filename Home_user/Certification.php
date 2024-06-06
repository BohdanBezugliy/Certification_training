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
    <title>Підвищення кваліфікації</title>
</head>
<body>
  <?php
  include('ConnectToDb.php');
  session_start();
  $pdo = ConnectToDb();
  $stmt = $pdo->prepare("SELECT * FROM Lecture WHERE id_lecture = :id;");
          $stmt->execute([
            'id'=>$_SESSION['id']
          ]);
          $lectures = $stmt->fetch(PDO::FETCH_ASSOC);
  ?>
<header class="sticky-top">
  <nav>
    <a class="nav-link active" href="Lecture.php">Домашня сторінка</a>
    <a class="nav-link" href="Certification.php">Підвищення кваліфікації</a>
    <a class="nav-link" href="logout.php"><img width="20px" src="/media/sign-out-alt.svg" alt="logout"></a>
</nav>
  </header>
  <div id="info" class="Lecture m-3" style="display:none">
  <div style='font-size:25px;'><b>ПІБ:</b> <?php echo $lectures['full_name']; ?></div>
  <div style='font-size:25px;'><b>Посада:</b> <?php echo $lectures['position']; ?></div>
  <div style='font-size:25px;'><b>Наукове звання:</b> <?php echo $lectures['rank']; ?></div>
  <div style='font-size:25px;'><b>Факультет:</b> <?php echo $lectures['department']; ?></div>
</div>
    <form id="SearchFrom" style="padding:10px" action="Certification.php" method="post">
    <table style="width:100%">
      <tr>
        <td>
          <input type="text" name="searchInstitution" class="form-control" id="searchInstitution" placeholder="Найменування закладу" style="border:1px solid grey;">
        </td>
        <td>
          <input type="text" name="searchDocumentType" class="form-control" id="searchDocumentType" placeholder="Вид документа" style="border:1px solid grey;">
        </td>
        <td>
          <input type="text" name="searchTopic" class="form-control" id="searchTopic" placeholder="Тема" style="border:1px solid grey;">
        </td>
      </tr>
      <tr>
      <td>
          <label for="date_begin" class="form-label mt-2">Дата початку:</label>
          <input type="date" style="border:1px solid grey;" id="searchDateBegin" name="searchDateBegin" class="form-control">
        </td>
        <td>
          <label for="date_end" class="form-label mt-2">Дата кінця:</label>
          <input type="date" style="border:1px solid grey;" id="searchDateEnd" name="searchDateEnd" class="form-control">
        </td>
        <td>
          <label for="credit_hours" class="form-label mt-2">Кількість навчальних кредитів (годин):</label>
          <input type="number" style="border:1px solid grey;" id="searchCreditHours" name="searchCreditHours" class="form-control">
        </td>
      </tr>
    </table>
    <div class="buttons my-1" style = "justify-content:space-around;">
      <button type="submit" id="searchBtn" name="search" class="btn btn-primary">Пошук</button>
      <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addCertificationModal">
        Додати запис
      </button>
      <button onclick="print()" class="btn btn-dark">Друк</button>
    </div>
    </form>
<table id="Education" class="table text-center">
  <thead>
  <tr>
    <th>
      Найменування закладу
    </th>
    <th>
      Вид документа
    </th>
    <th>
      Тема
    </th>
    <th>
      Дата початку
    </th>
    <th>
      Дата кінця
    </th>
    <th>
      Кількість навчальних кредитів (годин)
    </th>
    <th class="btnsEl"></th>
  </tr>
  </thead>
    <?php
        if (empty($_POST['searchDocumentType']) && empty($_POST['searchInstitution']) 
          && empty($_POST['searchTopic']) && empty($_POST['searchDateBegin']) 
          && empty($_POST['searchDateEnd']) && empty($_POST['searchCreditHours'])) {
            $stmt = $pdo->prepare("SELECT * FROM `training` WHERE id_lecture = :id;");
            $stmt->execute([
              'id'=>$_SESSION['id']
            ]);
        }
        else{
          $sql = "SELECT * FROM `training` WHERE id_lecture = :id";
          $searchParams = [];
          $searchParams[':id'] = $_SESSION['id'];
          if (!empty($_POST['searchInstitution'])) {
            $sql .= " AND institution LIKE CONCAT('%', :searchInstitution, '%')";
            $searchParams[':searchInstitution'] = '%' . $_POST['searchInstitution'] . '%';
          }

          if (!empty($_POST['searchDocumentType'])) {
            $sql .= " AND document_type LIKE CONCAT('%', :searchDocumentType, '%')";
            $searchParams[':searchDocumentType'] = '%' . $_POST['searchDocumentType'] . '%';
          }
          if (!empty($_POST['searchDateBegin'])) {
            $sql .= " AND date_begin >= :searchDateBegin";
            $searchParams[':searchDateBegin'] = $_POST['searchDateBegin'];
          }
          
          if (!empty($_POST['searchDateEnd'])) {
            $sql .= " AND date_end <= :searchDateEnd";
            $searchParams[':searchDateEnd'] = $_POST['searchDateEnd'];
          }

          if (!empty($_POST['searchTopic'])) {
            $sql .= " AND topic LIKE CONCAT('%', :searchTopic, '%')";
            $searchParams[':searchTopic'] = $_POST['searchTopic'];
          }
          
          if (!empty($_POST['searchCreditHours'])) {
            $sql .= " AND credit_hours = :searchCreditHours";
            $searchParams[':searchCreditHours'] = $_POST['searchCreditHours'];
          }
          $stmt = $pdo->prepare($sql);
          $stmt->execute($searchParams);
        }
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
            $linkToDoc = $document_and_event['link_to_doc'];
            $dataAttributes = "data-link-to-doc='$linkToDoc' data-certification-id='$certificationId' data-institution='$institution' data-document-type='$documentType' data-topic='$topic' data-date-begin='$dateBegin' data-date-end='$dateEnd' data-credit-hours='$creditHours'";
            ?>
            <tr>
            <td><?php echo $institution; ?></td>
            <td class="linkDocs"><?php echo '<a href="' . $linkToDoc . '">' . $documentType . '</a>';?></td>
            <td><?php echo $topic; ?></td>
            <td><?php echo $dateBegin; ?></td>
            <td><?php echo $dateEnd; ?></td>
            <td><?php echo $creditHours; ?></td>
              <td class="btnsEl">
                <div style="display:flex">
                  <button type="button" class="btn btn-secondary mx-2 edit-certification-btn" data-bs-toggle="modal" data-bs-target="#addCertificationModal" <?php echo $dataAttributes; ?>>Змінити</button>
              <form action='delete.php' method='post'>
              <button type='submit' class='btn btn-danger mx-2' onclick='window.location.href=$hrefDelete' name='Delete' value=<?php echo $certificationId;?>>Видалити</button>
              </form>
            </div>
              </td>
            </tr>
            <?php 
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
                <form action="InsertOrUpdate.php" method="post">
                        <label for="institution" class="form-label">Найменування закладу:</label>
                        <input type="text" id="institution" name="institution" class="form-control" required>

                        <label for="document_type" class="form-label mt-2">Вид документа:</label>
                        <input type="text" id="document_type" name="document_type" class="form-control" required>

                        <label for="document_link" class="form-label mt-2">Посилання на документ:</label>
                        <input type="text" id="document_link" name="document_link" class="form-control" required>

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
<script src="scriptForCertification.js"></script>
<style>
      @media print{
        #info{
          display: block !important;
        }
    header{
      display: none;
    }
    #SearchFrom{
      display: none;
    }
    .btnsEl{
      display: none;
    }
    .linkDocs a{
      text-decoration: none;
      color: black;
    }
  }
  .th-sort-asc::after{
    content: "\25b4" ;
  }
  .th-sort-desc::after{
    content: "\25be";
  }
    </style>
</body>
</html>