<?php
$a = $_POST;
file_put_contents('log.txt', print_r($a, true), FILE_APPEND);
file_put_contents('log.txt', print_r($_SERVER, true), FILE_APPEND);
?>
