<?php
session_start();
if(!isset($_SESSION['user'])) :
  header("Location: ../index.php");
  exit();
endif;
$page = "Halaman Utama";
include '../include/heading.php';

$count_user = "SELECT COUNT(*) AS count FROM user";
$count_driver = "SELECT COUNT(*) AS count FROM driver";
$count_car = "SELECT COUNT(*) AS count FROM car";
$count_business_trip = "SELECT COUNT(*) AS count FROM business_trip";
?>

<div id="app">
  <div class="main-wrapper">
    <?php
    include '../include/navbar.php';
    include '../include/sidebar.php';
    ?>

    <!-- Main Content -->
    <div class="main-content">
      <section class="section">
        <div class="section-header">
          <h1><?= $page ?></h1>
        </div>
        <div class="row">
          <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-warning">
                <i class="fas fa-users"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Pengguna</h4>
                </div>
                <div class="card-body">
                  <?php
                  $result = $pdo->query($count_user);
                  $row = $result->fetch(PDO::FETCH_ASSOC);
                  echo $row['count'];
                  ?>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-primary">
                <i class="fas fa-address-card"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Supir</h4>
                </div>
                <div class="card-body">
                  <?php
                  $result = $pdo->query($count_driver);
                  $row = $result->fetch(PDO::FETCH_ASSOC);
                  echo $row['count'];
                  ?>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-danger">
                <i class="fas fa-car"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Mobil</h4>
                </div>
                <div class="card-body">
                  <?php
                  $result = $pdo->query($count_car);
                  $row = $result->fetch(PDO::FETCH_ASSOC);
                  echo $row['count'];
                  ?>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-success">
                <i class="fas fa-map-marked-alt"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Perjalanan</h4>
                </div>
                <div class="card-body">
                  <?php
                  $result = $pdo->query($count_business_trip);
                  $row = $result->fetch(PDO::FETCH_ASSOC);
                  echo $row['count'];
                  ?>
                </div>
              </div>
            </div>
          </div>
        </div>
<!--         <div class="row">
          <div class="col-lg-8 col-md-12 col-12 col-sm-12">
            <div class="card">
              <div class="card-header">
                <h4>Statistik Data Perjalanan</h4>
                <div class="card-header-action">
                  <div class="btn-group">
                    <a href="#" class="btn">Mingguan</a>
                    <a href="#" class="btn btn-primary">Bulanan</a>
                    <a href="#" class="btn">Tahunan</a>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <canvas id="myChart" height="182"></canvas>
                <div class="statistic-details mt-sm-4">
                  <div class="statistic-details-item">
                    <span class="text-muted"><span class="text-primary"><i class="fas fa-caret-up"></i></span> 7%</span>
                    <div class="detail-value">$243</div>
                    <div class="detail-name">Today's Sales</div>
                  </div>
                  <div class="statistic-details-item">
                    <span class="text-muted"><span class="text-danger"><i class="fas fa-caret-down"></i></span> 23%</span>
                    <div class="detail-value">$2,902</div>
                    <div class="detail-name">This Week's Sales</div>
                  </div>
                  <div class="statistic-details-item">
                    <span class="text-muted"><span class="text-primary"><i class="fas fa-caret-up"></i></span>9%</span>
                    <div class="detail-value">$12,821</div>
                    <div class="detail-name">This Month's Sales</div>
                  </div>
                  <div class="statistic-details-item">
                    <span class="text-muted"><span class="text-primary"><i class="fas fa-caret-up"></i></span> 19%</span>
                    <div class="detail-value">$92,142</div>
                    <div class="detail-name">This Year's Sales</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-12 col-12 col-sm-12">
            <div class="card">
              <div class="card-header">
                <h4>Pengguna Online</h4>
              </div>
              <div class="card-body">
                <ul class="list-unstyled list-unstyled-border">
                  <li class="media">
                    <img alt="image" class="mr-3 rounded-circle" width="50" src="../assets/img/avatar/avatar-1.png">
                    <div class="media-body">
                      <div class="mt-0 mb-1 font-weight-bold">Hasan Basri</div>
                      <div class="text-success text-small font-600-bold"><i class="fas fa-circle"></i> Online</div>
                    </div>
                  </li>
                  <li class="media">
                    <img alt="image" class="mr-3 rounded-circle" width="50" src="../assets/img/avatar/avatar-2.png">
                    <div class="media-body">
                      <div class="mt-0 mb-1 font-weight-bold">Bagus Dwi Cahya</div>
                      <div class="text-small font-weight-600 text-muted"><i class="fas fa-circle"></i> Offline</div>
                    </div>
                  </li>
                  <li class="media">
                    <img alt="image" class="mr-3 rounded-circle" width="50" src="../assets/img/avatar/avatar-3.png">
                    <div class="media-body">
                      <div class="mt-0 mb-1 font-weight-bold">Wildan Ahdian</div>
                      <div class="text-small font-weight-600 text-success"><i class="fas fa-circle"></i> Online</div>
                    </div>
                  </li>
                  <li class="media">
                    <img alt="image" class="mr-3 rounded-circle" width="50" src="../assets/img/avatar/avatar-4.png">
                    <div class="media-body">
                      <div class="mt-0 mb-1 font-weight-bold">Rizal Fakhri</div>
                      <div class="text-small font-weight-600 text-success"><i class="fas fa-circle"></i> Online</div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div> -->
      </section>
    </div>
    
    <?php
    include '../include/footer.php';
    ?>
  </div>
</div>

<?php
include '../include/script.php';
?>