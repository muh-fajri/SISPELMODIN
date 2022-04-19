<?php
$page = "Laporan Mingguan";
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
          <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
          <div class="breadcrumb-item"><?= $page ?></div>
        </div>
        </div>
        <div class="row">
          <div class="col">
            <div class="card">
              <div class="card-header">
                <h4>Pilih Tanggal</h4>
              </div>
              <div class="card-body">
                <form method="POST" action="../fpdf184/generate_pdf.php" target="_blank">
                  <div class="row">
                    <div class="col-12 col-md-6">
                      <div class="form-group">
                        <label for="date-start">Dari Tanggal</label>
                        <input type="date" id="date-start" name="date-start" class="form-control" required autocomplete="off" max="<?= date('Y-m-d') ?>">
                      </div>
                    </div>
                    <div class="col-12 col-md-6">
                      <div class="form-group">
                        <label for="date-end">Sampai Tanggal</label>
                        <input type="date" id="date-end" name="date-end" class="form-control" required autocomplete="off" max="<?= date('Y-m-d') ?>">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <button type="submit" name="submit" id="submit" class="browse btn btn-icon icon-left btn-primary"><i class="fas fa-calendar-alt"></i> <span>Tampilkan</span></button>
                  </div>
                </form>
              </div>
            </div>
<!--         <div class="card">
          <div class="card-header">
            <h4>Laporan Mingguan</h4>
          </div>
          <div class="card-body">
            <div id="report-weekly" class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Supir</th>
                    <th scope="col">Data Perjalanan</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $no = 1;
                    foreach ($result as $row) :
                  ?>
                  <tr>
                    <th scope="row"><?= $no++; ?></th>
                    <td scope="row"><?= $row['name']; ?></td>
                    <td scope="row"><?= $row['destination']; ?></td>
                  </tr>
                <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer">
            <form method="GET" action="" target="_blank">
              <div class="form-group">
                <button type="submit" name="print" id="print" class="browse btn btn-icon icon-left btn-danger"><i class="fas fa-file-pdf"></i> <span>Cetak</span></button>
              </div>
            </form>
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