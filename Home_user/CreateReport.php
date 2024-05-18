<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
      $stmt = $pdo->prepare("SELECT * FROM Lecture WHERE id_lecture = :id;");
      $stmt->execute([
        'id'=>$_SESSION['id']
      ]);
      $lectures = $stmt->fetch(PDO::FETCH_ASSOC);
      echo "<div style='font-size:25px;'><b>ПІБ:</b> ".$lectures['full_name']."</в>";
      echo "<div style='font-size:25px;'><b>Посада:</b> ".$lectures['position']."</div>";
      echo "<div style='font-size:25px;'><b>Наукове звання:</b> ".$lectures['rank']."</div>";
      echo "<div style='font-size:25px;'><b>Факультет:</b> ".$lectures['department']."</div>";
    }catch(PDOException $e){
        echo $e->getMessage();
    }
    ?>
<table>
  <tr>
    <th>Найменування закладу</th>
    <th>Вид документа</th>
    <th>Тема</th>
    <th>Дата початку</th>
    <th>Дата кінця</th>
    <th>Кількість навчальних кредитів (годин)</th>
  </tr>
    <?php
$documents_and_events = $_SESSION['documents_and_events'];
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
    <tr style="text-align: center;">
    <td><?php echo $institution; ?></td>
    <td><?php echo $documentType; ?></td>
    <td><?php echo $topic; ?></td>
    <td><?php echo $dateBegin; ?></td>
    <td><?php echo $dateEnd; ?></td>
    <td><?php echo $creditHours; ?></td>
    </tr>
    <?php 
    }
header ("Content-Type: application/doc");
header ("Content-Disposition: attachment; filename=ExportFile.doc");
?>
</table>
</body>
</html>



