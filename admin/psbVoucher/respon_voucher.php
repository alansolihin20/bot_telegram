<?php
session_start();
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: ../login.php');
    exit;
}

$conn = new mysqli('localhost','root','jhon102017','bot_telegram');
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

$id = intval($_GET['id'] ?? 0);
if (!$id) die("ID tidak valid.");

$sql = "SELECT * FROM psb_voucher WHERE id = $id";
$result = $conn->query($sql);
if (!$result) die("Query error: " . $conn->error);
if ($result->num_rows == 0) die("Data PSB Voucher tidak ditemukan.");

$data = $result->fetch_assoc();

function kirimTelegram($message) {
    $token = '8028787353:AAEpc57hz-AD1Ba3d2SfImEVv9ib-QKQX3E';
    $chat_id = '-4949356523';

    $url = "https://api.telegram.org/bot$token/sendMessage";
    $data = [
        'chat_id' => $chat_id,
        'text' => $message,
        'parse_mode' => 'HTML'
    ];

    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        ]
    ];

    $context  = stream_context_create($options);
    file_get_contents($url, false, $context);
}

$nama = $data['nama'];
$kode_voucher = $data['kode_voucher'];
$pesan = "Admin sedang memproses voucher untuk <b>$nama</b> - Voucher: <b>$kode_voucher</b>";
kirimTelegram($pesan);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Respon Voucher</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">
<div class="container mt-4">
    <h3>Respon Voucher: <?= htmlspecialchars($data['nama']) ?></h3>
    <form action="proses_respon_voucher.php" method="POST">
        <input type="hidden" name="id" value="<?= $data['id'] ?>">
        <div class="mb-3">
            <label class="form-label">Port</label>
            <input type="text" name="port" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Index</label>
            <input type="text" name="index_rx" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">RX</label>
            <input type="text" name="rx" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">SN</label>
            <input type="text" name="sn_baru" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Kirim Respon</button>
        <a href="../psbVoucher.php" class="btn btn-secondary ms-2">Batal</a>
    </form>
</div>
</body>
</html>
