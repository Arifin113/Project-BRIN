<?php

require 'koneksi.php'; // Pastikan file koneksi sudah benar

// Ambil data dari database
$data = mysqli_query($koneksi, "SELECT * FROM esp32_table_ds18b20_record ORDER BY time ASC");

if (!$data) {
    die("Error executing query: " . mysqli_error($koneksi));
}

// Set header output untuk file CSV
header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename="data_sensor_ds18b20.csv"');

// Membuka output ke stream
$output = fopen('php://output', 'w');

// Menulis header kolom ke file CSV
fputcsv($output, ['No', 'ID', 'Board', 'Temperature 1', 'Temperature 2', 'Temperature 3', 'Temperature 4', 'Status Read Sensor DS18B20', 'Time', 'Date']);

// Mengatur nomor urut
$no = 1;

// Menulis data ke file CSV
foreach ($data as $sensor) {
    fputcsv($output, [
        $no++,
        $sensor['id'],
        $sensor['board'],
        $sensor['temperature1'],
        $sensor['temperature2'],
        $sensor['temperature3'],
        $sensor['temperature4'],
        $sensor['status_read_sensor_DS18B20'],
        $sensor['time'],
        $sensor['date'],
    ]);
}

// Tutup output
fclose($output);
exit;
