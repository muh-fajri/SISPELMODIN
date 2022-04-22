<?php
session_start();
$session = $_SESSION['user']['level'];
if(!in_array($_SESSION['user']['level'], ['Admin','Operator'])) :
  echo "Halaman gagal ditampilkan.";
  exit();
endif;

$page = "Ubah Data Perjalanan";
include '../include/heading.php';

//cek apakah tombol submit sudah ditekan atau belum
if(isset($_POST["submit"])) :
  if (edit_business_trip($_POST) > 0) :
    echo "
      // <script>
      //   alert('Data perjalanan berhasil diubah!');
      //   window.location.replace('./data-business-trip.php');  
      // </script>
      <script type='text/javascript'>
        setTimeout(function() {
          swal({
            title: 'Berhasil!',
            text: 'Data perjalanan berhasil diubah!',
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
      // <script>
      //   alert('Data perjalanan gagal diubah!');
      //   window.location.replace('./data-business-trip.php');  
      // </script>
      <script type='text/javascript'>
        setTimeout(function() {
          swal({
            title: 'Gagal!',
            text: 'Data perjalanan gagal diubah!',
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
      <div class="card">
        <div class="card-body">
          <form method="POST" action="">
            <?php
              $id = $_GET['id-business-trip'];
              $result = $pdo->query("SELECT * FROM business_trip WHERE id_business_trip='$id'");
              $row = $result->fetch(PDO::FETCH_ASSOC);
            ?>
            <input type="hidden" class="form-control" name="id-business-trip" id="id-business-trip" value="<?= $row['id_business_trip'] ?>" required>
            <div class="form-group">
              <label for="no-car">Mobil</label>
              <select name="no-car" id="no-car" class="form-control" required>
                <option value="" disabled>Pilih Mobil</option>
              <?php
                $result = $pdo->query("SELECT * FROM car");
                foreach ($result as $a) :
                  if($row['no_car'] == $a['no_car']) :
                    $select = "selected";
                  else :
                    $select = "";
                  endif;
                  echo "<option value='".$a['no_car']."' $select>".$a['no_car']." (".$a['type'].")</option>";
                endforeach;
              ?>
              </select>
            </div>
            <div class="form-group">
              <label for="id-driver">Supir</label>
              <select name="id-driver" id="id-driver" class="form-control" required>
                <option value="" disabled>Pilih Supir</option>
              <?php
                $result = $pdo->query("SELECT * FROM driver");
                foreach ($result as $b) :
                  if($row['id_driver'] == $b['id_driver']) :
                    $select = "selected";
                  else :
                    $select = "";
                  endif;
                  echo "<option value='".$b['id_driver']."' $select>".$b['name']."</option>";
                endforeach;
              ?>
              </select>
            </div>
            <div class="form-group">
              <label for="date-today">Set Tanggal</label>
              <input type="date" class="form-control" name="date-today" id="date-today" autocomplete="off" value="<?= $row['date_today'] ?>" max="<?= date('Y-m-d') ?>">
            </div>
            <div class="form-group">
              <label for="time-out">Jam Keluar</label>
              <input type="time" class="form-control" name="time-out" id="time-out" autocomplete="off" value="<?= $row['time_out'] ?>">
            </div>
            <div class="form-group">
              <label for="time-back">Jam Kembali</label>
              <input type="time" class="form-control" name="time-back" id="time-back" autocomplete="off" value="<?= $row['time_back'] ?>">
            </div>
            <div class="form-group">
              <label for="destination">Tujuan</label>
              <textarea class="form-control" name="destination" id="destination" placeholder="Tujuan Perjalanan" style="height: 100px" maxlength="255"><?= $row['destination'] ?></textarea>
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