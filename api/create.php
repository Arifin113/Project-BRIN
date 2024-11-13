<?php  
// Menetapkan header untuk JSON
header('Content-Type: application/json');

require '../config/koneksi.php';  // Memastikan koneksi database berhasil

// Menerima input
$nama = $_POST['nama'];
$username = $_POST['username'];
$role = $_POST['role'];

// Menjalankan query untuk insert data ke tabel user, sesuaikan nama kolom dengan tabel Anda
$query = mysqli_query($koneksi, "INSERT INTO user (nama, username, role) VALUES ('$nama', '$username', '$role')");

// Cek apakah query berhasil
if (!$query) {
    // Jika gagal, kembalikan pesan error
    echo json_encode(["error" => mysqli_error($koneksi)]);
    exit;
}

// Mengembalikan pesan sukses
echo json_encode(["success" => "Data berhasil ditambahkan"]);

// Menutup koneksi database
mysqli_close($koneksi);
?>
