<?php
session_start(); // Panggil session_start() di sini

// Logika untuk memeriksa sesi dan peran
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header('Location: loginAdmin.php'); // Redirect ke loginAdmin.php jika tidak terautentikasi
    exit;
}

// Sertakan header.php di sini
include 'header.php';

// Pastikan koneksi ke database sudah ada di header.php
$query = mysqli_query($koneksi, "SELECT * FROM user ORDER BY id ASC");

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
                    <p class="temperatureColor"><span class="reading"><span id="ESP32_03_Temp1"></span> &deg;C</span></p>
                    <h4 class="temperatureColor"><i class="fas fa-thermometer-half"></i> TEMPERATURE 2</h4>
                    <p class="temperatureColor"><span class="reading"><span id="ESP32_03_Temp2"></span> &deg;C</span></p>
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
                    <span>Data Pengunjung</span>
                </div>
                <div class="card-body">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn mb-3" style="background-color: #28a745; color: white;" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        <i class="fa-solid fa-circle-plus"></i> Tambah Data
                    </button>

                    <a href="/excel.php">
                        <button type="button" class="btn mb-3" style="background-color: #217346; color: white; border: none; margin-left: 10px;">
                            <i class="fa-solid fa-file-excel"></i> Download Excel
                        </button>
                    </a>

                    <a href="/pdf.php">
                        <button type="button" class="btn mb-3" style="background-color: #217346; color: white; border: none; margin-left: 10px;">
                            <i class="fa-solid fa-file-pdf"></i> Download Pdf
                        </button>
                    </a>

                    <table class="table table-bordered table-striped table-hover mt-3" id="table">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Username</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1; // Inisialisasi nomor urut
                            $tampil = mysqli_query($koneksi, "SELECT * FROM user ORDER BY id ASC"); // Ambil data dari database
                            while ($data = mysqli_fetch_array($tampil)):
                            ?>
                                <tr>
                                    <td class="text-center"><?php echo $no++; ?></td> <!-- Nomor urut berdasarkan ID -->
                                    <td class="text-center"><?php echo $data['nama']; ?></td>
                                    <td class="text-center"><?php echo $data['username']; ?></td>
                                    <td class="text-center"><?php echo $data['role']; ?></td>
                                    <td class="text-center">
                                        <a href="#" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalUbah<?= $data['id'] ?>"><i class="fa-solid fa-pen-to-square"></i> Ubah</a> |
                                        <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $data['id'] ?>"><i class="fa-solid fa-trash"></i> Hapus</a>
                                    </td>
                                </tr>

                                <!-<!-- Awal Modal (ubah) -->
                                    <div class="modal fade" id="modalUbah<?= $data['id'] ?>" tabindex="-1" aria-labelledby="modalUbahLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalUbahLabel">Ubah Data</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="CRUD.php" method="POST">
                                                        <input type="hidden" name="id" value="<?= $data['id']; ?>">
                                                        <div class="mb-3">
                                                            <label for="nama" class="form-label">Nama</label>
                                                            <input type="text" class="form-control" name="tNama" value="<?= $data['nama']; ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="username" class="form-label">Username</label>
                                                            <input type="text" class="form-control" name="tUsername" value="<?= $data['username']; ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="role" class="form-label">Status</label>
                                                            <input type="text" class="form-control" name="tRole" value="<?= $data['role']; ?>" required>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                            <button type="submit" class="btn btn-primary" name="bUbah">Simpan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Akhir Modal (ubah) -->

                                    <!-- Awal Modal (hapus) -->
                                    <div class="modal fade" id="modalHapus<?= $data['id'] ?>" tabindex="-1" aria-labelledby="modalHapusLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalHapusLabel">Hapus Data</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="CRUD.php" method="POST">
                                                        <input type="hidden" name="id" value="<?= $data['id']; ?>">
                                                        <p>Apakah Anda yakin ingin menghapus data <strong><?= $data['nama']; ?></strong>?</p>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                            <button type="submit" class="btn btn-danger" name="bHapus">Hapus</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Akhir Modal (hapus) -->

                                <?php endwhile; ?>
                        </tbody>
                    </table>

                    <!-- Awal Modal (tambah)-->
                    <div class="modal fade" id="modalTambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Form Input Data</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="CRUD.php" method="POST">
                                    <div class="modal-body">

                                        <div class="mb-3">
                                            <label class="form-label">Nama</label>
                                            <input type="text" class="form-control" name="tNama" placeholder="Masukkan Nama Anda">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Username</label>
                                            <input type="text" class="form-control" name="tUsername" placeholder="Masukkan Username Anda">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <input type="text" class="form-control" name="tRole" placeholder="Masukkan Status Anda">
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary" name="bSimpan">Simpan</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Keluar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Akhir Modal (tambah) -->

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
    document.getElementById("ESP32_03_Temp1").innerHTML = "NN";
    document.getElementById("ESP32_03_Temp2").innerHTML = "NN";
    document.getElementById("ESP32_03_Temp3").innerHTML = "NN";
    document.getElementById("ESP32_03_Temp4").innerHTML = "NN";
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
                    document.getElementById("ESP32_03_Temp1").innerHTML = myObj.temperature1;
                    document.getElementById("ESP32_03_Temp2").innerHTML = myObj.temperature2;
                    document.getElementById("ESP32_03_Temp3").innerHTML = myObj.temperature3;
                    document.getElementById("ESP32_03_Temp4").innerHTML = myObj.temperature4;
                    document.getElementById("ESP32_03_Status_Read_DS18B20").innerHTML = myObj.status_read_sensor_DS18B20;
                    document.getElementById("ESP32_03_LTRD").innerHTML = "Time : " + myObj.ls_time + " | Date : " + myObj.ls_date + " (dd-mm-yyyy)";
                }
            }
        };
        xmlhttp.open("POST", "/FinalDS18B20/getdata.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("id=" + id);
    }
    //------------------------------------------------------------
</script>

<script>
    // UNTUK MENU MONITORING SUHU DENGAN SENSOR TERMOKOPEL
    document.getElementById("ESP32_03_Temp1").innerHTML = "NN";
    document.getElementById("ESP32_03_Temp2").innerHTML = "NN";
    document.getElementById("ESP32_03_Temp3").innerHTML = "NN";
    document.getElementById("ESP32_03_Temp4").innerHTML = "NN";
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
                    document.getElementById("ESP32_03_Temp1").innerHTML = myObj.temperature1;
                    document.getElementById("ESP32_03_Temp2").innerHTML = myObj.temperature2;
                    document.getElementById("ESP32_03_Temp3").innerHTML = myObj.temperature3;
                    document.getElementById("ESP32_03_Temp4").innerHTML = myObj.temperature4;
                    document.getElementById("ESP32_03_Status_Read_DS18B20").innerHTML = myObj.status_read_sensor_DS18B20;
                    document.getElementById("ESP32_03_LTRD").innerHTML = "Time : " + myObj.ls_time + " | Date : " + myObj.ls_date + " (dd-mm-yyyy)";
                }
            }
        };
        xmlhttp.open("POST", "/FinalDS18B20/getdata.php", true);
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