<?php


// koneksi database
$hostname = "localhost";
$user = "root";
$password = "";
$db_name = "esp32_mc_db";

$koneksi = mysqli_connect($hostname, $user, $password, $db_name) or die(mysqli_connect_error($koneksi));
