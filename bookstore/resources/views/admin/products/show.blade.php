@extends('layouts.admin')

@section('title', 'Chi tiết sản phẩm')

@section('content')
<div class="container">
    <h2>Chi tiết sản phẩm</h2>

    <table class="table table-bordered">
        <tr>
            <th>Tên</th>
            <td>{{ $product->name }}</td>
        </tr>
        <tr>
            <th>Giá</th>
            <td>{{ number_format($product->price, 0) }} đ</td>
        </tr>
        <tr>
            <th>Số lượng</th>
            <td>{{ $product->quantity }}</td>
        </tr>
        <tr>
            <th>Tác giả</th>
            <td>{{ $product->author }}</td>
        </tr>
        <tr>
            <th>Nhà xuất bản</th>
            <td>{{ $product->publisher }}</td>
        </tr>
        <tr>
            <th>Số trang</th>
            <td>{{ $product->page }}</td>
        </tr>
        <tr>
            <th>Mô tả</th>
            <td>{{ $product->description }}</td>
        </tr>
        <tr>
            <th>Năm xuất bản</th>
            <td>{{ $product->year_of_publication }}</td>
        </tr>
        <tr>
            <th>Danh mục</th>
            <td>{{ $product->category->name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Ảnh</th>
            <td>
                @if($product->image)
                    <img src="{{ asset('storage/'.$product->image) }}" width="150">
                @else
                    Không có ảnh
                @endif
            </td>
        </tr>
    </table>

    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Quay lại</a>
</div>
@endsection
