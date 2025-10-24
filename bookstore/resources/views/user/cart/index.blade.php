@extends('layouts.user')

@section('title', 'Shopping Cart - Readora')

@section('content')
<div class="cart-page container py-5">
  {{-- Nội dung giỏ hàng ở đây --}}
  <h2>Your Shopping Cart</h2>

  @if($cartItems->count() > 0)
    @foreach($cartItems as $item)
      <div class="cart-item d-flex align-items-center justify-content-between border-bottom py-3">
        <div class="d-flex align-items-center">
          <img src="{{ asset($item->product->image) }}" width="60" height="80" alt="">
          <div class="ms-3">
            <h6>{{ $item->product->name }}</h6>
            <p>{{ number_format($item->product->price, 0, ',', '.') }} ₫</p>
          </div>
        </div>
        <strong>{{ number_format($item->product->price * $item->quantity, 0, ',', '.') }} ₫</strong>
      </div>
    @endforeach
  @else
    <p class="mt-4">Your cart is empty 😢</p>
  @endif
</div>
@endsection
