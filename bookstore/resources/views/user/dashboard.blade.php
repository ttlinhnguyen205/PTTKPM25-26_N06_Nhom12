@extends('layouts.user')

@section('title', 'Readora - Online Bookstore')

@section('content')
    <!-- Banner -->
    <section class="banner">
        <div class="container banner-container">
            <div class="banner-left">
                <h1>Find & Search Your <br><span>Favorite</span> Book</h1>
                <p>Discover thousands of books from top authors.</p>
                <a href="#shop" class="btn">Read More</a>
            </div>
            <div class="banner-right">
                <img src="/images/banner-books.png" alt="Books">
            </div>
        </div>
    </section>

    <!-- Services -->
    <section class="services">
        <div class="container services-container">
            <div>
                <h3>Reliable Shipping</h3>
                <p>Fast and safe delivery nationwide.</p>
            </div>
            <div>
                <h3>You’re Safe with Us</h3>
                <p>Secure payment and data protection.</p>
            </div>
            <div>
                <h3>Best Quality & Pricing</h3>
                <p>Affordable books with high quality.</p>
            </div>
        </div>
    </section>

    <!-- Best Online Bookstore -->
    <section id="shop" class="bookstore">
        <div class="container">
            <h2>BEST ONLINE BOOKSTORE TO BUY BOOK</h2>
            <div class="book-tabs">
                <button class="tab active">Best Sellers</button>
                <button class="tab">Bundles & Promotions</button>
                <button class="tab">On Sale</button>
            </div>
            <div class="book-list">
                @foreach ($products as $book)
                    <div class="book-item">
                        <img src="{{ asset($book->image) }}" alt="{{ $book->name }}">
                        <h3>{{ $book->name }}</h3>
                        <p class="price">{{ number_format($book->price) }} VNĐ</p>
                        <a href="{{ route('user.products.show', $book->id) }}" class="btn-add">📖 Xem chi tiết</a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonials">
        <div class="container">
            <h2>CUSTOMER TESTIMONIALS</h2>
            <div class="testimonial-list">
                <div class="testimonial">"Great bookstore, fast delivery!" ⭐⭐⭐⭐⭐</div>
                <div class="testimonial">"Amazing variety of books." ⭐⭐⭐⭐⭐</div>
                <div class="testimonial">"Excellent customer service." ⭐⭐⭐⭐⭐</div>
            </div>
        </div>
    </section>

    <!-- Refer a Friend -->
    <section class="refer">
        <div class="container text-center">
            <h3>REFER A FRIEND</h3>
            <p>And get <span>$30</span></p>
            <button class="btn">Refer Here</button>
        </div>
    </section>

    <!-- How to Order -->
    <section class="how-to-order">
        <div class="container">
            <h2>HOW TO ORDER BOOKS ONLINE</h2>
            <div class="steps">
                <div><h4>Register</h4></div>
                <div><h4>Shop</h4></div>
                <div><h4>Make Payment</h4></div>
                <div><h4>Relax</h4></div>
            </div>
        </div>
    </section>

    <!-- Recently Added -->
    <section class="recent">
        <div class="container">
            <h2>RECENTLY ADDED</h2>
            <div class="recent-list">
                <div><img src="/images/book5.jpg"><p>Harry Potter</p></div>
                <div><img src="/images/book6.jpg"><p>Clear</p></div>
                <div><img src="/images/book7.jpg"><p>Circe</p></div>
                <div><img src="/images/book8.jpg"><p>The Favour</p></div>
                <div><img src="/images/book9.jpg"><p>More…</p></div>
            </div>
        </div>
    </section>
@endsection
