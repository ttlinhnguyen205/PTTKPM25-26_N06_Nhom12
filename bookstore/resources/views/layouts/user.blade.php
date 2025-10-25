<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Readora - Online Bookstore')</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

    {{-- Navbar giữ nguyên --}}
    <x-navbar />

    {{-- Nội dung thay đổi từng trang --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer giữ nguyên --}}
    <footer class="footer">
        <div class="container footer-container">
            <div>
                <h3>Readora</h3>
                <p>Your best online bookstore for all genres.</p>
            </div>
            <div>
                <h4>Catalog</h4>
                <ul>
                    <li>Authors</li>
                    <li>Publishers</li>
                    <li>Categories</li>
                </ul>
            </div>
            <div>
                <h4>Support</h4>
                <ul>
                    <li>Contact Us</li>
                    <li>FAQ</li>
                    <li>Privacy Policy</li>
                </ul>
            </div>
            <div>
                <h4>Follow Us</h4>
                <p>Social Media Links</p>
            </div>
        </div>
    </footer>

</body>
</html>
