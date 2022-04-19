<?php
$page = "Tentang Aplikasi";
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

            <div class="section-body">
            <h2 class="section-title">Tentang Aplikasi</h2>
            <p class="section-lead">Menampilkan deskripsi aplikasi.</p>
            <div class="card">
                <div class="card-header">
                <h4>Tentang Aplikasi</h4>
                </div>
                <div class="card-body">
                <p>SISPELMODIN (Sistem Pelacakan Mobil Dinas) merupakan aplikasi berbasis web yang dibangun untuk melakukan pelacakan mobil dinas yang sedang digunakan di kantor Badan Pengembangan Pendidikan Anak Usia Dini dan Pendidikan Masyarakat Sulawesi Selatan (BP-Paud Dikmas SulSel). Pelacakan yang dimaksud yaitu dapat diketahui mobil digunakan oleh siapa, kapan dan kemana tujuannya.</p>
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