<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Registrasi Pendaftar</title>
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
      padding-top: 100px;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
    }

    .register-container {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: calc(100vh - 160px);
      padding: 40px 20px;
    }

    .register-card h2 {
        margin: 0 0 15px;
    }

    .register-card {
  padding: 20px 25px 30px; 
}

    .register-card {
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
      from { opacity: 0; transform: translateY(40px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .register-icon {
      width: 110px;
      margin-bottom: 5px;
    }

    .register-card h2 {
      margin-bottom: 20px;
    }

    .register-input {
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

    .register-input:focus {
      outline: none;
      background: rgba(255, 255, 255, 0.15);
    }

    .register-btn {
      width: 25%;
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

    .register-btn:hover {
      background-color: #0ba40b;
      color: yellow;
      box-shadow: 0 0 12px #0ba40b;
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

 .register-btn {
      width:30%;
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
    <section class="register-container">
      <div class="register-card">
        <img src="../assets/frame_121.png" alt="Register Icon" class="register-icon" />
        <h2>REGISTER</h2>
        <?php
if (isset($_GET['error'])) {
  if ($_GET['error'] == 'email') {
    echo '<div style="color: yellow; margin-bottom: 10px;">Email sudah digunakan</div>';
  } elseif ($_GET['error'] == 'empty') {
    echo '<div style="color: yellow; margin-bottom: 10px;">Semua field wajib diisi</div>';
  } elseif ($_GET['error'] == 'insert') {
    echo '<div style="color: yellow; margin-bottom: 10px;">Terjadi kesalahan saat mendaftar</div>';
  }
}
?>
        <form action="proses_register.php" method="POST">
          <input type="text" name="nama" placeholder="Nama Lengkap" required class="register-input" />
          <input type="email" name="email" placeholder="Email Aktif" required class="register-input" />
          <div style="position: relative; display: inline-block; width: 60%;">
  <input id="passwordInput" name="password" type="password" placeholder="Password" required class="register-input" style="width: 100%; padding-right: 40px;" />
  <i class="fas fa-eye" id="togglePassword" style="position: absolute; right: 12px; top: 12px; cursor: pointer; color: #ccc;"></i>
</div>
<br>
          <button type="submit" class="register-btn">DAFTAR</button>
        </form>
        <div class="toggle-links">
          <p>Sudah punya akun? <a href="login.php">LOGIN</a></p>
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
