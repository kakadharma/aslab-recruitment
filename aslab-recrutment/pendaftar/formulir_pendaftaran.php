<?php
session_start();
include '../db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'pendaftar') {
    header("Location: ../auth/login.php");
    exit;
}

$result = $conn->query("SELECT formulir_dibuka FROM pengaturan WHERE id = 1");
$data = $result->fetch_assoc();

if (!$data || $data['formulir_dibuka'] != 1) {
    header("Location: pendaftaran_ditutup.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Formulir Pendaftaran</title>
  <link rel="icon" href="../assets/uinsulogo.png" type="image/png" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: Arial, sans-serif;
      background: linear-gradient(to bottom, #8d9606 0%, #101e01 60%, #000 100%);
      color: white;
      min-height: 100vh;
      position: relative;
      overflow-x: hidden;
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
      padding: 4.5px 30px;
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
      margin-top: -4px;
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
      padding: 5px 11.8px;
      border-radius: 5px;
      cursor: pointer;
      width: 100%;
      transition: all 0.3s ease;
      margin-bottom: 20px
    }
    .auth2-button button:hover {
      color:rgb(255, 255, 255);
      background:rgb(241, 13, 13);
    }
    main {
      padding-top: 130px;
      padding-bottom: 60px;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .form-box {
      background: rgba(255, 255, 255, 0.05);
      padding: 30px;
      border-radius: 10px;
      border: 1px solid rgba(255,255,255,0.2);
      max-width: 650px;
      width: 90%;
      box-shadow: 0 4px 25px rgba(0,0,0,0.4);
      backdrop-filter: blur(10px);
    }
    .form-box h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #fff;
    }
    label {
      display: block;
      margin-top: 12px;
      font-weight: bold;
      color: #d7ffbb;
    }
    input, select {
      width: 40%;
      padding: 10px;
      margin-top: 5px;
      background: rgba(255, 255, 255, 0.1);
      border: none;
      border-radius: 6px;
      color: white;
    }
    input[type="file"] {
      background: none;
      border: none;
      color: white;
    }

.checkmark {
  margin-left: 10px;
  color: #7CFC00;
  font-size: 18px;
  vertical-align: middle;
  display: none;
}

.error-message {
  color: #ff8080;
  font-size: 13px;
  display: none;
}

    button {
      margin-top: 20px;
      width: 15%;
      padding: 15px;
      background-color: #0ba40ba2;
      border: none;
      color: white;
      border-radius: 8px;
      cursor: pointer;
      font-size: 13.5px;
    }
    button:hover {
      background-color: #0ba40b;
      color: #ff0;
      box-shadow: 0 0 12px #0ba40b;
    }
    a.download-link {
      font-size: 14px;
      color: #9fc1ff;
      display: inline-block;
      margin-top: 5px;
      text-decoration: none;
    }
    a.download-link:hover {
      color: #ff0;
    }

input[type="text"],
select {
  padding: 12px 15px;
  margin-top: 6px;
  background: rgba(255, 255, 255, 0.08);
  border: 1px solid rgba(255, 255, 255, 0.2);
  border-radius: 6px;
  color: #fff;
  font-size: 15px;
  transition: all 0.3s ease;
}

input[type="text"]:focus,
select:focus {
  outline: none;
  background: rgba(255, 255, 255, 0.12);
  border-color: #b8ff56;
  box-shadow: 0 0 8px #b8ff56;
}

select option {
  background-color:rgb(2, 20, 0);
  color: #fff;
}

input[type="file"] {
  display: none;
}

.input-lebar-besar {
  width: 49%;
}

.input-lebar-sedang {
  width: 20%;
}

.input-lebar-kecil {
  width: 13%;
}


.custom-file-upload {
  display: inline-block;
  padding: 12px 18px;
  margin-top: 8px;
  margin-bottom: 12px;
  background: rgba(255, 255, 255, 0.06);
  border: 1px dashed rgba(255,255,255,0.4);
  border-radius: 6px;
  color: #c2ffb4;
  font-weight: bold;
  font-size: 14px;
  cursor: pointer;
  transition: all 0.3s ease;
  backdrop-filter: blur(3px);
}
.custom-file-upload:hover {
  background: rgba(255, 255, 255, 0.15);
  color: #fff000;
  border-color: #fff000;
  transform: scale(1.02);
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

.input-lebar-besar {
  width:100%;
}

.input-lebar-sedang {
  width: 60%;
}

.input-lebar-kecil {
  width: 27%;
}

button {
      width: 21%;
    }

  main {
    padding-top: 140px; /* agar tidak ketutup header */
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
  <div class="form-box animate-up delay-1">
    <h2>Formulir Pendaftaran</h2>
    <form action="proses_pendaftaran.php" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
      <label>Nama Lengkap:</label>
      <input type="text" name="nama_lengkap" class="input-lebar-besar" required>

      <label>NIM:</label>
      <input type="text" name="nim" class="input-lebar-sedang" required>

      <label>Semester:</label>
      <select name="semester" class="input-lebar-kecil" required>
        <option value="III">III</option>
        <option value="V">V</option>
      </select>

      <label>Kelas:</label>
      <select name="kelas" class="input-lebar-kecil" required>
        <option value="IK-1">IK-1</option>
        <option value="IK-2">IK-2</option>
        <option value="IK-3">IK-3</option>
        <option value="IK-4">IK-4</option>
        <option value="IK-5">IK-5</option>
      </select>

      <label>IPK:</label>
      <input type="text" name="ipk" class="input-lebar-kecil" required>

      <label for="surat_lamaran">Surat Lamaran (PDF):</label>
<label class="custom-file-upload">
  📎 Unggah Surat Lamaran
  <input type="file" name="surat_lamaran" id="surat_lamaran" accept="application/pdf" required onchange="showCheckmark(this)">
  <span class="checkmark" id="check_surat">✔</span>
</label>
<div class="error-message" id="error_surat">* Harap unggah Surat Lamaran</div>

      </label>
      <a href="../assets/Surat_lamaran_Aslab_UIN.docx" class="download-link" target="_blank">📄 Unduh Template Surat Lamaran (.docx)</a>

      <label for="khs">KHS (PDF):</label>
<label class="custom-file-upload">
  📎 Unggah KHS
  <input type="file" name="khs" id="khs" accept="application/pdf" required onchange="showCheckmark(this)">
  <span class="checkmark" id="check_khs">✔</span>
</label>
<div class="error-message" id="error_khs">* Harap unggah KHS</div>


      <label for="krs">KRS (PDF):</label>
<label class="custom-file-upload">
  📎 Unggah KRS
  <input type="file" name="krs" id="krs" accept="application/pdf" required onchange="showCheckmark(this)">
  <span class="checkmark" id="check_krs">✔</span>
</label>
<div class="error-message" id="error_krs">* Harap unggah KRS</div>


      <label for="cv">CV (PDF):</label>
<label class="custom-file-upload">
  📎 Unggah CV
  <input type="file" name="cv" id="cv" accept="application/pdf" required onchange="showCheckmark(this)">
  <span class="checkmark" id="check_cv">✔</span>
</label>
<div class="error-message" id="error_cv">* Harap unggah CV</div>


      <label for="pas_foto">Pas Foto (PNG/JPG/JPEG):</label>
<label class="custom-file-upload">
  📸 Unggah Pas Foto
  <input type="file" name="pas_foto" id="pas_foto" accept="image/png, image/jpeg" required onchange="showCheckmark(this)">
  <span class="checkmark" id="check_pas">✔</span>
</label>
<div class="error-message" id="error_pas">* Harap unggah Pas Foto</div>

<br>

<div id="notifLengkapi" style="display:none; color:yellow; font-weight:bold; margin-top:10px;">
  ⚠ Harap lengkapi semua dokumen terlebih dahulu.
</div>
      <button type="submit">Kirim</button>
    </form>
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

<script>
  function showCheckmark(input) {
    const checkId = 'check_' + input.id.split('_')[0];
    const errorId = 'error_' + input.id.split('_')[0];
    document.getElementById(checkId).style.display = input.files.length ? 'inline' : 'none';
    document.getElementById(errorId).style.display = 'none';
  }

  function validateForm() {
    const fields = ['surat_lamaran','khs','krs','cv','pas_foto'];
    let valid = true;
    fields.forEach(id => {
      const fileInput = document.getElementById(id);
      const errorText = document.getElementById('error_' + id.split('_')[0]);
      if (!fileInput.files.length) {
        errorText.style.display = 'block';
        valid = false;
      }
    });
    return valid;
  }
</script>


</body>
</html>
