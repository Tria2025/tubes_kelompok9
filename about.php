<?php
date_default_timezone_set('Asia/Jakarta');

// Aplikasi metadata dan konfigurasi (tidak menampilkan API key)
$appName = 'OpenWeather Hybrid';
$appVersion = '1.0.0';

// Muat konfigurasi jika tersedia untuk memenuhi persyaratan testing
@include_once __DIR__ . '/config/config.php';
$apiConfigured = (isset($apiKey) && $apiKey) ? true : false;
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tentang | OpenWeather Hybrid</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="light">

<nav class="light">
  <div class="logo">
    <img src="https://openweathermap.org/themes/openweathermap/assets/img/logo_white_cropped.png" height="36">
    <div style="margin-left:10px">
      <h2 class="nav-title">OpenWeather Hybrid</h2>
      <div class="nav-sub">REST Client Project</div>
    </div>
  </div>
  <div>
    <a href="index.php">Home</a>
    <a href="weather.php">Weather</a>
    <a href="forecast.php">Forecast</a>
    <a href="about.php" class="active">About</a>
    <span class="theme-toggle" onclick="toggleTheme()">🌙 Dark</span>
  </div>
</nav>

<section class="container about-page">
  <div class="hero" style="grid-template-columns:1fr; padding:40px 0 10px;">
    <div>
      <h1 style="font-size:34px;">Tentang OpenWeather Hybrid</h1>
      <p style="margin-top:12px; max-width:760px;">Aplikasi interaktif ini menampilkan data cuaca real-time menggunakan OpenWeather API. Dirancang responsif, ringan, dan mudah diperluas untuk kebutuhan pembelajaran atau prototipe.</p>
      <div style="margin-top:18px">
        <a href="weather.php" class="btn-primary">Coba Sekarang</a>
        <a href="#team" style="margin-left:12px; color:#2563eb; font-weight:700; text-decoration:none;">Lihat Tim</a>
      </div>
    </div>
  </div>

  <div class="feature-grid" style="margin-top:30px;">
    <div class="feature-card">
      <h3>Fitur Interaktif</h3>
      <p>Deteksi lokasi otomatis, pencarian kota, ikon cuaca, dan respons cepat dengan desain modern.</p>
    </div>
    <div class="feature-card">
      <h3>Server-side API</h3>
      <p>Endpoint internal menjaga API key tetap aman dan menyederhanakan panggilan dari front-end.</p>
    </div>
    <div class="feature-card">
      <h3>Desain</h3>
      <p>Tema terang/gelap, kartu responsif, dan transisi halus untuk pengalaman pengguna yang nyaman.</p>
    </div>
  </div>

  <h2 id="team" style="margin-top:36px;">Tim Pengembang</h2>
  <div class="feature-grid" style="margin-top:12px;">
    <div class="feature-card" style="text-align:center">
      <img src="https://ui-avatars.com/api/?name=Tria+Silviana&background=F97316&color=fff&size=96" style="border-radius:50%; margin-bottom:12px">
      <h4>Tria Silviana</h4>
      <div style="color:#6b7280">2313030025 — Maintener</div>
    </div>
    <div class="feature-card" style="text-align:center">
      <img src="https://ui-avatars.com/api/?name=Ananda+Eva&background=2563eb&color=fff&size=96" style="border-radius:50%; margin-bottom:12px">
      <h4>Ananda Eva D. M</h4>
      <div style="color:#6b7280">2313030100 — Developer</div>
    </div>
    <div class="feature-card" style="text-align:center">
      <img src="https://ui-avatars.com/api/?name=Vema+Aulia&background=10b981&color=fff&size=96" style="border-radius:50%; margin-bottom:12px">
      <h4>Vema Aulia</h4>
      <div style="color:#6b7280">2313030097 — Developer</div>
    </div>
    <div class="feature-card" style="text-align:center">
      <img src="https://ui-avatars.com/api/?name=Diana+Rahmawati&background=8b5cf6&color=fff&size=96" style="border-radius:50%; margin-bottom:12px">
      <h4>Diana Rahmawati</h4>
      <div style="color:#6b7280">2313030079 — Developer</div>
    </div>
  </div>

  <h2 style="margin-top:36px;">Penjelasan & Demo</h2>
  <div class="insight-card">
    <h3 style="margin-bottom:8px">Bagaimana Aplikasi Bekerja</h3>
    <p>Front-end (JavaScript) memanggil endpoint internal pada server. Endpoint ini akan meneruskan permintaan ke OpenWeather API menggunakan API key yang tersimpan di server. Hasilnya dikembalikan sebagai JSON atau potongan HTML untuk ditampilkan di halaman.</p>

    <div style="margin-top:14px">
      <button class="btn-primary" onclick="document.getElementById('sample').scrollIntoView({behavior:'smooth'})">Lihat Contoh Panggilan API</button>
    </div>
  </div>

  <div id="sample" class="insight-card">
    <h3>Contoh Pemanggilan (curl)</h3>
    <pre id="curlExample" style="background:#0f172a;color:#e5e7eb;padding:12px;border-radius:8px;overflow:auto">curl "https://api.openweathermap.org/data/2.5/weather?q=Jakarta&units=metric&appid=YOUR_API_KEY"</pre>
    <div style="margin-top:10px">
      <button onclick="copyCurl()" class="btn-primary">Salin Contoh</button>
      <span id="copyStatus" style="margin-left:12px;color:#10b981;font-weight:700;display:none">Disalin!</span>
    </div>
  </div>

  <h2 style="margin-top:24px;">Tentang OpenWeather</h2>
  <div class="feature-card" style="margin-top:12px">
    <p>OpenWeather menyediakan data cuaca global: current weather, forecast, dan historical. Gunakan API key, atur parameter seperti <em>q</em> (city), <em>lat</em>, <em>lon</em>, dan <em>units</em> agar data sesuai kebutuhan.</p>
    <details style="margin-top:8px">
      <summary style="cursor:pointer">Keterangan singkat endpoint</summary>
      <ul style="margin-top:10px">
        <li><strong>/weather</strong> — data cuaca saat ini berdasarkan kota atau koordinat.</li>
        <li><strong>/forecast</strong> — prakiraan cuaca (3/5 hari) tergantung paket.</li>
        <li><strong>icon</strong> — kode ikon cuaca yang dapat diambil dari openweathermap.org/img/wn/xxx@2x.png.</li>
      </ul>
    </details>
  </div>

</section>

<script src="assets/js/theme.js"></script>
<script>
  function copyCurl() {
    const text = document.getElementById('curlExample').innerText;
    navigator.clipboard.writeText(text).then(() => {
      const status = document.getElementById('copyStatus');
      status.style.display = 'inline';
      setTimeout(() => status.style.display = 'none', 1800);
    });
  }
</script>

</body>
</html>
