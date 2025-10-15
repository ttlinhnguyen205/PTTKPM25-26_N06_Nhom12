@extends('layouts.admin')

@section('content')

@if (session('success'))
  <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
    <i class="fa-solid fa-circle-check me-2"></i> 
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

<div class="products-index">
  <div class="card shadow-sm p-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h4 class="fw-bold">Books</h4>
      <div class="d-flex gap-2">
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Reset</a>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">+ Thêm sách mới</a>
      </div>
    </div>

    {{-- FORM FILTER: Search + Sort (có ID ↑ / ID ↓) --}}
    <form method="GET" action="{{ route('admin.products.index') }}" class="mb-3" id="filterForm">
      <div class="row g-2 align-items-center">
        <div class="col-md-6">
          <input type="text" name="q" value="{{ request('q') }}" 
                class="form-control" placeholder="Search by id, name, author or publisher">
        </div>

        <div class="col-md-3">
          <select name="sort" class="form-select" id="sortSelect">
            @php $sort = request('sort','latest'); @endphp
            <option value="latest"   {{ $sort=='latest' ? 'selected' : '' }}>Mới nhất</option>
            <option value="oldest"   {{ $sort=='oldest' ? 'selected' : '' }}>Cũ nhất</option>
            <option value="id_asc"   {{ $sort=='id_asc' ? 'selected' : '' }}>ID ↑ </option>
            <option value="id_desc"  {{ $sort=='id_desc' ? 'selected' : '' }}>ID ↓</option>
            <option value="price_asc"  {{ $sort=='price_asc' ? 'selected' : '' }}>Giá ↑</option>
            <option value="price_desc" {{ $sort=='price_desc' ? 'selected' : '' }}>Giá ↓</option>
            <option value="qty_asc"    {{ $sort=='qty_asc' ? 'selected' : '' }}>Tồn kho ↑</option>
            <option value="qty_desc"   {{ $sort=='qty_desc' ? 'selected' : '' }}>Tồn kho ↓</option>
          </select>
        </div>
      </div>
    </form>

    <div class="table-responsive">
      <table class="table align-middle table-hover">
        <thead>
          <tr>
            <th><input type="checkbox" id="checkAll"></th>
            <th>Sách</th>
            <th>Giá</th>
            <th>Danh mục</th>
            <th>Số lượng</th>
            <th>Trạng thái</th>
            <th class="text-end">Hành động</th>
          </tr>
        </thead>
        <tbody>
          @foreach($products as $product)
          <tr>
            <td>
              <input type="checkbox" name="ids[]" value="{{ $product->id }}">
            </td>
            <td class="d-flex align-items-center">
              @if($product->image)
                <img src="{{ asset($product->image) }}" 
                     class="product-thumb me-2" alt="{{ $product->name }}">
              @else
                <div class="bg-light rounded me-2" style="width:40px;height:40px;"></div>
              @endif
              <div>
                <a href="{{ route('admin.products.show', $product->id) }}" class="fw-bold text-primary">
                  {{ $product->id }}
                </a>
                <div>{{ $product->name }}</div>
              </div>
            </td>
            <td>{{ number_format($product->price, 0, ',', '.') }} đ</td>
            <td>{{ $product->category->name ?? '—' }}</td>
            <td>{{ $product->quantity }}</td>
            <td>
              @if($product->quantity > 0)
                <span class="badge bg-success">Available</span>
              @else
                <span class="badge bg-danger">Out of Stock</span>
              @endif
            </td>
            <td class="text-end">
              <a href="{{ route('admin.products.show', $product->id) }}" class="text-primary me-2" title="View">
                <i class="fa-solid fa-eye"></i>
              </a>
              <a href="{{ route('admin.products.edit', $product->id) }}" class="text-warning me-2" title="Edit">
                <i class="fa-solid fa-pen-to-square"></i>
              </a>
              <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-link p-0 text-danger" onclick="return confirm('Delete this book?')" title="Delete">
                  <i class="fa-solid fa-trash"></i>
                </button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-3">
      <div>
        Showing {{ $products->firstItem() }} - {{ $products->lastItem() }} of {{ $products->total() }}
      </div>
      <div class="d-flex justify-content-end">
        {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
      </div>
    </div>
  </div>
</div>

{{-- Font Awesome (nếu layout chưa có) --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

{{-- Entry Vite riêng cho trang index --}}
@vite('resources/js/pages/products-index.js')
@endsection
