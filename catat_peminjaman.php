<?php
session_start();
if (!isset($_SESSION['status']) || $_SESSION['status'] != 'login') {
    header("Location: login.php?message=login_gagal");
    exit();
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Peminjaman Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
  <body class="catat-peminjaman-body">
  <nav class="navbar navbar-expand-lg sticky-top" style="background-color: #3153bb;" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Pustaka Digital</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="koleksi.php">Koleksi Buku</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="peminjaman_koleksi.php">Peminjaman</a>
        </li>
      </ul>
      <span class="navbar-text">
        <a href="logout.php" class="btn btn-light text-dark"><i class="bi bi-box-arrow-right"></i> Keluar</a>
      </span>
    </div>
  </div>
</nav>

<section class="catat-peminjaman-page">
   <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-info alert-dismissible fade show text-center" role="alert">
          <?php 
          echo $_SESSION['message'];
          unset($_SESSION['message']);
          ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>
  <div class="card" style="width: 40rem;">
  <div class="card-body" style="width: 100%;">
    <h3 class="card-title text-center">Form Data Peminjaman</h3>

    <form action="simpan_peminjaman.php" method="POST">
         <div class="mb-3">
                <label for="kode_peminjaman" class="form-label">Kode Peminjaman</label>
                <input type="text" name="kode_peminjaman" id="kode_peminjaman" class="form-control" value="" placeholder="Contoh: P001" required>
            </div>
            <div class="mb-3">
                <label for="nama_peminjam" class="form-label">Nama Peminjam</label>
                <input type="text" name="nama_peminjam" id="nama_peminjam" class="form-control" placeholder="Masukkan Nama Peminjam" required>
            </div>
            <div class="mb-3">
                <?php
                include 'koneksi.php';
                $query_buku = "SELECT * FROM data_buku";
                $result_buku = mysqli_query($koneksi, $query_buku);
                ?>
                <label for="pilih_buku" class="form-label">Pilih Buku</label>
                <select name="judul_buku" id="pilih_buku" class="form-select" required>
                    <option value="" disabled selected>Pilih Buku</option>
                    <?php while ($row = mysqli_fetch_assoc($result_buku)) { ?>
                        <option value="<?php echo $row['judul']; ?>"><?php echo $row['judul']; ?></option>
                    <?php } ?>
                </select>
            </div>
            
            <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label for="tanggal_peminjaman" class="form-label">Tanggal Peminjaman</label>
              <input type="date" class="form-control" id="tanggal_peminjaman" name="tanggal_peminjaman" required>
            </div>
            <div class="col-md-6">
              <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
              <input type="date" class="form-control" id="tanggal_kembali" name="tanggal_kembali" required>
            </div>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
              <button type="button" class="btn btn-secondary" onclick="window.location.href='peminjaman_koleksi.php'">Kembali</button>
              <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
            </div>
    </form>
  </div>
</div>
</section>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>