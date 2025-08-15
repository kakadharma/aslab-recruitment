<?php
include '../db.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Cetak Total Pendaftar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        h2 {
            text-align: center;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        th, td {
            padding: 8px;
            border: 1px solid black;
            text-align: left;
        }
        th {
            background-color: #eee;
        }
        @media print {
            body {
                margin: 0;
            }
        }
    </style>
</head>
<body onload="window.print()">

<h2>Total Pendaftar</h2>

<table>
    <tr>
        <th>Nama Lengkap</th>
        <th>NIM</th>
        <th>Semester</th>
        <th>Kelas</th>
    </tr>

    <?php
    $sql = "SELECT p.nama, f.nim, f.semester, f.kelas 
            FROM pendaftaran f 
            JOIN pendaftar p ON f.pendaftar_id = p.id";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()):
    ?>
    <tr>
        <td><?= htmlspecialchars($row['nama']) ?></td>
        <td><?= htmlspecialchars($row['nim']) ?></td>
        <td><?= htmlspecialchars($row['semester']) ?></td>
        <td><?= htmlspecialchars($row['kelas']) ?></td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
