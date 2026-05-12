<?php

$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'perpustakaan_digital';

$koneksi = mysqli_connect($hostname, $username, $password, $database);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

?>