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
    <title>Pengaturan Akun</title>
    <link rel="icon" href="../assets/uinsulogo.png" type="image/png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: rgb(236, 240, 182);
        }

        .sidebar.collapsed ~ #main-content,
        .sidebar.collapsed ~ #topbar {
            margin-left: 60px !important;
        }

        #main-content {
            margin-left: 200px;
            padding: 30px;
            transition: margin-left 0.3s ease;
            animation: fadeIn 0.6s ease forwards;
        }

        #topbar {
            margin-left: 200px;
            transition: margin-left 0.3s ease;
        }

        .table-body {
            padding: 20px;
            border-radius: 15px;
            max-width: 800px;
            margin: 0 auto;
            font-size: 13px;
        }

        .table-body h3 {
            text-align: center;
            color: #234c1d;
            animation: zoomIn 0.5s ease forwards;
        }

        .info-box,
        .form-box {
            background-color: #fffef1;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.25);
            margin: 20px auto;
            width: 30%;
            text-align: center;
            animation: fadeIn 0.7s ease forwards;
        }

        .form-box label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        .form-box input[type="password"],
        .reset-form input[type="text"] {
            width: 80%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .form-box input[type="password"]:hover,
        .reset-form input[type="text"]:hover {
            border-color: #4CAF50;
            box-shadow: 0 0 8px #4CAF50;
        }

        .form-box button,
        .reset-form button {
            background-color: #4CAF50;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            width: 40%;
        }

        .form-box button:hover,
        .reset-form button:hover {
            background-color: rgb(188, 201, 51);
        }

        .search-box {
            text-align: center;
            margin-bottom: 20px;
        }

        #searchInput {
            width: 250px;
            padding: 8px;
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

        table {
            width: 80%;
            margin: 0 auto;
            border-collapse: separate;
            border-spacing: 0;
            border: 1px solid #ccc;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0,0,0,0.25);
        }

        thead th {
            background: linear-gradient(to bottom, rgb(12, 99, 17), rgb(78, 140, 24));
            color: white;
            padding: 10px;
            text-align: left;
        }

        tbody tr:nth-child(odd) {
            background-color: rgb(247, 243, 133);
        }

        tbody tr:nth-child(even) {
            background-color: #edf5e1;
        }

        tbody tr:hover {
            background-color: #d3f2c8;
        }

        td, th {
            padding: 10px;
            font-size: 13px;
            border-bottom: 1px solid #ddd;
        }

        .reset-form {
            display: flex;
            flex-direction: column;
            animation: fadeIn 0.8s ease forwards;
        }

        .reset-form input[type="text"] {
            margin-bottom: 8px;
        }

        /* Animasi tambahan */
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
        <h3>Pengaturan Akun Admin</h3>

        <div class="info-box">
            <p><strong>Username:</strong> <?= htmlspecialchars($admin['username']) ?></p>
            <p><strong>ID Admin:</strong> <?= $admin['id'] ?></p>
        </div>

        <div class="form-box">
            <h4>Ganti Password</h4>
            <form action="proses_ganti_password.php" method="POST">
                <input type="hidden" name="admin_id" value="<?= $admin['id'] ?>">
                <label>Password Lama:</label>
                <input type="password" name="password_lama" required>

                <label>Password Baru:</label>
                <input type="password" name="password_baru" required>

                <button type="submit">Ganti</button>
            </form>
            <?php if (isset($_SESSION['notif'])): ?>
        <p style="color: <?= strpos($_SESSION['notif'], '✅') !== false ? 'green' : 'red' ?>;">
            <?= $_SESSION['notif'] ?>
        </p>
        <?php unset($_SESSION['notif']); ?>
        <?php endif; ?>
        </div>

        <div style="width: 90%; margin: 0 auto;">
            <h4 style="text-align:center; margin-top:40px;">Kelola Akun Pendaftar</h4>
            <div class="search-box">
                <input type="text" id="searchInput" placeholder="Cari nama atau email...">
            </div>
            <table id="akunTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Reset Password</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $result = $conn->query("SELECT id, nama, email FROM pendaftar");
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$no}</td>
                                <td>" . htmlspecialchars($row['nama']) . "</td>
                                <td>" . htmlspecialchars($row['email']) . "</td>
                                <td>
                                    <form method='POST' action='reset_password_pendaftar.php' class='reset-form'>
                                        <input type='hidden' name='id' value='{$row['id']}'>
                                        <input type='text' name='new_password' placeholder='Password baru' required>
                                        <button type='submit'>Reset</button>
                                    </form>
                                </td>
                              </tr>";
                        $no++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.getElementById('searchInput').addEventListener('keyup', function () {
        const filter = this.value.toUpperCase();
        const rows = document.querySelectorAll('#akunTable tbody tr');
        rows.forEach(row => {
            const nama = row.cells[1].textContent.toUpperCase();
            const email = row.cells[2].textContent.toUpperCase();
            row.style.display = (nama.includes(filter) || email.includes(filter)) ? "" : "none";
        });
    });
</script>

</body>
</html>
