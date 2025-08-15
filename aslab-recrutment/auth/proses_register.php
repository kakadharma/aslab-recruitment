<?php
session_start();
include('../db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $password_plain = $_POST['password'];

    if (empty($nama) || empty($email) || empty($password_plain)) {
        header("Location: register_pendaftar.php?error=empty");
        exit;
    }

    // Cek email sudah dipakai
    $cek = $conn->prepare("SELECT id FROM pendaftar WHERE email = ?");
    $cek->bind_param("s", $email);
    $cek->execute();
    $result = $cek->get_result();

    if ($result->num_rows > 0) {
        header("Location: register_pendaftar.php?error=email");
        exit;
    }

    // Hash password dan simpan
    $password_hashed = password_hash($password_plain, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO pendaftar (nama, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nama, $email, $password_hashed);

    if ($stmt->execute()) {
        // Ambil ID pendaftar terakhir
        $pendaftar_id = $stmt->insert_id;

        // ✅ Set session langsung login
        $_SESSION['user_id'] = $pendaftar_id;
        $_SESSION['role'] = 'pendaftar';
        $_SESSION['nama'] = $nama; // <--- Tambahkan ini

        header("Location: ../pendaftar/dashboard_pendaftar.php");
        exit;
    } else {
        header("Location: register_pendaftar.php?error=insert");
        exit;
    }

    $stmt->close();
    $cek->close();
    $conn->close();
} else {
    header("Location: register_pendaftar.php");
    exit;
}
?>
