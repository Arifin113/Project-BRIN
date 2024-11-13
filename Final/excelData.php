<?php

require 'koneksi.php'; // Pastikan file koneksi sudah benar

// Ambil data dari database
$data = mysqli_query($koneksi, "SELECT * FROM esp32_table_dht11_leds_record ORDER BY time ASC");

if (!$data) {
    die("Error executing query: " . mysqli_error($koneksi));
}

// Set header output untuk file CSV
header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename="data_sensor.csv"');

// Membuka output ke stream
$output = fopen('php://output', 'w');

// Menulis header kolom ke file CSV
fputcsv($output, ['No', 'ID', 'Board', 'Temperature', 'Humidity', 'Status Read Sensor DHT11', 'Time', 'Date']);

// Mengatur nomor urut
$no = 1;

// Menulis data ke file CSV
foreach ($data as $sensor) {
    fputcsv($output, [
        $no++, // No
        $sensor['id'], // ID
        $sensor['board'], // Board
        $sensor['temperature'], // Temperature
        $sensor['humidity'], // Humidity
        $sensor['status_read_sensor_dht11'], // Status Read Sensor DHT11
        $sensor['time'], // Time
        $sensor['date'], // Date
    ]);
}

// Tutup output
fclose($output);
exit;
