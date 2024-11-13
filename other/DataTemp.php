<?php

session_start();

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
  echo "<script>
  alert('Akses tidak diizinkan');
  window.location = 'loginAdmin.php';
  </script>";
  exit;
}

include 'headerMonitor.php';

include 'koneksi.php';

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Data Temperature</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.datatables.net/2.1.7/css/dataTables.bootstrap5.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <style>
    .content {
      padding: 5px;
    }

    .cards {
      max-width: 100%;
      /* Membuat gambar tidak melebihi lebar kontainer */
      height: auto;
      /* Mengatur tinggi secara otomatis untuk menjaga rasio aspek */
      display: block;
      /* Menghindari ruang kosong di bawah gambar */
      margin: 0 auto;
      /* Untuk memusatkan gambar dalam kontainer */

    }

    .card {
      margin: 5px;

      flex: 1;

      min-width: 150px;

      border: 1px #1b78e2;

      border-radius: 5px;

      padding: 10px;

      box-shadow: 0 2px 5px rebeccapurple;

    }

    .card-header {
      text-align: center;
      background-color: #007bff;

      color: white;

    }


    .reading {
      font-size: 1.3rem;
    }

    .packet {
      color: #bebebe;
    }

    .temperatureColor {
      margin-top: 15px;
      color: #fd7e14;
    }

    .humidityColor {
      color: #1b78e2;
    }

    .statusreadColor {
      color: #702963;
      font-size: 12px;
    }

    .text-center {
      text-align: center;
      /* Mengatur teks di tengah */
    }
  </style>

</head>


<br>

<div class="content">
  <div class="cards">
    <div class="card header" style="border-radius: 15px; min-width: 660px; text-align:center; background-color:greenyellow; color: black;">
      <h3 style="font-size: 0.7rem;">LAST TIME RECEIVED DATA FROM ESP32 [ <span id="ESP32_01_LTRD"></span> ]</h3>
    </div>
  </div>
</div>

<body>
  <div class="container">

    <div class="mt-3"></div>
    <h3 class="text-center">Temperature Data Monitoring</h3>
    <h3 class="text-center">Sensor MLX90614</h3>
  </div>

  <div class="card mt-3">
    <div class="card-header bg-primary text-white"><i class="fa-solid fa-list"></i> Data Temperature</div>
    <div class="card-body">

      <!-- Memberikan margin top pada tombol Download Excel -->
      <a href="excelData.php">
        <button type="button" class="btn mb-3" style="background-color: #217346; color: white; border: none; margin-left: 10px;">
          <i class="fa-solid fa-file-excel"></i> Download Excel
        </button>
      </a>

      <!-- Memberikan margin top pada tombol Download Pdf -->
      <a href="pdfData.php">
        <button type="button" class="btn mb-3" style="background-color: #217346; color: white; border: none; margin-left: 10px;">
          <i class="fa-solid fa-file-pdf"></i> Download Pdf
        </button>
      </a>

      <table class="table table-bordered table-striped table-hover mt-3" id="table_id">
        <thead>
          <tr>
            <th class="text-center">No</th>
            <th class="text-center">ID</th>
            <th class="text-center">Board</th>
            <th class="text-center">Temperature (°C)</th>
            <th class="text-center">Humidity (%)</th>
            <th class="text-center">Status Read Sensor DHT11</th>
            <th class="text-center">Time</th>
            <th class="text-center">Date (dd-mm-yyyy)</th>
          </tr>
        </thead>
        <tbody id="tbody_table_record">
          <?php
          include 'database.php';
          $num = 0;
          //------------------------------------------------------------ The process for displaying a record table containing the DHT11 sensor data and the state of the LEDs.
          $pdo = Database::connect();
          $sql = 'SELECT * FROM esp32_table_dht11_leds_record ORDER BY date, time';
          foreach ($pdo->query($sql) as $row) {
            $date = date_create($row['date']);
            $dateFormat = date_format($date, "d-m-Y");
            $num++;
            echo '<tr>';
            echo '<td class="text-center">' . $num . '</td>';
            echo '<td class="bdr text-center">' . $row['id'] . '</td>';
            echo '<td class="bdr text-center">' . $row['board'] . '</td>';
            echo '<td class="bdr text-center">' . $row['temperature'] . '°C</td>';
            echo '<td class="bdr text-center">' . $row['humidity'] . '%</td>';
            echo '<td class="bdr text-center">' . $row['status_read_sensor_dht11'] . '</td>';
            echo '<td class="bdr text-center">' . $row['time'] . '</td>';
            echo '<td class="bdr text-center">' . $dateFormat . '</td>';
            echo '</tr>';
          }
          Database::disconnect();
          //------------------------------------------------------------
          ?>
        </tbody>
      </table>

      <br>

      <div class="btn-group" style="display: flexbox; align-items: center; justify-content: space-between;">
        <button type="button" class="btn btn-info btn-sm" id="btn_prev" onclick="prevPage()" style="height: 38px; width: 80px;">Prev</button>
        <button type="button" class="btn btn-primary btn-sm" id="btn_next" onclick="nextPage()" style="height: 38px; width: 80px;">Next</button>

        <div style="display: inline-block; position: relative; margin-left: 2px;">
          <p style="font-size: 20px; margin: 0;">Table: <span id="page"></span></p>
        </div>

        <select name="number_of_rows" id="number_of_rows" style="margin-left: 2px; height: 38px;">
          <option value="10">10</option>
          <option value="25">25</option>
          <option value="50">50</option>
          <option value="100">100</option>
        </select>

        <button type="button" class="btn btn-primary btn-sm" id="btn_apply" onclick="apply_Number_of_Rows()" style="height: 38px; width: 80px;">Apply</button>
      </div>

      <br>

      <!-- script untuk menu monitoring -->

      <script>
        //------------------------------------------------------------
        document.getElementById("ESP32_01_Temp").innerHTML = "NN";
        document.getElementById("ESP32_01_Humd").innerHTML = "NN";
        document.getElementById("ESP32_01_Status_Read_DHT11").innerHTML = "NN";
        document.getElementById("ESP32_01_LTRD").innerHTML = "NN";
        //------------------------------------------------------------

        Get_Data("esp32_01");

        setInterval(myTimer, 5000);

        //------------------------------------------------------------
        function myTimer() {
          Get_Data("esp32_01");
        }
        //------------------------------------------------------------

        //------------------------------------------------------------
        function Get_Data(id) {
          if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
          } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
          }
          xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              const myObj = JSON.parse(this.responseText);
              if (myObj.id == "esp32_01") {
                document.getElementById("ESP32_01_Temp").innerHTML = myObj.temperature;
                document.getElementById("ESP32_01_Humd").innerHTML = myObj.humidity;
                document.getElementById("ESP32_01_Status_Read_DHT11").innerHTML = myObj.status_read_sensor_dht11;
                document.getElementById("ESP32_01_LTRD").innerHTML = "Time : " + myObj.ls_time + " | Date : " + myObj.ls_date + " (dd-mm-yyyy)";
                if (myObj.LED_01 == "ON") {
                  document.getElementById("ESP32_01_TogLED_01").checked = true;
                } else if (myObj.LED_01 == "OFF") {
                  document.getElementById("ESP32_01_TogLED_01").checked = false;
                }
                if (myObj.LED_02 == "ON") {
                  document.getElementById("ESP32_01_TogLED_02").checked = true;
                } else if (myObj.LED_02 == "OFF") {
                  document.getElementById("ESP32_01_TogLED_02").checked = false;
                }
              }
            }
          };
          xmlhttp.open("POST", "getdata.php", true);
          xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          xmlhttp.send("id=" + id);
        }
        //------------------------------------------------------------

        //------------------------------------------------------------
        function GetTogBtnLEDState(togbtnid) {
          if (togbtnid == "ESP32_01_TogLED_01") {
            var togbtnchecked = document.getElementById(togbtnid).checked;
            var togbtncheckedsend = "";
            if (togbtnchecked == true) togbtncheckedsend = "ON";
            if (togbtnchecked == false) togbtncheckedsend = "OFF";
            Update_LEDs("esp32_01", "LED_01", togbtncheckedsend);
          }
          if (togbtnid == "ESP32_01_TogLED_02") {
            var togbtnchecked = document.getElementById(togbtnid).checked;
            var togbtncheckedsend = "";
            if (togbtnchecked == true) togbtncheckedsend = "ON";
            if (togbtnchecked == false) togbtncheckedsend = "OFF";
            Update_LEDs("esp32_01", "LED_02", togbtncheckedsend);
          }
        }
        //------------------------------------------------------------

        //------------------------------------------------------------
        function Update_LEDs(id, lednum, ledstate) {
          if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
          } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
          }
          xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              //document.getElementById("demo").innerHTML = this.responseText;
            }
          }
          xmlhttp.open("POST", "updateLEDs.php", true);
          xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          xmlhttp.send("id=" + id + "&lednum=" + lednum + "&ledstate=" + ledstate);
        }
        //------------------------------------------------------------
      </script>

      <script>
        //------------------------------------------------------------
        var current_page = 1;
        var records_per_page = 10;
        var l = document.getElementById("table_id").rows.length
        //------------------------------------------------------------

        //------------------------------------------------------------
        function apply_Number_of_Rows() {
          var x = document.getElementById("number_of_rows").value;
          records_per_page = x;
          changePage(current_page);
        }
        //------------------------------------------------------------

        //------------------------------------------------------------
        function prevPage() {
          if (current_page > 1) {
            current_page--;
            changePage(current_page);
          }
        }
        //------------------------------------------------------------

        //------------------------------------------------------------
        function nextPage() {
          if (current_page < numPages()) {
            current_page++;
            changePage(current_page);
          }
        }
        //------------------------------------------------------------

        //------------------------------------------------------------
        function changePage(page) {
          var btn_next = document.getElementById("btn_next");
          var btn_prev = document.getElementById("btn_prev");
          var listing_table = document.getElementById("table_id");
          var page_span = document.getElementById("page");

          // Validate page
          if (page < 1) page = 1;
          if (page > numPages()) page = numPages();

          [...listing_table.getElementsByTagName('tr')].forEach((tr) => {
            tr.style.display = 'none'; // reset all to not display
          });
          listing_table.rows[0].style.display = ""; // display the title row

          for (var i = (page - 1) * records_per_page + 1; i < (page * records_per_page) + 1; i++) {
            if (listing_table.rows[i]) {
              listing_table.rows[i].style.display = ""
            } else {
              continue;
            }
          }

          page_span.innerHTML = page + "/" + numPages() + " (Total Number of Rows = " + (l - 1) + ") | Number of Rows : ";

          if (page == 0 && numPages() == 0) {
            btn_prev.disabled = true;
            btn_next.disabled = true;
            return;
          }

          if (page == 1) {
            btn_prev.disabled = true;
          } else {
            btn_prev.disabled = false;
          }

          if (page == numPages()) {
            btn_next.disabled = true;
          } else {
            btn_next.disabled = false;
          }
        }
        //------------------------------------------------------------

        //------------------------------------------------------------
        function numPages() {
          return Math.ceil((l - 1) / records_per_page);
        }
        //------------------------------------------------------------

        //------------------------------------------------------------
        window.onload = function() {
          var x = document.getElementById("number_of_rows").value;
          records_per_page = x;
          changePage(current_page);
        };
        //------------------------------------------------------------
      </script>

</body>

</html>