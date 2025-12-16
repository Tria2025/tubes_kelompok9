function searchWeather() {
  const city = document.getElementById("cityInput").value;
  const resultDiv = document.getElementById("weatherResult");

  if (!city) {
    resultDiv.innerHTML = "<p class='error'>Silakan masukkan nama kota.</p>";
    return;
  }

  resultDiv.innerHTML = "<p>Memuat data cuaca...</p>";

  fetch(`weather_api.php?city=${encodeURIComponent(city)}`)
    .then((response) => response.json())
    .then((data) => {
      if (data.error) {
        resultDiv.innerHTML = `<p class="error">${data.error}</p>`;
        return;
      }

      // Fungsi untuk menghasilkan insight cuaca berdasarkan data
      const generateInsight = (temp, description, humidity, wind) => {
        let insight = "";
        if (temp > 30) {
          insight =
            "Suhu cukup panas hari ini. Pastikan minum air yang cukup dan hindari aktivitas di luar ruangan pada siang hari.";
        } else if (temp < 15) {
          insight =
            "Suhu cukup dingin. Gunakan pakaian hangat untuk menjaga tubuh tetap nyaman.";
        } else if (description.toLowerCase().includes("hujan")) {
          insight =
            "Kemungkinan hujan. Jangan lupa bawa payung atau jas hujan saat keluar rumah.";
        } else if (humidity > 80) {
          insight =
            "Kelembaban udara tinggi. Ini bisa membuat udara terasa lebih lembab, perhatikan kesehatan pernapasan.";
        } else if (wind > 10) {
          insight =
            "Angin cukup kencang. Jika beraktivitas di luar, pastikan pakaian tidak mudah terbang.";
        } else {
          insight =
            "Cuaca terlihat baik hari ini. Cocok untuk beraktivitas di luar ruangan.";
        }
        return insight;
      };

      const insight = generateInsight(
        data.temp,
        data.description,
        data.humidity,
        data.wind
      );

      // Waktu update
      const updateTime = new Date().toLocaleString("id-ID", {
        year: "numeric",
        month: "long",
        day: "numeric",
        hour: "2-digit",
        minute: "2-digit",
      });

      resultDiv.innerHTML = `
        <div class="weather-card">
          <div class="location-header">
            <h2>${data.city}, ${data.country}</h2>
            <small>Diperbarui: ${updateTime}</small>
          </div>
          <div class="weather-main">
            <img src="https://openweathermap.org/img/wn/${
              data.icon
            }@4x.png" alt="${data.description}">
            <div class="temp-section">
              <p class="temp">${Math.round(data.temp)}°C</p>
              <p class="description">${data.description}</p>
            </div>
          </div>
          <div class="weather-details">
            <div class="detail-item">
              <span class="icon">💧</span>
              <div>
                <p>Kelembaban</p>
                <p><strong>${data.humidity}%</strong></p>
              </div>
            </div>
            <div class="detail-item">
              <span class="icon">🌬️</span>
              <div>
                <p>Angin</p>
                <p><strong>${data.wind} m/s</strong></p>
              </div>
            </div>
            <div class="detail-item">
              <span class="icon">🌡️</span>
              <div>
                <p>Tekanan</p>
                <p><strong>${data.pressure} hPa</strong></p>
              </div>
            </div>
          </div>
        </div>

        <!-- Insight Cuaca -->
        <div class="insight-card">
          <h3>💡 Insight Cuaca</h3>
          <p>${insight}</p>
        </div>
      `;
    })
    .catch(() => {
      resultDiv.innerHTML = "<p class='error'>Gagal mengambil data cuaca.</p>";
    });
}

// Tambahkan event listener untuk input agar bisa search dengan Enter
document.addEventListener("DOMContentLoaded", function () {
  document
    .getElementById("cityInput")
    .addEventListener("keypress", function (event) {
      if (event.key === "Enter") {
        searchWeather();
      }
    });
});
