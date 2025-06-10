<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Form Input Pelanggan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-7">
        <div class="card shadow-sm">
          <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Form Data Pelanggan (Teknisi)</h5>
          </div>
          <div class="card-body">
            <form action="proses.php" method="POST">
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
                    <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="teknisi[]" value="Iman" id="teknisiA">
                    <label class="form-check-label" for="teknisiA">Iman</label>
                    </div>
                    <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="teknisi[]" value="Parid" id="teknisiB">
                    <label class="form-check-label" for="teknisiB">Parid</label>
                    </div>
                    <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="teknisi[]" value="Epul" id="teknisiC">
                    <label class="form-check-label" for="teknisiC">Epul</label>
                    </div>
                    <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="teknisi[]" value="Jana" id="teknisiC">
                    <label class="form-check-label" for="teknisiC">Jana</label>
                    </div>
                    <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="teknisi[]" value="Garong" id="teknisiC">
                    <label class="form-check-label" for="teknisiC">Garong</label>
                    </div>
                    <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="teknisi[]" value="Odong" id="teknisiC">
                    <label class="form-check-label" for="teknisiC">Odong</label>
                    </div>
                    <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="teknisi[]" value="Adi" id="teknisiC">
                    <label class="form-check-label" for="teknisiC">Adi</label>
                    </div>
                    <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="teknisi[]" value="Dirman" id="teknisiC">
                    <label class="form-check-label" for="teknisiC">Dirman</label>
                    </div>
                </div>
              <button type="submit" class="btn btn-primary w-100">Kirim Data</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
