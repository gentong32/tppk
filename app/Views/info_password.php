<?= $this->extend('layout/default') ?>

<?= $this->section('header') ?>
<style>
    .container {
        max-width: 800px;
        background-color: #E1F4DD;
        border: 1px solid black;
        border-radius: 3px;
        padding: 20px;
        font-size: 14px;
        line-height: 28px;
    }

    .error-message {
        color: red;
        margin-bottom: 10px;
    }
</style>

<?= $this->endSection() ?>


<?= $this->section('konten') ?>
<div class="container">
    <h2>Informasi</h2>

    Halo, <?= session()->get("nama") ?>.<br>
    Password sudah berhasil disimpan. Untuk selanjutnya silakan gunakan alamat email dan password ini untuk Login sebagai Operator Satgas.
    <br>
    <br>
    <button id="tbok">OK</button>

</div>

<script>
    document.getElementById('tbok').addEventListener('click', function(event) {
        window.open("<?= base_url() ?>", "_self");
    });
</script>

<?= $this->endSection(); ?>