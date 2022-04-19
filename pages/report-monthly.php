<?php
$page = "Laporan Bulanan";
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
                <h4>Pilih Bulan</h4>
              </div>
              <div class="card-body">
                <form method="POST" action="../fpdf184/generate_pdf.php" target="_blank">
                  <div class="row">
                    <div class="col-12">
                      <div class="form-group">
                        <div class="input-group">
                          <label for="month">Bulan</label>
                        </div>
                        <div class="input-group">
                          <input type="month" id="month" name="month" class="form-control" required autocomplete="off" max="<?= date('Y-m') ?>">
                          <div class="input-group-append">
                            <button type="submit" name="submit" id="submit" class="browse btn btn-icon icon-left btn-primary"><i class="fas fa-calendar-alt"></i> <span>Tampilkan</span></button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
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