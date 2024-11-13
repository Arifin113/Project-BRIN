<?php
include "koneksi.php";

// Uji jika tombol simpan di klik
if (isset($_POST['bSimpan'])) {
    // Persiapan simpan data
    $simpan = mysqli_query($koneksi, "INSERT INTO user (nama, username, role) 
                                       VALUES ('$_POST[tNama]', '$_POST[tUsername]', '$_POST[tRole]')");

    // Jika simpan sukses
    if ($simpan) {
        echo "<script>
                alert('Simpan data sukses');
                document.location = 'index.php';   
              </script>";
    } else {
        echo "<script>
                alert('Simpan data gagal!');
                document.location = 'index.php';   
              </script>";
    }
}

// Uji jika tombol ubah di klik
if (isset($_POST['bUbah'])) {
    // Persiapan ubah data
    $ubah = mysqli_query($koneksi, "UPDATE user SET
                                        nama = '$_POST[tNama]',
                                        username = '$_POST[tUsername]',
                                        role = '$_POST[tRole]'
                                    WHERE id = '$_POST[id]'");

    // Jika ubah sukses
    if ($ubah) {
        echo "<script>
                alert('Ubah data sukses');
                document.location = 'index.php';   
              </script>";
    } else {
        echo "<script>
                alert('Ubah data gagal!');
                document.location = 'index.php';   
              </script>";
    }
}

// Uji jika tombol hapus di klik
if (isset($_POST['bHapus'])) {
    // Persiapan hapus data
    $hapus = mysqli_query($koneksi, "DELETE FROM user WHERE id = '$_POST[id]'");

    // Jika hapus sukses
    if ($hapus) {
        echo "<script>
                alert('Hapus data sukses');
                document.location = 'index.php';   
              </script>";
    } else {
        echo "<script>
                alert('Hapus data gagal!');
                document.location = 'index.php';   
              </script>";
    }
}
