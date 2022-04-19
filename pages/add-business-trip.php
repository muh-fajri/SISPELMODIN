<?php
session_start();
$session = $_SESSION['user']['level'];
$level = ['Admin','Operator'];
if(!in_array($session, $level)) :
  echo "Halaman gagal ditampilkan.";
  exit();
endif;

$page = "Tambah Data Perjalanan";
include '../include/heading.php';

//cek apakah tombol submit sudah ditekan atau belum
if(isset($_POST["submit"])) :
  if (add_business_trip($_POST) > 0) :
    echo "
      <script type='text/javascript'>
        setTimeout(function() {
          swal({
            title: 'Berhasil!',
            text: 'Data perjalanan berhasil ditambahkan!',
            type: 'success',
            timer: 10000,
            showConfirmButton: true
          });
        }, 10);
        window.setTimeout(function() {
          window.location.replace('./data-business-trip.php');
        }, 3000);
      </script>
    ";
  else :
    echo "
      <script type='text/javascript'>
        setTimeout(function() {
          swal({
            title: 'Gagal!',
            text: 'Data perjalanan gagal ditambahkan!',
            type: 'error',
            timer: 10000,
            showConfirmButton: true
          });
        }, 10);
        window.setTimeout(function() {
          window.location.replace('./data-business-trip.php');
        }, 3000);
      </script>
    ";
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
        <div class="alert alert-info alert-has-icon">
          <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
          <div class="alert-body">
            <div class="alert-title">Info</div>
            Hanya mobil dan supir yang tidak sedang melakukan perjalanan yang dapat dipilih. Jika tidak ada yang sedang melakukan perjalanan, semua data mobil dan supir akan ditampilkan.
          </div>
        </div>
      <div class="card">
        <div class="card-body">
          <form method="POST" action="">
            <div class="form-group">
              <label for="no-car">Mobil</label>
              <select name="no-car" id="no-car" class="form-control theSelect" required>
                <option value="" disabled selected>Pilih Mobil</option>
              <?php
                $today_date = date('Y-m-d');

                $result_trip = $pdo->query("SELECT * FROM business_trip");
                
                $items = [];
                foreach ($result_trip as $row_trip) :
                  $d = date_create($row_trip['date_today']);
                  if(date_format($d, 'Y-m-d') == $today_date && $row_trip['date_today'] == NULL) :
                    $items[] = $row_trip['no_car'];
                  endif;
                endforeach;

                $result_car = $pdo->query("SELECT * FROM car");

                foreach ($result_car as $row_car) :
                  // dibuat berdasarkan jumlah maksimal 10 mobil
                  // (made based on max 10 count of the car)
                  $a = $items[0] != $row_car['no_car'];
                  $b = $items[1] != $row_car['no_car'];
                  $c = $items[2] != $row_car['no_car'];
                  $d = $items[3] != $row_car['no_car'];
                  $e = $items[4] != $row_car['no_car'];
                  $f = $items[5] != $row_car['no_car'];
                  $g = $items[6] != $row_car['no_car'];
                  $h = $items[7] != $row_car['no_car'];
                  $i = $items[8] != $row_car['no_car'];
                  $j = $items[9] != $row_car['no_car'];
                  
                  if($a && $b && $c && $d && $e && $f && $g && $h && $i && $j) :
              ?>
              <option value="<?= $row_car['no_car'] ?>"><?= $row_car['no_car'] ?> (<?= $row_car['type'] ?>)</option>
              <?php
                  endif;
                endforeach
              ?>
              </select>
            </div>
            <div class="form-group">
              <label for="id-driver">Supir</label>
              <select name="id-driver" id="id-driver" class="form-control theSelect" required>
                <option value="" disabled selected>Pilih Supir</option>
              <?php
                $today_date = date('Y-m-d');

                $result_trip = $pdo->query("SELECT * FROM business_trip");
                
                $items = [];
                foreach ($result_trip as $row_trip) :
                  $d = date_create($row_trip['date_today']);
                  if(date_format($d, 'Y-m-d') == $today_date && $row_trip['date_today'] == NULL) :
                    $items[] = $row_trip['id_driver'];
                  endif;
                endforeach;

                $result_driver = $pdo->query("SELECT * FROM driver");
                foreach ($result_driver as $row_driver) :

                  // dibuat berdasarkan jumlah maksimal 10 supir
                  // (made based on max 10 count of the driver)
                  $a = $items[0] != $row_driver['id_driver'];
                  $b = $items[1] != $row_driver['id_driver'];
                  $c = $items[2] != $row_driver['id_driver'];
                  $d = $items[3] != $row_driver['id_driver'];
                  $e = $items[4] != $row_driver['id_driver'];
                  $f = $items[5] != $row_driver['id_driver'];
                  $g = $items[6] != $row_driver['id_driver'];
                  $h = $items[7] != $row_driver['id_driver'];
                  $i = $items[8] != $row_driver['id_driver'];
                  $j = $items[9] != $row_driver['id_driver'];
                  
                  if($a && $b && $c && $d && $e && $f && $g && $h && $i && $j) :
              ?>                
              <option value="<?= $row_driver['id_driver'] ?>"><?= $row_driver['name'] ?></option>
              <?php
                  endif;
                endforeach
              ?>
              </select>
            </div>
            <?php if(in_array($session, ['Admin'])) : ?>
            <div class="form-group">
              <label for="date-today">Tanggal</label>
              <input type="date" class="form-control" name="date-today" id="date-today" autocomplete="off" max="<?= date('Y-m-d') ?>">
            </div>
            <div class="form-group">
              <label for="time-out">Jam Keluar</label>
              <input type="time" class="form-control" name="time-out" id="time-out" autocomplete="off">
            </div>
            <div class="form-group">
              <label for="time-back">Jam Kembali</label>
              <input type="time" class="form-control" name="time-back" id="time-back" autocomplete="off">
            </div>
            <?php endif; ?>
            <div class="form-group">
              <label for="destination">Tujuan</label>
              <textarea class="form-control" name="destination" id="destination" placeholder="Tujuan Perjalanan" style="height: 100px" maxlength="255" required></textarea>
            </div>

            <div class="card-footer text-right">
              <button class="btn btn-icon icon-left btn-success mr-1" type="submit" name="submit"><i class="fas fa-save"></i> Simpan</button>
              <button class="btn btn-icon icon-left btn-warning" type="button"><i class="fas fa-times"></i> Batal</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <?php
    include '../include/footer.php';
    ?>

</div>
</div>

<?php
include '../include/script.php';
?>