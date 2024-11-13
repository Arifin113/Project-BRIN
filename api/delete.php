<?php  

// Menetapkan header untuk JSON
header('Content-Type: application/json');

require '../config/koneksi.php';  // Memastikan koneksi database berhasil

// Parsing input dari DELETE request
parse_str(file_get_contents('php://input'), $DELETE);

// menerima input id data yang akan dihapus
$id = $DELETE['id'];

// Menjalankan query untuk hapus data ke tabel user
$query = "DELETE FROM user WHERE id = $id";

// Jalankan query dengan mysqli_query
$result = mysqli_query($koneksi, $query);

// Mengembalikan pesan sukses
echo json_encode(["success" => "Data berhasil dihapus"]);

// Menutup koneksi database
mysqli_close($koneksi);
?>

