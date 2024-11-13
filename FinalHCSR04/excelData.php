<?php

require 'koneksi.php'; // Pastikan file koneksi sudah benar

// Ambil data dari database
$data = mysqli_query($koneksi, "SELECT * FROM esp32_table_hcsr04_record ORDER BY time ASC");

if (!$data) {
    die("Error executing query: " . mysqli_error($koneksi));
}

// Set header output untuk file CSV
header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename="data_sensor_hcsr04.csv"');

// Membuka output ke stream
$output = fopen('php://output', 'w');

// Menulis header kolom ke file CSV
fputcsv($output, ['No', 'ID', 'Board', 'Height', 'Status Read Sensor HCSR04', 'Time', 'Date']);

// Mengatur nomor urut
$no = 1;

// Menulis data ke file CSV
foreach ($data as $sensor) {
    fputcsv($output, [
        $no++,
        $sensor['id'],
        $sensor['board'],
        // Gunakan sprintf untuk memformat angka height dengan 2 angka di belakang koma
        sprintf('%.2f', $sensor['height']),
        $sensor['status_read_sensor_hcsr04'],
        $sensor['time'],
        $sensor['date'],
    ]);
}

// Tutup output
fclose($output);
exit;
