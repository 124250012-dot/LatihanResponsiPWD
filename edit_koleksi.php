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
    <title>Edit Koleksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
  <body class="koleksi-body">

  <nav class="navbar navbar-expand-lg sticky-top" style="background-color: #3153bb;" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Pustaka Digital</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="koleksi.php">Koleksi Buku</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="peminjaman_koleksi.php">Peminjaman</a>
        </li>
      </ul>
      <span class="navbar-text">
        <a href="logout.php" class="btn btn-light text-dark"><i class="bi bi-box-arrow-right"></i> Keluar</a>
      </span>
    </div>
  </div>
</nav>


<section class="edit-page">
  <?php
  include 'koneksi.php';
  $id = $_GET['id'];
  $query = "SELECT * FROM data_buku WHERE id_buku = '$id'";
  $result = mysqli_query($koneksi, $query);
  if (mysqli_num_rows($result) > 0) {
      $data = mysqli_fetch_assoc($result);
  } else {
      echo "<script>alert('Data tidak ditemukan!'); window.location='koleksi.php';</script>";
      exit();
  }
      $kode_buku = $data['kode_buku'];
      $judul     = $data['judul'];
      $pengarang = $data['pengarang'];
      $kategori  = $data['kategori'];
      $stok      = $data['stok'];
  ?>
  <div class="card" style="width: 40rem;">
  <div class="card-body" style="width: 100%;">
    <h3 class="card-title text-center">Form Edit Buku</h3>

    <form action="edit_koleksi_proses.php?id=<?php echo $id; ?>" method="POST">
        <div class="mb-3">
              <label for="id_buku" class="form-label">ID Buku</label>
              <input class="form-control" type="text" name="id_buku" value="<?php echo $id; ?>" disabled>
            </div>
         <div class="row g-3 mb-3">
              <div class="col-md-6">
                <label class="form-label">Kode Buku</label>
                <input type="text" name="kode_buku" class="form-control" placeholder="Contoh: B001" value="<?php echo $kode_buku; ?>" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Jumlah Stok</label>
                <input type="number" name="stok" class="form-control" min="0" placeholder="Minimal 1" value="<?php echo $stok; ?>" required>
              </div>
            </div>
            <div class="mb-3">
              <label for="judul" class="form-label">Judul Buku</label>
              <input type="text" class="form-control" id="judul" name="judul" value="<?php echo $judul; ?>" required>
            </div>
            <div class="mb-3">
              <label for="pengarang" class="form-label">Pengarang</label>
              <input type="text" class="form-control" id="pengarang" name="pengarang" value="<?php echo $pengarang; ?>" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Kategori</label>
              <select name="kategori" class="form-select" required>
              <option value="Fiksi" <?php if ($kategori == "Fiksi") echo 'selected'; ?>>Fiksi</option>
              <option value="Teknologi" <?php if ($kategori == "Teknologi") echo 'selected'; ?>>Teknologi</option>
              <option value="Sejarah" <?php if ($kategori == "Sejarah") echo 'selected'; ?>>Sejarah</option>
              <option value="Sains" <?php if ($kategori == "Sains") echo 'selected'; ?>>Sains</option>
              </select>
            </div>
            <div class="footer">
            <button type="button" class="btn btn-secondary" onclick="window.location.href='koleksi.php'">Kembali</button>
            <button type="submit" class="btn btn-primary" name="simpan">Simpan Perubahan</button>
            </div>
    </form>
  </div>
</div>
</section>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>