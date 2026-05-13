<?php
session_start();
include 'koneksi.php';

if (isset($_POST['simpan'])) { //untuk nangkap data dari form modal
    $kode_buku = $_POST['kode_buku'];
    $judul     = $_POST['judul'];
    $pengarang = $_POST['pengarang'];
    $kategori  = $_POST['kategori'];
    $stok      = $_POST['stok'];

    // $query = "INSERT INTO data_buku (kode_buku, judul, pengarang, kategori, stok, status) VALUES ('$kode_buku', '$judul', '$pengarang', '$kategori', '$stok', 'Tersedia')";
    // $result = mysqli_query($koneksi, $query);

    // if ($result) {
    //     $_SESSION['message'] = "Data buku berhasil ditambahkan.";
    //     header("Location: koleksi.php");
    // } else {
    //     $_SESSION['message'] = "Gagal menambahkan data buku.";
    //     header("Location: koleksi.php");
    // }

    $cek = mysqli_query($koneksi, "SELECT * FROM data_buku WHERE kode_buku = '$kode_buku' OR judul = '$judul'"); //buat ngecek apakah kode buku udah ada di database, biar ga keduplikat

    if (mysqli_num_rows($cek) > 0) { // ini kondisi kalau kodenya ada yg sama maka gak bisa di input, balik ke halaman koleksi
        $_SESSION['message'] = "Kode Buku atau Judul Buku sudah ada!Gagal menambahkan data buku.";
        header("Location: koleksi.php");
        //echo "<script>alert('Kode Buku atau Judul Buku sudah ada!'); window.location='koleksi.php';</script>";
    } else { // kala ga ada yg sama maka data yg dinput akan dimasukkan ke database
        $query = "INSERT INTO data_buku (kode_buku, judul, pengarang, kategori, stok, status) VALUES ('$kode_buku', '$judul', '$pengarang', '$kategori', '$stok', 'Tersedia')";

        if (mysqli_query($koneksi, $query)) {
            $_SESSION['message'] = "Data buku berhasil ditambahkan.";
            header("Location: koleksi.php");
        } else {
            echo "Gagal simpan data.";
        }
    }
}
?>