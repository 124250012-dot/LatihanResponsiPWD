<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Perpustakaan Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
  <body>

  <section class="login-page">
  <div class="card" style="width: 30rem;">
  <div class="card-body" style="width: 100%;">
    <h3 class="card-title text-center">Pustaka Digital</h3>
    <p class="card-text text-center">Sistem Perpustakaan Nasional</p>

    <?php if (isset($_GET['message'])):
         if ($_GET['message'] == 'login_gagal'): ?>
            <div class="alert alert-danger" role="alert">
                Login Gagal! Pastikan username dan password benar.
            </div>
        <?php elseif ($_GET['message'] == 'logout_berhasil'): ?>
            <div class="alert alert-success" role="alert">
                Logout Berhasil! Terima kasih telah menggunakan sistem kami.
            </div>
        <?php endif;
        endif; ?>

    <form action="login_proses.php" method="POST">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" name="username" id="username" aria-describedby="usernameHelp">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" id="password">
        </div>
        <button type="submit" class="btn btn-primary w-100">Masuk</button>
    </form>
  </div>
</div>
</section>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>