<?php
session_start();

// Hapus semua session
session_unset();
session_destroy();

// Arahkan kembali ke halaman login pendaftar
header("Location: ../auth/login.php");
exit();
?>
