<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$bulan = $_GET['bulan'] ?? date('m');
$tahun = $_GET['tahun'] ?? date('Y');

$conn = new mysqli('localhost','root','jhon102017','bot_telegram');
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

$stmt = $conn->prepare("SELECT id, pppoe, sn_lama, sn_baru, waktu_input, port, index_rx, rx, sn, waktu_respon FROM migrasi WHERE MONTH(waktu_input) = ? AND YEAR(waktu_input) = ? ORDER BY waktu_input DESC");
$stmt->bind_param("ss", $bulan, $tahun);
$stmt->execute();
$stmt->store_result();

$stmt->bind_result($id, $pppoe, $sn_lama, $sn_baru, $waktu_input, $port, $index_rx, $rx, $sn, $waktu_respon);

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=migrasi_{$bulan}_{$tahun}.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "<table border='1'>";
echo "<tr>
        <th>No</th>
        <th>PPPoE</th>
        <th>SN Lama</th>
        <th>SN Baru</th>
        <th>Port</th>
        <th>Index RX</th>
        <th>RX</th>
        <th>SN Konfirmasi</th>
        <th>Waktu Input</th>
        <th>Waktu Respon</th>
      </tr>";

$no = 1;
while ($stmt->fetch()) {
    echo "<tr>
            <td>{$no}</td>
            <td>{$pppoe}</td>
            <td>{$sn_lama}</td>
            <td>{$sn_baru}</td>
            <td>{$port}</td>
            <td>{$index_rx}</td>
            <td>{$rx}</td>
            <td>{$sn}</td>
            <td>{$waktu_input}</td>
            <td>{$waktu_respon}</td>
          </tr>";
    $no++;
}

echo "</table>";

$stmt->close();
$conn->close();
