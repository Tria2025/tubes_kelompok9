<?php
date_default_timezone_set('Asia/Jakarta');
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Forecast | OpenWeather Hybrid</title>
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
    <a href="forecast.php" class="active">Forecast</a>
    <a href="about.php">About</a>
    <span class="theme-toggle" onclick="toggleTheme()">🌙 Dark</span>
  </div>
</nav>

<section class="container weather-page">
  <h1>Prakiraan Cuaca Beberapa Hari</h1>
  <p>Masukkan nama kota untuk melihat prakiraan cuaca beberapa hari ke depan (ringkasan harian).</p>

  <!-- FORM SEARCH -->
  <div class="search-box">
    <input type="text" id="cityInput" placeholder="Contoh: Jakarta, Bandung, Surabaya">
    <button onclick="searchForecast()">Lihat Forecast</button>
  </div>

  <!-- HASIL FORECAST -->
  <div id="forecastResult" class="forecast-grid"></div>
</section>

<script src="assets/js/theme.js"></script>
<script>
function searchForecast() {
  const city = document.getElementById('cityInput').value;
  const resultDiv = document.getElementById('forecastResult');

  if (!city) {
    resultDiv.innerHTML = "<p class='error'>Silakan masukkan nama kota.</p>";
    return;
  }

  resultDiv.innerHTML = "<p>Memuat prakiraan cuaca...</p>";

  fetch(`forecast_api.php?city=${encodeURIComponent(city)}`)
    .then(res => res.json())
    .then(data => {
      if (data.error) {
        resultDiv.innerHTML = `<p class='error'>${data.error}</p>`;
        return;
      }

      if (!data.forecast || data.forecast.length === 0) {
        resultDiv.innerHTML = "<p class='error'>Tidak ada data prakiraan untuk kota ini.</p>";
        return;
      }

      // Render cards per day
          let html = '';
          data.forecast.forEach(day => {
            const date = new Date(day.date).toLocaleDateString('id-ID', { weekday:'long', day:'numeric', month:'long' });

            // simple heuristics
            const desc = day.description.toLowerCase();
            let rainProb = 5;
            if (desc.includes('hujan') || desc.includes('rain') || desc.includes('shower')) rainProb = 75;
            if (desc.includes('berawan') || desc.includes('cloud')) rainProb = Math.max(rainProb, 35);
            if (desc.includes('cerah') || desc.includes('clear')) rainProb = 5;

            // insight text
            let insight = '';
            if (day.temp >= 30) insight = 'Cukup panas — hidrasi penting dan hindari sinar matahari langsung pada siang hari.';
            else if (day.temp <= 15) insight = 'Cukup dingin — siapkan jaket hangat jika bepergian pagi atau malam.';
            else if (rainProb > 50) insight = 'Kemungkinan hujan — bawa payung saat keluar.';
            else insight = 'Cuaca mendukung aktivitas luar ruangan.';

            // temp bar: compute percentage position between min/max on a 100% scale
            const min = day.temp_min;
            const max = day.temp_max;
            const val = day.temp;
            let fillPercent = 50;
            if (max !== min) {
              fillPercent = Math.round(((val - min) / (max - min)) * 100);
              fillPercent = Math.max(5, Math.min(95, fillPercent));
            }

            html += `
              <div class="forecast-card" tabindex="0" data-date="${day.date}" data-icon="${day.icon}" data-desc="${day.description}" data-temp="${day.temp}" data-min="${min}" data-max="${max}">
                <div class="card-inner">
                  <div class="card-front">
                    <h4>${date}</h4>
                    <img src="https://openweathermap.org/img/wn/${day.icon}@2x.png" alt="${day.description}">
                    <p class="desc">${day.description}</p>
                    <p class="temp">${Math.round(day.temp)}°C</p>
                    <div class="forecast-meta">
                      <span>Min: <strong>${Math.round(min)}°C</strong></span>
                      <span>Max: <strong>${Math.round(max)}°C</strong></span>
                    </div>
                    <div class="temp-bar"><div class="temp-fill" style="width:${fillPercent}%;"></div></div>
                    <button class="btn-small details-btn">Lihat Detail</button>
                  </div>
                  <div class="card-back">
                    <h4>Insight & Tips</h4>
                    <p class="insight-text">${insight}</p>
                    <ul style="text-align:left; margin-top:8px; list-style:none; padding-left:0">
                      <li>💧 Prob. hujan: <strong>${rainProb}%</strong></li>
                      <li>🌡️ Suhu: <strong>${Math.round(day.temp)}°C</strong> (Min ${Math.round(min)} / Max ${Math.round(max)})</li>
                    </ul>
                    <div style="margin-top:8px">
                      <button class="btn-small back-btn">Kembali</button>
                    </div>
                  </div>
                </div>
              </div>
            `;
          });

      resultDiv.innerHTML = `
        <div class="forecast-header">
          <h2>Prakiraan untuk ${data.city}, ${data.country}</h2>
          <small>Data sumber: OpenWeather (ringkasan harian)</small>
        </div>
        <div class="forecast-grid-inner">${html}</div>
        <div id="forecastModal" class="modal">
          <div class="modal-card">
            <div style="display:flex;justify-content:space-between;align-items:center">
              <h3 id="modalTitle">Detail Hari</h3>
              <button id="modalClose" class="btn-small">Tutup</button>
            </div>
            <div id="modalContent" style="margin-top:10px"></div>
          </div>
        </div>
      `;

         
          document.querySelectorAll('.forecast-card').forEach(card => {
            const detailsBtn = card.querySelector('.details-btn');
            const backBtn = card.querySelector('.back-btn');

            // flip on focus+enter or click anywhere
            card.addEventListener('click', (e) => {
              if (e.target.classList.contains('details-btn') || e.target.classList.contains('back-btn')) return;
              card.classList.toggle('flipped');
            });

            card.addEventListener('keypress', (e) => {
              if (e.key === 'Enter') card.classList.toggle('flipped');
            });

            if (detailsBtn) {
              detailsBtn.addEventListener('click', (ev) => {
                ev.stopPropagation();
                openModalWithHourly(card);
              });
            }
            if (backBtn) {
              backBtn.addEventListener('click', (ev) => {
                ev.stopPropagation();
                card.classList.remove('flipped');
              });
            }
          });

         
          const modal = document.getElementById('forecastModal');
          const modalClose = document.getElementById('modalClose');
          modalClose.addEventListener('click', () => { modal.classList.remove('active'); });

          function openModalWithHourly(card) {
            const date = card.dataset.date;
            const title = new Date(date).toLocaleDateString('id-ID', { weekday:'long', day:'numeric', month:'long' });
            document.getElementById('modalTitle').innerText = `Detail: ${title}`;
            // generate hourly preview (simple interpolation between min and max)
            const min = parseFloat(card.dataset.min);
            const max = parseFloat(card.dataset.max);
            const icon = card.dataset.icon;
            const desc = card.dataset.desc;
            const hours = ['06:00','09:00','12:00','15:00','18:00','21:00'];
            let htmlH = '';
            for (let i=0;i<hours.length;i++){
              const t = min + ( (max-min) * (i/(hours.length-1)) );
              htmlH += `<div class="hourly-item"><div><strong>${hours[i]}</strong> — ${desc}</div><div><img src="https://openweathermap.org/img/wn/${icon}.png" style="vertical-align:middle"> <strong>${Math.round(t)}°C</strong></div></div>`;
            }
            document.getElementById('modalContent').innerHTML = htmlH;
            modal.classList.add('active');
          }
    })
    .catch(() => {
      resultDiv.innerHTML = "<p class='error'>Gagal mengambil data prakiraan cuaca.</p>";
    });
}


document.addEventListener('DOMContentLoaded', function() {
  document.getElementById('cityInput').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') searchForecast();
  });
});
</script>

</body>
</html>
