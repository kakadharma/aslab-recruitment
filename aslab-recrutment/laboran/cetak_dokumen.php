<?php
session_start();
include('../db.php'); 

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$admin_id = $_SESSION['admin_id'];
$sql_admin = "SELECT * FROM admin WHERE id = ?";
$stmt_admin = $conn->prepare($sql_admin);
$stmt_admin->bind_param("i", $admin_id);
$stmt_admin->execute();
$result_admin = $stmt_admin->get_result();
$admin = $result_admin->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cetak Dokumen</title>
    <link rel="icon" href="../assets/uinsulogo.png" type="image/png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: rgb(236, 240, 182);
        }

        #main-content {
            margin-left: 200px;
            padding: 30px;
            transition: margin-left 0.3s ease;
            opacity: 0;
            transform: translateX(40px);
            animation: slideFadeIn 0.6s ease forwards;
        }

        @keyframes slideFadeIn {
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .sidebar.collapsed ~ #main-content,
        .sidebar.collapsed ~ #topbar {
            margin-left: 60px;
        }

        #topbar {
            transition: margin-left 0.3s ease;
            margin-left: 200px;
        }

        .table-body {
            padding: 20px;
            border-radius: 15px;
            overflow-x: auto;
            max-width: 1000px;
            margin: 0 auto;
            font-size: 13px;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeUp 0.8s ease 0.2s forwards;
        }

        @keyframes fadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .table-body h3 {
            text-align: center;
            color: #234c1d;
            opacity: 0;
            transform: scale(0.95);
            animation: zoomIn 0.6s ease 0.4s forwards;
        }

        @keyframes zoomIn {
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .table-body table {
            width: 40%;
            margin: 0 auto;
            border-collapse: separate;
            border-spacing: 0;
            border: 1px solid #ccc;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0,0,0,0.25);
        }

        .table-body thead th {
            background: linear-gradient(to bottom, rgb(12, 99, 17), rgb(78, 140, 24));
            color: white;
            padding: 10px;
            text-align: left;
        }

        .table-body tbody tr:nth-child(odd) {
            background-color: rgb(247, 243, 133);
        }

        .table-body tbody tr:nth-child(even) {
            background-color: #edf5e1;
        }

        .table-body tbody tr {
            opacity: 0;
            transform: translateY(20px);
            animation: rowFadeIn 0.6s ease forwards;
        }

        .table-body tbody tr:nth-child(1) { animation-delay: 0.5s; }
        .table-body tbody tr:nth-child(2) { animation-delay: 0.7s; }
        .table-body tbody tr:nth-child(3) { animation-delay: 0.9s; }

        @keyframes rowFadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .table-body tbody tr:hover {
            background-color: #d3f2c8;
            transform: scale(1.01);
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .table-body td, .table-body th {
            padding: 10px;
            font-size: 13px;
            border-bottom: 1px solid #ddd;
        }

        .btn {
            display: inline-block;
            padding: 6px 12px;
            text-decoration: none;
            background-color: #4CAF50;
            color: white;
            border-radius: 4px;
            text-align: center;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn:hover {
            background-color: rgb(188, 201, 51);
            transform: scale(1.05);
        }
    </style>
</head>
<body>

<?php include 'sidebar_admin.php'; ?>
<?php include 'topbar_admin.php'; ?>

<div class="content" id="main-content">
    <div class="table-body">
        <h3>Daftar Dokumen Laporan</h3>
        <table>
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Laporan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Total Semua Pendaftar</td>
                    <td><a href="cetak_total_pendaftar.php" class="btn" target="_blank">Cetak</a></td>
                </tr>
                <tr>
                    <td>Peserta Lulus Berkas</td>
                    <td><a href="cetak_lulus_berkas.php" class="btn" target="_blank">Cetak</a></td>
                </tr>
                <tr>
                    <td>Peserta Lulus Final</td>
                    <td><a href="cetak_lulus_final.php" class="btn" target="_blank">Cetak</a></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
