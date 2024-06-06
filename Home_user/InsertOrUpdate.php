<?php
session_start();
include('ConnectToDb.php');
$pdo = ConnectToDb();
if(isset($_POST['add'])){
    $institution = $_POST['institution'];
    $documentType = $_POST['document_type'];
    $topic = $_POST['topic'];
    $date_begin = $_POST['date_begin'];
    $date_end = $_POST['date_end'];
    $linkToDoc = $_POST['document_link'];
    if($date_begin>$date_end){
      echo '<script>
      alert("Некоректно введена дата!");
      </script>';
      exit;
    }else{
      $creditHours = $_POST['credit_hours'];
      if($creditHours<=0){
        echo '<script>
        alert("Некоректно введена кількість навчальних кредитів (годин)!");
        </script>';
              exit;
      }
    $sql = "INSERT INTO training (institution, document_type, link_to_doc, topic, date_begin, date_end, credit_hours, id_lecture) 
             VALUES (:institution, :document_type, :link_to_doc, :topic, :date_begin, :date_end, :credit_hours, :id_lecture)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':institution', $institution);
    $stmt->bindParam(':document_type', $documentType);
    $stmt->bindParam(':link_to_doc', $linkToDoc);
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
    $linkToDoc = $_POST['document_link'];
    $topic = $_POST['topic'];
    $date_begin = $_POST['date_begin'];
    $date_end = $_POST['date_end'];
    if($date_begin>$date_end){
      echo '<script>
        alert("Некоректно введена дата!");
        </script>';
      exit;
    }else{
      $creditHours = $_POST['credit_hours'];
      if($creditHours<0){
        echo '<script>
          alert("Некоректно введена кількість навчальних кредитів (годин)!");
          </script>';
              exit;
      }
    $sql = "UPDATE training
    SET institution = :institution,
        document_type = :document_type,
        link_to_doc = :link_to_doc,
        topic = :topic,
        date_begin = :date_begin,
        date_end = :date_end,
        credit_hours = :credit_hours
    WHERE id_lecture = :id AND ct_id = :ct_id;";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':institution', $institution);
    $stmt->bindParam(':document_type', $documentType);
    $stmt->bindParam(':link_to_doc', $linkToDoc);
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