<?php
session_start();
require_once 'config/database.php';
// Proteksi 1: Jika sudah login, lempar langsung ke halaman utama
if (isset($_SESSION['id_user'])) {
  header("Location: index.php");
  exit;
}
$error = '';
// Proses saat tombol submit form login ditekan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = trim($_POST['username']);
  $password = md5($_POST['password']); // Hashing password dengan algoritma MD5
  // Gunakan Prepared Statement untuk mencegah SQL Injection
  $stmt = $koneksi->prepare("SELECT id_user, nama, password, role FROM user WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Verifikasi kesesuaian hash password
    if ($password === $row['password']) {
      // Daftarkan variabel session
      $_SESSION['id_user'] = $row['id_user'];
      $_SESSION['nama'] = $row['nama'];
      $_SESSION['role'] = $row['role'];

      // Redirect ke halaman index setelah sukses login
      header("Location: index.php");
      exit;
    } else {
      $error = "Password yang Anda masukkan salah!";
    }
  } else {
    $error = "Username tidak ditemukan dalam sistem!";
  }
  $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Sistem Penjualan</title>
  <!-- Bootstrap 5 CSS CDN -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet">
</head>

<body class="bg-light">
  <div class="container d-flex justify-content-center align-items-center
vh-100">
    <div class="card shadow-sm border-0" style="width: 100%; max-width:
400px; border-radius: 12px;">
      <div class="card-body p-4">
        <div class="text-center mb-4">
          <h3 class="fw-bold text-primary mb-1">Masuk Sistem</h3>
          <p class="text-muted small">Aplikasi Penjualan & Kasir
            Modern</p>
        </div>

        <?php if ($error != ''): ?>
          <div class="alert alert-danger py-2 small mb-3"><?=
                                                          htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form action="login.php" method="POST">
          <div class="mb-3">
            <label class="form-label small
fw-bold">Username</label>
            <input type="text" name="username" class="form-control"
              placeholder="Masukkan username" required autofocus autocomplete="off">
          </div>
          <div class="mb-4">
            <label class="form-label small
fw-bold">Password</label>
            <input type="password" name="password"
              class="form-control" placeholder="Masukkan password" required>
          </div>
          <button type="submit" class="btn btn-primary w-100 py-2
rounded-pill fw-bold">Masuk Sekarang</button>
        </form>
      </div>
    </div>
  </div>
</body>

</html>