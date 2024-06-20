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

    Kode Password telah dikirimkan ke alamat email Anda. Silakan periksa email Anda, kemudian gunakan kode password yang telah dikirimkan sebagai password awal Anda. Setelah berhasil masuk, silakan membuat Password baru.
    <br>
    <br>
    <button id="tbok">OK</button>

</div>

<script>
    document.getElementById('tbok').addEventListener('click', function(event) {
        window.open("<?= base_url('login_satgas') ?>", "_self");
    });
</script>

<?= $this->endSection(); ?>