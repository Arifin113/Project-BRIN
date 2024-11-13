<?php
include 'database.php';

//---------------------------------------- Condition to check that POST value is not empty.
if (!empty($_POST)) {
  // keep track post values
  $id = $_POST['id'];

  $myObj = (object)array();

  //........................................ 
  $pdo = Database::connect();

  $sql = 'SELECT * FROM esp32_table_hx710b_update WHERE id="' . $id . '"';
  foreach ($pdo->query($sql) as $row) {
    $date = date_create($row['date']);
    $dateFormat = date_format($date, "d-m-Y");

    $myObj->id = $row['id'];
    $myObj->pressureInput = $row['pressureInput'];
    $myObj->pressureOutput = $row['pressureOutput'];
    $myObj->pressureSelisih = $row['pressureSelisih'];
    $myObj->status_read_sensor_hx710b_input = $row['status_read_sensor_hx710b_input'];
    $myObj->status_read_sensor_hx710b_output = $row['status_read_sensor_hx710b_output'];
    $myObj->ls_time = $row['time'];
    $myObj->ls_date = $dateFormat;

    $myJSON = json_encode($myObj);

    echo $myJSON;
  }
  Database::disconnect();
  //........................................ 
}
//---------------------------------------- 
