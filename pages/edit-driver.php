<?php
session_start();
if(!in_array($_SESSION['user']['level'], ['Admin','Operator'])) :
  echo "Halaman gagal ditampilkan.";
  exit();
endif;

$page = "Ubah Data Supir";
include '../include/heading.php';

//cek apakah tombol submit sudah ditekan atau belum
if(isset($_POST["submit"])) :
  if (edit_driver($_POST) > 0) :
    echo "
      <script type='text/javascript'>
        setTimeout(function() {
          swal({
            title: 'Berhasil!',
            text: 'Data supir berhasil diubah!',
            type: 'success',
            timer: 10000,
            showConfirmButton: true
          });
        }, 10);
        window.setTimeout(function() {
          window.location.replace('./data-driver.php');
        }, 3000);
      </script>
    ";
  else :
    echo "
      <script type='text/javascript'>
        setTimeout(function() {
          swal({
            title: 'Gagal!',
            text: 'Data supir gagal diubah!',
            type: 'error',
            timer: 10000,
            showConfirmButton: true
          });
        }, 10);
        window.setTimeout(function() {
          window.location.replace('./data-driver.php');
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
              $id = $_GET['id-driver'];
              $result = $pdo->query("SELECT * FROM driver WHERE id_driver=$id");
              $row = $result->fetch(PDO::FETCH_ASSOC);
            ?>
            <input type="hidden" class="form-control" name="id-driver" id="id-driver" value="<?= $row['id_driver'] ?>" required>
            <div class="form-group">
              <label for="name">Nama</label>
              <input type="text" class="form-control" name="name" id="name" placeholder="Nama" value="<?= $row['name'] ?>" required autocomplete="off">
            </div>
            <div class="form-group">
              <label for="hp-wa">No. HP/WA</label>
              <input type="tel" class="form-control" name="hp-wa" id="hp-wa" placeholder="081xxxxxxxxx" value="<?= $row['no_hp_wa'] ?>" required autocomplete="off">
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