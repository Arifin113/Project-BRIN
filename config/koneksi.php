<?php


// koneksi database
$hostname = "localhost";
$user = "root";
$password = "";
$db_name = "administrasi";

$koneksi = mysqli_connect($hostname, $user, $password, $db_name) or die(mysqli_connect_error($koneksi));

?>
