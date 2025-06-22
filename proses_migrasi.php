<?php
// config/db.php (koneksi)
$host = 'localhost';
$user = 'root';
$pass = 'jhon102017';
$dbname = 'bot_telegram';

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Fungsi kirim ke Telegram
function kirimTelegram($message) {
    $token = '5757704421:AAESrEhh2LixuySoaI7S65waZBYuX4LEFKY'; // ganti dengan token bot kamu
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

// Ambil data
$pppoe = $_POST['pppoe'] ?? '';
$alamat = $_POST['alamat'] ?? '';
$sn_lama = $_POST['sn_lama'] ?? '';
$sn_baru = $_POST['sn_baru'] ?? '';

// Validasi
if (!$pppoe || !$alamat) {
    die("Nama PPPoE dan Alamat wajib diisi.");
}

// Simpan ke tabel migrasi
$stmt = $conn->prepare("INSERT INTO migrasi (pppoe, alamat, sn_lama, sn_baru) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $pppoe, $alamat, $sn_lama, $sn_baru);

if ($stmt->execute()) {
    // Kirim notifikasi ke Telegram
    $message = "<b>Permintaan Migrasi/Ganti Alat</b>\n"
             . "PPPoE: $pppoe\n"
             . "Alamat: $alamat\n"
             . ($sn_lama ? "SN Lama: $sn_lama\n" : "")
             . ($sn_baru ? "SN Baru: $sn_baru\n" : "")
             . "Status: PENDING ⚠️\n"
             . "<a href='http://103.157.24.125:5617/bot_telegram/admin/login.php'>🔗 Buka Halaman Admin</a>";

    kirimTelegram($message);

    echo "<script>alert('Data berhasil dikirim'); window.location.href='form-teknisi.php';</script>";
} else {
    echo "Gagal menyimpan data: " . $stmt->error;
}

$stmt->close();
$conn->close();
