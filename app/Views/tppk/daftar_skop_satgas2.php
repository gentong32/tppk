<?php
$txtstatus = array("Belum di Approval", "<span style='color:red'>Ditolak</span>", "<span style='color:green'>Disetujui</span>");
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
        font-size: 12px;
    }

    .my-custom-table th,
    .my-custom-table td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .my-custom-table td:nth-child(4),
    .my-custom-table td:nth-child(5),
    .my-custom-table td:nth-child(6) {
        text-align: center;
    }

    .my-custom-table tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    /* Gaya Header Tabel */
    .my-custom-table th {
        background-color: #5a96c7;
        color: white;
    }

    .tbatas {
        color: #000000;
        background-color: #8cd6e8;
        font-size: 14px;
        border: 1px solid #60b3be;
        border-radius: 3px;
        padding: 5px 8px;
        margin-right: 2px;
        margin-bottom: 2px;
        cursor: pointer
    }

    .tbatas:hover {
        color: #2d63c8;
        background-color: #ffffff;
    }

    .aktif {
        background-color: #60b3be !important;
        color: #000000 !important;
    }

    .tbijo {
        color: #000000;
        background-color: #8cd6e8;
        font-size: 14px;
        border: 1px solid #60b3be;
        border-radius: 3px;
        padding: 2px 5px;
        cursor: pointer
    }

    .tbijo:hover {
        color: #2d63c8;
        background-color: #ffffff;
    }

    .tabel_container {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .judulkiri {
        margin-top: 30px;
    }
</style>

<?= $this->endSection(); ?>

<?= $this->section('konten') ?>
<div class="content-wrap">

    <div style="float:right"><button onclick="return kembali();">Kembali</button>
    </div>
    <div class="judulkiri">
        <b>Daftar SK Admin Satgas Kab/Kota</b>
    </div>

    <div class="button_container">
        <button class="tbatas" onclick="satgasprov()">Satgas Provinsi</button>
        <button class="tbatas" onclick="satgaskota()">Satgas Kab/Kota</button>
        <button class="tbatas" onclick="operatorprov()">Admin Provinsi</button>
        <button class="tbatas aktif" onclick="operatorkota()">Admin Kab/Kota</button>
    </div>

    <div class="tabel_container">
        <table class="table table-striped my-custom-table" id="example">
            <thead>
                <th>No</th>
                <th>Nama Kab/Kota</th>
                <th>Nama Admin</th>
                <th>Status Approval</th>
                <th>Aksi</th>
            </thead>

            <tbody>
                <?php
                $nomor = 1;
                foreach ($daftar_sksatgas as $row) : ?>
                    <tr>
                        <td><?= $nomor++ ?></td>
                        <td><?= $row['nama_wilayah'] ?></td>
                        <td><?= $row['nama'] ?></td>
                        <td><?= $txtstatus[intval($row['status_approval'])] ?></td>
                        <td><button onclick="return lihatsk('<?= $row['pengguna_id'] ?>');" class="tbijo">Lihat</button></td>
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
        searching: true,
        paging: true,
        info: true,
        processing: true,
    });

    function satgasprov() {
        window.open("<?= base_url() ?>inputdata/daftar_skbaru", "_self");
    }

    function satgaskota() {
        window.open("<?= base_url() ?>inputdata/daftar_skbaru/kota", "_self");
    }

    function operatorprov() {
        window.open("<?= base_url() ?>inputdata/daftar_skbaru/op_prov", "_self");
    }

    function operatorkota() {
        window.open("<?= base_url() ?>inputdata/daftar_skbaru/op_kota", "_self");
    }

    function editanggota() {
        window.open("<?= base_url() ?>inputdata/edit", "_self");
    }

    function kembali() {
        var previousPageURL = document.referrer;
        cekback = previousPageURL;
        if (cekback.slice(-14) == "inputdata/edit")
            window.open("<?= base_url() ?>home", "_self");
        else
            history.back()
    }

    function lihatsk(penggunaid) {
        window.open("<?= base_url() ?>inputdata/lihatanggota_op/" + penggunaid, "_self");
    }
</script>
<?= $this->endSection(); ?>