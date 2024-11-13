<?php

include "koneksi.php";

// uji jika tombol simpan di klik
if (isset($_POST['bSimpan'])) {

    //persipaan ubah data


    $simpan = mysqli_query($koneksi, "INSERT INTO user (nama, username) 
                                    VALUES ('$_POST[tNama]',
                                            '$_POST[tUsername]')");


    // jika simpan sukses

    if ($simpan) {
        echo "<script>
        alert('simpan data sukses');
        document.location = 'formUbah1.php';   
        </script>";
    } else {
        echo "<script>
        alert('simpan data Gagal!');
        document.location = 'formUbah1.php';   
        </script>";
    }

}



    // uji jika tombol ubah di klik
if (isset($_POST['bUbah'])) {

    //persipaan ubah data
    $ubah = mysqli_query($koneksi, "UPDATE user SET
                                                nama = '$_POST[tNama]',
                                                username = '$_POST[tUsername]'
                                            WHERE id = '$_POST[id]'
                                                ");


    // jika ubah sukses

    if ($ubah) {
        echo "<script>
        alert('Ubah data sukses');
        document.location = 'formUbah1.php';   
        </script>";
    } else {
        echo "<script>
        alert('Ubah data Gagal!');
        document.location = 'formUbah1.php';   
        </script>";
    }

}


// uji jika tombol hapus di klik
if (isset($_POST['bHapus'])) {

    //persipaan hapus data
    $hapus = mysqli_query($koneksi, "DELETE FROM user WHERE id = '$_POST[id]' ");


    // jika ubah sukses

    if ($hapus) {
        echo "<script>
        alert('Hapus data sukses');
        document.location = 'formUbah1.php';   
        </script>";
    } else {
        echo "<script>
        alert('Hapus data Gagal!');
        document.location = 'formUbah1.php';   
        </script>";
    }

}

?>

