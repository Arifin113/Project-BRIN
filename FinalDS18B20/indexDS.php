<?php
session_start(); // Mulai sesi

// Cek sesi login dan peran (boleh "admin" atau "user")
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header('Location: ../admin/page/loginAdmin.php'); // Redirect ke loginAdmin.php jika tidak terautentikasi
    exit;
}

// Sertakan header.php di sini
include 'headerDS.php';

// Pastikan koneksi ke database sudah ada di header.php
$query = mysqli_query($koneksi, "SELECT * FROM esp32_table_ds18b20_record ORDER BY date, time");

// Periksa apakah query berhasil
if (!$query) {
    die("Query Error: " . mysqli_error($koneksi));
}
?>

<style>
    .content {
        padding: 5px;
    }

    .cards {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        max-width: 1000px;
        /* Anda bisa menyesuaikan lebar ini */
        margin: 0 auto;
    }

    .card {
        margin: 5px;
        flex-basis: calc(25% - 10px);
        /* Ukuran kartu sama rata, 4 kartu dalam satu baris */
        min-width: 200px;
        /* Lebar minimum kartu */
        border: 1px solid #1b78e2;
        border-radius: 5px;
        padding: 10px;
        box-shadow: 0 2px 5px rebeccapurple;
        transition: transform 0.3s, box-shadow 0.3s;
        /* Efek transisi untuk hover */
    }

    .card:hover {
        transform: scale(1.05);
        /* Memperbesar kartu ketika di-hover */
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        /* Bayangan lebih besar saat di-hover */
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
        font-size: 23px;
        color: #1b78e2;
    }

    .statusreadColor {
        color: #702963;
        font-size: 12px;
    }

    .text-center {
        text-align: center;
    }

    .card1 {
        margin: 5px;
        /* Menambahkan margin */
        flex: 1;
        /* Membuat kartu bisa mengambil ruang yang tersedia
        min-width: 150px;
        /* Menetapkan lebar minimum untuk kartu */
        border: 1px #1b78e2;
        /* Tambahkan border untuk kartu */
        border-radius: 5px;
        /* Sudut yang membulat */
        padding: 10px;
        /* Padding di dalam kartu */
        box-shadow: 0 2px 5px rebeccapurple;
        /* Bayangan */
    }

    .card-header1 {
        text-align: center;
        background-color: #007bff;
        /* Ganti dengan warna biru yang Anda inginkan */
        color: white;
        /* Mengubah warna teks menjadi putih untuk kontras yang baik */
        background-size: 10vh;
        margin: 5px;
        /* Menambahkan margin */
        flex: 1;
        /* Membuat kartu bisa mengambil ruang yang tersedia
        min-width: 150px;
        /* Menetapkan lebar minimum untuk kartu */
        border: 1px #1b78e2;
        /* Tambahkan border untuk kartu */
        border-radius: 5px;
        /* Sudut yang membulat */
        padding: 10px;
        /* Padding di dalam kartu */
        box-shadow: 0 2px 5px rebeccapurple;
        /* Bayangan */
    }

    .card-body {
        margin-top: 15px;
    }
</style>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/admin/page/index.php">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard v1</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="cards">
            <!-- == MONITORING 1 ======================================================================================== -->
            <div class="card">
                <div class="card-header">
                    <h3 style="font-size: 1rem;">TEMPERATURE</h3>
                </div>
                <div class="text-center">
                    <h4 class="temperatureColor"><i class="fas fa-thermometer-half"></i> TEMPERATURE</h4>
                    <p class="temperatureColor"><span class="reading"><span id="ESP32_01_Temp"></span> &deg;C</span></p>
                    <h4 class="humidityColor"><i class="fas fa-tint"></i> HUMIDITY</h4>
                    <p class="humidityColor"><span class="reading"><span id="ESP32_01_Humd"></span> &percnt;</span></p>
                    <h4 class="statusreadColor"><span>Status Read Sensor DHT11: </span></h4>
                    <p style="font-size: 12px;"><span id="ESP32_01_Status_Read_DHT11"></span></p>
                </div>
            </div>
            <!-- ======================================================================================================= -->

            <!-- == MONITORING 2 ======================================================================================== -->
            <div class="card">
                <div class="card-header">
                    <h3 style="font-size: 1rem;">WATER LEVEL</h3>
                </div>
                <div class="text-center">
                    <h4 class="temperatureColor"><i class="fas fa-water"></i> HEIGHT</h4>
                    <p class="temperatureColor"><span class="reading"><span id="ESP32_02_Height"></span> cm</span></p>
                    <h4 class="statusreadColor" style="margin-top: 46%;"><span>Status Read Sensor HC-SR04: </span></h4>
                    <p style="font-size: 12px;"><span id="ESP32_02_Status_Read_HCSR04"></span></p>
                </div>
            </div>
            <!-- ======================================================================================================= -->

            <!-- == MONITORING 3 ======================================================================================== -->
            <div class="card">
                <div class="card-header">
                    <h3 style="font-size: 1rem;">PRESSURE </h3>
                </div>
                <div class="text-center">
                    <h4 class="temperatureColor"><i class="fas fa-gauge"></i> Pressure Input</h4>
                    <p class="temperatureColor"><span class="reading"><span id="ESP32_04_pressureInput"></span> INWC</span></p>
                    <h4 class="humidityColor"><i class="fas fa-gauge"></i> Pressure Output</h4>
                    <p class="humidityColor"><span class="reading"><span id="ESP32_04_pressureOutput"></span> INWC</span></p>
                    <h4 class="statusreadColor"><span>Status Read Sensor (input): </span></h4>
                    <p style="font-size: 12px;"><span id="ESP32_04_Status_Read_hx710b_input"></span></p>
                    <h4 class="statusreadColor"><span>Status Read Sensor (output): </span></h4>
                    <p style="font-size: 12px;"><span id="ESP32_04_Status_Read_hx710b_output"></span></p>
                </div>
            </div>
            <!-- ======================================================================================================= -->

            <!-- == MONITORING 4 ======================================================================================== -->
            <div class="card">
                <div class="card-header">
                    <h3 style="font-size: 1rem;">TEMPERATURE</h3>
                </div>
                <div class="text-center">
                    <h4 class="temperatureColor"><i class="fas fa-thermometer-half"></i> TEMPERATURE 1</h4>
                    <p class="temperatureColor"><span class="reading"><span id="ESP32_03_termokopelSatu"></span> &deg;C</span></p>
                    <h4 class="temperatureColor"><i class="fas fa-thermometer-half"></i> TEMPERATURE 2</h4>
                    <p class="temperatureColor"><span class="reading"><span id="ESP32_03_termokopelDua"></span> &deg;C</span></p>
                    <!-- <h4 class="statusreadColor"><span>Status Read Sensor DS18B20: </span></h4>
                    <p style="font-size: 12px;"><span id="ESP32_03_Status_Read_DS18B20"></span></p> -->
                </div>
            </div>
            <!-- ======================================================================================================= -->

            <br>


            <div class="content">
                <div class="cards">
                    <div class="card header" style="border-radius: 15px; min-width: 985px; text-align:center; background-color:greenyellow; color: black;">
                        <h3 style="font-weight: bold; font-size: 0.8rem;">LAST TIME RECEIVED DATA DHT11 FROM ESP32 [ <span id="ESP32_01_LTRD"></span> ]</h3>
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="cards">
                    <div class="card header" style="border-radius: 15px; min-width: 985px; text-align:center; background-color:greenyellow; color: black;">
                        <h3 style="font-weight: bold; font-size: 0.8rem;">LAST TIME RECEIVED DATA HCSR04 FROM ESP32 [ <span id="ESP32_02_LTRD"></span> ]</h3>
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="cards">
                    <div class="card header" style="border-radius: 15px; min-width: 985px; text-align:center; background-color:greenyellow; color: black;">
                        <h3 style="font-weight: bold; font-size: 0.8rem;">LAST TIME RECEIVED DATA DS18B20 FROM ESP32 [ <span id="ESP32_03_LTRD"></span> ]</h3>
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="cards">
                    <div class="card header" style="border-radius: 15px; min-width: 985px; text-align:center; background-color:greenyellow; color: black;">
                        <h3 style="font-weight: bold; font-size: 0.8rem;">LAST TIME RECEIVED DATA HX710B FROM ESP32 [ <span id="ESP32_04_LTRD"></span> ]</h3>
                    </div>
                </div>
            </div>

            <!-- ___________________________________________________________________________________________________________________________________ -->

        </div>

        <div class="row mt-3">
            <div class="card1">
                <div class="card-header1 text-white bg-primary d-flex align-items-center">
                    <i class="fas fa-list me-2"></i> <!-- Menambahkan kelas 'me-2' untuk margin kanan -->
                    <span>Data Sensor Temperature</span>
                </div>
                <div class="card-body">

                    <a href="excelData.php">
                        <button type="button" class="btn mb-3" style="background-color: #217346; color: white; border: none; margin-left: 10px;">
                            <i class="fa-solid fa-file-excel"></i> Download Excel
                        </button>
                    </a>

                    <a href="pdfData.php">
                        <button type="button" class="btn mb-3" style="background-color: #217346; color: white; border: none; margin-left: 10px;">
                            <i class="fa-solid fa-file-pdf"></i> Download Pdf
                        </button>
                    </a>

                    <table class="table table-bordered table-striped table-hover mt-3" id="table">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">ID</th>
                                <th class="text-center">Board</th>
                                <th class="text-center">Temperature 1 (°C)</th>
                                <th class="text-center">Temperature 2 (°C)</th>
                                <th class="text-center">Temperature 3 (°C)</th>
                                <th class="text-center">Temperature 4 (°C)</th>
                                <!-- <th class="text-center">Status Read Sensor DS18B20</th> -->
                                <th class="text-center">Time</th>
                                <th class="text-center">Date (dd-mm-yyyy)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include 'database.php';
                            $no = 1; // Inisialisasi nomor urut
                            $tampil = mysqli_query($koneksi, "SELECT * FROM esp32_table_ds18b20_record ORDER BY date, time"); // Ambil data dari database

                            while ($data = mysqli_fetch_array($tampil)):
                                // Format date
                                $date = date_create($data['date']); // Mengambil kolom 'date' dari database
                                $dateFormat = date_format($date, 'd-m-Y'); // Mengubah format tanggal menjadi 'dd-mm-yyyy'
                            ?>

                                <tr>
                                    <td class="text-center"><?php echo $no++; ?></td> <!-- Nomor urut berdasarkan ID -->
                                    <td class="text-center"><?php echo $data['id']; ?></td>
                                    <td class="text-center"><?php echo $data['board']; ?></td>
                                    <td class="text-center"><?php echo $data['temperature1']; ?></td>
                                    <td class="text-center"><?php echo $data['temperature2']; ?></td>
                                    <td class="text-center"><?php echo $data['temperature3']; ?></td>
                                    <td class="text-center"><?php echo $data['temperature4']; ?></td>
                                    <!-- <td class="text-center"><?php echo $data['status_read_sensor_DS18B20']; ?></td> -->
                                    <td class="text-center"><?php echo $data['time']; ?></td>
                                    <td class="text-center"><?php echo $dateFormat; ?></td> <!-- Menampilkan tanggal yang sudah diformat -->
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // UNTUK MENU MONITORING SENSOR SUHU
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
                }
            }
        };
        xmlhttp.open("POST", "/Final/getdata.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("id=" + id);
    }
    //------------------------------------------------------------
</script>

<script>
    // UNTUK MENU MONITORING SENSOR JARAK
    document.getElementById("ESP32_02_Height").innerHTML = "NN";
    document.getElementById("ESP32_02_Status_Read_HCSR04").innerHTML = "NN";
    document.getElementById("ESP32_02_LTRD").innerHTML = "NN";
    //------------------------------------------------------------

    Get_Data("esp32_02");

    setInterval(myTimer, 5000);

    //------------------------------------------------------------
    function myTimer() {
        Get_Data("esp32_02");
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
                if (myObj.id == "esp32_02") {
                    document.getElementById("ESP32_02_Height").innerHTML = myObj.height;
                    document.getElementById("ESP32_02_Status_Read_HCSR04").innerHTML = myObj.status_read_sensor_hcsr04;
                    document.getElementById("ESP32_02_LTRD").innerHTML = "Time : " + myObj.ls_time + " | Date : " + myObj.ls_date + " (dd-mm-yyyy)";
                }
            }
        };
        xmlhttp.open("POST", "/FinalHCSR04/getdata.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("id=" + id);
    }
    //------------------------------------------------------------
</script>


<script>
    // UNTUK MENU MONITORING SUHU DENGAN SENSOR TERMOKOPEL
    document.getElementById("ESP32_03_termokopelSatu").innerHTML = "NN";
    document.getElementById("ESP32_03_termokopelDua").innerHTML = "NN";
    document.getElementById("ESP32_03_temperature3").innerHTML = "NN";
    document.getElementById("ESP32_03_temperature4").innerHTML = "NN";
    document.getElementById("ESP32_03_Status_Read_DS18B20").innerHTML = "NN";
    document.getElementById("ESP32_03_LTRD").innerHTML = "NN";
    //------------------------------------------------------------

    Get_Data("esp32_03");

    setInterval(myTimer, 5000);

    //------------------------------------------------------------
    function myTimer() {
        Get_Data("esp32_03");
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
                if (myObj.id == "esp32_03") {
                    document.getElementById("ESP32_03_termokopelSatu").innerHTML = myObj.temperature1;
                    document.getElementById("ESP32_03_termokopelDua").innerHTML = myObj.temperature2;
                    document.getElementById("ESP32_03_temperature3").innerHTML = myObj.temperature3;
                    document.getElementById("ESP32_03_temperature4").innerHTML = myObj.temperature4;
                    document.getElementById("ESP32_03_Status_Read_DS18B20").innerHTML = myObj.status_read_sensor_DS18B20;
                    document.getElementById("ESP32_03_LTRD").innerHTML = "Time : " + myObj.ls_time + " | Date : " + myObj.ls_date + " (dd-mm-yyyy)";
                }
            }
        };
        xmlhttp.open("POST", "getdata.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("id=" + id);
    }
    //------------------------------------------------------------
</script>

<script>
    // UNTUK MENU MONITORING TEKANAN
    document.getElementById("ESP32_04_pressureInput").innerHTML = "NN";
    document.getElementById("ESP32_04_pressureOutput").innerHTML = "NN";
    document.getElementById("ESP32_04_Status_Read_hx710b_input").innerHTML = "NN";
    document.getElementById("ESP32_04_Status_Read_hx710b_output").innerHTML = "NN";
    document.getElementById("ESP32_04_LTRD").innerHTML = "NN";
    //------------------------------------------------------------

    Get_Data("esp32_04");

    setInterval(myTimer, 5000);

    //------------------------------------------------------------
    function myTimer() {
        Get_Data("esp32_04");
    }
    //------------------------------------------------------------

    //------------------------------------------------------------
    function Get_Data(id) {
        var xmlhttp;
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText); // Tambahkan ini untuk melihat respons di console browser
                const myObj = JSON.parse(this.responseText);

                // Check if there is an error in the response
                if (myObj.error) {
                    console.error("Error: " + myObj.error);
                    return;
                }

                // Update the UI with the fetched data
                document.getElementById("ESP32_04_pressureInput").innerHTML = myObj.pressureInput;
                document.getElementById("ESP32_04_pressureOutput").innerHTML = myObj.pressureOutput;
                document.getElementById("ESP32_04_Status_Read_hx710b_input").innerHTML = myObj.status_read_sensor_hx710b_input;
                document.getElementById("ESP32_04_Status_Read_hx710b_output").innerHTML = myObj.status_read_sensor_hx710b_output;
                document.getElementById("ESP32_04_LTRD").innerHTML = "Time: " + myObj.ls_time + " | Date: " + myObj.ls_date;
            }
        };
        xmlhttp.open("POST", "/FinalHX710B/getdata.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("id=" + id);
    }
</script>


<!-- Sertakan footer.php di sini -->
<?php include 'footer.php'; ?>