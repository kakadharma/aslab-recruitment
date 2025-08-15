<!-- topbar_admin.php -->
<div class="topbar" id="topbar">
    <div class="admin-actions">
        <i class="fas fa-user-circle"></i>
        <span><?= htmlspecialchars($admin['username']) ?></span>
        <a href="logout_admin.php" title="Logout"><i class="fas fa-sign-out-alt logout-icon"></i></a>
    </div>
</div>

<style>
    .topbar {
        background-color: #fff;
        padding: 15px 20px;
        border-bottom: 1px solid #ccc;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); /* Shadow agar timbul */
        display: flex;
        justify-content: flex-end;
        align-items: center;
        margin-left: 200px;
        transition: margin-left 0.3s ease;
        z-index: 1000;
        position: relative;
    }

    .topbar.collapsed {
        margin-left: 60px;
    }

    .admin-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: bold;
        color:rgb(144, 167, 19);
    }

    .admin-actions i {
        font-size: 18px;
        color:rgb(4, 88, 11);
    }

    .admin-actions span {
        margin-right: 20px; /* Memberi jarak ke ikon logout */
    }

    .admin-actions a {
        text-decoration: none;
        color: #789262;
        transition: transform 0.2s ease, color 0.2s ease;
    }

    .admin-actions a:hover .logout-icon {
        transform: scale(1.2); /* Membesar saat hover */
        color: #4e691f;
    }

    .logout-icon {
        transition: transform 0.2s ease;
    }
</style>

<!-- Font Awesome (jika belum ada di-load sebelumnya) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
