<?php
require 'database.php';

//---------------------------------------- Condition to check that POST value is not empty.
if (!empty($_POST)) {
  //........................................ keep track POST values
  $id = $_POST['id'];
  $height = $_POST['height'];
  $status_read_sensor_hcsr04 = $_POST['status_read_sensor_hcsr04'];
  //........................................

  //........................................ Get the time and date.
  date_default_timezone_set("Asia/Jakarta"); // Look here for your timezone : https://www.php.net/manual/en/timezones.php
  $tm = date("H:i:s");
  $dt = date("Y-m-d");
  //........................................

  //........................................ Updating the data in the table.
  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // replace_with_your_table_name, on this project I use the table name 'esp32_table_dht11_leds_update'.
  // This table is used to store DHT11 sensor data updated by ESP32. 
  // This table is also used to store the state of the LEDs, the state of the LEDs is controlled from the "home.php" page. 
  // This table is operated with the "UPDATE" command, so this table will only contain one row.
  $sql = "UPDATE esp32_table_hcsr04_update SET height = ?, status_read_sensor_hcsr04 = ?, time = ?, date = ? WHERE id = ?";
  $q = $pdo->prepare($sql);
  $q->execute(array($height, $status_read_sensor_hcsr04, $tm, $dt, $id));
  Database::disconnect();
  //........................................ 

  //........................................ Entering data into a table.
  $id_key;
  $board = $_POST['id'];
  $found_empty = false;

  $pdo = Database::connect();

  //:::::::: Process to check if "id" is already in use.
  while ($found_empty == false) {
    $id_key = generate_string_id(10);
    $sql = 'SELECT * FROM esp32_table_hcsr04_record WHERE id="' . $id_key . '"';
    $q = $pdo->prepare($sql);
    $q->execute();

    if (!$data = $q->fetch()) {
      $found_empty = true;
    }
  }
  //::::::::

  //:::::::: The process of entering data into a table.
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "INSERT INTO esp32_table_hcsr04_record (id,board,height,status_read_sensor_hcsr04,time,date) values(?, ?, ?, ?, ?, ?)";
  $q = $pdo->prepare($sql);
  $q->execute(array($id_key, $board, $height, $status_read_sensor_hcsr04, $tm, $dt));
  //::::::::

  Database::disconnect();
  //........................................ 
}
//---------------------------------------- 

//---------------------------------------- Function to create "id" based on numbers and characters.
function generate_string_id($strength = 16)
{
  $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $input_length = strlen($permitted_chars);
  $random_string = '';
  for ($i = 0; $i < $strength; $i++) {
    $random_character = $permitted_chars[mt_rand(0, $input_length - 1)];
    $random_string .= $random_character;
  }
  return $random_string;
}
//---------------------------------------- 
