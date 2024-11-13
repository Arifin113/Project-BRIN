<?php
include 'database.php';

//---------------------------------------- Condition to check that POST value is not empty.
if (!empty($_POST)) {
  // keep track post values
  $id = $_POST['id'];

  $myObj = (object)array();

  //........................................ 
  $pdo = Database::connect();

  $sql = 'SELECT * FROM esp32_table_ds18b20_update WHERE id="' . $id . '"';
  foreach ($pdo->query($sql) as $row) {
    $date = date_create($row['date']);
    $dateFormat = date_format($date, "d-m-Y");

    $myObj->id = $row['id'];
    $myObj->termokopelSatu = $row['temperature1'];
    $myObj->termokopelDua = $row['temperature2'];
    $myObj->temperature3 = $row['temperature3'];
    $myObj->temperature4 = $row['temperature4'];
    $myObj->status_read_sensor_DS18B20 = $row['status_read_sensor_DS18B20'];
    $myObj->ls_time = $row['time'];
    $myObj->ls_date = $dateFormat;

    $myJSON = json_encode($myObj);

    echo $myJSON;
  }
  Database::disconnect();
  //........................................ 
}
//---------------------------------------- 
