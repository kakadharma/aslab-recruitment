<?php
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $id = $_POST['id'] ?? null;
    $tipe = $_POST['tipe'] ?? null;
    $status = $_POST['status'] ?? null;

    // Validasi awal
    if (!$id || !$tipe || !$status) {
        die("Data tidak lengkap.");
    }

    // Tentukan query berdasarkan tipe
    if ($tipe === 'administrasi') {
        $sql = "UPDATE pendaftaran SET status_administrasi = ? WHERE id = ?";
        $redirect = 'data_berkas.php';
    } elseif ($tipe === 'wawancara') {
        $sql = "UPDATE pendaftaran SET status_wawancara = ? WHERE id = ?";
        $redirect = 'data_wawancara.php';
    } else {
        die("Tipe tidak valid.");
    }

    // Jalankan update ke database
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();

    // Redirect kembali ke halaman yang sesuai
    header("Location: $redirect");
    exit;
} else {
    die("Metode tidak diizinkan.");
}
?>
