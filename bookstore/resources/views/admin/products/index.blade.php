@extends('layouts.admin')

@section('title', 'Danh sách sản phẩm')

@section('content')
<div class="container">
    <h2 class="mb-4">Danh sách sản phẩm</h2>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary mb-3">+ Thêm sản phẩm</a>

    <div class="card">
        <div class="card-body">
            <p class="card-title">Advanced Table</p>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <div id="example_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row"><div class="col-sm-12 col-md-6">

                            </div>
                            <div class="col-sm-12 col-md-6">

                            </div>
                        </div>
                        <div class="row"><div class="col-sm-12">
                            <table id="example" class="display expandable-table dataTable no-footer" style="width:100%" role="grid">
                                <thead>
                                    <tr role="row">
                                        <th>#</th>
                                        <th>Tên sách</th>
                                        <th>Tác giả</th>
                                        <th>NXB</th>
                                        <th>Giá</th>
                                        <th>Số lượng</th>
                                        <th>Năm XB</th>
                                        <th>Danh mục</th>
                                        <th>Ảnh</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($products as $p)
                                        <tr>
                                            <td >{{ $p->id }}</td>
                                            <td class="text-wrap">{{ $p->name }}</td>
                                            <td class="text-wrap">{{ $p->author }}</td>
                                            <td class="text-wrap">{{ $p->publisher }}</td>
                                            <td>{{ number_format($p->price, 0) }} đ</td>
                                            <td>{{ $p->quantity }}</td>
                                            <td>{{ $p->year_of_publication }}</td>
                                            <td class="text-wrap">{{ $p->category->name ?? 'N/A' }}</td>
                                            <td>
                                                @if($p->image)
                                                    <img src="{{ asset($p->image) }}" alt="{{ $p->name }}" style="height:40px">
                                                @endif
                                            </td>
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
                        <div class="row">
                            <div class="col-sm-12 col-md-5">
                            </div>
                            <div class="col-sm-12 col-md-7">
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            @php
                $totalPages = $products->lastPage();
                $current    = $products->currentPage();
                $keepQuery  = request()->except('page');
            @endphp
            <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
                <div class="text-muted small">
                    {{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }}
                        of {{ $products->total() }}
                </div>

                <div class="d-flex align-items-center gap-2">
                    <span class="text-muted small">The page on</span>
                        <form id="page-jump-form" method="GET" action="{{ route('admin.products.index') }}" class="d-inline">
                            @foreach($keepQuery as $name => $value)
                                @if(is_array($value))
                                    @foreach($value as $v)
                                        <input type="hidden" name="{{ $name }}[]" value="{{ $v }}">
                                    @endforeach
                                @else
                                    <input type="hidden" name="{{ $name }}" value="{{ $value }}">
                                @endif
                            @endforeach
                            <select name="page" class="form-select form-select-sm w-auto d-inline-block"
                                    onchange="this.form.submit()">
                                @for($i = 1; $i <= $totalPages; $i++)
                                <option value="{{ $i }}" @selected($i === $current)>{{ $i }}</option>
                                @endfor
                            </select>
                        </form>
                        <div class="btn-group ms-1" role="group" aria-label="Pagination">
                            <a class="btn btn-sm btn-outline-secondary {{ $products->onFirstPage() ? 'disabled' : '' }}"
                                href="{{ $products->onFirstPage() ? '#' : $products->previousPageUrl() }}"
                                aria-label="Previous">&lsaquo;</a>
                            <a class="btn btn-sm btn-outline-secondary {{ $products->hasMorePages() ? '' : 'disabled' }}"
                                href="{{ $products->hasMorePages() ? $products->nextPageUrl() : '#' }}"
                                aria-label="Next">&rsaquo;
                            </a>
                        </div>
                </div>
        </div>
    </div>
    
</div>
@endsection



