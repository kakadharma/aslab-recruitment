<?php
session_start();
include '../db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $admin_id = $_POST['admin_id'];
    $password_lama = $_POST['password_lama'];
    $password_baru = $_POST['password_baru'];

    // Ambil data admin
    $sql = "SELECT * FROM admin WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $admin_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    // Verifikasi password lama
    if ($admin && password_verify($password_lama, $admin['password'])) {
        $hash_baru = password_hash($password_baru, PASSWORD_DEFAULT);

        // Update password
        $update = $conn->prepare("UPDATE admin SET password = ? WHERE id = ?");
        $update->bind_param("si", $hash_baru, $admin_id);
        $update->execute();

        $_SESSION['notif'] = "✅ Password berhasil diubah.";
    } else {
        $_SESSION['notif'] = "❌ Password lama salah";
    }

    header("Location: pengaturan_akun.php");
    exit;
}
?>
