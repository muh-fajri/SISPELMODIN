<?php
session_start();
$session = $_SESSION['user']['level'];
$level = ['Admin','Operator'];
if(!in_array($session, $level)) :
  echo "Halaman gagal ditampilkan.";
  exit();
endif;

$page = "Data Supir";
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
        <?php if(in_array($session, $level)) : ?>
        <div class="alert alert-warning alert-has-icon">
          <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
          <div class="alert-body">
            <div class="alert-title">Perhatian</div>
            Untuk penambahan data supir dibatasi maksimal 10 orang. Jika tidak, program harus ditinjau ulang.
          </div>
        </div>
        <?php endif; ?>

      <div class="card">
        <?php if(in_array($session, $level)) : ?>
        <div class="card-header">
          <a href="./add-driver.php" class="btn btn-icon icon-left btn-primary"><i class="fas fa-plus"></i> Tambah</a>
        </div>
        <?php endif; ?>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Nama</th>
                  <th scope="col">HP/WA</th>
                  <?php if(in_array($session, $level)) : ?>
                  <th scope="col">Opsi</th>
                  <?php endif;?>
                </tr>
              </thead>
              <tbody>
                <?php
                  $no = 1;
                  $result = $pdo->query("SELECT * FROM driver");
                  foreach ($result as $row) :
                ?>
                <tr>
                  <th scope="row"><?= $no++; ?></th>
                  <td scope="row"><?= $row['name']; ?></td>
                  <td scope="row"><?= $row['no_hp_wa']; ?></td>
                  <?php if(in_array($session, $level)) : ?>
                  <td scope="row">
                    <a href="./edit-driver.php?id-driver=<?= $row['id_driver'] ?>" class="btn btn-icon icon-left btn-info" onclick="return confirm('Ingin mengubah data supir?');"><i class="fas fa-edit"></i> <span class="d-none d-sm-none d-lg-inline-block">Ubah</span></a>
                    <?php if(in_array($session, ['Admin'])) : ?>
                    <a href="./delete-driver.php?id-driver=<?= $row['id_driver'] ?>" class="btn btn-icon icon-left btn-danger" onclick="return confirm('Yakin ingin menghapus data supir?');"><i class="fas fa-trash-alt"></i> <span class="d-none d-sm-none d-lg-inline-block">Hapus</span></a>
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
    </div>

    <?php
    include '../include/footer.php';
    ?>

</div>
</div>

<?php
include '../include/script.php';
?>