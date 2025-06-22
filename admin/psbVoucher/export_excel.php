<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$bulan = $_GET['bulan'] ?? date('m');
$tahun = $_GET['tahun'] ?? date('Y');

$conn = new mysqli('localhost','root','jhon102017','bot_telegram');
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

$stmt = $conn->prepare("SELECT id, nama, kode_voucher, user, sales, sn, sn_baru, keterangan, port, index_rx, rx, waktu_input, waktu_respon FROM psb_voucher WHERE MONTH(waktu_input) = ? AND YEAR(waktu_input) = ? ORDER BY waktu_input DESC");
$stmt->bind_param("ss", $bulan, $tahun);
$stmt->execute();
$stmt->store_result();

$stmt->bind_result($id, $nama, $kode_voucher, $user, $sales, $sn, $sn_baru, $keterangan, $port, $index_rx, $rx, $waktu_input, $waktu_respon);

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=psb_voucher_{$bulan}_{$tahun}.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "<table border='1'>";
echo "<tr>
        <th>No</th>
        <th>Nama</th>
        <th>Kode Voucher</th>
        <th>User</th>
        <th>Alamat</th>
        <th>Sales</th>
        <th>SN</th>
        <th>SN Baru</th>
        <th>Keterangan</th>
        <th>Port</th>
        <th>Index RX</th>
        <th>RX</th>
        <th>Waktu Input</th>
        <th>Waktu Respon</th>
      </tr>";

$no = 1;
while ($stmt->fetch()) {
    echo "<tr>
            <td>{$no}</td>
            <td>{$nama}</td>
            <td>{$kode_voucher}</td>
            <td>{$user}</td>
            <td>{$alamat}</td>
            <td>{$sales}</td>
            <td>{$sn}</td>
            <td>{$sn_baru}</td>
            <td>{$keterangan}</td>
            <td>{$port}</td>
            <td>{$index_rx}</td>
            <td>{$rx}</td>
            <td>{$waktu_input}</td>
            <td>{$waktu_respon}</td>
          </tr>";
    $no++;
}

echo "</table>";

$stmt->close();
$conn->close();
