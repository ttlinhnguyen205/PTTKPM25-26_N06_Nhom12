@extends('layouts.admin')

@section('title', 'Cập nhật sản phẩm')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

<style>
  .ui-card{border:1px solid #e5e7eb;border-radius:16px;background:#fff}
  .ui-section{border:1px solid #e5e7eb;border-radius:16px;background:#fff}
  .fld{border-radius:12px;padding:10px 14px;border:1px solid #e5e7eb}
  .fld:focus{outline:none;border-color:#3b82f6;box-shadow:0 0 0 .15rem rgba(59,130,246,.15)}
  .lbl{font-weight:600;font-size:.875rem;color:#374151}
  .hint{font-size:.85rem;color:#6b7280}
  .drop{border:2px dashed #cfe0ff;background:#f3f7ff;border-radius:12px;
        height:200px;display:flex;align-items:center;justify-content:center;
        flex-direction:column;gap:8px;color:#3b82f6;cursor:pointer;overflow:hidden}
  .btn-pill{border-radius:12px;padding:.625rem 1rem}
  .preview-img{max-height:180px;border-radius:12px;object-fit:contain;}
  .input-group .input-group-text{border-radius:12px 0 0 12px;border:1px solid #e5e7eb;background:#f8fafc}
  .currency-input{border-radius:0 12px 12px 0;border:1px solid #e5e7eb;border-left:0}
  .currency-input:focus{outline:none;border-color:#3b82f6;box-shadow:0 0 0 .15rem rgba(59,130,246,.15)}
</style>

<div class="container-fluid px-3 px-md-4">
  <h4 class="fw-bold mb-3">Cập nhật sản phẩm</h4>

  {{-- Thông báo thành công (nếu có) --}}
  @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  {{-- Hiển thị lỗi --}}
  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" id="editProductForm">
    @csrf
    @method('PUT')

    <div class="ui-card p-3 p-md-4">
      <div class="row g-4">
        {{-- LEFT COLUMN --}}
        <div class="col-lg-7">
          <div class="ui-section p-3 p-md-4 h-100">
            <h5 class="fw-bold mb-1">Product Information</h5>
            <p class="hint mb-4">Chỉnh sửa thông tin sản phẩm của bạn.</p>

            <div class="mb-3">
              <label class="lbl">Tên sản phẩm</label>
              <input type="text" name="name" class="form-control fld"
                     value="{{ old('name', $product->name) }}" required>
            </div>

            <div class="row g-3">
              <div class="col-md-6">
                <label class="lbl d-block">Giá</label>
                {{-- hiển thị tiền Việt: ₫ + phân tách nghìn --}}
                <div class="input-group">
                  <span class="input-group-text">₫</span>
                  <input
                    type="text"
                    id="price_display"
                    class="form-control currency-input"
                    inputmode="numeric"
                    placeholder="Nhập giá (VND)"
                    value="{{ old('price', (int) $product->price) }}"
                    autocomplete="off">
                </div>
                {{-- giá trị số thực sự submit về server --}}
                <input type="hidden" id="price" name="price" value="{{ old('price', $product->price) }}">
              </div>

              <div class="col-md-6">
                <label class="lbl">Số lượng</label>
                <input type="number" name="quantity" class="form-control fld"
                       value="{{ old('quantity', $product->quantity) }}" required>
              </div>
            </div>

            <div class="row g-3 mt-1">
              <div class="col-md-6">
                <label class="lbl">Tác giả</label>
                <input type="text" name="author" class="form-control fld"
                       value="{{ old('author', $product->author) }}">
              </div>
              <div class="col-md-6">
                <label class="lbl">Nhà xuất bản</label>
                <input type="text" name="publisher" class="form-control fld"
                       value="{{ old('publisher', $product->publisher) }}">
              </div>
            </div>

            <div class="row g-3 mt-1">
              <div class="col-md-6">
                <label class="lbl">Số trang</label>
                <input type="number" name="page" class="form-control fld"
                       value="{{ old('page', $product->page) }}">
              </div>
              <div class="col-md-6">
                <label class="lbl">Năm xuất bản</label>
                <input type="number" name="year_of_publication" class="form-control fld"
                       value="{{ old('year_of_publication', $product->year_of_publication) }}">
              </div>
            </div>

            <div class="mt-3">
              <label class="lbl">Mô tả</label>
              <textarea name="description" class="form-control fld" rows="4">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="mt-3">
              <label class="lbl">Danh mục</label>
              <select name="category_id" class="form-select fld" required>
                @foreach($categories as $category)
                  <option value="{{ $category->id }}"
                    {{ (old('category_id', $product->category_id) == $category->id) ? 'selected' : '' }}>
                    {{ $category->name }}
                  </option>
                @endforeach
              </select>
            </div>
          </div>
        </div>

        {{-- RIGHT COLUMN --}}
        <div class="col-lg-5">
          <div class="ui-section p-3 p-md-4 h-100 d-flex flex-column">
            <h5 class="fw-bold mb-1">Image Product</h5>
            <div class="hint mb-3"><strong>Note :</strong> SVG, PNG hoặc JPG (tối đa 4MB)</div>

            <label class="w-100">
              <input type="file" name="image" class="d-none" accept="image/*"
                     onchange="previewSingle(this)">
              <div id="dropArea" class="drop w-100">
                <i class="fa-regular fa-image fa-2xl mb-1"></i>
                <span id="dropText">Chọn ảnh</span>

                @if($product->image)
                  <img id="previewImg"
                       src="{{ asset($product->image) }}"
                       class="preview-img mt-1" alt="Ảnh hiện tại">
                @else
                  <img id="previewImg" class="d-none preview-img mt-1" alt="Preview ảnh">
                @endif
              </div>
            </label>

            <div class="mt-auto d-flex justify-content-between pt-4">
              <a href="{{ route('admin.products.index') }}" class="btn btn-light btn-pill px-4">Cancel</a>
              <button type="submit" class="btn btn-primary btn-pill px-4">Save Product</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>

<script>
  // Định dạng VND (display) <-> numeric (hidden)
  const nfVN = new Intl.NumberFormat('vi-VN');
  const priceDisplay = document.getElementById('price_display');
  const priceHidden  = document.getElementById('price');

  // Hàm chuẩn hoá: lấy chỉ chữ số từ chuỗi
  function digitsOnly(s){ return (s || '').toString().replace(/[^\d]/g, ''); }

  // Khởi tạo hiển thị từ hidden (nếu có)
  (function initPrice(){
    const val = digitsOnly(priceHidden.value);
    priceDisplay.value = val ? nfVN.format(parseInt(val, 10)) : '';
  })();

  // Khi gõ vào input hiển thị: format lại theo VND và cập nhật hidden
  priceDisplay.addEventListener('input', function(){
    const raw = digitsOnly(this.value);
    if(!raw){
      this.value = '';
      priceHidden.value = '';
      return;
    }
    const num = parseInt(raw, 10);
    this.value = nfVN.format(num);
    priceHidden.value = num; // gửi số nguyên về server (VND thường không dùng lẻ)
  });

  // Tránh submit khi người dùng vô tình xoá hidden
  document.getElementById('editProductForm').addEventListener('submit', function(){
    const raw = digitsOnly(priceDisplay.value);
    priceHidden.value = raw ? parseInt(raw, 10) : '';
  });

  // Preview ảnh
  function previewSingle(input){
    const file = input.files && input.files[0];
    if(!file) return;
    const img = document.getElementById('previewImg');
    const txt = document.getElementById('dropText');
    const url = URL.createObjectURL(file);
    img.src = url;
    img.classList.remove('d-none');
    txt && txt.classList.add('d-none');
    img.onload = () => URL.revokeObjectURL(url);
  }
</script>
@endsection
