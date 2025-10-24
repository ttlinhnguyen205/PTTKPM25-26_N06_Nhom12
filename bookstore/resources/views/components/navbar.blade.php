<nav class="navbar">
  <!-- ======= TOP BAR ======= -->
  <div class="top-bar">
    <div class="container navbar-top">
      <!-- Logo -->
      <div class="logo">
        <a href="/">
          <img src="{{ asset('images/logo6.png') }}" alt="Readora Logo">
        </a>
      </div>

      <!-- Search bar -->
      <div class="search-bar">
        <form action="{{ route('user.dashboard') }}" method="GET">
          <input type="text" name="q" placeholder="Search Books..." class="search-input">
          <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
      </div>

      <!-- Right icons -->
      <div class="user-actions">
        <div class="dropdown">
          <a href="#" class="dropdown-toggle">
            <i class="fa-regular fa-user"></i> Account <i class="fa-solid fa-caret-down"></i>
          </a>
          <ul class="dropdown-menu">
            <li><a href="{{ route('profile.edit') }}">Profile</a></li>
            <li><a href="{{ route('user.orders.index') }}">My Orders</a></li>
            <li>
              <a href="{{ route('logout') }}"
                 onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                 Logout
              </a>
            </li>
          </ul>
        </div>

        <a href="{{ route('user.cart.index') }}">
          <i class="fa-solid fa-bag-shopping"></i> Cart:(0₫)
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
          @csrf
        </form>
      </div>
    </div> <!-- ✅ ĐÓNG top-bar ở đây -->
  </div>

  <!-- ======= BOTTOM NAVBAR ======= -->
  <div class="bottom-bar">
    <div class="container">
      <ul class="menu">
        <li><a href="{{ route('user.dashboard') }}" class="active">HOME</a></li>
        <li><a href="#shop">PRODUCT</a></li>
        <li><a href="#">AUTHOR</a></li>
        <li><a href="#">PUBLISHER</a></li>
        <li><a href="#">CONTACT US</a></li>
        <li><a href="#">BLOG</a></li>
      </ul>
    </div>
  </div>
</nav>
