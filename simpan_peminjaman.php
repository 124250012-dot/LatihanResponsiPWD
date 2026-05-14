<?php
session_start();
if (!isset($_SESSION['status']) || $_SESSION['status'] != 'login') {
    header("Location: login.php?message=login_gagal");
    exit();
}

include 'koneksi.php';

if (isset($_POST['simpan'])) {
    $kode_peminjaman = $_POST['kode_peminjaman'];
    $nama_peminjam = $_POST['nama_peminjam'];
    $judul_buku = $_POST['judul_buku'];
    $tanggal_peminjaman = $_POST['tanggal_peminjaman'];
    $tanggal_kembali = $_POST['tanggal_kembali'];

    $cekIDBuku = mysqli_query($koneksi, "SELECT id_buku FROM data_buku WHERE judul = '$judul_buku' AND stok > 0");

    if (mysqli_num_rows($cekIDBuku) > 0) {
        $dataBuku = mysqli_fetch_assoc($cekIDBuku);
        $id_buku = $dataBuku['id_buku'];
        $buku = $judul_buku;
    } else {
        $_SESSION['message'] = "Buku tidak tersedia untuk dipinjam.";
        header("Location: catat_peminjaman.php?message=buku_tidak_tersedia");
        exit();
    }

    $cek = mysqli_query($koneksi, "SELECT * FROM peminjaman WHERE kode_peminjaman = '$kode_peminjaman'");

    if (mysqli_num_rows($cek) > 0) {
        $_SESSION['message'] = "Kode peminjaman sudah digunakan.";
        header("Location: catat_peminjaman.php?message=peminjaman_sudah_ada");
        exit();
    }

    if ($tanggal_kembali < $tanggal_peminjaman) {
        $_SESSION['message'] = "Tanggal kembali tidak valid.";
        header("Location: catat_peminjaman.php?message=tanggal_kembali_invalid");
        exit();
    }

    $tanggal_hari_ini = date('Y-m-d');
    if ($tanggal_peminjaman > $tanggal_hari_ini) {
        $_SESSION['message'] = "Tanggal peminjaman tidak boleh lebih dari hari ini.";
        header("Location: catat_peminjaman.php?message=tanggal_peminjaman_invalid");
        exit();
    }

    $query = "INSERT INTO peminjaman (kode_peminjaman, peminjam, id_buku, tanggal_pinjam, tanggal_kembali, status) VALUES ('$kode_peminjaman', '$nama_peminjam', '$id_buku', '$tanggal_peminjaman', '$tanggal_kembali', 'Dipinjam')";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        $kurangStok = "UPDATE data_buku SET stok = stok - 1 WHERE id_buku = '$id_buku'";
        mysqli_query($koneksi, $kurangStok);

        $updateStatusBuku = "UPDATE data_buku SET status = CASE 
            WHEN stok = 0 THEN 'Habis' 
            WHEN stok > 0 AND stok <= 5 THEN 'Menipis' 
            ELSE 'Tersedia' 
        END WHERE id_buku = '$id_buku'";
        mysqli_query($koneksi, $updateStatusBuku);

        header("Location: peminjaman_koleksi.php?message=peminjaman_berhasil");
        exit();
    } else {
        header("Location: catat_peminjaman.php?message=peminjaman_gagal");
        exit();
    }
}