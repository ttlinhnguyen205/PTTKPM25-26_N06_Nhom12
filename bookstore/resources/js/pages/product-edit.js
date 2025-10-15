import '../../css/pages/product-form.css';

// code xử lý giá + preview ảnh
const nfVN = new Intl.NumberFormat('vi-VN');
const priceDisplay = document.getElementById('price_display');
const priceHidden  = document.getElementById('price');

function digitsOnly(s){ return (s || '').toString().replace(/[^\d]/g, ''); }

if (priceDisplay && priceHidden) {
  (function initPrice(){
    const val = digitsOnly(priceHidden.value);
    priceDisplay.value = val ? nfVN.format(parseInt(val, 10)) : '';
  })();

  priceDisplay.addEventListener('input', function(){
    const raw = digitsOnly(this.value);
    if(!raw){ this.value = ''; priceHidden.value = ''; return; }
    const num = parseInt(raw, 10);
    this.value = nfVN.format(num);
    priceHidden.value = num;
  });

  document.getElementById('editProductForm')?.addEventListener('submit', function(){
    const raw = digitsOnly(priceDisplay.value);
    priceHidden.value = raw ? parseInt(raw, 10) : '';
  });
}

// preview ảnh
window.previewSingle = function(input){
  const file = input.files && input.files[0];
  if(!file) return;
  const img = document.getElementById('previewImg');
  const txt = document.getElementById('dropText');
  const url = URL.createObjectURL(file);
  img.src = url;
  img.classList.remove('d-none');
  if (txt) txt.classList.add('d-none');
  img.onload = () => URL.revokeObjectURL(url);
};
