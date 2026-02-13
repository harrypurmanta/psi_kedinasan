<nav class="main-header navbar navbar-expand-md navbar-light navbar-white" style="background-color: rgb(52, 78, 65);">
    <div class="container">
      <a href="<?= base_url() ?>" class="navbar-brand">
        <span class="brand-text font-weight-bold" style="color:#ffffff;">Bintang Timur</span>
      </a>

      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a href="<?= base_url() ?>/admin" class="nav-link" style="color:#ffffff;">Home</a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url() ?>/admin/soal" class="nav-link" style="color:#ffffff;">Soal</a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url() ?>/admin/users" class="nav-link" style="color:#ffffff;">Users</a>
          </li>
        </ul>

        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
        <!-- Messages Dropdown Menu -->
        
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item">
        <a href="<?= base_url() ?>/login/logout" class="nav-link" style="color:#ffffff;">Logout</a>
        </li>
        
      </ul>
      </div>

      <!-- Right navbar links -->
    
    </div>
  </nav>