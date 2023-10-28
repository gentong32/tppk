<?php
$txtstatus = array("Belum di Approval", "<span style='color:red'>Tidak Sesuai</span>", "<span style='color:green'>Sesuai</span>");
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
</style>

<?= $this->endSection(); ?>

<?= $this->section('konten') ?>
<div class="content-wrap">

    <div style="float:right"><button onclick="return kembali();">Kembali</button>
    </div>
    <div class="judulkiri">
        <b>Daftar SK Satuan Tugas (Satgas)</b>
    </div>

    <table class="table table-striped my-custom-table" id="example">
        <thead>
            <th>No</th>
            <th>Nama Provinsi</th>
            <th>Nomor SK</th>
            <th>Status SK</th>
            <!-- <th>SK Kab/Kota</th>
            <th>SK Kab/Kota OK</th> -->
            <th>Aksi</th>
        </thead>

        <tbody>
            <?php
            $nomor = 1;
            foreach ($daftar_sksatgas as $row) : ?>
                <tr>
                    <td><?= $nomor++ ?></td>
                    <td><?= ($row['jumlah_sk_kabupaten_kota'] > 0) ? '<a href="' . base_url() . 'inputdata/daftar_skbaru/' . $row['kode_wilayah'] . '">' . $row['nama'] . '</a>' : $row['nama'] ?></td>
                    <td><?= $row['nomor_sk'] ?></td>
                    <td><?= $txtstatus[intval($row['status_sk'])] ?></td>
                    <td><?= $row['jumlah_sk_kabupaten_kota'] ?></td>
                    <td><?= $row['jumlah_status_ok'] ?></td>
                    <td><button onclick="return lihatsk('<?= $row['kode_wilayah'] ?>');" class="tbijo">Lihat</button></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

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

    function lihatsk(kodewilayah) {
        window.open("<?= base_url() ?>inputdata/lihatanggota2/" + kodewilayah, "_self");
    }
</script>
<?= $this->endSection(); ?>