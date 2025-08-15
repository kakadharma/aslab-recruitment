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

// Ambil status formulir dari database
$sql = "SELECT * FROM pengaturan LIMIT 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$status_formulir = $row ? $row['formulir_dibuka'] : 0;

// Handle form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $baru = ($_POST['status'] === '1') ? 1 : 0;

    if ($row) {
        $update = $conn->prepare("UPDATE pengaturan SET formulir_dibuka = ?");
        $update->bind_param("i", $baru);
        $update->execute();
    } else {
        $insert = $conn->prepare("INSERT INTO pengaturan (formulir_dibuka) VALUES (?)");
        $insert->bind_param("i", $baru);
        $insert->execute();
    }

    header("Location: atur_formulir.php?success=1");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pengaturan Pendaftaran</title>
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
            animation: fadeIn 0.6s ease forwards;
        }

        .sidebar.collapsed ~ #main-content,
        .sidebar.collapsed ~ #topbar {
            margin-left: 60px;
        }

        #topbar {
            margin-left: 200px;
            transition: margin-left 0.3s ease;
        }

        .table-body {
            padding: 20px;
            border-radius: 15px;
            max-width: 500px;
            margin: 0 auto;
            font-size: 14px;
            background-color: #fffef1;
            box-shadow: 0 8px 20px rgba(0,0,0,0.25);
            text-align: center;
            animation: zoomIn 0.5s ease forwards;
        }

        .table-body h3 {
            color: #234c1d;
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            margin: 10px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .btn-buka {
            background-color: #4CAF50;
        }

        .btn-buka:hover {
            background-color:rgb(89, 255, 44);
        }

        .btn-tutup {
            background-color: #e74c3c;
        }

        .btn-tutup:hover {
            background-color:rgb(255, 55, 0);
        }

        .success-message {
            color: green;
            font-weight: bold;
            margin-top: 15px;
            animation: fadeIn 0.4s ease;
        }

        .form-group {
            margin-top: 20px;
        }

        /* Animasi sederhana */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes zoomIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
    </style>
</head>
<body>

<?php include 'sidebar_admin.php'; ?>
<?php include 'topbar_admin.php'; ?>

<div class="content" id="main-content">
    <div class="table-body">
        <h3>Pengaturan Status Pendaftaran</h3>

        <p>Status Saat Ini:
            <?php if ($status_formulir): ?>
                <span class="btn btn-buka">Pendaftaran DIBUKA</span>
            <?php else: ?>
                <span class="btn btn-tutup">Pendaftaran DITUTUP</span>
            <?php endif; ?>
        </p>

        <form method="POST" class="form-group">
            <button type="submit" name="status" value="1" class="btn btn-buka">Buka</button>
            <button type="submit" name="status" value="0" class="btn btn-tutup">Tutup</button>
        </form>

        <?php if (isset($_GET['success'])): ?>
            <p class="success-message">Pengaturan berhasil disimpan!</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
