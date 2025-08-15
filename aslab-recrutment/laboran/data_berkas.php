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

$sql = "SELECT f.*, p.nama FROM pendaftaran f 
        JOIN pendaftar p ON f.pendaftar_id = p.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Berkas Pendaftar</title>
    <link rel="icon" href="../assets/uinsulogo.png" type="image/png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <style>
        html {
            scroll-behavior: smooth;
        }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: rgb(236, 240, 182);
        }
        #main-content {
            margin-left: 200px;
            padding: 30px;
            transition: margin-left 0.3s ease;
            animation: slideFadeIn 0.8s ease;
        }

#topbar {
    transition: margin-left 0.3s ease;
    margin-left: 200px;
}

body.sidebar-collapsed #topbar {
    margin-left: 60px;
}


        body.sidebar-collapsed #main-content {
            margin-left: 60px;
        }

        @keyframes slideFadeIn {
            from { opacity: 0; transform: translateX(50px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .table-body {
            padding: 20px;
            border-radius: 15px;
            overflow-x: auto;
            max-width: 1000px;
            margin: 0 auto;
            font-size: 13px;
            animation: fadeInUp 1s ease;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .table-body h3 {
            text-align: center;
            color: #234c1d;
        }
        .table-body table {
            width: 100%;
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

        #searchInput {
            width: 300px;
            padding: 10px;
            margin-bottom: 15px;
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

        .status-badge select {
            font-weight: bold;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 5px 10px;
        }
        .status-badge.lulus select { background-color: #4CAF50; }
        .status-badge.tidak_lulus select { background-color: #f44336; }
        .status-badge.pending select { background-color: #9E9E9E; }

        .modal {
            display: block;
            visibility: hidden;
            opacity: 0;
            transform: scale(0.9);
            position: fixed;
            z-index: 999;
            left: 50%;
            top: 15%;
            transform: translateX(-50%) scale(0.9);
            background-color: rgba(255,255,255,0.95);
            padding: 20px;
            border: 2px solid #66bb6a;
            border-radius: 10px;
            width: 60%;
            transition: opacity 0.3s ease, transform 0.3s ease, visibility 0.3s;
            backdrop-filter: blur(4px);
        }

        .modal.show {
            visibility: visible;
            opacity: 1;
            transform: translateX(-50%) scale(1);
        }

        .modal-content {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            padding: 10px;
        }
        .modal-left {
            flex: 2;
            min-width: 250px;
        }
        .modal-left h3 {
            color: #2e7d32;
            margin-bottom: 15px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }
        .modal-left p {
            margin: 8px 0;
            font-size: 14px;
        }
        .modal-left strong {
            color: #333;
            width: 140px;
            display: inline-block;
        }
        .modal-right {
            flex: 1;
            min-width: 120px;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .modal-right img {
            width: 113px;
            height: 151px;
            object-fit: cover;
            border: 2px solid #ccc;
            border-radius: 6px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        button:hover {
            background-color: inherit;
        }

        .file-link {
            text-decoration: none;
            font-size: 16px;
            margin-left: 5px;
        }
    </style>
</head>
<body>

<?php include 'sidebar_admin.php'; ?>
<?php include 'topbar_admin.php'; ?>

<div class="content" id="main-content">
    <div class="table-body">
        <h3 id="top">Data Berkas Pendaftar</h3>
        <input type="text" id="searchInput" placeholder="Cari nama atau NIM...">
        <table id="pendaftarTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>NIM</th>
                    <th>Tanggal Upload</th>
                    <th>Status</th>
                    <th>Berkas</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
                <?php 
                    $status = $row['status_administrasi'] ?: 'pending';
                    $statusClass = strtolower($status);
                    $modalId = 'modal-' . $row['id']; 
                ?>
                <tr id="row-<?= $row['id'] ?>">
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['nama']) ?></td>
                    <td><?= htmlspecialchars($row['nim']) ?></td>
                    <td><?= htmlspecialchars($row['created_at'] ?? '-') ?></td>
                    <td class="status-badge <?= $statusClass ?>">
                        <form action="ubah_status_berkas.php" method="POST" target="dummyframe" onsubmit="saveScrollPosition()">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <input type="hidden" name="tipe" value="administrasi">
                            <select name="status" onchange="updateStatusBadge(this, <?= $row['id'] ?>); this.form.submit();">
                                <option value="pending" <?= $status == 'pending' ? 'selected' : '' ?>>⏳ Pending</option>
                                <option value="lulus" <?= $status == 'lulus' ? 'selected' : '' ?>>✔ Lulus</option>
                                <option value="tidak_lulus" <?= $status == 'tidak_lulus' ? 'selected' : '' ?>>✖ Tidak Lulus</option>
                            </select>
                        </form>
                    </td>
                    <td><button onclick="openModal('<?= $modalId ?>')">📂</button></td>
                </tr>
                <div id="<?= $modalId ?>" class="modal">
                    <div class="modal-content">
                        <span class="close" onclick="closeModal('<?= $modalId ?>')">&times;</span>
                        <div class="modal-left">
                            <h3><?= htmlspecialchars($row['nama']) ?></h3>
                            <p><strong>NIM:</strong> <?= htmlspecialchars($row['nim']) ?></p>
                            <p><strong>Semester:</strong> <?= htmlspecialchars($row['semester']) ?></p>
                            <p><strong>Kelas:</strong> <?= htmlspecialchars($row['kelas']) ?></p>
                            <p><strong>IPK:</strong> <?= htmlspecialchars($row['ipk']) ?></p>
                            <p><strong>Surat Lamaran:</strong> <a class="file-link" href="<?= $row['surat_lamaran'] ?>" target="_blank">📄</a></p>
                            <p><strong>KHS:</strong> <a class="file-link" href="<?= $row['khs'] ?>" target="_blank">📄</a></p>
                            <p><strong>KRS:</strong> <a class="file-link" href="<?= $row['krs'] ?>" target="_blank">📄</a></p>
                            <p><strong>CV:</strong> <a class="file-link" href="<?= $row['cv'] ?>" target="_blank">📄</a></p>
                        </div>
                        <div class="modal-right">
                            <?php if (!empty($row['pas_foto'])): ?>
                                <img src="<?= htmlspecialchars($row['pas_foto']) ?>" alt="Pas Foto">
                            <?php else: ?>
                                <p><em>Pas foto belum diunggah</em></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
<iframe name="dummyframe" style="display:none;"></iframe>

<script>
function openModal(id) {
    const modal = document.getElementById(id);
    modal.classList.add('show');
}

function closeModal(id) {
    const modal = document.getElementById(id);
    modal.classList.remove('show');
}

document.getElementById('searchInput').addEventListener('keyup', function() {
    const filter = this.value.toUpperCase();
    const rows = document.querySelectorAll("#pendaftarTable tbody tr");
    rows.forEach(row => {
        const nama = row.cells[1].textContent.toUpperCase();
        const nim = row.cells[2].textContent.toUpperCase();
        row.style.display = (nama.includes(filter) || nim.includes(filter)) ? "" : "none";
    });
});

function saveScrollPosition() {
    sessionStorage.setItem('scrollTop', window.scrollY);
}
window.onload = function() {
    const scrollY = sessionStorage.getItem('scrollTop');
    if (scrollY) window.scrollTo(0, scrollY);
};

function updateStatusBadge(selectElem, rowId) {
    const status = selectElem.value;
    const row = document.getElementById('row-' + rowId);
    const badge = row.querySelector('.status-badge');
    badge.className = 'status-badge ' + status;
}
</script>

</body>
</html>
