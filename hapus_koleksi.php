<?php
session_start();
if (!isset($_SESSION['status']) || $_SESSION['status'] != 'login') {
    header("Location: login.php?message=login_gagal");
    exit();
}

include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $querycek = "SELECT * FROM data_buku WHERE id_buku='$id'";
    $resultcek = mysqli_query($koneksi, $querycek);
    if (mysqli_num_rows($resultcek) > 0) {
        $data = mysqli_fetch_assoc($resultcek);
    } else {
        $_SESSION['message'] = "Data buku tidak ditemukan! Gagal menghapus data buku.";
        header("Location: koleksi.php");
        exit();
    }

    $cekBukuDipinjam = "SELECT * FROM peminjaman WHERE id_buku='$id' AND status='Dipinjam'";
    $resultCekBukuDipinjam = mysqli_query($koneksi, $cekBukuDipinjam);
    if (mysqli_num_rows($resultCekBukuDipinjam) > 0) {
        $_SESSION['message'] = "Buku tidak dapat dihapus karena sedang dipinjam.";
        header("Location: koleksi.php");
        exit();
    }

    $query = "DELETE FROM data_buku WHERE id_buku='$id'";
    if (mysqli_query($koneksi, $query)) {
        $_SESSION['message'] = "Data buku berhasil dihapus.";
        header("Location: koleksi.php");
        exit();
    } else {
        $_SESSION['message'] = "Error! Gagal menghapus data buku" . mysqli_error($koneksi);
        header("Location: koleksi.php");
        exit();
    }
} else {
    $_SESSION['message'] = "ID buku tidak ditemukan! Gagal menghapus data buku.";
    header("Location: koleksi.php");
    exit();
}

?>