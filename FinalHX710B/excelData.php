<?php

require 'koneksi.php'; // Pastikan file koneksi sudah benar

// Ambil data dari database
$data = mysqli_query($koneksi, "SELECT * FROM esp32_table_hx710b_record ORDER BY time ASC");

if (!$data) {
    die("Error executing query: " . mysqli_error($koneksi));
}

// Set header output untuk file CSV
header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename="data_sensor_hx710b.csv"');

// Membuka output ke stream
$output = fopen('php://output', 'w');

// Menulis header kolom ke file CSV
fputcsv($output, ['No', 'ID', 'Board', 'pressureInput', 'pressureOutput', 'pressureSelisih', 'Status Read Sensor HX710B Input', 'Status Read Sensor HX710B Output', 'Time', 'Date']);

// Mengatur nomor urut
$no = 1;

// Menulis data ke file CSV
foreach ($data as $sensor) {
    fputcsv($output, [
        $no++,
        $sensor['id'],
        $sensor['board'],
        $sensor['pressureInput'],
        $sensor['pressureOutput'],
        $sensor['pressureSelisih'],
        $sensor['status_read_sensor_hx710b_input'],
        $sensor['status_read_sensor_hx710b_output'],
        $sensor['time'],
        $sensor['date'],
    ]);
}

// Tutup output
fclose($output);
exit;
