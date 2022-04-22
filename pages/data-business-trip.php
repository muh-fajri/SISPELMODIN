<?php
session_start();
$session = $_SESSION['user']['level'];

$page = "Data Perjalanan";
include '../include/heading.php';

// check whether change-date button has clicked
if(isset($_POST["change-date"])) :
  $id = $_POST["date-today"];
  $date = date_create();
  $date_today = $date->format('Y-m-d');

  $query = 'UPDATE business_trip SET date_today = :date_today WHERE id_business_trip = :id';
  $stmt = $pdo->prepare($query);
  if($stmt->execute([':date_today' => $date_today, ':id' => $id])) :
    setcookie("success", "Tanggal berhasil diset.", time()+5);
    header("Location: ".$_SERVER['PHP_SELF']);
  endif;
endif;

// check whether allow button has clicked
if(isset($_POST["allow"])) :
  $id = $_POST["time-out"];
  $date = date_create();
  $time_out = $date->format('G:i:s');

  $query = 'UPDATE business_trip SET time_out = :time_out WHERE id_business_trip = :id';
  $stmt = $pdo->prepare($query);
  if($stmt->execute([':time_out' => $time_out, ':id' => $id])) :
    setcookie("success", "Izin keluar berhasil ditandai.", time()+5);
    header("Location: ".$_SERVER['PHP_SELF']);
  endif;
endif;

// check whether finish button has clicked
if(isset($_POST["finish"])) :
  $id = $_POST["time-back"];
  $date = date_create();
  $time_back = $date->format('G:i:s');

  $query = 'UPDATE business_trip SET time_back = :time_back WHERE id_business_trip = :id';
  $stmt = $pdo->prepare($query);
  if($stmt->execute([':time_back' => $time_back, ':id' => $id])) :
    setcookie("success", "Perjalanan telah selesai.", time()+5);
    header("Location: ".$_SERVER['PHP_SELF']);
  endif;
endif;
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
        <?php if(in_array($session, ['Admin','Operator'])) : ?>
        <div class="alert alert-warning alert-has-icon">
          <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
          <div class="alert-body">
            <div class="alert-title">Perhatian</div>
            Jika tanggal, jam masuk, dan jam keluar yang akan diset bukan untuk tanggal hari ini, harap diset secara manual melalui TOMBOL EDIT.
          </div>
        </div>
        <?php endif; ?>
        <div class="card">
          <?php if(in_array($session, ['Admin','Operator'])) : ?>
          <div class="card-header">
            <a href="./add-business-trip.php" class="btn btn-icon icon-left btn-primary"><i class="fas fa-plus"></i> Tambah</a>
          </div>
          <?php endif; ?>
          <div class="card-body">
            <?php
              // Mengecek apakah terdapat session bernama "success"
              if(isset($_COOKIE['success'])) :
                echo" <div class='alert alert-success alert-dismissible show fade'>
                  <div class='alert-body'>
                    <button class='close' data-dismiss='alert'>
                      <span>&times;</span>
                    </button>".
                    $_COOKIE['success'].
                  "</div>
                </div>";
              elseif(isset($_COOKIE['fail'])) :
                echo" <div class='alert alert-danger alert-dismissible show fade'>
                  <div class='alert-body'>
                    <button class='close' data-dismiss='alert'>
                      <span>&times;</span>
                    </button>".
                    $_COOKIE['fail'].
                  "</div>
                </div>";
              endif;
            ?>
            <div class="table-responsive">
              <table id="myTable" class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Mobil</th>
                    <th scope="col">Supir</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Jam Keluar</th>
                    <th scope="col">Jam Kembali</th>
                    <th scope="col">Tujuan</th>
                    <th scope="col">Lampiran</th>
                    <th scope="col">Status</th>
                    <?php if(in_array($session, ['Admin','Operator'])) : ?>
                    <th scope="col">Opsi</th>
                    <?php endif; ?>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $no = 1;
                    $query = "SELECT * FROM business_trip a JOIN driver b ON a.id_driver = b.id_driver";
                    $result = $pdo->query($query);
                    foreach ($result as $row) :
                  ?>
                  <tr>
                    <th scope="row"><?= $no++; ?></th>
                    <td scope="row"><?= $row['no_car']; ?></td>
                    <td scope="row"><?= $row['name']; ?></td>
                    <td scope="row">
                    <?php
                    if($row['date_today'] == NULL) :
                      if(in_array($session, ['Admin','Operator'])) :
                        echo "
                          <form method='POST' action=''>
                            <input type='hidden' class='form-control' name='date-today' id='date-today' value='".$row['id_business_trip']."'>
                            <button class='btn btn-sm btn-icon icon-left btn-info' type='submit' name='change-date'><i class='fas fa-calendar-alt'></i> Set Tanggal</button>
                          </form>
                        ";
                      else :
                        echo "-";
                      endif;
                    else :
                      $date_today = date_create($row['date_today']);
                      echo "<b class='text-primary'>".date_format($date_today, 'd M Y')."</b>";
                    endif;
                    ?>
                    </td>
                    <td scope="row">
                      <?php
                      if($row['date_today'] == NULL) :
                        if(in_array($session, ['Admin','Operator'])) :
                          echo "<b class='text-danger'>Lakukan set tanggal</b>";
                        else :
                          echo "-";
                        endif;
                      elseif($row['time_out'] == NULL) :
                        if(in_array($session, ['Admin','Operator'])) :
                          echo "
                            <form method='POST' action=''>
                              <input type='hidden' class='form-control' name='time-out' id='time-out' value='".$row['id_business_trip']."'>
                              <button class='btn btn-sm btn-icon icon-left btn-success' type='submit' name='allow'><i class='fas fa-check'></i> Izinkan</button>
                            </form>
                          ";
                        else :
                          echo "-";
                        endif;
                      else :
                        echo "<b class='text-success'>".$row['time_out']."</b>";
                      endif;
                      ?>
                    </td>
                    <td scope="row">
                      <?php
                      if($row['time_out'] == NULL) :
                        if(in_array($session, ['Admin','Operator'])) :
                          echo "<b class='text-danger'>Tandai izin keluar</b>";
                        else :
                          echo "-";
                        endif;
                      elseif($row['time_back'] == NULL) :
                        if(in_array($session, ['Admin','Operator'])) :
                          echo "
                            <form method='POST' action=''>
                              <input type='hidden' class='form-control' name='time-back' id='time-back' value='".$row['id_business_trip']."'>
                              <button class='btn btn-sm btn-icon icon-left btn-success' type='submit' name='finish'><i class='fas fa-check'></i> Selesai</button>
                            </form>                        
                          ";
                        else :
                          echo "-";
                        endif;
                      else :
                        echo "<b class='text-success'>".$row['time_back']."</b>";
                      endif;
                      ?>
                    </td>
                    <td scope="row"><?= $row['destination']; ?></td>
                    <td scope="row">
                      <?php
                      if(!empty($row['attachment'])) :
                        echo $row['attachment'];
                      else :
                        echo "-";
                      endif;
                      ?>
                    </td>
                    <td scope="row">
                      <?php
                        $date_today = $row['date_today'];
                        $time_out = $row['time_out'];
                        $time_back = $row['time_back'];
                        if($date_today == NULL) :
                          echo "<div class='badge badge-danger'>Tanggal Belum Diset</div>";
                        elseif($time_out == NULL) :
                          echo "<div class='badge badge-warning'>Belum Diizinkan</div>";
                        elseif($time_back == NULL) :
                          echo "<div class='badge badge-primary'>Dalam Perjalanan</div>";
                        else :
                          echo "<div class='badge badge-success'>Selesai</div>";
                        endif;
                      ?>
                    </td>
                    <?php if(in_array($session, ['Admin','Operator'])) : ?>
                    <td scope="row">
                    <a href="./edit-business-trip.php?id-business-trip=<?= $row['id_business_trip'] ?>" class="btn btn-icon btn-primary" onclick="return confirm('Ingin mengubah data perjalanan?');"><i class="fas fa-edit"></i></a>
                    <?php if(in_array($session, ['Admin'])) : ?>
                    <a href="./delete-business-trip.php?id-business-trip=<?= $row['id_business_trip'] ?>" class="btn btn-icon btn-danger" onclick="return confirm('Yakin ingin menghapus data perjalanan?');"><i class="fas fa-trash-alt"></i></a>
                    <?php endif; ?>
                    </td>
                    <?php endif; ?>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
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

<!-- <script>
  $(document).ready( function () {
      $('#myTable').DataTable();
  } );
</script> -->