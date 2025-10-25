@extends('layouts.user')

@section('title', 'Shopping Cart - Readora')

@section('content')
<div class="cart-page container py-5">

  <!-- === STEP NAVIGATION === -->
  <div class="checkout-steps d-flex justify-content-center align-items-center mb-5">
    <div class="step active"><span>🛒</span> Shopping Cart</div>
    <div class="line"></div>
    <div class="step"><span>💳</span> Checkout</div>
    <div class="line"></div>
    <div class="step"><span>✅</span> Order Complete</div>
  </div>

  <!-- === MAIN CART SECTION === -->
  <div class="row">
    <div class="col-lg-8">
      <h3 class="mb-4">Your Cart</h3>

      @if($cartItems->count() > 0)
        @foreach($cartItems as $item)
          <div class="cart-item d-flex align-items-center justify-content-between border-bottom py-3">
            <div class="d-flex align-items-center">
              <input type="checkbox" class="me-3">
              <img src="{{ asset($item->product->image) }}" width="70" height="90" alt="">
              <div class="ms-3">
                <h6 class="mb-1">{{ $item->product->name }}</h6>
                <p class="text-muted mb-0">{{ number_format($item->product->price, 0, ',', '.') }} ₫</p>
              </div>
            </div>
            <div class="d-flex align-items-center">
              <button class="btn btn-sm btn-light">-</button>
              <span class="px-3">{{ $item->quantity }}</span>
              <button class="btn btn-sm btn-light">+</button>
            </div>
            <strong class="text-dark">
              {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }} ₫
            </strong>
          </div>
        @endforeach
      @else
        <p class="mt-4">Your cart is empty 😢</p>
      @endif
    </div>

    <!-- === SIDEBAR SUMMARY === -->
    <div class="col-lg-4">
      <div class="cart-summary card shadow-sm p-4">
        <h5 class="mb-3">Order Summary</h5>
        <div class="d-flex justify-content-between">
          <span>Subtotal</span>
          <strong>{{ number_format($cartItems->sum(fn($i) => $i->product->price * $i->quantity), 0, ',', '.') }} ₫</strong>
        </div>
        <div class="d-flex justify-content-between">
          <span>Discount</span>
          <strong>0 ₫</strong>
        </div>
        <div class="d-flex justify-content-between">
          <span>Shipping</span>
          <strong>50.000 ₫</strong>
        </div>

        <div class="mt-3">
          <input type="text" class="form-control" placeholder="Coupon code">
          <button class="btn btn-outline-primary w-100 mt-2">Apply Coupon</button>
        </div>

        <hr>
        <div class="d-flex justify-content-between align-items-center">
          <h6>Total</h6>
          <h5 class="text-primary fw-bold">
            {{ number_format($cartItems->sum(fn($i) => $i->product->price * $i->quantity) + 50000, 0, ',', '.') }} ₫
          </h5>
        </div>

        <button class="btn btn-primary w-100 mt-3 py-2">Proceed to Checkout</button>

        <div class="mt-4 text-center small text-muted">
          Secure Payments Provided by <br>
          <img src="/images/payments.png" alt="Payments" width="120">
        </div>
      </div>
    </div>
  </div>

  <!-- === DELIVERY & RETURNS === -->
  <div class="row mt-5">
    <div class="col-md-6 col-lg-4">
      <div class="info-card border p-3 rounded-3 h-100">
        <h6 class="text-danger">Delivery</h6>
        <p class="fw-bold">Order by 10pm for next day delivery on orders over 100k ₫</p>
        <p class="text-muted small">We deliver Monday to Saturday - excluding holidays</p>
      </div>
    </div>
    <div class="col-md-6 col-lg-4">
      <div class="info-card border p-3 rounded-3 h-100">
        <h6 class="text-danger">Free Delivery</h6>
        <p class="fw-bold">Free delivery for orders above 500k ₫</p>
        <p class="text-muted small">Under 500k ₫ → shipping is only 50k ₫.</p>
      </div>
    </div>
    <div class="col-md-6 col-lg-4">
      <div class="info-card border p-3 rounded-3 h-100">
        <h6 class="text-danger">Free Returns</h6>
        <p class="fw-bold">30 days to return items for a refund.</p>
        <p class="text-muted small">Return via post or bring it to our store for free.</p>
      </div>
    </div>
  </div>

</div>

{{-- === CART PAGE STYLES === --}}
<style>
  .checkout-steps {
    gap: 15px;
  }
  .checkout-steps .step {
    font-weight: 600;
    color: #777;
  }
  .checkout-steps .step.active {
    color: #0d6efd;
  }
  .checkout-steps .line {
    width: 40px;
    height: 2px;
    background: #ccc;
  }
  .cart-item img {
    border-radius: 8px;
    object-fit: cover;
  }
  .cart-summary {
    border-radius: 10px;
    background: #fff;
  }
  .info-card {
    background: #fff;
    box-shadow: 0 0 10px rgba(0,0,0,0.05);
  }
</style>
@endsection
