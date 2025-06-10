<?php
$bulan = $_GET['bulan'] ?? date('m');
$tahun = $_GET['tahun'] ?? date('Y');

// koneksi database
$conn = new mysqli('localhost','root','','bot_telegram');
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

// Ambil data berdasarkan filter
$stmt = $conn->prepare("SELECT * FROM pelanggan WHERE MONTH(waktu_input) = ? AND YEAR(waktu_input) = ? ORDER BY waktu_input DESC");
$stmt->bind_param("ss", $bulan, $tahun);
$stmt->execute();
$result = $stmt->get_result();

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
while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$no}</td>
            <td>{$row['nama']}</td>
            <td>{$row['alamat']}</td>
            <td>{$row['nik']}</td>
            <td>{$row['nomor_hp']}</td>
            <td>{$row['paket']}</td>
            <td>{$row['sales']}</td>
            <td>{$row['teknisi']}</td>
            <td>{$row['status']}</td>
            <td>{$row['user_pppoe']}</td>
            <td>{$row['port']}</td>
            <td>{$row['index_rx']}</td>
            <td>{$row['rx']}</td>
            <td>{$row['sn']}</td>
            <td>{$row['waktu_input']}</td>
            <td>{$row['waktu_respon']}</td>
          </tr>";
    $no++;
}

echo "</table>";

$stmt->close();
$conn->close();
