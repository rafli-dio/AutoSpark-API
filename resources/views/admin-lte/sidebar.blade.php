<style>
  .main-sidebar {
    height: 100vh;           
    overflow-y: auto;        
    overflow-x: hidden;      
  }
</style>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
    <img src="/adminlte/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">Karaka</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        
        <!-- Dashboard -->
        <li class="nav-header">Dashboard</li>
        <li class="nav-item">
          <a href="{{ route('dashboard-admin') }}" class="nav-link @yield('active-dashboard')">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <!-- Lapangan Basket -->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="fas fa-basketball-ball nav-icon"></i>
            <p>
              Lapangan Basket
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('booking-lapangan-admin') }}" class="nav-link @yield('active-booking')">
                <i class="far fa-circle nav-icon"></i>
                <p>Data Booking</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('status-booking-admin') }}" class="nav-link @yield('active-pembayaran')">
                <i class="far fa-circle nav-icon"></i>
                <p>Status Booking</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- Admin Section -->
        <li class="nav-header">ADMIN</li>
        <li class="nav-item">
          <a href="{{ route('get-admin-user') }}" class="nav-link @yield('active-user')">
            <i class="fas fa-users nav-icon"></i>
            <p>User</p>
          </a>
        </li>
        <!-- Master Data Section -->
        <li class="nav-header">MASTER DATA</li>

        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="fas fa-database nav-icon"></i>
            <p>
              Master Data
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('kategori-barang-admin') }}" class="nav-link @yield('active-kategori')">
                <i class="far fa-circle nav-icon"></i>
                <p>Kategori</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="" class="nav-link @yield('active-satuan')">
                <i class="far fa-circle nav-icon"></i>
                <p>Satuan</p>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
