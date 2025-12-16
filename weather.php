<?php
/**
 * File: weather.php
 * Halaman pencarian cuaca berdasarkan kota
 */
date_default_timezone_set('Asia/Jakarta');
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Weather | OpenWeather Hybrid</title>
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
    <a href="weather.php" class="active">Weather</a>
    <a href="Forecast.php">Forecast</a>
    <a href="About.php">About</a>
    <span class="theme-toggle" onclick="toggleTheme()">🌙 Dark</span>
  </div>
</nav>

<section class="container weather-page">
  <h1>Cari Cuaca Berdasarkan Kota</h1>
  <p>Masukkan nama kota untuk melihat kondisi cuaca terkini</p>

  <!-- FORM SEARCH -->
  <div class="search-box">
    <input type="text" id="cityInput" placeholder="Contoh: Jakarta, Bandung, Surabaya">
    <button onclick="searchWeather()">Cari Cuaca</button>
  </div>

  <!-- HASIL CUACA -->
  <div id="weatherResult" class="weather-result"></div>

  <!-- PRAKIRAAN CUACA -->
  <div id="weatherForecast"></div>
</section>

<script src="assets/js/weather.js"></script>
<script src="assets/js/theme.js"></script>

</body>
</html>
