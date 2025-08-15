<?php
$current_page = basename($_SERVER['PHP_SELF']);
$openDropdown = in_array($current_page, ['data_berkas.php', 'data_wawancara.php']);
?>

<style>
    .sidebar {
        height: 100vh;
        background: linear-gradient(to bottom,rgb(4, 19, 0),rgb(17, 46, 1),rgb(17, 122, 5));
        color: white;
        position: fixed;
        width: 200px;
        overflow: hidden;
        z-index: 999;
        font-family: Arial, sans-serif;
        box-shadow: 3px 0 10px rgba(0, 0, 0, 0.2);
        font-size: 14px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: width 0.3s ease;
    }

    .sidebar.collapsed {
        width: 60px;
    }

    .sidebar-toggle {
        background: none;
        border: none;
        color: white;
        font-size: 18px;
        text-align: right;
        padding: 10px 16px;
        cursor: pointer;
        width: 100%;
        margin-left: -6px;
    }

    .sidebar-header {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 0 16px;
        margin-bottom: 10px;
    }

    .sidebar-header img {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 50%;
        filter: drop-shadow(0 0 0 white) drop-shadow(0 0 1px white);
        margin-left: -6px;
    }

    .instansi {
        font-weight: bold;
        font-size: 14px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        transition: opacity 0.3s ease;
    }

    .sidebar.collapsed .instansi {
        opacity: 0;
        width: 0;
    }

    .sidebar ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .sidebar ul li {
        margin: 6px 0;
    }

    .sidebar ul li a {
        display: flex;
        align-items: center;
        padding: 10px 16px;
        color: white;
        text-decoration: none;
        border-radius: 10px 0 0 10px;
        transition: background 0.3s ease;
    }

    .sidebar ul li a:hover {
        background-color: rgba(179, 185, 12, 0.52);
    }

    .sidebar a.active {
        background-color: rgba(255, 255, 255, 0.2);
        border-left: 4px solid yellow;
    }

    .sidebar i {
        min-width: 24px;
        text-align: center;
        font-size: 16px;
        flex-shrink: 0;
    }

    .sidebar a span {
        margin-left: 10px;
        white-space: nowrap;
        overflow: hidden;
        transition: opacity 0.3s ease, margin-left 0.3s ease;
    }

    .sidebar.collapsed a span {
        opacity: 0;
        margin-left: 0;
    }

    .dropdown.open .submenu {
        display: block;
    }

    .sidebar ul li .dropdown-toggle::after {
        content: '▼';
        font-size: 10px;
        margin-left: auto;
        transition: transform 0.3s ease;
    }

    .dropdown.open .dropdown-toggle::after {
        content: '▲';
    }

    .sidebar.collapsed .dropdown-toggle::after {
        display: none;
    }

    .sidebar.collapsed .submenu {
        display: none !important;
    }

    .submenu {
        display: none;
        font-size: 13px;
        padding-left: 10px;
    }

    .submenu li a {
        display: flex;
        align-items: center;
        padding: 10px 16px 10px 36px;
        color: white;
        text-decoration: none;
        opacity: 0.9;
        transition: background 0.3s ease;
        margin-left: 15px;
    }

    .submenu li a i {
        margin-right: 8px;
        min-width: 20px;
    }

    .submenu li a:hover {
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 10px 0 0 10px;
    }

    .sidebar-footer {
        text-align: center;
        font-size: 11px;
        padding: 10px;
        opacity: 0.8;
        transition: all 0.3s ease;
        transform-origin: left;
        white-space: nowrap;
    }

    .sidebar.collapsed .sidebar-footer {
        opacity: 0;
        transform: scaleX(0);
        pointer-events: none;
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

<div class="sidebar" id="sidebar">
    <div>
        <button class="sidebar-toggle" onclick="toggleSidebar()">☰</button>

        <div class="sidebar-header">
            <img src="../assets/uinsulogo.png" alt="Logo Instansi">
            <div class="instansi">Menu</div>
        </div>

        <ul>
            <li><a href="dashboard_admin.php" class="<?= $current_page == 'dashboard_admin.php' ? 'active' : '' ?>"><i class="fas fa-home"></i><span>Dashboard</span></a></li>

            <li class="dropdown <?= $openDropdown ? 'open' : '' ?>">
                <a class="dropdown-toggle" onclick="toggleSubmenu(this)">
                    <i class="fas fa-folder-open"></i><span>Data Pendaftar</span>
                </a>
                <ul class="submenu">
                    <li><a href="data_berkas.php" class="<?= $current_page == 'data_berkas.php' ? 'active' : '' ?>"><i class="fas fa-file-alt"></i><span>Berkas</span></a></li>
                    <li><a href="data_wawancara.php" class="<?= $current_page == 'data_wawancara.php' ? 'active' : '' ?>"><i class="fas fa-comments"></i><span>Wawancara</span></a></li>
                </ul>
            </li>

            <li><a href="cetak_dokumen.php" class="<?= $current_page == 'cetak_dokumen.php' ? 'active' : '' ?>"><i class="fas fa-print"></i><span>Cetak Laporan</span></a></li>
            <li><a href="pengaturan_akun.php" class="<?= $current_page == 'pengaturan_akun.php' ? 'active' : '' ?>"><i class="fas fa-user-cog"></i><span>Pengaturan Akun</span></a></li>
            <li><a href="atur_jadwal_wawancara.php" class="<?= $current_page == 'atur_jadwal_wawancara.php' ? 'active' : '' ?>"><i class="fas fa-calendar"></i><span>Jadwal Wawancara</span></a></li>
            <li><a href="atur_formulir.php" class="<?= $current_page == 'atur_formulir.php' ? 'active' : '' ?>"><i class="fas fa-pen"></i><span>Atur Pendaftaran</span></a></li>
        </ul>
    </div>

    <div class="sidebar-footer">
        &copy; <?= date('Y') ?> Kelompok-3_IK-P2
    </div>
</div>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        document.body.classList.toggle('sidebar-collapsed');
        sidebar.classList.toggle('collapsed');
    }

    function toggleSubmenu(el) {
        const parent = el.parentElement;
        parent.classList.toggle('open');
    }

    document.body.classList.add('sidebar-open');
</script>
