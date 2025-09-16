@extends('layouts.admin')

@section('title', 'Danh sách đơn hàng')

@section('content')
<div class="container">
    <h2>Danh sách đơn hàng</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(Auth::user()->usertype !== 'admin')
        <a href="{{ route('orders.create') }}" class="btn btn-primary mb-3">+ Đặt hàng</a>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Khách hàng</th>
                <th>Địa chỉ</th>
                <th>Ngày tạo</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->customer->name ?? 'N/A' }}</td>
                <td>{{ $order->address->address ?? 'N/A' }}</td>
                <td>{{ $order->date }}</td>
                <td>{{ number_format($order->totalMoney, 0) }} đ</td>
                <td>{{ ucfirst($order->status) }}</td>
                <td>
                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-info btn-sm">Xem</a>
                    @if(Auth::user()->usertype === 'admin')
                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Xóa đơn hàng này?')">Xóa</button>
                        </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center">Chưa có đơn hàng nào</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
