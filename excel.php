<?php

session_start();

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    echo "<script>
    alert('Akses tidak diizinkan');
    window.location = 'loginAdmin.php';
    </script>";
    exit;
}

require './config/koneksi.php';
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

$spreadsheet = new Spreadsheet();
$activeWorksheet = $spreadsheet->getActiveSheet();
$activeWorksheet->setCellValue('A1', 'No');
$activeWorksheet->setCellValue('B1', 'Nama');
$activeWorksheet->setCellValue('C1', 'Username');

$data = mysqli_query($koneksi, "SELECT * FROM user");

$no = 1;
$start = 2;

foreach ($data as $pengunjung) {
    $activeWorksheet->setCellValue('A' . $start, $no++);
    $activeWorksheet->setCellValue('B' . $start, $pengunjung['nama']);
    $activeWorksheet->setCellValue('C' . $start, $pengunjung['username']);

    $start++;
}

// Mengatur header untuk download file CSV
header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename="user_list.csv"');
header('Cache-Control: max-age=0');

// Menyimpan output sebagai file CSV tanpa border
$writer = new Csv($spreadsheet);
$writer->setDelimiter(','); // Mengatur delimiter (komma)
$writer->setEnclosure('"');  // Mengatur enclosure untuk data yang mengandung koma
$writer->setSheetIndex(0);   // Pilih worksheet yang ingin di-save
$writer->save('php://output');
exit;
