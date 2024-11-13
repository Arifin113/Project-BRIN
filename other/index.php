<!-- halaman indeks dengan tabel yang urutannya berdasarkan nama  -->

<?php

session_start();

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
  echo "<script>
  alert('Akses tidak diizinkan');
  window.location = 'loginAdmin.php';
  </script>";
  exit;
}

include 'koneksi.php';

$query = mysqli_query($koneksi, "SELECT * FROM user ORDER BY nama ASC");

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>DASHBOARD ADMIN</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.datatables.net/2.1.7/css/dataTables.bootstrap5.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
  <div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
        <a class="navbar-brand" href="">Menu</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../Final/home.php">Real Time Data</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../Final/recordtable.php">Recording Data</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="About.php">About</a>
            <li class="nav-item">
              <a class="nav-link" href="logout.php">Logout</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </div>

  <div class="container">

    <div class="mt-3"></div>
    <h3 class="text-center">DASHBOARD ADMIN</h3>
    <h3 class="text-center">Selamat Datang Admin</h3>
  </div>

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

        <?php

        // persiapan menampilkan data
        $no = 1;
        $tampil = mysqli_query($koneksi, "SELECT * FROM user ORDER BY nama ASC");
        while ($data = mysqli_fetch_array($tampil)):

        ?>

          <tr>
            <td class="text-center"><?php echo $no++ ?></td>
            <td class="text-center"><?php echo $data['nama']; ?></td>
            <td class="text-center"><?php echo $data['username']; ?></td>
            <td class="text-center">
              <a href="#" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalUbah<?= $no ?>"><i class="fa-solid fa-pen-to-square"></i> Ubah</a> |
              <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $no ?>"><i class="fa-solid fa-trash"></i> Hapus</a>
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



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

  <!-- asset plugin datatables -->

  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/2.1.7/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/2.1.7/js/dataTables.bootstrap5.js"></script>


  <script>
    new DataTable('#table');
  </script>
</body>

</html>