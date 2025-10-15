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

document.addEventListener('DOMContentLoaded', () => {
  const sortSelect = document.getElementById('sortSelect');
  const form = document.getElementById('filterForm');
  if (sortSelect && form) {
    sortSelect.addEventListener('change', () => form.submit());
  }
});

