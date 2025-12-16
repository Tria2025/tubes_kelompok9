<?php
header('Content-Type: application/json');

require __DIR__ . '/config/config.php'; // API KEY disimpan aman

if (!isset($_GET['city'])) {
    echo json_encode(['error' => 'Nama kota tidak ditemukan']);
    exit;
}

$city = urlencode($_GET['city']);
$apiKey = getenv('OPENWEATHER_API_KEY');

// Current weather
$currentUrl = "https://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$apiKey}&units=metric&lang=id";
$currentResponse = file_get_contents($currentUrl);

if ($currentResponse === false) {
    echo json_encode(['error' => 'Gagal menghubungi OpenWeather API']);
    exit;
}

$currentData = json_decode($currentResponse, true);

if ($currentData['cod'] != 200) {
    echo json_encode(['error' => 'Kota tidak ditemukan']);
    exit;
}

echo json_encode([
    'city' => $currentData['name'],
    'country' => $currentData['sys']['country'],
    'temp' => $currentData['main']['temp'],
    'description' => ucfirst($currentData['weather'][0]['description']),
    'humidity' => $currentData['main']['humidity'],
    'pressure' => $currentData['main']['pressure'], // Tambahkan tekanan udara
    'wind' => $currentData['wind']['speed'],
    'icon' => $currentData['weather'][0]['icon']
]);
