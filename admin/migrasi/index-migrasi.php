<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if (empty($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

$bulan_filter = $_GET['bulan'] ?? date('m'); // default: bulan sekarang
$tahun_filter = $_GET['tahun'] ?? date('Y'); // default: tahun sekarang

$conn = new mysqli('localhost','root','jhon102017','bot_telegram');
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);


$sql_migrasi = "SELECT * FROM migrasi  WHERE MONTH(waktu_input) = '$bulan_filter' 
        AND YEAR(waktu_input) = '$tahun_filter' 
        ORDER BY waktu_input DESC";
$result_migrasi = $conn->query($sql_migrasi);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

</head>
<body>

<div class="container mt-4">
    <h3>Data Migrasi / Ganti Alat</h3>
    <a href="hapus-migrasi.php?bulan=<?= $bulan_filter ?>&tahun=<?= $tahun_filter ?>" 
      class="btn btn-danger mb-3"
      onclick="return confirm('Yakin ingin menghapus semua data bulan ini?')">
      Hapus Semua Data Bulan Ini
    </a>

    <form method="get" class="mb-3 d-flex align-items-end gap-2">
  <div>
    <label for="bulan" class="form-label">Filter Bulan</label>
    <select name="bulan" id="bulan" class="form-select">
      <?php 
      for ($i = 1; $i <= 12; $i++) {
        $val = str_pad($i, 2, '0', STR_PAD_LEFT);
        $selected = ($val == $bulan_filter) ? 'selected' : '';
        echo "<option value='$val' $selected>" . date('F', mktime(0, 0, 0, $i, 10)) . "</option>";
      }
      ?>
    </select>
  </div>
  <div>
    <label for="tahun" class="form-label">Tahun</label>
    <select name="tahun" id="tahun" class="form-select">
      <?php 
      for ($t = date('Y'); $t >= 2022; $t--) {
        $selected = ($t == $tahun_filter) ? 'selected' : '';
        echo "<option value='$t' $selected>$t</option>";
      }
      ?>
    </select>
  </div>
  <button type="submit" class="btn btn-primary">Tampilkan</button>
</form>

<?php if (!empty($bulan_filter) && !empty($tahun_filter)): ?>
  <a href="export_excel.php?bulan=<?= $bulan_filter ?>&tahun=<?= $tahun_filter ?>" class="btn btn-success mb-3">
    Export to Excel
  </a>
<?php endif; ?>

<table class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>#</th>
      <th>PPPoE</th>
      <th>Alamat</th>
      <th>SN Lama</th>
      <th>SN Baru</th>
      <th>Waktu Input</th>
      <th>Respon</th>
    </tr>
  </thead>
  <tbody>
    <?php if ($result_migrasi->num_rows > 0): ?>
      <?php $no=1; while($row = $result_migrasi->fetch_assoc()): ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= htmlspecialchars($row['pppoe']) ?></td>
          <td><?= htmlspecialchars($row['alamat']) ?></td>
          <td><?= htmlspecialchars($row['sn_lama']) ?></td>
          <td><?= htmlspecialchars($row['sn_baru']) ?></td>
          <td><?= $row['waktu_input'] ?></td>
          <td>
            <?php if (empty($row['port']) && empty($row['index_rx'])): ?>
              <a href="respon_migrasi.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Respon</a>
            <?php else: ?>
              <span class="text-success">Sudah Respon</span>
            <?php endif; ?>
          </td>
        </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr><td colspan="7" class="text-center">Belum ada data migrasi</td></tr>
    <?php endif; ?>
  </tbody>
</table>

<a href="../index.php" class="btn btn-primary">Kembali ke Halaman Pelanggan</a>
</div>
    


    <script>
  window.onload = function() {
      if (performance.navigation.type === 2) {
          window.location.reload(true);
      }
  };
  </script>
</body>
</html>