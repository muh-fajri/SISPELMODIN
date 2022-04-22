      <div class="main-sidebar">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="index.php">Sispelmodin</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.php">Spmd</a>
          </div>
          <ul class="sidebar-menu">
              <li class="menu-header">Menu Utama</li>
              <li <?php if($page == "Halaman Utama") echo "class='active'"; ?>><a class="nav-link" href="index.php"><i class="fas fa-home"></i> <span>Halaman Utama</span></a></li>
              <li <?php if($page == "Profil") echo "class='active'"; ?>><a class="nav-link" href="profile.php"><i class="fas fa-user"></i> <span>Profil</span></a></li>
              <li <?php if($page == "Tentang Aplikasi") echo "class='active'"; ?>><a class="nav-link" href="about-app.php"><i class="fas fa-exclamation"></i> <span>Tentang Aplikasi</span></a></li>
              <?php if(in_array($_SESSION['user']['level'], ['Admin','Operator'])) : ?>
              <li class="menu-header">Data Master</li>
              <li <?php if($page == "Data Pengguna") echo "class='active'"; ?>><a class="nav-link" href="data-user.php"><i class="fas fa-users"></i> <span>Data Pengguna</span></a></li>
              <li <?php if($page == "Data Supir") echo "class='active'"; ?>><a class="nav-link" href="data-driver.php"><i class="fas fa-address-card"></i> <span>Data Supir</span></a></li>
              <li <?php if($page == "Data Mobil") echo "class='active'"; ?>><a class="nav-link" href="data-car.php"><i class="fas fa-car"></i> <span>Data Mobil</span></a></li>
              <?php endif; ?>
              <li class="menu-header">Perjalanan Dinas</li>
              <li <?php if($page == "Data Perjalanan") echo "class='active'"; ?>><a class="nav-link" href="data-business-trip.php"><i class="fas fa-map-marked-alt"></i> <span>Data Perjalanan</span></a></li>
              <li <?php if($page == "Ketersediaan Mobil") echo "class='active'"; ?>><a class="nav-link" href="car-availability.php"><i class="fas fa-car-side"></i> <span>Ketersediaan Mobil</span></a></li>
              <li class="menu-header">Laporan</li>
              <li <?php if($page == "Laporan Mingguan") echo "class='active'"; ?>><a href="report-weekly.php" class="nav-link"><i class="fas fa-file-alt"></i> <span>Laporan Mingguan</span></a></li>
              <li <?php if($page == "Laporan Bulanan") echo "class='active'"; ?>><a href="report-monthly.php" class="nav-link"><i class="fas fa-file-alt"></i> <span>Laporan Bulanan</span></a></li>
              <li <?php if($page == "Laporan Tahunan") echo "class='active'"; ?>><a href="report-annually.php" class="nav-link"><i class="fas fa-file-alt"></i> <span>Laporan Tahunan</span></a></li>
            </ul>
        </aside>
      </div>
