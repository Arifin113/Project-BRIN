<?php  

require '../config/koneksi.php';  // Memastikan koneksi database berhasil

// Menetapkan header untuk JSON
header('Content-Type: application/json');

// Menjalankan query untuk mendapatkan data dari tabel user
$query = mysqli_query($koneksi, "SELECT * FROM user");

// Cek apakah query berhasil
if (!$query) {
    // Jika gagal, kembalikan pesan error
    echo json_encode(["error" => mysqli_error($koneksi)]);
    exit;
}

// Mengambil semua data sebagai array asosiatif
$data = mysqli_fetch_all($query, MYSQLI_ASSOC);

// Mengembalikan data dalam format JSON
echo json_encode($data);

// Menutup koneksi database
mysqli_close($koneksi);
?>
