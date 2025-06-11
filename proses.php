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

// Helper fungsi kirim ke Telegram
function kirimTelegram($message) {
    $token = '5757704421:AAESrEhh2LixuySoaI7S65waZBYuX4LEFKY'; // ganti dengan token bot kamu
    $chat_id = '-4949356523';  // ganti dengan chat_id grup telegram kamu

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

// Ambil data POST
$nama = $_POST['nama'] ?? '';
$alamat = $_POST['alamat'] ?? '';
$nik = $_POST['nik'] ?? '';
$nomor_hp = $_POST['nomor_hp'] ?? '';
$paket = $_POST['paket'] ?? '';
$sales = $_POST['sales'] ?? '';
$teknisi_arr = $_POST['teknisi'] ?? [];
$teknisi = implode(', ', $teknisi_arr);

// Validasi sederhana
if (!$nama || !$alamat || !$nik || !$nomor_hp || !$paket || !$sales || !$teknisi) {
    die("Semua data wajib diisi.");
}

// Simpan ke database
$stmt = $conn->prepare("INSERT INTO pelanggan (nama, alamat, nik, nomor_hp, paket, sales, teknisi) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $nama, $alamat, $nik, $nomor_hp, $paket, $sales, $teknisi);

if ($stmt->execute()) {
    // Kirim notifikasi ke Telegram
    $message = "<b>Data Pelanggan Baru</b>\n"
             . "NAMA = $nama\n"
             . "ALAMAT = $alamat\n"
             . "NIK = $nik\n"
             . "NO HP = $nomor_hp\n"
             . "PAKET = $paket\n"
             . "SALES = $sales\n"
             . "TEKNISI = $teknisi\n"
             . "STATUS = PENDING ❗\n"
             . "Mohon Ditunggu Admin Segera Merespon ❗❗❗ \n"
             ."<a href='https://e.ebilling.id:2053/billing/'>🔗 Buka Halaman Admin</a>";

    kirimTelegram($message);

    // Tampilkan halaman modal sukses
    ?>
    <!DOCTYPE html>
    <html lang="id">
    <head>
      <meta charset="UTF-8" />
      <title>Data Terkirim</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    </head>
    <body>
      <!-- Modal -->
      <div class="modal fade show" id="successModal" tabindex="-1" aria-modal="true" style="display: block;">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Sukses</h5>
            </div>
            <div class="modal-body">
              Data berhasil dikirim.
            </div>
            <div class="modal-footer">
              <button type="button" id="btnOk" class="btn btn-primary">OK</button>
            </div>
          </div>
        </div>
      </div>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
      <script>
        document.getElementById('btnOk').addEventListener('click', function() {
          window.location.href = 'form-teknisi.php'; // ganti dengan halaman form teknisi kamu
        });
      </script>
    </body>
    </html>
    <?php
} else {
    echo "Gagal menyimpan data: " . $stmt->error;
}

$stmt->close();
$conn->close();


