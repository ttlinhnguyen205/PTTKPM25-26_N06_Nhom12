@extends('layouts.admin')

@section('title', 'Thêm sản phẩm')

@section('content')
<div class="container">
    <h2 class="mb-4">Thêm sản phẩm</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class = "card">
        <div class = "card-body">
            <form class="forms-sample">

            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">ID (tùy chọn)</label>
                    <input type="number" name="id" class="form-control" value="{{ old('id') }}" min="1" placeholder="Bỏ trống để hệ thống tự tạo">
                </div>

                <div class="mb-3">
                    <label class="form-label">Tên sản phẩm</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Giá</label>
                    <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Số lượng</label>
                    <input type="number" name="quantity" class="form-control" value="{{ old('quantity') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tác giả</label>
                    <input type="text" name="author" class="form-control" value="{{ old('author') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Nhà xuất bản</label>
                    <input type="text" name="publisher" class="form-control" value="{{ old('publisher') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Số trang</label>
                    <input type="number" name="page" class="form-control" value="{{ old('page') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Mô tả</label>
                    <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Năm xuất bản</label>
                    <input type="number" name="year_of_publication" class="form-control" value="{{ old('year_of_publication') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Danh mục</label>
                    <select name="category_id" class="form-control" required>
                        <option value="">-- Chọn danh mục --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ảnh sản phẩm</label>
                    <input type="file" name="image" class="form-control" onchange="previewImage(event)">
                    <div class="mt-2">
                        <img id="preview" alt="Preview ảnh" class="img-fluid d-none" style="max-height: 200px;">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mr-2">Lưu</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-light">Hủy</a>
            </form>
        </form>
        </div>
    </div>
    
</div>

{{-- Script preview ảnh --}}
<script>
    function previewImage(event) {
        const preview = document.getElementById('preview');
        preview.src = URL.createObjectURL(event.target.files[0]);
        preview.classList.remove('d-none');
        preview.onload = () => URL.revokeObjectURL(preview.src);
    }
</script>
@endsection
