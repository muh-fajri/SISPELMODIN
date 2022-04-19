<?php
session_start();
if(!in_array($_SESSION['user']['level'], ['Admin','Operator'])) :
  echo "Halaman gagal ditampilkan.";
  exit();
endif;

$page = "Ubah Data Mobil";
include '../include/heading.php';

//cek apakah tombol submit sudah ditekan atau belum
if(isset($_POST["submit"])) :
  if (edit_car($_POST) > 0) :
    echo "
      <script type='text/javascript'>
        setTimeout(function() {
          swal({
            title: 'Berhasil!',
            text: 'Data mobil berhasil diubah!',
            type: 'success',
            timer: 10000,
            showConfirmButton: true
          });
        }, 10);
        window.setTimeout(function() {
          window.location.replace('./data-car.php');
        }, 3000);
      </script>
    ";
  else :
    echo "
      <script type='text/javascript'>
        setTimeout(function() {
          swal({
            title: 'Gagal!',
            text: 'Data mobil gagal diubah!',
            type: 'error',
            timer: 10000,
            showConfirmButton: true
          });
        }, 10);
        window.setTimeout(function() {
          window.location.replace('./data-car.php');
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
          <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
          <div class="breadcrumb-item"><?= $page ?></div>
        </div>
        </div>
      <div class="card">
        <div class="card-body">
          <form method="POST" action="">
            <?php
              $no_car = $_GET['no-car'];
              $result = $pdo->query("SELECT * FROM car WHERE no_car='$no_car'");
              $row = $result->fetch(PDO::FETCH_ASSOC);
            ?>
            <div class="form-group">
              <label for="no-car">Nomor Mobil</label>
              <input type="text" class="form-control" name="no-car" id="no-car" placeholder="xx xxxx xx" required autocomplete="off" value="<?= $row['no_car'] ?>" required>
            </div>
            <div class="form-group">
              <label for="type">Tipe</label>
              <input type="tel" class="form-control" name="type" id="type" placeholder="Cth.: Suzuki Carry1.5" autocomplete="off" value="<?= $row['type'] ?>">
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