<nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="/admin/dashboard">
              <i class="icon-grid menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.categories.index') }}">
              <i class="icon-paper menu-icon"></i>
              <span class="menu-title">Quản lý danh mục</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href={{ route('admin.products.index') }}>
              <i class="icon-columns menu-icon"></i>
              <span class="menu-title">Quản lý sản phẩm</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.orders.index') }}">
              <i class="icon-layout menu-icon"></i>
              <span class="menu-title">Quản lý đơn hàng</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.users.index') }}">
              <i class="icon-head menu-icon"></i>
              <span class="menu-title">Quản lý người dùng</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="pages/documentation/documentation.html">
              <i class="icon-paper menu-icon"></i>
              <span class="menu-title">Documentation</span>
            </a>
          </li>


        </ul>
      </nav>