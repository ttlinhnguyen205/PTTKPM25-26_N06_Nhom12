@extends('layouts.admin')

@section('title', 'Danh sách đơn hàng')

@section('content')
@php
    use Illuminate\Support\Str;

    $statusParam = request('status');
    $q = request('q');

    $counts = $counts ?? [
        'all'        => $orders->total(),
        'shipping'   => $shippingCount ?? 0,
        'completed'  => $completedCount ?? 0,
        'cancelled'  => $cancelledCount ?? 0,
    ];

    function statusBadge($status) {
        return match($status) {
            'pending'   => 'badge bg-secondary',
            'confirmed' => 'badge bg-info',
            'shipping'  => 'badge bg-primary',
            'completed' => 'badge bg-success',
            'cancelled' => 'badge bg-danger',
            default     => 'badge bg-light text-dark',
        };
    }
@endphp

@push('styles')
  @vite(['resources/css/pages/orders-index.css'])
@endpush

<div class="container-fluid px-3 px-md-4">
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="card-ui p-3 p-md-4">
    {{-- Top actions --}}
    <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">
      <form method="GET" action="{{ route('admin.orders.index') }}" class="flex-grow-1 me-2" style="max-width:520px;">
        <div class="position-relative">
          <i class="fa-solid fa-magnifying-glass search-ico"></i>
          <input type="text" name="q" value="{{ $q }}" class="form-control search-input"
                 placeholder="Search for id, name product">
          @if($statusParam) <input type="hidden" name="status" value="{{ $statusParam }}"> @endif
        </div>
      </form>

      <div class="d-flex gap-2">
        <a class="btn btn-outline-secondary"><i class="fa-solid fa-filter me-1"></i> Filter</a>
        <a class="btn btn-outline-secondary"><i class="fa-solid fa-file-export me-1"></i> Export</a>
        <a href="{{ route('admin.orders.create') }}" class="btn btn-primary">
          <i class="fa-solid fa-plus me-1"></i> New Order
        </a>
      </div>
    </div>

    {{-- Tabs --}}
    <div class="tabs-wrap mb-3">
      <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('admin.orders.index', array_filter(['q'=>$q])) }}"
           class="tab-btn {{ !$statusParam ? 'tab-active' : '' }}">
          All Orders ({{ $counts['all'] }})
        </a>
        <a href="{{ route('admin.orders.index', array_filter(['status'=>'shipping','q'=>$q])) }}"
           class="tab-btn {{ $statusParam==='shipping' ? 'tab-active' : '' }}">
          Shipping ({{ $counts['shipping'] }})
        </a>
        <a href="{{ route('admin.orders.index', array_filter(['status'=>'completed','q'=>$q])) }}"
           class="tab-btn {{ $statusParam==='completed' ? 'tab-active' : '' }}">
          Completed ({{ $counts['completed'] }})
        </a>
        <a href="{{ route('admin.orders.index', array_filter(['status'=>'cancelled','q'=>$q])) }}"
           class="tab-btn {{ $statusParam==='cancelled' ? 'tab-active' : '' }}">
          Cancel ({{ $counts['cancelled'] }})
        </a>
      </div>
    </div>

    {{-- Table --}}
    <div class="table-responsive">
      <table class="table align-middle table-hover table-rounded">
        <thead>
          <tr>
            <th style="width:36px"><input type="checkbox" id="checkAll"></th>
            <th>Orders</th>
            <th>Customer</th>
            <th>Price</th>
            <th>Date</th>
            <th>Payment</th>
            <th>Status</th>
            <th class="text-end">Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse($orders as $order)
            @php
                $firstDetail = $order->orderDetails->first() ?? null;
                $product = $firstDetail?->product;
                $thumb = '';
                if ($product && $product->image) {
                    $thumb = asset(Str::startsWith($product->image, 'images/book/')
                            ? $product->image
                            : 'images/book/' . ltrim($product->image, '/'));
                }
                $payment = $order->payment_status ?? ($order->status === 'completed' ? 'paid' : 'unpaid');
                $paymentClass = $payment === 'paid' ? 'badge bg-success-subtle text-success' : 'badge bg-warning-subtle text-warning';
                $statusClass  = statusBadge($order->status);
            @endphp
            <tr>
              <td><input type="checkbox" name="ids[]" value="{{ $order->id }}"></td>

              <td>
                <div class="d-flex align-items-center">
                  @if($thumb)
                    <img src="{{ $thumb }}" class="thumb me-2" alt="thumb">
                  @else
                    <div class="thumb me-2"></div>
                  @endif
                  <div>
                    <a href="{{ route('admin.orders.show', $order->id) }}" class="text-primary small fw-semibold">0{{ $order->id }}</a>
                    <div class="text-muted">{{ $product->name ?? '—' }}</div>
                  </div>
                </div>
              </td>

              <td>{{ $order->customer->name ?? 'N/A' }}</td>
              <td>{{ number_format($order->total_money ?? 0, 0, ',', '.') }} đ</td>
              <td>{{ \Carbon\Carbon::parse($order->date)->format('m/d/Y') }}</td>

              <td><span class="{{ $paymentClass }}">{{ Str::title($payment) }}</span></td>
              <td><span class="{{ $statusClass }}">{{ Str::title($order->status) }}</span></td>

              <td class="text-end">
                <a href="{{ route('admin.orders.show', $order->id) }}" class="icon-btn me-1" title="View">
                  <i class="fa-regular fa-eye"></i>
                </a>
                <a href="{{ route('admin.orders.edit', $order->id) }}" class="icon-btn me-1" title="Edit">
                  <i class="fa-regular fa-pen-to-square"></i>
                </a>
                <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Xóa đơn hàng này?')">
                  @csrf @method('DELETE')
                  <button type="submit" class="icon-btn text-danger" title="Delete">
                    <i class="fa-regular fa-trash-can"></i>
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" class="text-center text-muted py-4">Chưa có đơn hàng nào</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- Footer --}}
    <div class="d-flex justify-content-between align-items-center mt-2">
      <div class="text-muted small">
        {{ $orders->firstItem() ?? 0 }} - {{ $orders->lastItem() ?? 0 }} of {{ $orders->total() ?? $orders->count() }} Pages
      </div>

      <div class="d-flex align-items-center gap-2">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="d-flex align-items-center">
          @if($statusParam) <input type="hidden" name="status" value="{{ $statusParam }}"> @endif
          @if($q) <input type="hidden" name="q" value="{{ $q }}"> @endif
          <label class="me-1 small text-muted">The page on</label>
        </form>
        <div class="ms-2">
          {{ $orders->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
@vite(['resources/js/pages/orders-index.js'])
@endpush
@endsection
