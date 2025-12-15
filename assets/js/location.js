function getLocationWeather(e) {
  e.preventDefault();

  const result = document.getElementById('locationResult');
  result.innerHTML = `
    <div class="location-card">
      <p>Mendeteksi lokasi dan memuat data cuaca...</p>
    </div>
  `;

  if (!navigator.geolocation) {
    result.innerHTML = "Browser tidak mendukung lokasi.";
    return;
  }

  navigator.geolocation.getCurrentPosition(
    position => {
      const { latitude, longitude } = position.coords;

      fetch(`location_api.php?lat=${latitude}&lon=${longitude}`)
        .then(res => res.text())
        .then(html => result.innerHTML = html)
        .catch(() => {
          result.innerHTML =
            "<div class='location-card'>Gagal memuat data cuaca</div>";
        });
    },
    () => {
      result.innerHTML =
        "<div class='location-card'>Izin lokasi ditolak</div>";
    }
  );
}
