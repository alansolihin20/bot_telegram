<?php
$conn = new mysqli('localhost','root','jhon102017','bot_telegram');
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

function kirimTelegram($message) {
    $token = '8028787353:AAEpc57hz-AD1Ba3d2SfImEVv9ib-QKQX3E'; // Ganti dengan token bot kamu
    $chat_id = '-4949356523'; // Ganti dengan chat id grup kamu

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
$user_pppoe = $_POST['user_pppoe'] ?? '';
$port = $_POST['port'] ?? '';
$index_rx = $_POST['index_rx'] ?? '';
$rx = $_POST['rx'] ?? '';
$sn = $_POST['sn'] ?? '';

if (!$id || !$user_pppoe || !$port || !$index_rx || !$rx || !$sn) {
    die("Semua data harus diisi.");
}

// Update data pelanggan, status jadi 'respon' dan isi form admin
$stmt = $conn->prepare("UPDATE pelanggan SET user_pppoe=?, port=?, index_rx=?, rx=?, sn=?, status='respon', waktu_respon=NOW() WHERE id=?");
$stmt->bind_param("sssssi", $user_pppoe, $port, $index_rx, $rx, $sn, $id);

if ($stmt->execute()) {
    // Ambil data pelanggan untuk notifikasi Telegram
    $sql = "SELECT nama, alamat, nik, nomor_hp, paket, sales, teknisi FROM pelanggan WHERE id = $id";
    $res = $conn->query($sql);
    $row = $res->fetch_assoc();

    $message = "<b>Respon dari Admin</b>\n"
             . "NAMA = {$row['nama']}\n"
             . "ALAMAT = {$row['alamat']}\n"
             . "NIK = {$row['nik']}\n"
             . "NO HP = {$row['nomor_hp']}\n"
             . "PAKET = {$row['paket']}\n"
             . "SALES = {$row['sales']}\n"
             . "TEKNISI = {$row['teknisi']}\n\n"
             . "PPPOE = $user_pppoe\n"
             . "PORT = $port\n"
             . "INDEX = $index_rx\n"
             . "RX = $rx\n"
             . "SN = $sn\n"
             . "STATUS = BERHASIL DIKONFIGURASI ✅";

    kirimTelegram($message);

    echo "Data respon berhasil disimpan dan notifikasi terkirim.";
    echo '<br><a href="index.php">Kembali ke List</a>';
} else {
    echo "Gagal menyimpan data: " . $stmt->error;
}

$stmt->close();
$conn->close();
