<?php
use PHPUnit\Framework\TestCase;

class FileTypeTest extends TestCase
{
    /** Daftar file yang diuji saat ini hanya index.php karena
     * file lain belum dikembangkan
     * */
    private $projectFiles = [
    'index.php',
    'weather.php',
    'forecast.php',
    'about.php'
    ];

    /** TestCase-01: File Exist (Memastikan file ada) */
    public function test_files_exist()
    {
        foreach ($this->projectFiles as $file) {
            $this->assertFileExists($file, 
            "❌ File $file tidak ditemukan!");
        }
    }

    /** TestCase-02: PHP File Contains PHP Code 
     * (Memastikan file PHP mengandung kode PHP) 
     * */
    public function test_php_file_contain_php_code()
    {
        foreach ($this->projectFiles as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                $content = file_get_contents($file);
                
                $this->assertStringContainsString('<?php',
                $content, "❌ File $file tidak mengandung kode PHP!");
            }
        }
    }

    /** TestCase-03: HTML Files Contain HTML Tags 
     * (Memastikan file PHP mengandung HTML valid) 
     * */
    public function test_html_files_contain_html_tags()
    {
        foreach ($this->projectFiles as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                $content = file_get_contents($file);
                
                $this->assertMatchesRegularExpression(
                    '/<html|<head|<body|<div|<section|<p|<span/i',
                    $content,
                    "❌ File $file tidak mengandung struktur HTML!"
                );
            }
        }
    }

    /** TestCase-04: Config File Contains API Key
     * (API Key tidak kosong (.env)) 
     * */
    public function test_api_key_not_empty()
    {
        $envFile = '.env';
        $this->assertFileExists(
            $envFile, 
            "❌ File $envFile tidak ditemukan!"
        );

        $content = file_get_contents($envFile);
        $this->assertStringContainsString(
            'OPENWEATHER_API_KEY=', 
            $content, 
            "❌ API Key tidak ditemukan di $envFile!"
        );
    }

    /** TestCase-05: API Response is Valid JSON
     * (Valid JSON Response dari OpenWeather API) 
     * */
    public function test_valid_json_response()
    {
        include 'config/config.php';

        $url = "$baseUrl/weather?q=Jakarta&units=metric&appid=$apiKey";
        $response = file_get_contents($url);

        $this->assertJson(
            $response, 
            "❌ Response API bukan JSON Valid!"
        );
    }

    /** TestCase-06: API Response Code 200
     * (HTTP Response Code 200) 
     * */
    public function test_http_response_code_200()
    {
        include 'config/config.php';

        $url = "$baseUrl/weather?q=Jakarta&appid=$apiKey";
        $headers = get_headers($url);

        $this->assertStringContainsString(
            '200 OK', 
            $headers[0], 
            "❌ HTTP Response bukan 200 OK!"
        );
    }
    
}