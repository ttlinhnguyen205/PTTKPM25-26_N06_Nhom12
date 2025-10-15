import '../../css/pages/products-index.css';

// ====== Check-all checkbox ======
const master = document.getElementById('checkAll');
if (master) {
  master.addEventListener('change', function () {
    document
      .querySelectorAll('input[name="ids[]"]')
      .forEach(cb => cb.checked = this.checked);
  });
}