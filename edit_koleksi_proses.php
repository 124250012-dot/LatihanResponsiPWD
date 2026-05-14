<?php
session_start();
if (!isset($_SESSION['status']) || $_SESSION['status'] != 'login') {
    header("Location: login.php?message=login_gagal");
    exit();
}

include 'koneksi.php';

if (isset($_POST['simpan'])) {
    $id = $_GET['id'];
    $kode_buku = $_POST['kode_buku'];
    $judul = $_POST['judul'];
    $pengarang = $_POST['pengarang'];
    $kategori = $_POST['kategori'];
    $stok = $_POST['stok'];

    if ($stok == 0) {
        $status = "Habis";
    } else if ($stok > 0 && $stok <= 5) {
        $status = "Menipis";
    } else {
        $status = "Tersedia";
    } 

    $cek = mysqli_query($koneksi, "SELECT * FROM data_buku WHERE (kode_buku='$kode_buku' OR judul='$judul') AND id_buku != '$id'");
    if (mysqli_num_rows($cek) > 0) {
        $_SESSION['message'] = "Kode Buku atau Judul Buku sudah ada! Gagal memperbarui data buku.";
        header("Location: edit_koleksi.php?id=$id");
        exit();
}
$query = "UPDATE data_buku SET kode_buku='$kode_buku', judul='$judul', pengarang='$pengarang', kategori='$kategori', stok='$stok', status='$status' WHERE id_buku='$id'";
    
    if (mysqli_query($koneksi, $query)) {
        $_SESSION['message'] = "Data buku berhasil diperbarui.";
        header("Location: koleksi.php");
        exit();
    } else {
        $_SESSION['message'] = "Error! Gagal memperbarui data buku" . mysqli_error($koneksi);
        header("Location: edit_koleksi.php?id=$id");
        exit();
    }

}