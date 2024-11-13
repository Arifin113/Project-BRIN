<?php
// Koneksi database
$hostname = "localhost";
$user = "root";
$password = "";
$db_name = "administrasi";

$koneksi = mysqli_connect($hostname, $user, $password, $db_name) or die(mysqli_connect_error($koneksi));

session_start();

// Cek jika form login telah disubmit
if (isset($_POST['login'])) {
  $username = $_POST['user'];
  $password = $_POST['pass'];

  // Menggunakan Prepared Statements untuk menghindari SQL Injection
  $stmt = $koneksi->prepare("SELECT * FROM user WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $ambil = $stmt->get_result();

  if ($ambil->num_rows === 1) {
    $data = $ambil->fetch_assoc();

    // Verifikasi password
    if (password_verify($password, $data['password'])) {
      $_SESSION['nama'] = $data['nama'];

      // Cek apakah user adalah admin
      if ($data['username'] == 'admin') {
        $_SESSION['role'] = 'admin';
        header("Location: /admin/page/index.php");
        exit;
      } else {
        $_SESSION['role'] = 'user';
        echo "<script>
                let dataType = prompt('Masukkan tipe data yang ingin diakses (Ketinggian Air/Temperature/Tekanan):').toLowerCase();
                if (dataType === 'ketinggian air') {
                  window.location = '/FinalHCSR04/IndexDistPublic.php';
                } else if (dataType === 'temperature') {
                  window.location = '/FinalDS18B20/indexDSPublic.php';
                } else if (dataType === 'tekanan') {
                  window.location = '/FinalHX710B/indexHXPublic.php';
                } else {
                  alert('Tipe data tidak valid');
                  window.location = 'login.php';
                }
              </script>";
      }
    } else {
      echo "<script>
                alert('Username atau password salah');
                window.location = 'login.php';
            </script>";
    }
  } else {
    echo "<script>
            alert('Username atau password salah');
            window.location = 'login.php';
        </script>";
  }
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.84.0">
  <title>Login</title>

  <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sign-in/">

  <!-- Bootstrap core CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <!-- Favicons -->
  <link rel="icon" href="../assets/Alt_Logo_BRIN.png">
  <meta name="theme-color" content="#7952b3">


  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>

  <!-- Custom styles for this template -->
  <link href="../css/signin.css" rel="stylesheet">
</head>

<body class="text-center">

  <main class="form-signin">
    <form action="" method="POST">
      <img class="mb-4" src="/assets/Alt_Logo_BRIN.png" alt="" width="250" height="100">
      <h1 class="h3 mb-3 fw-normal">Silahkan Login Terlebih Dahulu</h1>

      <div class="form-floating">
        <input type="text" class="form-control" id="floatingInput" name="user" placeholder="Username...." required>
        <label for="floatingInput">Username</label>
      </div>
      <div class="form-floating" style="margin-bottom: 30px;">
        <input type="password" class="form-control" id="floatingPassword" name="pass" placeholder="Password...." required>
        <label for="floatingPassword">Password</label>
      </div>

      <button class="w-100 btn btn-lg btn-primary" type="submit" name="login">Login</button>

      <div class="login-help">
        <h6 style="margin-top: 20px;">Belum punya akun? <a href="registrasi.php">Daftar</a></h6>
      </div>
      <p class="mt-5 mb-3 text-muted">Copyright &copy; Muhammad Zaenal Arifin <?= date('Y') ?></p>
    </form>
  </main>

</body>

</html>