<?php  
// Menetapkan header untuk JSON
header('Content-Type: application/json');

require '../config/koneksi.php';  // Memastikan koneksi database berhasil

// Parsing input dari PUT request
parse_str(file_get_contents('php://input'), $PUT);

// Menerima input
$id = $PUT['id'];
$nama = $PUT['nama'];
$username = $PUT['username'];

// Cek apakah kunci 'role' ada dalam input, jika tidak beri nilai default
$role = isset($PUT['role']) ? $PUT['role'] : null; // Jika role tidak dikirim, diatur null

// Menjalankan query untuk update data ke tabel user
$query = "UPDATE user SET nama = '$nama', username = '$username' WHERE id = $id";

// Jalankan query dengan mysqli_query
$result = mysqli_query($koneksi, $query);

// Cek apakah query berhasil
if (!$result) {
    // Jika gagal, kembalikan pesan error
    echo json_encode(["error" => mysqli_error($koneksi)]);
    exit;
}

// Mengembalikan pesan sukses
echo json_encode(["success" => "Data berhasil diperbarui"]);

// Menutup koneksi database
mysqli_close($koneksi);
?>
