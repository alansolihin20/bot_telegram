<?php
session_start();
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

$conn = new mysqli('localhost','root','jhon102017','bot_telegram');
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

$bulan = $_GET['bulan'] ?? date('m');
$tahun = $_GET['tahun'] ?? date('Y');

$sql = "DELETE FROM pelanggan WHERE MONTH(waktu_input) = ? AND YEAR(waktu_input) = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $bulan, $tahun);

if ($stmt->execute()) {
    header("Location: index.php?msg=hapus_sukses");
    exit;
} else {
    echo "Gagal menghapus data: " . $stmt->error;
}
