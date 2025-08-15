<?php
session_start();
include '../db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$admin_id = $_SESSION['admin_id'];

$sql = "SELECT * FROM admin WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
    <link rel="icon" href="../assets/uinsulogo.png" type="image/png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: rgb(236, 240, 182);
        }

        .content {
            margin-left: 200px;
            padding: 30px;
            transition: margin-left 0.3s ease;
        }

        .content.collapsed {
            margin-left: 60px;
        }

        .cards {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            flex: 1;
            color: white;
            padding: 20px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 8px 20px rgba(0,0,0,0.25);
            position: relative;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: scale(1.03);
            box-shadow: 0 12px 25px rgba(0,0,0,0.3);
        }

        .card h3 {
            margin: 0;
            font-size: 18px;
        }

        .card p {
            font-size: 26px;
            margin-top: 10px;
            font-weight: bold;
        }

        .card i {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 36px;
            opacity: 0.2;
        }

        .card.green-light {
            background: linear-gradient(135deg, #b8e994, #78e08f);
        }

        .card.green-dark {
            background: linear-gradient(135deg, #14532d, rgb(29, 159, 81));
        }

        .card.gold {
            background: linear-gradient(135deg, #f7d774, rgb(210, 206, 22));
        }

        .table-body {
            background-color: rgba(231, 244, 42, 0);
            padding: 20px;
            border-radius: 15px;
            overflow-x: auto;
            max-width: 800px;
            margin: 0 auto;
            font-size: 13px;
        }

        .table-body h3 {
            margin-top: 0;
            color: #234c1d;
            text-align: center;
        }

        .table-body table {
            width: 70%;
            border-collapse: separate;
            border-spacing: 0;
            border: 1px solid #ccc;
            border-radius: 12px;
            overflow: hidden;
            table-layout: auto;
            box-shadow: 0 8px 20px rgba(0,0,0,0.25);
            margin: 0 auto;
        }

        .table-body thead th {
            background: linear-gradient(to bottom, rgb(12, 99, 17), rgb(78, 140, 24));
            color: white;
            padding: 10px;
            text-align: left;
            font-size: 13px;
        }

        .table-body thead th:first-child {
            border-top-left-radius: 12px;
        }

        .table-body thead th:last-child {
            border-top-right-radius: 12px;
        }

        .table-body th:nth-child(1),
        .table-body td:nth-child(1) {
            width: 60px;
            text-align: center;
        }

        .table-body th:nth-child(2),
        .table-body td:nth-child(2) {
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .table-body th:nth-child(4),
        .table-body td:nth-child(4) {
            max-width: 160px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .table-body tbody tr:nth-child(odd) {
            background-color: rgb(247, 243, 133);
        }

        .table-body tbody tr:nth-child(even) {
            background-color: #edf5e1;
        }

        .table-body tbody tr {
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .table-body tbody tr:hover {
            background-color: #d3f2c8;
            transform: scale(1.01);
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .table-body td {
            padding: 10px;
            font-size: 13px;
            border-bottom: 1px solid #ddd;
        }

        .table-body tbody tr:last-child td:first-child {
            border-bottom-left-radius: 12px;
        }

        .table-body tbody tr:last-child td:last-child {
            border-bottom-right-radius: 12px;
        }

        /* Animation */
        @keyframes fadeSlideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animated {
            opacity: 0;
            animation: fadeSlideUp 0.8s ease-out forwards;
        }

        .animated-delay-1 {
            animation-delay: 0.2s;
        }

        .animated-delay-2 {
            animation-delay: 0.4s;
        }

        .animated-delay-3 {
            animation-delay: 0.6s;
        }
    </style>
</head>
<body>

<?php include 'sidebar_admin.php'; ?>
<?php include 'topbar_admin.php'; ?>

<!-- CONTENT -->
<div class="content" id="main-content">
    <h2 class="animated animated-delay-1">Dashboard Admin</h2>

    <div class="cards animated animated-delay-2">
        <div class="card green-light">
            <h3>Total Pendaftar</h3>
            <p>
                <?php
                $result = $conn->query("SELECT COUNT(*) AS total FROM pendaftaran");
                $row = $result->fetch_assoc();
                echo $row['total'] . " Orang";
                ?>
            </p>
            <i class="fas fa-users"></i>
        </div>
        <div class="card green-dark">
            <h3>Lulus Berkas</h3>
            <p>
                <?php
                $result = $conn->query("SELECT COUNT(*) AS total FROM pendaftaran WHERE status_administrasi = 'lulus'");
                $row = $result->fetch_assoc();
                echo $row['total'] . " Orang";
                ?>
            </p>
            <i class="fas fa-file-alt"></i>
        </div>
        <div class="card gold">
            <h3>Lulus Wawancara</h3>
            <p>
                <?php
                $result = $conn->query("SELECT COUNT(*) AS total FROM pendaftaran WHERE status_wawancara = 'lulus'");
                $row = $result->fetch_assoc();
                echo $row['total'] . " Orang";
                ?>
            </p>
            <i class="fas fa-comments"></i>
        </div>
    </div>

    <div class="table-body animated animated-delay-3">
        <h3>Pendaftar Terbaru</h3>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>NIM</th>
                    <th>Tanggal Upload Formulir</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT pendaftar.nama, pendaftaran.nim, pendaftaran.created_at 
                        FROM pendaftaran 
                        JOIN pendaftar ON pendaftar.id = pendaftaran.pendaftar_id 
                        ORDER BY pendaftaran.created_at DESC 
                        LIMIT 5";
                $result = $conn->query($sql);
                $no = 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>$no</td>";
                    echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nim']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                    echo "</tr>";
                    $no++;
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    const sidebar = document.getElementById('sidebar');
    const content = document.getElementById('main-content');
    const topbar = document.getElementById('topbar');

    function toggleSidebar() {
        sidebar.classList.toggle('collapsed');
        content.classList.toggle('collapsed');
        topbar.classList.toggle('collapsed');
    }
</script>

</body>
</html>
