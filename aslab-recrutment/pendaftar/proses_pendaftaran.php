<?php
session_start();
include '../db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'pendaftar') {
    header("Location: ../auth/login.php");
    exit;
}

$pendaftar_id = $_SESSION['user_id'];
$nim = $_POST['nim'];
$semester = $_POST['semester'];
$kelas = $_POST['kelas'];
$ipk = $_POST['ipk'];

// Fungsi upload ke subfolder sesuai jenis file
function uploadFile($name, $subfolder) {
    $target_dir = "../uploads/" . $subfolder . "/";
    
    // Buat folder jika belum ada
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $filename = basename($_FILES[$name]["name"]);
    $filename = time() . "_" . preg_replace("/[^a-zA-Z0-9.]/", "_", $filename); // amankan nama file
    $target_file = $target_dir . $filename;

    if (move_uploaded_file($_FILES[$name]["tmp_name"], $target_file)) {
        return $target_file;
    }
    return "";
}

// Upload masing-masing ke folder yang sesuai
$surat_lamaran = uploadFile('surat_lamaran', 'surat lamaran');
$khs           = uploadFile('khs', 'khs');
$krs           = uploadFile('krs', 'krs');
$cv            = uploadFile('cv', 'cv');
$pas_foto      = uploadFile('pas_foto', 'pas foto');

// Masukkan data ke database
$sql = "INSERT INTO pendaftaran (pendaftar_id, nim, semester, kelas, ipk, surat_lamaran, khs, krs, cv, pas_foto, status_administrasi, status_wawancara, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending', 'pending', NOW())";

$stmt = $conn->prepare($sql);
$stmt->bind_param("isssssssss", $pendaftar_id, $nim, $semester, $kelas, $ipk, $surat_lamaran, $khs, $krs, $cv, $pas_foto);

if ($stmt->execute()) {
    header("Location: status_pendaftaran.php");
    exit();
} else {
    echo "Terjadi kesalahan saat menyimpan data / Data Tidak Lengkap. Silakan coba lagi.";
}
?>
