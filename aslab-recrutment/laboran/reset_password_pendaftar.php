<?php
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $new_password = $_POST['new_password'];

    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("UPDATE pendaftar SET password = ? WHERE id = ?");
    $stmt->bind_param("si", $hashed_password, $id);

    if ($stmt->execute()) {
        header("Location: pengaturan_akun.php?reset=success");
        exit;
    } else {
        echo "❌ Gagal reset password pendaftar.";
    }

    $stmt->close();
    $conn->close();
} else {
    die("Akses tidak valid.");
}
