<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Readora - Online Bookstore')</title>

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    {{-- Bootstrap (nếu cần) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    {{-- ========== NAVBAR ========== --}}
    <x-navbar />

    {{-- ========== MAIN CONTENT ========== --}}
    <main class="content-wrapper">
        @yield('content')
    </main>

    {{-- ========== FOOTER ========== --}}
    <footer class="footer mt-5">
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

    {{-- JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
