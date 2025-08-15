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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tanggal = $_POST['tanggal'];
    $waktu_mulai = $_POST['waktu_mulai'];
    $waktu_selesai = $_POST['waktu_selesai'];
    $tempat = $_POST['tempat'];

    $sql = "UPDATE pendaftaran 
            SET tanggal_wawancara = ?, 
                waktu_mulai = ?, 
                waktu_selesai = ?, 
                tempat_wawancara = ? 
            WHERE status_administrasi = 'lulus'";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $tanggal, $waktu_mulai, $waktu_selesai, $tempat);

    if ($stmt->execute()) {
        $success = "Jadwal wawancara berhasil diperbarui.";
    } else {
        $error = "Gagal menyimpan jadwal wawancara.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Atur Jadwal Wawancara</title>
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
            animation: fadeSlideIn 0.6s ease forwards;
            opacity: 0;
            transform: translateY(30px);
        }

        @keyframes fadeSlideIn {
            to {
                opacity: 1;
                transform: translateY(0);
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
            max-width: 600px;
            margin: 0 auto;
            font-size: 14px;
            background-color: #fffef1;
            box-shadow: 0 8px 20px rgba(0,0,0,0.25);
            animation: fadeUp 0.7s ease 0.2s forwards;
            opacity: 0;
            transform: translateY(20px);
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
            margin-bottom: 20px;
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

        form label,
        form input,
        form .time-range,
        form button {
            opacity: 0;
            transform: translateX(-20px);
            animation: slideInLeft 0.4s ease forwards;
        }

        form label:nth-of-type(1) { animation-delay: 0.6s; }
        form input[name="tanggal"] { animation-delay: 0.7s; }
        form label:nth-of-type(2) { animation-delay: 0.8s; }
        .time-range { animation-delay: 0.9s; }
        form label:nth-of-type(3) { animation-delay: 1s; }
        form input[name="tempat"] { animation-delay: 1.1s; }
        form button { animation-delay: 1.2s; }

        @keyframes slideInLeft {
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        form label {
            display: block;
            margin-top: 10px;
            margin-bottom: 5px;
            font-weight: bold;
        }

        form input[type="date"],
        form input[type="time"],
        form input[type="text"] {
            width: 79%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 6px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }

        form input[type="date"]:hover,
        form input[type="time"]:hover,
        form input[type="text"]:hover,
        form input[type="date"]:focus,
        form input[type="time"]:focus,
        form input[type="text"]:focus {
            border-color: #4CAF50;
            box-shadow: 0 0 8px rgba(76, 175, 80, 0.4);
            outline: none;
        }

        .time-range {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .btn {
            display: inline-block;
            padding: 10px 18px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            margin-top: 10px;
        }

        .btn:hover {
            background-color: rgb(188, 201, 51);
            transform: scale(1.05);
        }

        .success {
            color: green;
            text-align: center;
            margin-bottom: 15px;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<?php include 'sidebar_admin.php'; ?>
<?php include 'topbar_admin.php'; ?>

<div class="content" id="main-content">
    <div class="table-body">
        <h3>Atur Jadwal Wawancara</h3>

        <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

        <form method="POST">
            <label>Tanggal Wawancara:</label>
            <input type="date" name="tanggal" required>

            <label>Waktu Wawancara:</label>
            <div class="time-range">
                <input type="time" name="waktu_mulai" required>
                <span>sampai</span>
                <input type="time" name="waktu_selesai" required>
            </div>

            <label>Tempat Wawancara:</label>
            <input type="text" name="tempat" required>

            <button type="submit" class="btn">Simpan Jadwal</button>
        </form>
    </div>
</div>

</body>
</html>
