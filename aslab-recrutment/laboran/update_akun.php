<?php
session_start();
include '../db.php';

$id = $_SESSION['admin']['id'];
$nama = $_POST['nama'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$conn->query("UPDATE admin SET nama='$nama', email='$email', password='$password' WHERE id = $id");
echo "Berhasil diperbarui!";
