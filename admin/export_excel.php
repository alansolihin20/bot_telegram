<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$bulan = $_GET['bulan'] ?? date('m');
$tahun = $_GET['tahun'] ?? date('Y');

// koneksi database
$conn = new mysqli('localhost','root','jhon102017','bot_telegram');
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

// Ambil data berdasarkan filter
$stmt = $conn->prepare("SELECT nama, alamat, nik, nomor_hp, paket, sales, teknisi, status, user_pppoe, port, index_rx, rx, sn, waktu_input, waktu_respon FROM pelanggan WHERE MONTH(waktu_input) = ? AND YEAR(waktu_input) = ? ORDER BY waktu_input DESC");
$stmt->bind_param("ss", $bulan, $tahun);
$stmt->execute();
$stmt->store_result();

$stmt->bind_result($nama, $alamat, $nik, $nomor_hp, $paket, $sales, $teknisi, $status, $user_pppoe, $port, $index_rx, $rx, $sn, $waktu_input, $waktu_respon);

// Set header untuk Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=data_pelanggan_{$bulan}_{$tahun}.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Tulis data sebagai HTML table (dibaca Excel)
echo "<table border='1'>";
echo "<tr>
        <th>No</th>
        <th>Nama</th>
        <th>Alamat</th>
        <th>NIK</th>
        <th>No HP</th>
        <th>Paket</th>
        <th>Sales</th>
        <th>Teknisi</th>
        <th>Status</th>
        <th>PPPoE</th>
        <th>Port</th>
        <th>Index</th>
        <th>RX</th>
        <th>SN</th>
        <th>Waktu Input</th>
        <th>Waktu Respon</th>
      </tr>";

$no = 1;
while ($stmt->fetch()) {
    echo "<tr>
            <td>{$no}</td>
            <td>{$nama}</td>
            <td>{$alamat}</td>
            <td>{. $nik .}</td>
            <td>{$nomor_hp}</td>
            <td>{$paket}</td>
            <td>{$sales}</td>
            <td>{$teknisi}</td>
            <td>{$status}</td>
            <td>{$user_pppoe}</td>
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
