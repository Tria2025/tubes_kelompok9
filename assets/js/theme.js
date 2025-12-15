function toggleTheme() {
  document.body.classList.toggle('dark');

  const btn = document.querySelector('.theme-toggle');
  if (document.body.classList.contains('dark')) {
    btn.innerHTML = '☀️ Light';
    localStorage.setItem('theme', 'dark');
  } else {
    btn.innerHTML = '🌙 Dark';
    localStorage.setItem('theme', 'light');
  }
}

// Load theme saat halaman dibuka
(function () {
  const theme = localStorage.getItem('theme');
  if (theme === 'dark') {
    document.body.classList.add('dark');
    const btn = document.querySelector('.theme-toggle');
    if (btn) btn.innerHTML = '☀️ Light';
  }
})();
