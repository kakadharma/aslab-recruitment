<!-- bagian PHP tetap sama (tidak diubah) -->
<?php
session_start();
include '../db.php';

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

$sql = "SELECT f.id, f.pendaftar_id, f.status_wawancara, p.nama, f.nim, f.kelas 
        FROM pendaftaran f 
        JOIN pendaftar p ON f.pendaftar_id = p.id 
        WHERE f.status_administrasi = 'lulus'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Wawancara Pendaftar</title>
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
            transform: translateX(50px);
            animation: slideIn 0.8s ease forwards;
        }

        @keyframes slideIn {
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
            transform: translateY(50px);
            animation: fadeUp 1s ease 0.4s forwards;
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
            animation: fadeZoom 0.7s ease 0.2s forwards;
            opacity: 0;
            transform: scale(0.95);
        }

        @keyframes fadeZoom {
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .search-container {
            text-align: center;
            margin-bottom: 15px;
            opacity: 0;
            transform: scale(0.9);
            animation: fadeZoom 0.7s ease 0.3s forwards;
        }

        #searchInput {
            width: 300px;
            padding: 10px;
            border: 2px solid #ccc;
            border-radius: 20px;
            transition: all 0.3s ease;
        }

        #searchInput:hover,
        #searchInput:focus {
            border-color: #4CAF50;
            box-shadow: 0 0 10px #4CAF50;
            outline: none;
        }

        .table-body table {
            width: 60%;
            border-collapse: separate;
            border-spacing: 0;
            border: 1px solid #ccc;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0,0,0,0.25);
            margin: 0 auto;
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
            animation: rowFadeIn 0.5s ease forwards;
        }

        <?php for ($i = 1; $i <= 50; $i++): ?>
        .table-body tbody tr:nth-child(<?= $i ?>) {
            animation-delay: <?= 0.1 + $i * 0.05 ?>s;
        }
        <?php endfor; ?>

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

        .status-badge select {
            font-weight: bold;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 5px 10px;
        }

        .status-badge select.lulus {
            background-color: #4CAF50;
        }

        .status-badge select.tidak_lulus {
            background-color: #f44336;
        }

        .status-badge select.pending {
            background-color: #9E9E9E;
        }
    </style>
</head>
<body>

<?php include 'sidebar_admin.php'; ?>
<?php include 'topbar_admin.php'; ?>

<div class="content" id="main-content">
    <div class="table-body">
        <h3>Data Wawancara Pendaftar</h3>
        <div class="search-container">
            <input type="text" id="searchInput" placeholder="Cari nama atau NIM...">
        </div>
        <table id="wawancaraTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>NIM</th>
                    <th>Kelas</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
                <?php 
                    $status = $row['status_wawancara'] ?: 'pending';
                    $statusClass = strtolower($status);
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['nama']) ?></td>
                    <td><?= htmlspecialchars($row['nim']) ?></td>
                    <td><?= htmlspecialchars($row['kelas']) ?></td>
                    <td class="status-badge">
                        <form action="ubah_status_berkas.php" method="POST" target="dummyframe">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <input type="hidden" name="tipe" value="wawancara">
                            <select name="status" class="<?= $statusClass ?>" onchange="updateSelectColor(this); this.form.submit();">
                                <option value="pending" <?= $status == 'pending' ? 'selected' : '' ?>>⏳ Pending</option>
                                <option value="lulus" <?= $status == 'lulus' ? 'selected' : '' ?>>✔ Lulus</option>
                                <option value="tidak_lulus" <?= $status == 'tidak_lulus' ? 'selected' : '' ?>>✖ Tidak Lulus</option>
                            </select>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
<iframe name="dummyframe" style="display:none;"></iframe>

<script>
document.getElementById('searchInput').addEventListener('keyup', function() {
    const filter = this.value.toUpperCase();
    const rows = document.querySelectorAll("#wawancaraTable tbody tr");
    rows.forEach(row => {
        const nama = row.cells[1].textContent.toUpperCase();
        const nim = row.cells[2].textContent.toUpperCase();
        row.style.display = (nama.includes(filter) || nim.includes(filter)) ? "" : "none";
    });
});

function updateSelectColor(select) {
    const status = select.value;
    select.classList.remove('lulus', 'tidak_lulus', 'pending');
    select.classList.add(status);
}
</script>

</body>
</html>
