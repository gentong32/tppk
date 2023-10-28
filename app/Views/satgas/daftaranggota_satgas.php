<?php
$penugasan = array("", "Ketua", "Anggota");
$jabatan = array("", "Wakil Kepala Bidang Kesiswaan", "Guru", "Guru Bimbingan Konseling", "Komite Sekolah");
?>

<?= $this->extend('layout/default') ?>
<?= $this->section('header') ?>
<!-- <link rel="stylesheet" href="<?= base_url() ?>css/my_tables.css" /> -->
<link rel="stylesheet" href="<?= base_url() ?>css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="<?= base_url() ?>css/responsive2.dataTables.min.css" />
<script src="<?= base_url() ?>js/jquery-3.5.1.js"></script>
<script src="<?= base_url() ?>js/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>js/dataTables.responsive.min.js"></script>

<style>
    /* Gaya Tabel */
    .my-custom-table {
        border-collapse: collapse;
        width: 100%;
        background-color: #f8f8f8;
        border: 1px solid #ddd;
    }

    .my-custom-table th,
    .my-custom-table td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .my-custom-table tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    /* Gaya Header Tabel */
    .my-custom-table th {
        background-color: #5a96c7;
        color: white;
    }
</style>

<?= $this->endSection(); ?>

<?= $this->section('konten') ?>
<div class="content-wrap">

    <div class="judul">
        <h5>Anggota TPPK</h5>
        <h4><?= $namasekolah['nama'] ?></h4>
    </div>
    <div style="max-width: 1024px;margin:20px auto 10px;"><button onclick="history.back()">Kembali</button></div>
    <div class="informasi">
        <table class="table table-striped my-custom-table" id="example">
            <thead>
                <th>No</th>
                <th>Nama</th>
                <th>Status Keanggotaan</th>
                <th>Unsur Keanggotaan</th>
            </thead>

            <tbody>
                <?php
                $nomor = 1;
                foreach ($daftaranggota as $row) : ?>
                    <tr>
                        <td><?= $nomor++ ?></td>
                        <td><?= $row['nama'] ?></td>
                        <td><?= $penugasan[intval($row['penugasan'])] ?></td>
                        <td><?= $jabatan[intval($row['jabatan_id'])] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scriptfooter') ?>
<script>
    var w = window.innerWidth;
    var h = window.innerHeight;

    if (w < h) {
        teru = true;
    } else {
        teru = false;
    }

    $('#example').DataTable({
        scrollX: teru,
        searching: false,
        paging: false,
        info: false,
        processing: true,
        responsive: true,
    });
</script>
<?= $this->endSection(); ?>