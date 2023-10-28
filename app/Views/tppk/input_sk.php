<?php
$penugasan = array("", "Ketua", "Anggota");
$jabatan = array("", "Wakil Kepala Bidang Kesiswaan", "Guru", "Guru Bimbingan Konseling", "Komite Sekolah");

?>

<?= $this->extend('layout/default') ?>
<?= $this->section('header') ?>
<!-- <link rel="stylesheet" href="<?= base_url() ?>css/my_tables.css" /> -->
<link rel="stylesheet" href="<?= base_url() ?>css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="<?= base_url() ?>css/responsive.dataTables.min.css" />
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

    .alert {
        color: red;
        font-size: 16px;
        padding: 5px;
    }
</style>

<?= $this->endSection(); ?>

<?= $this->section('konten') ?>
<div class="content-wrap">

    <div class="judulkiri">
        <b>INPUT SK<br>Tim Pencegahan dan Penanganan Kekerasan (TPPK)</b>
        <h3><?= $namasekolah['nama'] ?></h3>
    </div>
    <table class="tabelinfo">
        <tr>
            <td>NPSN</td>
            <td>:</td>
            <td><?= $namasekolah['npsn'] ?></td>
        </tr>
        <tr>
            <td>Provinsi</td>
            <td>:</td>
            <td><?= substr($provinsi, 5) ?></td>
        </tr>
        <tr>
            <td><?= (substr($kota, 0, 3) == "Kab") ? "Kabupaten" : "Kota" ?></td>
            <td>:</td>
            <td><?= substr($kota, 4) ?></td>
        </tr>
        <tr>
            <td>Kecamatan</td>
            <td>:</td>
            <td><?= substr($kecamatan, 4) ?></td>
        </tr>
    </table>
    <br>
    <table class="tabelinfo">
        <tr>
            <td>Nama Kepala Sekolah</td>
            <td>:</td>
            <td><?= ($kepalasekolah == null) ? "" : $kepalasekolah; ?></td>
        </tr>
        <tr>
            <td>Jumlah PTK</td>
            <td>:</td>
            <td><?= $jumlah_ptk ?></td>
        </tr>
        <tr>
            <td>Jumlah Peserta Didik</td>
            <td>:</td>
            <td><?= $jumlah_pd ?></td>
        </tr>
    </table>


    <div style="margin:20px auto 10px;font-size:16px;">ANGGOTA</div>

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
                    <td><?= $row['nm_ang'] ?></td>
                    <td><?= $row['peran_ang'] ?></td>
                    <td><?= ($row['jenis_ptk'] == NULL) ? $row['nama_unsur2'] : $row['jenis_ptk'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div style="max-width:1000px;margin:auto;margin-top:20px;line-height:16px;">
        <table class="tabelinfo">
            <tr>
                <td>Nomor SK</td>
                <td>:</td>
                <td><?= $linknomorsk ?></td>
            </tr>
            <tr>
                <td>Tanggal SK</td>
                <td>:</td>
                <td><?= ($nomor > 1) ? substr($row['tmt_sk_tugas'], 8, 2) . "-" . substr($row['tmt_sk_tugas'], 5, 2) . "-" . substr($row['tmt_sk_tugas'], 0, 4) : "-" ?></td>
            </tr>
            <tr>
                <td>Tanggal Berakhir SK</td>
                <td>:</td>
                <td><?= ($nomor > 1) ? substr($row['tst_sk_tugas'], 8, 2) . "-" . substr($row['tst_sk_tugas'], 5, 2) . "-" . substr($row['tst_sk_tugas'], 0, 4) : "-" ?></td>
            </tr>

        </table>
        <br>

        <div style="display: <?= ($nomor > 1) ? "block;" : "none;" ?>">
            <table class="tabelinfo">
                <form action="<?= base_url() ?>inputdata/upload_sk" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <label for="file_sk">Unggah SK</label>
                        <input type="file" id="file_sk" name="file_sk" accept=".jpg,.jpeg,.png,.pdf">
                    </div>
                    <?php
                    if (session('error')) :
                    ?>
                        <div id="gagalunggah" class="alert">
                            <?= session('error') ?>
                        </div>
                    <?php
                    endif ?>
                    <div>
                        <input name="npsn" id="npsn" type="hidden" value="<?= $namasekolah['npsn'] ?>">
                        <input name="sk_tugas" id="sk_tugas" type="hidden" value="<?= ($nomor > 1) ? $row['sk_tugas'] : ""; ?>">
                        <input class="btn_ijo" onclick="return cekinput();" type="submit" value="Unggah">
                    </div>
                </form>
            </table>
        </div>
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
    });

    function cekinput() {
        var oke = true;
        var valsk = document.getElementById("file_sk").value;
        if (valsk == "") {
            oke = false;
        }
        return oke;
    }
</script>
<?= $this->endSection(); ?>