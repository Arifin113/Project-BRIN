<?php


require __DIR__ . '/vendor/autoload.php';
require './config/koneksi.php';

use Spipu\Html2Pdf\Html2Pdf;

$data_pengunjung = mysqli_query($koneksi, "SELECT * FROM user");

$content = '
<page>
    <table border="1" align="center">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Username</th>
        </tr>';

$no = 1;
foreach ($data_pengunjung as $pengunjung) {
    $content .= '
        <tr>
            <td>' . $no++ . '</td>
            <td>' . $pengunjung['nama'] . '</td>
            <td>' . $pengunjung['username'] . '</td>
        </tr>';
}

$content .= '
    </table>
</page>';

$html2pdf = new Html2Pdf();
$html2pdf->writeHTML($content);
$html2pdf->output('my_doc.pdf', 'D');
