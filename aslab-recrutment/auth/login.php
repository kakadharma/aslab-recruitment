<?php
session_start();
include('../db.php');

$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $identifier = trim($_POST['identifier']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, username, password FROM admin WHERE username = ?");
    $stmt->bind_param("s", $identifier);
    $stmt->execute();
    $resultAdmin = $stmt->get_result();

    if ($resultAdmin->num_rows > 0) {
        $admin = $resultAdmin->fetch_assoc();
        if (password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['role'] = 'admin';
            header("Location: ../laboran/dashboard_admin.php");
            exit();
        } else {
            $error = "Password admin salah";
        }
    } else {
        $stmt = $conn->prepare("SELECT id, email, nama, password FROM pendaftar WHERE email = ?");
        $stmt->bind_param("s", $identifier);
        $stmt->execute();
        $resultPendaftar = $stmt->get_result();

        if ($resultPendaftar->num_rows > 0) {
            $pendaftar = $resultPendaftar->fetch_assoc();
            if (password_verify($password, $pendaftar['password'])) {
                $_SESSION['user_id'] = $pendaftar['id'];
                $_SESSION['role'] = 'pendaftar';
                $_SESSION['nama'] = $pendaftar['nama'];
                header("Location: ../pendaftar/dashboard_pendaftar.php");
                exit();
            } else {
                $error = "Password pendaftar salah";
            }
        } else {
            $error = "Akun tidak ditemukan.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login</title>
  <link rel="icon" href="../assets/uinsulogo.png" type="image/png" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: Arial, sans-serif;
      background: linear-gradient(to bottom, #8d9606 0%, #101e01 60%, #000 100%);
      color: white;
      position: relative;
      min-height: 100vh;
      overflow-x: hidden;
    }
    .hex-pattern {
      position: absolute;
      top: 0; left: 0; width: 100%; height: 100%;
      background: linear-gradient(to bottom, rgba(0,0,0,0.1) 80%, #000), url('../assets/hex-pattern.jpg') no-repeat center center;
      background-size: cover;
      opacity: 0.2;
      z-index: -1;
      pointer-events: none;
    }
    header {
      display: flex; justify-content: space-between; align-items: center;
      background: linear-gradient(to right, #000000, #042f01);
      padding: 10px 30px;
      z-index: 1000;
      position: fixed;
      width: 100%;
      border-bottom: 0.5px solid #ffffffbd;
    }
    .logo { display: flex; align-items: center; }
    .logo img {
      height: 60px; margin-right: 10px; margin-top: -5px;
      filter: drop-shadow(0 0 0 white) drop-shadow(0 0 2px white);
    }
    .title {
      filter: drop-shadow(0 0 0 black) drop-shadow(0 0 6px rgba(198,212,6,0.564));
      font-weight: bold;
    }
    .auth-group { display: flex; align-items: center; gap: 15px; }
    .nav-links { display: flex; gap: 20px; margin-right: 145px; }
    .nav-links a {
      position: relative; text-decoration: none; color: white;
      font-weight: bold; transition: color 0.3s ease, transform 0.3s ease;
    }
    .nav-links a::after {
      content: ''; position: absolute; width: 0; height: 2px;
      bottom: -4px; left: 0; background-color: yellow;
      transition: width 0.3s ease;
    }
    .nav-links a:hover {
      color: yellow; transform: scale(1.05);
    }
    .nav-links a:hover::after { width: 100%; }
    .auth2-button button {
      background: #067a32; border: 1px solid #067a32; color: white;
      padding: 5px 12px; border-radius: 5px; cursor: pointer;
      transition: all 0.3s ease;
    }
    .auth2-button button:hover {
      color: #03471d; box-shadow: 0 0 0 1px #97a60f; background: #97a60f;
    }

    main {
      padding-top: 100px; padding-bottom: 60px;
      display: flex; justify-content: center; align-items: center;
      flex-direction: column;
    }

    .login-container {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: calc(100vh - 160px);
      padding: 40px 20px;
    }

    .login-card {
  padding: 20px 25px 30px; /* top: 20px */
}

.login-card h2 {
  margin: 0 0 15px; /* hapus margin atas */
}

    .login-card {
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.2);
      padding: 30px 25px;
      border-radius: 12px;
      box-shadow: 0 4px 25px rgba(0,0,0,0.4);
      backdrop-filter: blur(8px);
      width: 100%;
      max-width: 420px;
      text-align: center;
      animation: fadeInUp 0.6s ease-in-out;
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(40px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .login-icon {
  width: 110px;
  margin-bottom: 5px; /* lebih kecil dari sebelumnya */
}


    .login-input {
      width: 60%;
      padding: 12px;
      margin-bottom: 18px;
      border: none;
      border-radius: 8px;
      background: rgba(255, 255, 255, 0.1);
      color: white;
      font-size: 14px;
      transition: background 0.3s ease;
    }

    .login-input:focus {
      outline: none;
      background: rgba(255, 255, 255, 0.15);
    }

    .login-btn {
      width: 20%;
      padding: 12px;
      background-color: #0ba40ba2;
      border: none;
      color: white;
      font-weight: bold;
      border-radius: 8px;
      cursor: pointer;
      font-size: 15px;
      transition: all 0.3s ease;
    }

    .login-btn:hover {
      background-color: #0ba40b;
      color: #ff0;
      box-shadow: 0 0 12px #0ba40b;
    }

    .error {
      color: #ff4d4d;
      margin-bottom: 12px;
      font-size: 13px;
      font-weight: bold;
    }

    .toggle-links {
      text-align: center;
      margin-top: 15px;
    }

    .toggle-links a {
      color: #889a22a5;
      font-weight: bold;
      font-size: 11pt;
      text-decoration: none;
    }

    .toggle-links a:hover { color: #9db41f; }

    footer {
      background: linear-gradient(to bottom, #000000, #021801);
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      padding: 20px 30px;
      font-size: 14px;
      color: white;
      flex-wrap: wrap;
      width: 100%;
      box-sizing: border-box;
      margin-top: auto;
      border-top: 0.5px solid #ffffff;
    }

    .social { margin-top: 20px; }
    .social strong { margin-left: 60px; }
    .social-icons {
      display: flex;
      gap: 35px;
      margin-left: 30px;
      margin-top: 20px;
    }

    .social-icons a {
      color: white;
      font-size: 30px;
      transition: transform 0.3s ease, color 0.3s ease;
    }

    .social-icons a:hover {
      color: yellow;
      transform: scale(1.4);
    }

    .credit {
    text-align: center;
    padding: 10px;
    font-size: 14px;
    color: #333;
    margin-top: 60px;
}

.credit a {
    color: inherit;
    text-decoration: none;
    font-weight: normal;
    transition: all 0.3s ease;
}

.credit a:hover {
    color: #FFD700;          /* Warna kuning */
    font-weight: bold;       /* Jadi tebal saat hover */
    text-decoration: none;   /* Tidak ada underline */
}

    .kampus { margin-right: -25px; }

    .kampus i {
      margin-right: 10px;
      color: yellowgreen;
    }

    .email-link {
      color: white;
      text-decoration: none;
      transition: color 0.3s ease;
    }

    .email-link:hover { color: yellow; }

@media (max-width: 768px) {
  header {
    flex-direction: column;
    align-items: flex-start;
    padding: 10px 20px;
  }

  .logo {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .logo img {
    height: 45px;
    margin-right: 10px;
  }

  .title {
    text-align: left;
    font-size: 11px;
    line-height: 1.2;
    max-width: 160px;
    margin-right: 155px;
  }

  .auth-group {
    flex-direction: row;
    flex-wrap: wrap;
    align-items: center;
    width: 100%;
    margin-top: 8px;
  }

  .nav-links {
    display: flex;
    flex-wrap: wrap;
    gap: 13px;
    font-size: 13px;
    margin-right: 71px;
  }

  .auth2-button {
    margin-top: 0;
    margin-left: 0px;
  }

  .auth2-button button {
    padding: 5px 10px;
    font-size: 12px;
  }

  main {
    padding-top: 140px; /* agar tidak ketutup header */
  }

 .login-btn {
      width: 30%;
 }

  footer {
    flex-direction: column;
    gap: 20px;
    padding: 20px;
    font-size: 13px;
    text-align: left;
  }

  .social strong{
    margin-left: 15px;

  }

  .social-icons {
    margin-left: 0;
    gap: 20px;
    margin-bottom: -60px;
  }

  .kampus {
    margin-right: 0;
  }
}

  </style>
</head>
<body>
  <div class="hex-pattern"></div>
  <header>
    <div class="logo">
      <img src="../assets/uinsulogo.png" alt="Logo UIN">
      <div class="title">
        <div>REKRUTMEN______________________</div>
        <div>ASISTEN LABORATORIUM KOMPUTER</div>
      </div>
    </div>
    <div class="auth-group">
      <nav class="nav-links">
        <a href="../index.php">Home</a>
        <a href="https://laboratorium.uinsu.ac.id/laboratorium-komputer/">Profil</a>
        <a href="https://wa.me/6282361961201">Contact</a>
      </nav>
      <div class="auth2-button">
        <button onclick="location.href='./login.php'">Login</button>
      </div>
      <div class="auth2-button">
        <button onclick="location.href='./register_pendaftar.php'">Sign Up</button>
      </div>
    </div>
  </header>

  <main>
    <section class="login-container">
      <div class="login-card">
        <img src="../assets/frame_121.png" alt="User Icon" class="login-icon" />
        <div class="form-container active">
          <h2>LOGIN</h2>
          <?php if ($error): ?>
            <div class="error"><?= $error ?></div>
          <?php endif; ?>
          <form method="POST">
            <input name="identifier" placeholder="Username atau Email" required class="login-input" />
            <div style="position: relative; display: inline-block; width: 60%;">
  <input id="passwordInput" name="password" type="password" placeholder="Password" required class="login-input" style="width: 100%; padding-right: 40px;" />
  <i class="fas fa-eye" id="togglePassword" style="position: absolute; right: 12px; top: 12px; cursor: pointer; color: #ccc;"></i>
</div>
<br>
            <button type="submit" class="login-btn">LOGIN</button>
          </form>
          <div class="toggle-links">
            <p>Belum punya akun? <a href="register_pendaftar.php">SIGN UP</a></p>
          </div>
        </div>
      </div>
    </section>
  </main>

  <footer>
    <div class="social">
      <strong>SOCIAL MEDIA</strong>
      <div class="social-icons">
        <a href="https://www.instagram.com/labkomputer.uinsu"><i class="fab fa-instagram"></i></a>
        <a href="https://youtube.com/@saintekuinsu7764?feature=shared"><i class="fab fa-youtube"></i></a>
        <a href="https://wa.me/6282361961201"><i class="fab fa-whatsapp"></i></a>
      </div>
    </div>

    <div class="credit">
    © 2025. <a href="../assets/Proposal_Kelompok3_IKP2.pdf" target="_blank">KELOMPOK3_IK-P2</a>
</div>

    <div class="kampus">
      <strong>TENTANG KAMPUS</strong><br><br>
      <p><i class="fas fa-map-marker-alt"></i><a href="https://maps.app.goo.gl/3AsJcEaeHjbncWho9" class="email-link">&nbsp;&nbsp;Jl. Lap. Golf No.120, Kp. Tengah, Kec. Pancur Batu,<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kabupaten Deli Serdang, Sumatera Utara 20353</a></p><br>
      <p><i class="fas fa-envelope"></i><a href="mailto:laboratorium@uinsu.ac.id" class="email-link">&nbsp;laboratorium@uinsu.ac.id</a></p>
    </div>
  </footer>

  <script>
  const togglePassword = document.getElementById('togglePassword');
  const passwordInput = document.getElementById('passwordInput');

  togglePassword.addEventListener('click', function () {
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);

    this.classList.toggle('fa-eye');
    this.classList.toggle('fa-eye-slash');
  });
</script>

</body>
</html>
