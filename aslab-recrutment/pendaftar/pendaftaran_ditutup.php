<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'pendaftar') {
    header("Location: ../auth/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pendaftaran Ditutup</title>
  <link rel="icon" href="../assets/uinsulogo.png" type="image/png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: Arial, sans-serif;
      background: linear-gradient(to bottom, #8d9606 0%, #101e01 60%, #000 100%);
      color: white;
      min-height: 100vh;
      position: relative;
    }
    .hex-pattern {
      position: absolute; top: 0; left: 0; width: 100%; height: 100%;
      background: linear-gradient(to bottom, rgba(0,0,0,0.1) 80%, #000), url('../assets/hex-pattern.jpg') no-repeat center center;
      background-size: cover;
      opacity: 0.2;
      z-index: -1;
    }

    header {
      display: flex; justify-content: space-between; align-items: center;
      background: linear-gradient(to right, #000000, #042f01);
      padding: 10px 30px;
      position: fixed;
      width: 100%;
      border-bottom: 0.5px solid #ffffffbd;
      z-index: 1000;
    }
    .logo {
      display: flex;
      align-items: center;
    }
    .logo img {
      height: 60px;
      margin-right: 10px;
      margin-top: -5px;
      filter: drop-shadow(0 0 0 white) drop-shadow(0 0 2px white);
    }
    .title {
      filter: drop-shadow(0 0 0 black) drop-shadow(0 0 6px rgba(198,212,6,0.564));
      font-weight: bold;
    }
    .auth-group {
      display: flex;
      align-items: center;
      gap: 15px;
    }
    .nav-links {
      display: flex;
      gap: 20px;
      margin-right: 145px;
    }
    .nav-links a {
      position: relative;
      text-decoration: none;
      color: white;
      font-weight: bold;
      transition: color 0.3s ease, transform 0.3s ease;
    }
    .nav-links a::after {
      content: '';
      position: absolute;
      width: 0;
      height: 2px;
      bottom: -4px;
      left: 0;
      background-color: yellow;
      transition: width 0.3s ease;
    }
    .nav-links a:hover {
      color: yellow;
      transform: scale(1.05);
    }
    .nav-links a:hover::after {
      width: 100%;
    }
    .auth2-button button {
      background:rgb(182, 4, 4);
      border: 1px rgb(182, 4, 4);
      color: white;
      padding: 5px 12px;
      border-radius: 5px;
      cursor: pointer;
      transition: all 0.3s ease;
    }
    .auth2-button button:hover {
      color:rgb(255, 255, 255);
      background:rgb(241, 13, 13);
    }
    main {
      padding-top: 130px;
      padding-bottom: 80px;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .status-box {
      padding: 30px;
      border-radius: 12px;
      border: 1px solid rgba(255,255,255,0.2);
      max-width: 700px;
      width: 90%;
      background: rgba(0,0,0,0.4);
      box-shadow: 0 4px 25px rgba(0,0,0,0.4);
      backdrop-filter: blur(10px);
      text-align: center;
      margin-top: 130px;
      margin-bottom: 130px;
    }
    .status-box h2 {
      color: #ff4d4d;
      margin-bottom: 15px;
    }
    .status-box a {
      display: inline-block;
      margin-top: 20px;
      text-decoration: none;
      background-color: #004d00;
      color: white;
      padding: 10px 20px;
      border-radius: 4px;
      transition: background-color 0.3s, transform 0.3s;
    }
    .status-box a:hover {
      background-color: #007700;
      transform: scale(1.05);
    }
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
      color: #FFD700;
      font-weight: bold;
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
    margin-top: -27px;
  }

  .nav-links {
    display: flex;
    flex-wrap: wrap;
    gap: 13px;
    font-size: 13px;
    margin-right: 140px;
    margin-top: 40px;
  }

  .auth2-button {
    margin-top: 0;
    margin-left: 0px;
  }

  .auth2-button button {
    padding: 5px 10px;
    font-size: 12px;
  }

  .hero-section {
    flex-direction: column;
    padding: 20px;
  }

  .intro {
    margin-left: 0;
    padding-right: 0;
  }

  .hero-image {
    margin-left: 0;
    margin-top: 20px;
    min-width: unset;
  }

  .hero-image img {
    height: auto;
    width: 100%;
    max-width: 300px;
  }

  main {
    padding-top: 150px; /* agar tidak ketutup header */
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

  @keyframes slideUpSmooth {
  0% {
    transform: translateY(60px);
    opacity: 0;
    visibility: hidden;
  }
  100% {
    transform: translateY(0);
    opacity: 1;
    visibility: visible;
  }
}

.animate-up {
  opacity: 0;
  visibility: hidden;
  animation: slideUpSmooth 1.0s ease-in-out forwards;
  will-change: transform, opacity, visibility;
}

    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.1s; }
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
      <a href="dashboard_pendaftar.php">Home</a>
      <a href="https://laboratorium.uinsu.ac.id/laboratorium-komputer/">Profil</a>
      <a href="https://wa.me/6282361961201">Contact</a>
    </nav>
    <div class="auth2-button">
      <button onclick="location.href='logout_pendaftar.php'">Logout</button>
    </div>
  </div>
</header>
<main>
  <div class="status-box animate-up delay-1">
    <h2>Pendaftaran Telah Ditutup</h2>
    <p>Mohon maaf, saat ini pendaftaran asisten laboratorium telah ditutup.</p>
    <a href="dashboard_pendaftar.php">← Kembali ke Dashboard</a>
  </div>
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
</body>
</html>
