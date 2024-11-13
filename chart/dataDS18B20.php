<?php
include 'koneksi.php';

// Query untuk mengambil 10 data terakhir berdasarkan waktu
$sql = "SELECT time, temperature1, temperature2, temperature3 FROM esp32_table_ds18b20_record ORDER BY time DESC LIMIT 10"; // Ubah di sini
$result = $koneksi->query($sql);

$data = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Mengembalikan data dalam format JSON
echo json_encode(array_reverse($data)); // Membalikkan array agar data terbaru muncul di urutan bawah

$koneksi->close();
