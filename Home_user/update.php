<?php
    session_start();
    $_SESSION['ct_id']=$_GET['ct_id'];
    header("Location: Change.php");