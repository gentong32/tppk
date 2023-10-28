<?= $this->extend('layout/default') ?>

<?= $this->section('header') ?>
<style>
    .infoul {
        padding: 5px;
        margin-top: 25px;
        list-style-type: none;
        font-size: 13px;
    }

    .infoul li {
        line-height: 25px;
    }

    /* .infoul li:nth-child(even) {
        margin-top: 5px;
        background-color: white;
        padding: 10px;
    }

    .infoul li:nth-child(odd) {
        margin-top: 5px;
        background-color: rgba(40, 170, 205, 0.1);
        background-color: white;
        padding: 10px;
    } */

    .info-container {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.5s ease;
    }

    .info-container.show {
        max-height: 1700px;
        /* margin-top: 25px; */
        /* Atur tinggi maksimum sesuai kebutuhan */
    }

    /* .info-container li:nth-child(odd) {
        margin-top: 5px;
        background-color: white;
        padding: 10px;
    } */
</style>
<?= $this->endSection() ?>


<?= $this->section('konten') ?>
<div class="content-wrap">
    <section class="informasi">
        <div class="judul">INFORMASI</div>
        Panduan Pengguna Aplikasi Dasbor TPPK dan Satgas, Kabupaten, Kota, dan Provinsi<br>
        <button onclick="return download_panduan();">Unduh Panduan</button>

    </section>
</div>

<script>
    function toggleInfo(event, idx) {
        event.preventDefault(); // Mencegah aksi default hyperlink

        var info = document.getElementById("info" + idx);
        info.classList.toggle("show");
    }

    function download_panduan() {
        window.open("<?= base_url() ?>inputdata/download_panduan");
    }
</script>
<?= $this->endSection(); ?>