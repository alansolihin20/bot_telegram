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

// Fungsi kirim ke Telegram
function kirimTelegram($message) {
    $token = '5757704421:AAESrEhh2LixuySoaI7S65waZBYuX4LEFKY';
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
$nama = $_POST['nama'] ?? '';
$kode_voucher = $_POST['kode_voucher'] ?? '';
$user = $_POST['user'] ?? '';
$sales = $_POST['sales'] ?? '';
$sn = $_POST['sn'] ?? '';
$keterangan = $_POST['keterangan'] ?? '';

// Validasi wajib
if (!$nama || !$kode_voucher) {
    die("Nama dan Kode Voucher wajib diisi.");
}

// Simpan ke database
$stmt = $conn->prepare("INSERT INTO psb_voucher (nama, kode_voucher, user, sales, sn, keterangan) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $nama, $kode_voucher, $user, $sales, $sn, $keterangan);

if ($stmt->execute()) {
    // Kirim notifikasi ke Telegram
    $message = "<b>PSB Voucher</b>\n"
             . "Nama: $nama\n"
             . "Kode Voucher: $kode_voucher\n"
             . "User: $user\n"
             . "Sales: $sales\n"
             . "SN: $sn\n"
             . "Keterangan: $keterangan\n"
             . "Status: <b>PENDING ⚠️</b>\n"
             . "<a href='http://103.157.24.125:5617/bot_telegram/admin/login.php'>🔗 Buka Halaman Admin</a>";

    kirimTelegram($message);

    echo "<script>alert('Data berhasil dikirim'); window.location.href='form-teknisi.php';</script>";
} else {
    echo "Gagal menyimpan data: " . $stmt->error;
}

$stmt->close();
$conn->close();
