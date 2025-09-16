@extends('layouts.admin')

@section('title', 'Danh sách sản phẩm')

@section('content')
<div class="container">
    <h3 class="display-1">Danh sách sản phẩm</h3>

    <div class="card">
        <div class="card-body">
            
            <a href="{{ route('admin.products.create') }}" class="btn btn-inverse-info btn-fw">+ Thêm sản phẩm</a>
            <div class="row mt-3">
                <div class="col-12">
                    <div class="table-responsive">
                        <div id="example_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                </div>
                                <div class="col-sm-12 col-md-6">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="example" class="display expandable-table dataTable no-footer" style="width:100%" role="grid">
                                        <thead>
                                            <tr role="row">
                                                <th>ID</th>
                                                <th>Ảnh</th>
                                                <th>Tên sách</th>
                                                <th>Tác giả</th>
                                                <th>NXB</th>
                                                <th>Giá</th>
                                                <th>Số lượng</th>
                                                <th>Năm XB</th>
                                                <th>Danh mục</th>
                                                <th>Hành động</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($products as $p)
                                                <tr>
                                                    <td>{{ $p->id }}</td>
                                                    <td>
                                                        @if($p->image)
                                                            <img src="{{ asset($p->image) }}" alt="{{ $p->name }}" style="height:40px">
                                                        @endif
                                                    </td>
                                                    <td class="text-wrap">{{ $p->name }}</td>
                                                    <td class="text-wrap">{{ $p->author }}</td>
                                                    <td class="text-wrap">{{ $p->publisher }}</td>
                                                    <td>{{ number_format($p->price, 0) }} đ</td>
                                                    <td>{{ $p->quantity }}</td>
                                                    <td>{{ $p->year_of_publication }}</td>
                                                    <td class="text-wrap">{{ $p->category->name ?? 'N/A' }}</td>
                                                    <td>
                                                        <a href="{{ route('admin.products.show', $p->id) }}" class="btn btn-outline-primary btn-sm">Xem</a>
                                                        <a href="{{ route('admin.products.edit', $p->id) }}" class="btn btn-outline-warning btn-sm">Sửa</a>
                                                        <form action="{{ route('admin.products.destroy', $p->id) }}" method="POST" style="display:inline">
                                                            @csrf @method('DELETE')
                                                            <button type="submit" class="btn btn-outline-danger btn-sm"
                                                                    onclick="return confirm('Xóa sản phẩm này?')">Xóa</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr><td colspan="10" class="text-center">Chưa có sản phẩm nào</td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <form id="product-filter-form" class="col-12">

                            <!-- Phân trang chỉ có trang trước và trang sau -->
                            <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="btn-group ms-1" role="group" aria-label="Pagination">
                                        <!-- Nút Previous (Trang trước) -->
                                        <a class="btn btn-sm btn-outline-secondary {{ $products->onFirstPage() ? 'disabled' : '' }}"
                                        href="{{ $products->previousPageUrl() }}" aria-label="Previous">&lsaquo; Trang trước</a>

                                        <!-- Nút Next (Trang sau) -->
                                        <a class="btn btn-sm btn-outline-secondary {{ !$products->hasMorePages() ? 'disabled' : '' }}"
                                        href="{{ $products->nextPageUrl() }}" aria-label="Next">Trang sau &rsaquo;</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#per_page').on('change', function() {
        var perPage = $(this).val(); 

        $.ajax({
            url: '{{ route('admin.products.index') }}',
            method: 'GET',
            data: {
                per_page: perPage,  
                q: '{{ request('q') }}',  
                author: '{{ request('author') }}',
                price_min: '{{ request('price_min') }}',
                price_max: '{{ request('price_max') }}',
                category_id: '{{ request('category_id') }}'
            },
            success: function(response) {
                $('#product-list').html(response); 
            }
        });
    });
});
</script>
