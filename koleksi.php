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
    <title>Perpustakaan Digital</title>
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
          <a class="nav-link active" aria-current="page" href="#">Koleksi Buku</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Peminjaman</a>
        </li>
      </ul>
      <span class="navbar-text">
        <a href="logout.php" class="btn btn-light text-dark"><i class="bi bi-box-arrow-right"></i> Keluar</a>
      </span>
    </div>
  </div>
</nav>

    <section class="koleksi-content">
      <?php
if (isset($_SESSION['message'])) { ?>
        <div class="alert alert-info text-center" role="alert">
          <?php echo $_SESSION['message']; ?>
        </div>
      <?php
      unset($_SESSION['message']);
      }
      ?>
      <div class="koleksi-container">
        <div class="koleksi-judul text-center mb-3 mt-4">
          <h1>Koleksi Buku</h1>
        </div>

        <div class="koleksi-button mb-2 text-end">
          <a href="#" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalTambahBuku"><span><i class="bi bi-plus"></i></span> Tambah Koleksi</a>
        </div>

        <div class="daftar-koleksi">
          <table class="table shadow-lg rounded overflow-hidden">
  <thead class="table-primary">
    <tr>
      <th scope="col">Id</th>
      <th scope="col">Kode Buku</th>
      <th scope="col">Judul</th>
      <th scope="col">Pengarang</th>
      <th scope="col">Kategori</th>
      <th scope="col">Stok</th>
      <th scope="col">Status</th>
      <th scope="col">Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php
    include 'koneksi.php';
    $query = "SELECT * FROM data_buku";
    $result = mysqli_query($koneksi, $query);
    $id = 1;
    while ($data = mysqli_fetch_assoc($result)) {
    ?>
    <tr>
      <th scope="row"><?php echo $id; ?></th>
      <td><?php echo $data['kode_buku']; ?></td>
      <td><?php echo $data['judul']; ?></td>
      <td><?php echo $data['pengarang']; ?></td>
      <td><?php echo $data['kategori']; ?></td>
      <td><?php echo $data['stok']; ?></td>
      <td><?php echo $data['status']; ?></td>
      <td>
        <a href="#" class="btn btn-success btn-sm">Edit</a>
        <a href="#" class="btn btn-warning btn-sm">Hapus</a>
      </td>
    </tr>
    <?php
    $id++;
  }
  ?>
  </tbody>
</table>
        </div>
      </div>
    </section>


  <div class="modal fade" id="modalTambahBuku" tabindex="-1" aria-labelledby="modalTambahBukuLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title" id="modalTambahBukuLabel">Tambah Koleksi Buku</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <form action="tambahBuku_proses.php" method="POST">
            <!-- <div class="mb-3">
              <label for="kode_buku" class="form-label">Kode Buku</label>
              <input type="text" class="form-control" id="kode_buku" name="kode_buku" required>
              <label for="stok" class="form-label">Jumlah Stok</label>
              <input type="number" class="form-control" id="jumlah_stok" name="stok" required>
            </div> -->
            <div class="row g-3 mb-3">
              <div class="col-md-6">
                <label class="form-label">Kode Buku</label>
                <input type="text" name="kode_buku" class="form-control" placeholder="Contoh: B001" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Jumlah Stok</label>
                <input type="number" name="stok" class="form-control" min="1" placeholder="Minimal 1" required>
              </div>
            </div>
            <div class="mb-3">
              <label for="judul" class="form-label">Judul Buku</label>
              <input type="text" class="form-control" id="judul" name="judul" required>
            </div>
            <div class="mb-3">
              <label for="pengarang" class="form-label">Pengarang</label>
              <input type="text" class="form-control" id="pengarang" name="pengarang" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Kategori</label>
              <select name="kategori" class="form-select" required>
              <option value="" disabled selected>Pilih Kategori...</option>
              <option value="Fiksi">Fiksi</option>
              <option value="Teknologi">Teknologi</option>
              <option value="Sejarah">Sejarah</option>
              <option value="Sains">Sains</option>
              </select>
            </div>
            <!-- <div class="mb-3">
              <label for="kategori" class="form-label">Kategori</label>
              <input type="text" class="form-control" id="kategori" name="kategori" required>
            </div> -->
            <!-- <div class="mb-3">
              <label for="status" class="form-label">Status</label>
              <select class="form-select" id="status" name="status" required>
                <option value="Tersedia">Tersedia</option>
                <option value="Dipinjam">Dipinjam</option>
              </select> -->
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
              <button type="submit" class="btn btn-primary" name="simpan">Simpan Data</button>
            </div>
          </form>
    </div>
  </div>
  </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>