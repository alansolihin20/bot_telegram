<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Form Teknisi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card shadow-sm">
          <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Form Teknisi</h5>
          </div>
          <div class="card-body">

            <!-- Dropdown Pilihan Jenis Form -->
            <div class="mb-4">
              <label class="form-label">Jenis Form</label>
              <select id="formSelector" class="form-select">
                <option value="pelanggan" selected>Data Pelanggan Baru</option>
                <option value="migrasi">Migrasi / Ganti Alat</option>
                <option value="psbVoucher">PSB Voucher</option>
              </select>
            </div>

            <!-- Form Pelanggan Baru -->
            <form id="formPelanggan" action="proses.php" method="POST">
              <div class="mb-3">
                <label for="nama" class="form-label">Nama Pelanggan</label>
                <input type="text" class="form-control" id="nama" name="nama" required />
              </div>
              <div class="mb-3">
                <label for="alamat" class="form-label">Alamat Lengkap</label>
                <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
              </div>
              <div class="mb-3">
                <label for="nik" class="form-label">NIK</label>
                <input type="text" class="form-control" id="nik" name="nik" required />
              </div>
              <div class="mb-3">
                <label for="nomor_hp" class="form-label">No HP</label>
                <input type="text" class="form-control" id="nomor_hp" name="nomor_hp" required />
              </div>
              <div class="mb-3">
                <label for="paket" class="form-label">Paket</label>
                <select class="form-select" id="paket" name="paket" required>
                  <option value="" selected disabled>Pilih Paket</option>
                  <option value="5MBPS">5-MBPS</option>
                  <option value="7MBPS">7-MBPS</option>
                  <option value="10MBPS">10-MBPS</option>
                  <option value="20MBPS">20-MBPS</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="sales" class="form-label">Sales</label>
                <input type="text" class="form-control" id="sales" name="sales" required />
              </div>
              <div class="mb-3">
                <label class="form-label">Teknisi</label>
                <div class="form-check"><input class="form-check-input" type="checkbox" name="teknisi[]" value="Iman"> Iman</div>
                <div class="form-check"><input class="form-check-input" type="checkbox" name="teknisi[]" value="Parid"> Parid</div>
                <div class="form-check"><input class="form-check-input" type="checkbox" name="teknisi[]" value="Epul"> Epul</div>
                <div class="form-check"><input class="form-check-input" type="checkbox" name="teknisi[]" value="Jana"> Jana</div>
                <div class="form-check"><input class="form-check-input" type="checkbox" name="teknisi[]" value="Garong"> Garong</div>
                <div class="form-check"><input class="form-check-input" type="checkbox" name="teknisi[]" value="Odong"> Odong</div>
                <div class="form-check"><input class="form-check-input" type="checkbox" name="teknisi[]" value="Dirman"> Dirman</div>
              </div>
              <button type="submit" class="btn btn-primary w-100">Kirim Data Pelanggan</button>
            </form>

            <!-- Form Migrasi / Ganti Alat -->
            <form id="formMigrasi" action="proses_migrasi.php" method="POST" style="display:none;">
              <div class="mb-3">
                <label for="pppoe" class="form-label">Nama PPPoE</label>
                <input type="text" class="form-control" id="pppoe" name="pppoe" required />
              </div>
              <div class="mb-3">
                <label for="alamat_migrasi" class="form-label">Alamat</label>
                <textarea class="form-control" id="alamat_migrasi" name="alamat" rows="3" required></textarea>
              </div>
              <div class="mb-3">
                <label for="sn_lama" class="form-label">SN Lama</label>
                <input type="text" class="form-control" id="sn_lama" name="sn_lama" />
              </div>
              <div class="mb-3">
                <label for="sn_baru" class="form-label">SN Baru</label>
                <input type="text" class="form-control" id="sn_baru" name="sn_baru" />
              </div>
              <button type="submit" class="btn btn-primary w-100">Kirim Data Migrasi</button>
              <div class="text-bold p-0">
                 <p>Note :</p>
                <p>Untuk Migrasi Kolom <b>SN LAMA</b> di isi dengan <b>MIGRASI</b></p>
              </div>
            </form>


            <form id="psbVoucher" action="proses_psbVoucher.php" method="POST" style="display:none;">
              <div class="mb-3">
                <label for="nama" class="form-label">Nama Pelanggan</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
              </div>
              <div class="mb-3">
                <label for="kode_voucher" class="form-label">Kode Voucher</label>
                <input type="text" class="form-control" id="kode_voucher" name="kode_voucher" required>
              </div>
              <div class="mb-3">
                 <label for="user" class="form-label">User</label>
                <select class="form-select" id="user" name="user" required>
                  <option value="" selected disabled>Pilih User</option>
                  <option value="1HP">1-HP</option>
                  <option value="2HP">2-HP</option>
                  <option value="3HP">3-HP</option>
                  <option value="4HP">4-HP</option>
                  <option value="5HP">5-HP</option>
                  <option value="6HP">6-HP</option>
                </select>
              </div>
               <div class="mb-3">
                <label for="sales" class="form-label">Sales</label>
                <input type="text" class="form-control" id="sales" name="sales" required>
              </div>
               <div class="mb-3">
                <label for="sn" class="form-label">SN</label>
                <input type="text" class="form-control" id="sn" name="sn" required>
              </div>
              <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea class="form-control" id="keterangan" name="keterangan" rows="3" required></textarea>
              </div>
               <button type="submit" class="btn btn-primary w-100">Kirim Data PSB VC</button>
              <div class="text-bold p-0">
                 <p>Note :</p>
                <p>Untuk Pararel Kolom <b>SN</b> di isi dengan <b>PARAREL</b></p>
              </div>

            </form>
           
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    const selector = document.getElementById('formSelector');
    const formPelanggan = document.getElementById('formPelanggan');
    const formMigrasi = document.getElementById('formMigrasi');
    const psbVoucher = document.getElementById('psbVoucher')

    selector.addEventListener('change', function () {
      if (this.value === 'pelanggan') {
        formPelanggan.style.display = 'block';
        formMigrasi.style.display = 'none';
        psbVoucher.style.display = 'none';
      } else if (this.value === 'migrasi'){
        formPelanggan.style.display = 'none';
        formMigrasi.style.display = 'block';
        psbVoucher.style.display = 'none';
      } else if (this.value === 'psbVoucher'){
        formPelanggan.style.display = 'none';
        formMigrasi.style.display = 'none';
        psbVoucher.style.display = 'block';
      }
    });
  </script>
</body>
</html>
