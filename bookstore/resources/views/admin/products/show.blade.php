@extends('layouts.admin')

@section('title', 'Chi tiết sản phẩm')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Chi tiết sản phẩm</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row">
                {{-- Ảnh sản phẩm --}}
                <div class="col-md-4 text-center mb-3">
                    @if($product->image)
                        <img src="{{ asset($product->image) }}" 
                             alt="{{ $product->name }}" class="img-fluid img-thumbnail">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center" 
                             style="width:100%; height:200px;">
                            <span>Không có ảnh</span>
                        </div>
                    @endif
                </div>

                {{-- Thông tin sản phẩm --}}
                <div class="col-md-8">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th>Tên</th>
                                <td>{{ $product->name }}</td>
                            </tr>
                            <tr>
                                <th>Giá</th>
                                <td>{{ number_format($product->price, 0, ',', '.') }} đ</td>
                            </tr>
                            <tr>
                                <th>Số lượng</th>
                                <td>{{ $product->quantity }}</td>
                            </tr>
                            <tr>
                                <th>Tác giả</th>
                                <td>{{ $product->author ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Nhà xuất bản</th>
                                <td>{{ $product->publisher ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Số trang</th>
                                <td>{{ $product->page ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Mô tả</th>
                                <td>{{ $product->description ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Năm xuất bản</th>
                                <td>{{ $product->year_of_publication ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Danh mục</th>
                                <td>{{ $product->category->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Slug</th>
                                <td>{{ $product->slug ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Ngày tạo</th>
                                <td>{{ $product->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Ngày cập nhật</th>
                                <td>{{ $product->updated_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-3">
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Quay lại</a>
                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary">Chỉnh sửa</a>
            </div>
        </div>
    </div>
</div>
@endsection
