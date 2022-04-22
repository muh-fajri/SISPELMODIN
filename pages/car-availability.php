<?php
session_start();
$session = $_SESSION['user']['level'];
$level = ['Admin','Operator','Pengawas'];
if(!in_array($session, $level)) :
  echo "Halaman gagal ditampilkan.";
  exit();
endif;

$page = "Ketersediaan Mobil";
include '../include/heading.php';
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
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="./index.php">Dashboard</a></div>
          <div class="breadcrumb-item"><?= $page ?></div>
        </div>
        </div>
        <div class="alert alert-info alert-has-icon">
          <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
          <div class="alert-body">
            <div class="alert-title">Info</div>
            Data Ketersediaan Mobil ditampilkan berdasarkan tanggal hari ini.
          </div>
        </div>
        <div class="row">
          <div class="col col-md-5">
            <div class="card">
              <div class="card-header">
                <h4>Mobil yang Terpakai</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nomor Mobil</th>
                        <th scope="col">Tipe</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $no = 1;
                        $today_date = date('Y-m-d');

                        $query_trip = "SELECT * FROM business_trip";
                        $result_trip = mysqli_query($conn, $query_trip);
                        
                        foreach ($result_trip as $rows_trip) :
                          $d = date_create($rows_trip['date_today']);

                          $query = "SELECT * FROM car";
                          $result = mysqli_query($conn, $query);

                          foreach ($result as $rows) :

                          if(date_format($d, 'Y-m-d') == $today_date && $rows_trip['time_back'] == NULL && $rows_trip['no_car'] == $rows['no_car']) :
                      ?>
                      <tr>
                        <td scope="row"><?= $no++ ?></td>
                        <td scope="row"><?= $rows['no_car']; ?></td>
                        <td scope="row"><?= $rows['type']; ?></td>
                      </tr>
                      <?php
                            endif;
                          endforeach;
                        endforeach;
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="col col-md-7">
            <div class="card">
              <div class="card-header">
                <h4>Mobil yang Terparkir</h4>
              </div>
              <div class="card-body">
                <?php
                  // Mengecek apakah terdapat session bernama "success"
                  if(isset($_COOKIE['success'])) :
                    echo $_COOKIE['success'];
                  elseif(isset($_COOKIE['fail'])) :
                    echo $_COOKIE['fail'];
                  endif;
                ?>
                <div class="table-responsive">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nomor Mobil</th>
                        <th scope="col">Tipe</th>
                        <?php if(in_array($session, ['Admin','Operator'])) : ?>
                        <th scope="col">Opsi</th>
                        <?php endif; ?>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $no = 1;
                        $today_date = date('Y-m-d');

                        $query_trip = "SELECT * FROM business_trip";
                        $result_trip = mysqli_query($conn, $query_trip);
                        
                        $items = [];
                        foreach ($result_trip as $rows_trip) :
                          $d = date_create($rows_trip['date_today']);
                          if(date_format($d, 'Y-m-d') == $today_date && $rows_trip['time_back'] == NULL) :
                            $items[] = $rows_trip['no_car'];
                          endif;
                        endforeach;

                        $query = "SELECT * FROM car";
                        $result = mysqli_query($conn, $query);
                        foreach ($result as $rows) :

                          // dibuat berdasarkan jumlah maksimal 10 mobil
                          // (made based on max 10 count of the car)
                          $a = $items[0] != $rows['no_car'];
                          $b = $items[1] != $rows['no_car'];
                          $c = $items[2] != $rows['no_car'];
                          $d = $items[3] != $rows['no_car'];
                          $e = $items[4] != $rows['no_car'];
                          $f = $items[5] != $rows['no_car'];
                          $g = $items[6] != $rows['no_car'];
                          $h = $items[7] != $rows['no_car'];
                          $i = $items[8] != $rows['no_car'];
                          $j = $items[9] != $rows['no_car'];
                          
                          if($a && $b && $c && $d && $e && $f && $g && $h && $i && $j) :
                      ?>
                      <tr>
                        <td scope="row"><?= $no++ ?></td>
                        <td scope="row"><?= $rows['no_car']; ?></td>
                        <td scope="row"><?= $rows['type']; ?></td>
                        <?php if(in_array($session, ['Admin','Operator'])) : ?>
                        <td scope="row">
                          <?php $no_car = $rows['no_car']; ?>
                          <a href="./car-use.php?no_car=<?= $rows['no_car'] ?>" class="btn btn-icon icon-left btn-info" onclick="return confirm('Ingin menggunakan mobil ini?');"><i class="fas fa-car-side"></i> <span>Gunakan</span></a>
                        </td>
                        <?php endif; ?>
                      </tr>
                      <?php
                          endif;
                        endforeach;
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
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