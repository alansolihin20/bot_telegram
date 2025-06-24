<?php
$conn = new mysqli('localhost','root','jhon102017','bot_telegram');
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

// Fungsi kirim Telegram
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

    $context = stream_context_create($options);
    file_get_contents($url, false, $context);
}

// Ambil data dari form
$id = intval($_POST['id'] ?? 0);
$port = $_POST['port'] ?? '';
$index_rx = $_POST['index_rx'] ?? '';
$rx = $_POST['rx'] ?? '';
$sn_baru = $_POST['sn_baru'] ?? '';

// Validasi input
if (!$id || !$port || !$index_rx || !$rx || !$sn_baru) {
    die("Semua data harus diisi.");
}

// Cek apakah kolom sn_baru ada di database
$checkColumn = $conn->query("SHOW COLUMNS FROM psb_voucher LIKE 'sn_baru'");
if ($checkColumn->num_rows === 0) {
    die("Kolom <b>sn_baru</b> tidak ditemukan di tabel <b>psb_voucher</b>. Tambahkan kolom ini terlebih dahulu.");
}

// Query update
$sql = "UPDATE psb_voucher 
        SET port = ?, index_rx = ?, rx = ?, sn_baru = ?, waktu_respon = NOW() 
        WHERE id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("ssssi", $port, $index_rx, $rx, $sn_baru, $id);

if ($stmt->execute()) {
    // Ambil data untuk notifikasi Telegram
    $res = $conn->query("SELECT nama, kode_voucher, user, sales, keterangan FROM psb_voucher WHERE id = $id");
    if ($res && $res->num_rows > 0) {
        $row = $res->fetch_assoc();

        $message = "<b>Respon Admin PSB Voucher</b>\n"
                 . "NAMA: {$row['nama']}\n"
                 . "KODE VOUCHER: {$row['kode_voucher']}\n"
                 . "USER: {$row['user']}\n"
                 . "SALES: {$row['sales']}\n"
                 . "KETERANGAN: {$row['keterangan']}\n\n"
                 . "PORT: $port\n"
                 . "INDEX: $index_rx\n"
                 . "RX: $rx\n"
                 . "SN BARU: $sn_baru\n"
                 . "STATUS: ✅ BERHASIL DIKONFIGURASI";

        kirimTelegram($message);
    }

    echo "<div style='padding:20px;font-family:sans-serif;'>
            ✅ <strong>Respon voucher berhasil disimpan & notifikasi terkirim.</strong><br>
            <a href='index-voucher.php'>⬅ Kembali ke Data PSB Voucher</a>
          </div>";
} else {
    echo "❌ Gagal menyimpan data: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
