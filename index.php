<?php
/**
 * OpenWeather Hybrid CI/CD
 * File: index.php
 * 
 * Fungsi:
 * - Landing page aplikasi
 * - Entry point web (PHP-based)
 * - Memastikan environment berjalan normal
 */

date_default_timezone_set('Asia/Jakarta');

// Informasi aplikasi (bisa dipakai nanti)
$appName = "OpenWeather Hybrid CI/CD";
$appVersion = "1.0.0";

// Cek apakah config ada (tidak error meski belum dipakai penuh)
$configPath = __DIR__ . '/config/config.php';
$configLoaded = file_exists($configPath);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>OpenWeather | Informasi Cuaca</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="light">

<nav class="light">
  <div class="logo">
    <img src="https://openweathermap.org/themes/openweathermap/assets/img/logo_white_cropped.png" height="36">
    <div style="margin-left:10px">
      <h2 class="nav-title">OpenWeather Hybrid</h1>
      <div class="nav-sub">REST Client Project</div>
    </div>
  </div>
  <div>
    <a href="index.php">Home</a>
    <a href="weather.php">Weather</a>
    <a href="forecast.php">Forecast</a>
    <a href="about.php">About</a>
    <span class="theme-toggle" onclick="toggleTheme()">🌙 Dark</span>
  </div>
</nav>

<!-- HERO -->
<section class="hero container">
  <div>
    <h1>Informasi Cuaca Akurat & Real-Time</h1>
    <p>
      Pantau kondisi cuaca terkini, suhu, kelembaban, dan prakiraan
      berbasis data OpenWeather API secara cepat, aman, dan profesional.
    </p>
    <div class="hero-buttons">
      <a href="#" class="btn-primary" onclick="getLocationWeather(event)">Cuaca Lokasi Saya</a>
    </div>
  </div>

  <img src="https://cdn-icons-png.flaticon.com/512/1779/1779940.png" width="100%">

  <!-- HASIL CUACA LOKASI -->
  <div id="locationResult" class="location-result"></div>


</section>

<!-- FEATURES -->
<section class="features">
  <h2>Fitur Unggulan</h2>
  <div class="feature-grid container">
    <div class="feature-card">
      <h3>🌍 Lokasi Otomatis</h3>
      <p>Menampilkan cuaca berdasarkan lokasi Anda secara otomatis.</p>
    </div>
    <div class="feature-card">
      <h3>🔍 Pencarian Kota</h3>
      <p>Cari informasi cuaca kota mana pun di seluruh dunia.</p>
    </div>
    <div class="feature-card">
      <h3>📊 Data Akurat</h3>
      <p>Menggunakan OpenWeather API dengan data real-time.</p>
    </div>
    <div class="feature-card">
      <h3>🔐 Aman & CI/CD</h3>
      <p>API key disimpan aman menggunakan environment & GitHub Secrets.</p>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="cta">
  <h2>Mulai Pantau Cuaca Sekarang</h2>
  <p>Akses informasi cuaca kapan saja dengan tampilan profesional.</p>
  <a href="weather.php">Mulai Sekarang</a>
</section>

<script src="assets/js/location.js"></script>
<script src="assets/js/theme.js"></script>

</body>
</html>
