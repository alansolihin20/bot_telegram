<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if (!empty($_SESSION['admin_logged_in'])) {
    header('Location: index.php');
    exit;
}

// Password yang benar (ganti dengan password kamu sendiri)
$password_benar = '234988';

if (isset($_POST['password'])) {
    if ($_POST['password'] === $password_benar) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: index.php');
        exit;
    } else {
        $error = "Password salah!";
    }
}

// Kalau sudah login, langsung redirect ke index.php
if (!empty($_SESSION['admin_logged_in'])) {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Login Admin</title>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">
  <div class="container" style="max-width: 400px; margin-top: 100px;">
    <div class="card shadow-sm p-4">
      <h4 class="mb-3 text-center">Login Admin</h4>
      <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>
      <form method="post" action="">
        <div class="mb-3">
          <input type="password" name="password" class="form-control" placeholder="Masukkan password" required autofocus>
        </div>
        <button type="submit" class="btn btn-primary w-100">Masuk</button>
      </form>
    </div>
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
