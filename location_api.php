<?php
include 'config/config.php';

if (!isset($_GET['lat'], $_GET['lon'])) {
    exit;
}

$lat = $_GET['lat'];
$lon = $_GET['lon'];

$url = "$baseUrl/weather?lat=$lat&lon=$lon&units=metric&appid=$apiKey";
$data = json_decode(file_get_contents($url), true);

if ($data['cod'] != 200) {
    exit;
}
?>

<div class="location-card">
  <h1><?= $data['name'] ?>, <?= $data['sys']['country'] ?></h1>
  <img src="https://openweathermap.org/img/wn/<?= $data['weather'][0]['icon'] ?>@2x.png">
  <h2><?= round($data['main']['temp']) ?>°C</h2>
  <p><?= ucfirst($data['weather'][0]['description']) ?></p>

  <div class="location-info">
    <div class="info">💧 Kelembaban<br><b><?= $data['main']['humidity'] ?>%</b></div>
    <div class="info">🌬️ Angin<br><b><?= $data['wind']['speed'] ?> m/s</b></div>
    <div class="info">🌡️ Tekanan<br><b><?= $data['main']['pressure'] ?> hPa</b></div>
  </div>
</div>
