// Lightbox untuk galeri foto
(function () {
  var box = document.getElementById('lightbox');
  if (!box) return;
  var big = box.querySelector('img');
  var cap = document.getElementById('lightbox-caption');

  document.querySelectorAll('.gallery-item').forEach(function (item) {
    item.addEventListener('click', function () {
      big.src = item.querySelector('img').src;
      cap.textContent = item.getAttribute('data-caption') || '';
      box.classList.add('show');
    });
  });
  box.addEventListener('click', function () { box.classList.remove('show'); });
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') box.classList.remove('show');
  });
})();
