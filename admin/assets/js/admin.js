// Tutup sidebar saat klik di luar (mobile) & sembunyikan notifikasi otomatis
document.addEventListener('click', e => {
  const sb = document.getElementById('sidebar');
  if (sb && sb.classList.contains('open') && !sb.contains(e.target) && !e.target.closest('.burger')) sb.classList.remove('open');
});
setTimeout(() => document.querySelectorAll('.alert.ok').forEach(a => a.style.display = 'none'), 4000);
