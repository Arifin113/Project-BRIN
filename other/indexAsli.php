<?php
session_start(); // Panggil session_start() di sini

// Logika untuk memeriksa sesi dan peran
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    echo "<script>alert('Akses tidak diizinkan');</script>";
    header('Location: loginAdmin.php');
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

// Lanjutkan dengan pengolahan data dari query...
?>

<style>
    .content {
        padding: 5px;
    }

    .card {
        background-color: white;
        box-shadow: 0px 0px 10px 1px rgba(140, 140, 140, .5);
        border: 1px solid #0c6980;
        border-radius: 15px;
    }

    .card.header {
        background-color: #0c6980;
        color: white;
        border-bottom-right-radius: 0px;
        border-bottom-left-radius: 0px;
        border-top-right-radius: 12px;
        border-top-left-radius: 12px;
    }

    .cards {
        max-width: 700px;
        margin: 0 auto;
        display: grid;
        grid-gap: 2rem;
    }

    .reading {
        font-size: 1.3rem;
    }

    .packet {
        color: #bebebe;
    }

    .temperatureColor {
        color: #fd7e14;
    }

    .humidityColor {
        color: #1b78e2;
    }

    .statusreadColor {
        color: #702963;
        font-size: 12px;
    }

    /* ----------------------------------- */
</style>

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard v1</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="cards">

            <!-- == MONITORING ======================================================================================== -->
            <div class="card">
                <div class="card header">
                    <h3 style="font-size: 1rem;">MONITORING</h3>
                </div>

                <!-- Displays the humidity and temperature values received from ESP32. *** -->
                <h4 class="temperatureColor"><i class="fas fa-thermometer-half"></i> TEMPERATURE</h4>
                <p class="temperatureColor"><span class="reading"><span id="ESP32_01_Temp"></span> &deg;C</span></p>
                <h4 class="humidityColor"><i class="fas fa-tint"></i> HUMIDITY</h4>
                <p class="humidityColor"><span class="reading"><span id="ESP32_01_Humd"></span> &percnt;</span></p>
                <!-- *********************************************************************** -->

                <p class="statusreadColor"><span>Status Read Sensor DHT11 : </span><span id="ESP32_01_Status_Read_DHT11"></span></p>
            </div>
            <!-- ======================================================================================================= -->


            <div class="row">
                <div class="card mt-3">
                    <div class="card-header bg-primary text-white"><i class="fa-solid fa-list"></i> Data Pengunjung</div>
                    <div class="card-body">

                        <!-- Button trigger modal -->
                        <button type="button" class="btn mb-3" style="background-color: #28a745; color: white;" data-bs-toggle="modal" data-bs-target="#modalTambah">
                            <i class="fa-solid fa-circle-plus"></i> Tambah Data
                        </button>

                        <!-- Memberikan margin top pada tombol Download Excel -->
                        <a href="/excel.php">
                            <button type="button" class="btn mb-3" style="background-color: #217346; color: white; border: none; margin-left: 10px;">
                                <i class="fa-solid fa-file-excel"></i> Download Excel
                            </button>
                        </a>

                        <!-- Memberikan margin top pada tombol Download Pdf -->
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
                                        <td class="text-center">
                                            <a href="#" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalUbah<?= $data['id'] ?>"><i class="fa-solid fa-pen-to-square"></i> Ubah</a> |
                                            <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $data['id'] ?>"><i class="fa-solid fa-trash"></i> Hapus</a>
                                        </td>
                                    </tr>

                                    <!-- Awal Modal (ubah) -->
                                    <div class="modal fade" id="modalUbah<?= $no ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Form Ubah Data</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="CRUD.php" method="POST">
                                                    <input type="hidden" name="id" value="<?= $data['id'] ?>">
                                                    <div class="modal-body">

                                                        <div class="mb-3">
                                                            <label class="form-label">Nama</label>
                                                            <input type="text" class="form-control" name="tNama" value="<?= $data['nama'] ?>" placeholder="Masukkan Nama Anda">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Username</label>
                                                            <input type="text" class="form-control" name="tUsername" value="<?= $data['username'] ?>" placeholder="Masukkan Username Anda">
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary" name="bUbah">Ubah</button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Keluar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Akhir Modal (ubah)-->

                                    <!-- Awal Modal (hapus) -->
                                    <div class="modal fade" id="modalHapus<?= $no ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Konfirmasi Hapus Data</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="CRUD.php" method="POST">
                                                    <input type="hidden" name="id" value="<?= $data['id'] ?>">
                                                    <div class="modal-body">
                                                        <h5 class="text-center">Apakah anda yakin akan menghapus data ini?<br>
                                                            <span class="text-danger"><?= $data['nama'] ?> - <?= $data['username'] ?></span>
                                                        </h5>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary" name="bHapus">Hapus</button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Akhir Modal (hapus)-->


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
        </section>
    </div>



    <?php include 'footer.php'; ?>