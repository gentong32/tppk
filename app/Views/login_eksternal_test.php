<?= $this->extend('layout/default') ?>

<?= $this->section('header') ?>
<style>
    .container {
        display: flex;
        top: 10px;
        left: 0px;
        width: 100% !important;
        max-width: 900px;
    }

    .left-column {
        flex: 1;
        padding: 20px;
        background-color: #f0f0f0;
        height: 280px;
    }

    .right-column {
        flex: 2;
        position: relative;
        padding: 20px;
    }

    .right-column iframe {
        position: absolute;
        top: 0;
        left: 10px;
        right: 10px;
        width: 100%;
        height: 100%;
        border: none;
    }

    .infologin {
        font-size: larger;
        margin-top: 20px;
        border: 1px solid gray;
        padding: 5px;
    }
</style>
<?= $this->endSection() ?>


<?= $this->section('konten') ?>
<div class="content-wrap">
    <div class="container">
        <div class="left-column">
            <h2>Login Pengisian Laporan</h2>
            <p>Silakan login untuk mengisi Laporan</p>
            <div class="infologin">
                Login Pelaporan untuk Ketua TPPK setiap satuan Pendidikan dan satu anggota yang ditunjuk oleh Ketua TPPK.
            </div>
        </div>
        <div class="right-column">
            <div style="padding:20px">
                <iframe src="https://dev-sso.datadik.kemdikbud.go.id/app/60B05B81-79A8-46D0-9458-7B10E5B7606C" frameborder="10px"></iframe>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener("message", function(event) {
        window.open('https://referensi.data.kemdikbud.go.id/tppk/', '_self');
    }, false);
</script>

<?= $this->endSection(); ?>