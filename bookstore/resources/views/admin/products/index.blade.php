@extends('layouts.admin')

@section('content')
<div class="card shadow-sm p-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Books</h4>
        <div>
            <button class="btn btn-outline-secondary me-2">Filter</button>
            <button class="btn btn-outline-secondary me-2">Export</button>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">+ New Book</a>
        </div>
    </div>

    <!-- Search box -->
    <form method="GET" action="{{ route('admin.products.index') }}" class="mb-3">
        <input type="text" name="q" value="{{ request('q') }}" 
               class="form-control" placeholder="Search by id or name">
    </form>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table align-middle table-hover">
            <thead>
                <tr>
                    <th>
                        <input type="checkbox" id="checkAll">
                    </th>
                    <th>Book</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>QTY</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th class="text-end">Action</th>
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
                            <img src="{{ asset('images/' . $product->image) }}" 
                                 class="rounded me-2" width="40" height="40" alt="{{ $product->name }}">
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
                    <td>${{ number_format($product->price, 2) }}</td>
                    <td>{{ $product->category->name ?? '—' }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>{{ $product->created_at->format('m/d/y \a\t h:i A') }}</td>
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

    <!-- Pagination -->
    <div class="d-flex justify-content-between align-items-center mt-3">
        <div>
            Showing {{ $products->firstItem() }} - {{ $products->lastItem() }} of {{ $products->total() }}
        </div>
        <div class="d-flex justify-content-end">
            {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    </div>


<!-- Include Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection
