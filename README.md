# 🌦️ OpenWeather Hybrid – Web Informasi Cuaca

## 📌 Informasi Proyek

**Nama Proyek** : OpenWeather Hybrid CI/CD
**Jenis Proyek** : Web REST Client (PHP) dengan Implementasi CI/CD
**Public API** : OpenWeather API (https://openweathermap.org/api)
**Tujuan Proyek** : Membangun aplikasi web informasi cuaca berbasis REST Client menggunakan PHP yang menerapkan praktik Continuous Integration dan Continuous Delivery (CI/CD) melalui automated testing (PHPUnit) dan pipeline GitHub Actions, guna memastikan kualitas kode, keamanan API, dan stabilitas aplikasi secara berkelanjutan.

---

## 👥 Anggota Kelompok & Peran

| No | Nama              | NIM        | Peran                      | Tanggung Jawab                                                                                                     |
| -- | ----------------- | ---------- | -------------------------- | ------------------------------------------------------------------------------------------------------------------ |
| 1  | **Tria Silviana** | 2313030025 | **Maintainer / Ketua Tim** | Inisialisasi project, setup struktur & environment, pengembangan core system, integrasi API, code review, merge PR |
| 2  | Ananda Eva        | 2313030100 | Developer                  | Pengembangan halaman **Weather** (pencarian kota & cuaca saat ini)                                                 |
| 3  | Vema Aulia        | 2313030097 | Developer                  | Pengembangan halaman **Forecast** (prakiraan cuaca beberapa hari)                                                  |
| 4  | Diana Rahmawati   | 2313030079 | Developer                  | Pengembangan halaman **About** (dokumentasi & konten)                                                              |

---

## 🎯 Scope / Ruang Lingkup Proyek

### Fitur Utama

* **Home Page**

  * Landing page informasi aplikasi
  * Deteksi lokasi otomatis (Geolocation API)
  * Menampilkan cuaca berdasarkan lokasi pengguna

* **Weather Page**

  * Pencarian cuaca berdasarkan nama kota
  * Menampilkan suhu, cuaca, kelembaban, angin, tekanan udara

* **Forecast Page**

  * Prakiraan cuaca beberapa hari ke depan
  * Tampilan kartu forecast yang interaktif

  **Penggunaan & Endpoint**

  * Halaman `forecast.php` menyediakan form untuk memasukkan nama kota dan menampilkan ringkasan prakiraan harian.
  * Endpoint server: `/forecast_api.php?city={nama_kota}` — merelay permintaan ke OpenWeather `/forecast` dan mengembalikan ringkasan harian (min/max, deskripsi, ikon).
  * Contoh curl:

    ```bash
    curl "http://localhost/tubes_kelompok9/forecast_api.php?city=Jakarta"
    ```

  * Respons JSON (ringkasan):

    ```json
    {
      "city": "Jakarta",
      "country": "ID",
      "forecast": [
        {"date":"2025-12-16","temp":30,"temp_min":27,"temp_max":31,"description":"Cerah","icon":"01d"},
        {...}
      ]
    }
    ```

* **About Page**

  * Deskripsi aplikasi
  * Informasi tim pengembang

* **Dark / Light Mode**

  * Toggle tema
  * Penyimpanan preferensi menggunakan Local Storage

### Keamanan & Praktik Modern

* API Key disimpan dalam file `.env`
* `.env` diabaikan oleh Git (`.gitignore`)
* Konsep CI/CD siap diintegrasikan

---

## 🗂️ Struktur Project

```
tubes_kelompok9/
│     
├── assets/
│   ├── css/
│   │   └── style.css       # Styling global & dark/light mode
│   └── js/
│       ├── location.js     # Geolocation & fetch API cuaca 
│       └── theme.js        # Toggle dark / light mode
│
├── config/
│   └── config.php          # Konfigurasi environment & API
│
├── tests/
│   └── FileTypeTest.php    # Automated testing (File, System & Integration Test)
│
├── index.php               # Halaman Home
├── weather.php             # Halaman Cuaca (Developer)
├── forecast.php            # Halaman Forecast (Developer)
├── about.php               # Halaman About (Developer)
├── location_api.php        # Handler API lokasi otomatis
│
├── phpunit.xml             # Konfigurasi PHPUnit
├── .env                    # API Key (tidak di-push ke GitHub)
├── .gitignore              # Ignore vendor & .env
└── README.md               # Dokumentasi Project
```

---

## 🔄 Alur & Urutan Pengerjaan Proyek

### 1️⃣ Perencanaan

* Menentukan API publik (OpenWeather)
* Menentukan fitur utama dan pembagian tugas
* Menentukan Maintainer dan Developer

### 2️⃣ Inisialisasi (Maintainer)

* Membuat repository GitHub
* Setup struktur folder
* Menambahkan `.gitignore`
* Konfigurasi `.env` & `config.php`

### 3️⃣ Pengembangan Fitur

* **Home & Core System** → Maintainer
* **Weather Page** → Developer
* **Forecast Page** → Developer
* **About Page** → Developer

Setiap developer:

* Bekerja di branch masing-masing
* Membuat Pull Request
* Menunggu review Maintainer

### 4️⃣ Integrasi & Review

* Code review oleh Maintainer
* Merge ke branch `main`
* Testing manual fitur

### 5️⃣ Finalisasi

* Penyesuaian UI/UX
* Dokumentasi README
* Persiapan presentasi

---

## ⚙️ Konfigurasi Environment

### File `.env`

```env
OPENWEATHER_API_KEY=YOUR_API_KEY
```

### File `config/config.php`

* Membaca environment variable
* Validasi API Key
* Menyediakan base URL OpenWeather

---

## 🌐 API yang Digunakan

### Diagram Alur Request API

```
[ Client (Browser) ]
        |
        | 1. Request (klik / search / lokasi)
        v
[ PHP Controller ]  (index.php, weather.php, forecast.php)
        |
        | 2. Load config & API Key (.env)
        v
[ OpenWeather API ]
        |
        | 3. JSON Response (cuaca)
        v
[ PHP Processing ]
        |
        | 4. HTML Output
        v
[ Client (Browser) ]
```

Diagram ini menunjukkan bahwa **client tidak pernah berkomunikasi langsung dengan OpenWeather**, melainkan melalui server PHP untuk menjaga keamanan API Key.

### Endpoint API

* **Current Weather**

  ```
  /weather?q={city}&appid={API_KEY}
  ```

* **Weather by Location**

  ```
  /weather?lat={lat}&lon={lon}&appid={API_KEY}
  ```

* **Forecast**

  ```
  /forecast?q={city}&appid={API_KEY}
  ```

---

## 🧪 Testing (Rencana & Test Case)

Pengujian dilakukan berdasarkan materi **System Test & CI/CD** dan diimplementasikan menggunakan **PHPUnit**.

### Tabel Test Case

| No    | Test Case                   | Jenis        | Skenario                                                                 | Expected Result                                  |
| ----- | --------------------------- | ------------ | ------------------------------------------------------------------------ | ------------------------------------------------ |
| TC-01 | File Exist                  | Black Box    | Mengecek keberadaan file `index.php`                                     | File `index.php` ditemukan                      |
| TC-02 | PHP File Contains PHP Code  | White Box    | Membaca isi file PHP dan mengecek adanya tag `<?php`                     | File mengandung kode PHP                        |
| TC-03 | HTML Structure Validation   | White Box    | Mengecek apakah file PHP mengandung struktur HTML dasar                  | Struktur HTML valid terdeteksi                  |
| TC-04 | API Key Tidak Kosong        | White Box    | Mengecek file `.env` dan variabel `OPENWEATHER_API_KEY`                  | API Key ditemukan dan tidak kosong              |
| TC-05 | Valid JSON Response         | Integration  | Melakukan request ke OpenWeather API                                     | Response berupa JSON valid                      |
| TC-06 | HTTP Response Code 200      | Integration  | Mengecek HTTP response code dari OpenWeather API                         | Status response = 200 OK                        |

Pengujian ini bersifat **incremental** dan akan diperluas setelah seluruh halaman (`weather.php`, `forecast.php`, `about.php`) selesai dikembangkan.

Test case ini dapat dikembangkan menjadi **automatic testing menggunakan PHPUnit dan GitHub Actions**.

---

## 📌 Peran & Tanggung Jawab Maintainer

Peran **Maintainer** tidak hanya menulis kode, tetapi mencakup:

### 1️⃣ Review Pull Request

* Memeriksa struktur folder dan konsistensi kode
* Memastikan fitur sesuai scope
* Mencegah bug sebelum merge ke `main`

### 2️⃣ Keamanan API Key

* Menyimpan API Key di file `.env`
* Menambahkan `.env` ke `.gitignore`
* Menghindari hardcode API Key di source code

### 3️⃣ Standar Coding & Struktur

* Menentukan struktur folder project
* Memisahkan **HTML, CSS, PHP, dan JavaScript** sesuai best practice
* Menyusun `config/config.php` sebagai pusat konfigurasi
* Menjaga konsistensi penamaan file & variabel

### 4️⃣ Arsitektur Client–Server

* Client (Browser) hanya berinteraksi dengan PHP
* PHP bertindak sebagai REST Client ke OpenWeather API
* API Key **tidak pernah terekspos ke client**

> Dengan peran ini, Maintainer bertanggung jawab terhadap **stabilitas, keamanan, arsitektur, dan kualitas keseluruhan project**.

---

## 📜 Penutup

Proyek **OpenWeather Hybrid** dibuat sebagai implementasi REST Client berbasis PHP dengan praktik pengembangan modern, kolaboratif, dan aman.

---

✨ *"Simple Weather, Powerful Insight"*
