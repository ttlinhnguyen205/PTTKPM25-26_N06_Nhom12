@extends('layouts.admin')

@section('title', 'Danh sách sản phẩm')

@section('content')
<div class="container">
    <h2 class="mb-4">Danh sách sản phẩm</h2>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary mb-3">+ Thêm sản phẩm</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Tên</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Tác giả</th>
                <th>NXB</th>
                <th>Năm XB</th>
                <th>Danh mục</th>
                <th>Ảnh</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ number_format($product->price, 0) }} đ</td>
                <td>{{ $product->quantity }}</td>
                <td>{{ $product->author }}</td>
                <td>{{ $product->publisher }}</td>
                <td>{{ $product->year_of_publication }}</td>
                <td>{{ $product->category->name ?? 'N/A' }}</td>
                <td>
                    @if($product->image)
                        <img src="{{ asset('storage/'.$product->image) }}" width="50">
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-info btn-sm">Xem</a>
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Xóa sản phẩm này?')">Xóa</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="10" class="text-center">Chưa có sản phẩm nào</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
