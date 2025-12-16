<?php
header('Content-Type: application/json');

require __DIR__ . '/config/config.php';

if (!isset($_GET['city']) || !trim($_GET['city'])) {
    echo json_encode(['error' => 'Nama kota tidak ditemukan']);
    exit;
}

$city = urlencode($_GET['city']);

$url = "$baseUrl/forecast?q={$city}&appid={$apiKey}&units=metric&lang=id";
$resp = @file_get_contents($url);

if ($resp === false) {
    echo json_encode(['error' => 'Gagal menghubungi OpenWeather API']);
    exit;
}

$data = json_decode($resp, true);

if (!isset($data['cod']) || (int)$data['cod'] !== 200) {
    $message = isset($data['message']) ? $data['message'] : 'Kota tidak ditemukan';
    echo json_encode(['error' => $message]);
    exit;
}

// Group by date, compute min/max and pick representative (prefer 12:00)
$grouped = [];
foreach ($data['list'] as $item) {
    $dt = $item['dt_txt']; // format: YYYY-MM-DD HH:MM:SS
    $date = substr($dt, 0, 10);
    $time = substr($dt, 11);

    if (!isset($grouped[$date])) {
        $grouped[$date] = [
            'representative' => $item,
            'temp_min' => $item['main']['temp_min'],
            'temp_max' => $item['main']['temp_max'],
            'has_noon' => ($time === '12:00:00')
        ];
    } else {
        // update min/max
        if ($item['main']['temp_min'] < $grouped[$date]['temp_min']) {
            $grouped[$date]['temp_min'] = $item['main']['temp_min'];
        }
        if ($item['main']['temp_max'] > $grouped[$date]['temp_max']) {
            $grouped[$date]['temp_max'] = $item['main']['temp_max'];
        }

        // prefer 12:00 item as representative
        if ($time === '12:00:00') {
            $grouped[$date]['representative'] = $item;
            $grouped[$date]['has_noon'] = true;
        }
    }
}

// Build result array (limit to next 5 days)
$forecast = [];
$count = 0;
foreach ($grouped as $date => $info) {
    if ($count >= 5) break;
    $rep = $info['representative'];
    $forecast[] = [
        'date' => $date,
        'temp' => $rep['main']['temp'],
        'temp_min' => $info['temp_min'],
        'temp_max' => $info['temp_max'],
        'description' => ucfirst($rep['weather'][0]['description']),
        'icon' => $rep['weather'][0]['icon']
    ];
    $count++;
}

echo json_encode([
    'city' => $data['city']['name'],
    'country' => $data['city']['country'],
    'forecast' => $forecast
]);
