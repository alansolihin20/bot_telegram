<?php
$conn = new mysqli('localhost','root','jhon102017','bot_telegram');
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

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

$id = intval($_POST['id'] ?? 0);
$port = $_POST['port'] ?? '';
$index_rx = $_POST['index_rx'] ?? '';
$rx = $_POST['rx'] ?? '';
$sn = $_POST['sn'] ?? '';

if (!$id || !$port || !$index_rx || !$rx || !$sn) {
    die("Semua data harus diisi.");
}

// Update data migrasi
$stmt = $conn->prepare("UPDATE migrasi 
    SET port = ?, index_rx = ?, rx = ?, sn = ?, waktu_respon = NOW() 
    WHERE id = ?");
$stmt->bind_param("ssssi", $port, $index_rx, $rx, $sn, $id);

if ($stmt->execute()) {
    // Ambil data migrasi untuk notifikasi Telegram
    $res = $conn->query("SELECT pppoe, alamat, sn_lama, sn_baru FROM migrasi WHERE id = $id");
    $row = $res->fetch_assoc();

    $message = "<b>Respon Migrasi/Ganti Alat</b>\n"
             . "PPPOE = {$row['pppoe']}\n"
             . "ALAMAT = {$row['alamat']}\n"
             . "SN LAMA = {$row['sn_lama']}\n"
             . "SN BARU = {$row['sn_baru']}\n\n"
             . "PORT = $port\n"
             . "INDEX = $index_rx\n"
             . "RX = $rx\n"
             . "SN BARU = $sn\n"
             . "STATUS = BERHASIL DIKONFIGURASI ✅";

    kirimTelegram($message);

    echo "Respon migrasi berhasil disimpan & notifikasi terkirim.";
    echo '<br><a href="index-migrasi.php">Kembali ke Data Migrasi</a>';
} else {
    echo "Gagal menyimpan data: " . $stmt->error;
}

$stmt->close();
$conn->close();
