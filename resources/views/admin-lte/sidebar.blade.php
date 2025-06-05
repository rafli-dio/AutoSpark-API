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
    <span class="brand-text font-weight-light">Admin AutoSpark</span>
  </a>
  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Dashboard -->

        <li class="nav-item">
          <a href="{{ route('get-dashboard-admin') }}" class="nav-link @yield('active-dashboard')">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>
        <!-- Layanan Cuci -->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="fas fa-shower nav-icon"></i>
            <p>
              Pesanan Cuci
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="" class="nav-link @yield('active-booking')">
                <i class="far fa-circle nav-icon"></i>
                <p>Data Pesanan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="" class="nav-link @yield('active-pembayaran')">
                <i class="far fa-circle nav-icon"></i>
                <p>Status Pesanan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="" class="nav-link @yield('active-pembayaran')">
                <i class="far fa-circle nav-icon"></i>
                <p>Riwayat Pesanan</p>
              </a>
            </li>
          </ul>
        </li>
        


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
              <a href="{{route('get-layanan-admin')}}" class="nav-link @yield('active-layanan')">
                <i class="far fa-circle nav-icon"></i>
                <p>Layanan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('get-layanan-tambahan-admin')}}" class="nav-link @yield('active-layanan-tambahan')">
                <i class="far fa-circle nav-icon"></i>
                <p>Layanan Tambahan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('get-metode-pembayaran-admin')}}" class="nav-link @yield('active-metode-pembayaran')">
                <i class="far fa-circle nav-icon"></i>
                <p>Metode Pembayaran</p>
              </a>
            </li>
          </ul>
        </li>
        <!-- Admin Section -->

        <li class="nav-item">
          <a href="" class="nav-link @yield('active-user')">
            <i class="fas fa-users nav-icon"></i>
            <p>User</p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
