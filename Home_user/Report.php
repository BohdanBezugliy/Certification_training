<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вибірка відомостей та формування звіту</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
    crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
    crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/styles/style.css">
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
  <div id='FormForChange' class='container' style='width: 80%;'>
    <h1>Вибірка відомостей</h1>
    <form action="Report.php" method="post">

    <label for="institution" class="form-label">Найменування закладу:</label>
    <input type="text" id="institution" name="institution" class="form-control">

    <label for="document_type" class="form-label mt-2">Вид документа:</label>
   <input type="text" id="document_type" name="document_type" class="form-control">

    <label for="topic" class="form-label mt-2">Тема:</label>
    <input type="text" id="topic" name="topic" class="form-control">

    <label for="date_begin" class="form-label mt-2">Дата початку:</label>
    <input type="date" id="date_begin" name="date_begin" class="form-control">

    <label for="date_end" class="form-label mt-2">Дата кінця:</label>
    <input type="date" id="date_end" name="date_end" class="form-control">

    <label for="credit_hours" class="form-label mt-2">Кількість навчальних кредитів (годин):</label>
    <input type="number" id="credit_hours" name="credit_hours" class="form-control">

    <div class="buttons my-2">
        <button type="submit" class="btn btn-primary" name="Search">Пошук</button>
        <button type="submit" class="btn btn-secondary" name="pdf">Формування звіту у форматі pdf</button>
    </div>
    </form>
    </div>
<table class="table">
  <tr>
    <th>Найменування закладу</th>
    <th>Вид документа</th>
    <th>Тема</th>
    <th>Дата початку</th>
    <th>Дата кінця</th>
    <th>Кількість навчальних кредитів (годин)</th>
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
        if(isset($_POST['Search']))
        {
            $sql = "SELECT * FROM training WHERE id_lecture =:id";
            if(empty($_POST['institution']) 
                && empty($_POST['document_type']) && empty($_POST['topic']) 
                && empty($_POST['date_begin']) && empty($_POST['date_end']) && empty($_POST['credit_hours'])){
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['id'=>$_SESSION['id']]);
                $documents_and_events = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach($documents_and_events as $key => $document_and_event){
                    echo "<tr>
                    <td>{$document_and_event['institution']}</td>
                    <td>{$document_and_event['document_type']}</td>
                    <td>{$document_and_event['topic']} </td>
                    <td>{$document_and_event['date_begin']} </td>
                    <td>{$document_and_event['date_end']} </td>
                    <td>{$document_and_event['credit_hours']}</td>
                    </tr>
                    ";
                }
            }else if(!empty($_POST['institution'])){
                $sql = $sql . "AND institution LIKE :institution";
                
            }
        }
        
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    ?>
    </table>
</body>
</html>

