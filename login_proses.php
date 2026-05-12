<?php
include 'koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];

$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
$result = mysqli_query($koneksi, $query);

if (mysqli_num_rows($result) > 0) {
    session_start();
    $_SESSION['status'] = 'login';
    header("Location: koleksi.php");
    exit();
} else {
    header("Location: login.php?message=login_gagal");
    exit();
}
?>