<?php
require 'vendor/autoload.php';
use Dompdf\Dompdf;
$dompdf = new Dompdf();
$dompdf->loadHtml('hello world');

?>