<?php
$envFile = dirname(__DIR__) . '/.env';

if (!file_exists($envFile)) {
    die('.env TIDAK DITEMUKAN');
}

$lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
foreach ($lines as $line) {
    putenv(trim($line));
}

$apiKey = getenv('OPENWEATHER_API_KEY');

if (!$apiKey) {
    die('API KEY ERROR');
}

$baseUrl = "https://api.openweathermap.org/data/2.5";
