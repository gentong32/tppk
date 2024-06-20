<?= $this->extend('layout/default') ?>

<?= $this->section('header') ?>
<style>
    .content-wrap {
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        box-sizing: border-box;
        padding: 10px;
        margin-top: 0px !important;
    }

    .container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        align-items: stretch;
        /* Make both columns the same height */
        width: 100%;
        max-width: 900px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .left-column,
    .right-column {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .left-column {
        flex: 1;
        padding: 20px;
        background-color: #f0f0f0;
    }

    .right-column {
        flex: 2;
        padding-left: 20px;
        padding-right: 20px;
    }

    .right-column iframe {
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

    @media (max-width: 700px) {
        .container {
            flex-direction: column;
            align-items: center;
            margin: 0 auto;
            max-width: 450px;
        }

        .right-column {
            padding-left: 0;
            padding-right: 0;
            width: 100%;
        }
    }
</style>
<link rel="stylesheet" href="<?= base_url() ?>css/mylogin.css?v1.1">
<?= $this->endSection() ?>


<?= $this->section('konten') ?>
<div class="content-wrap">
    <div class="container">
        <div class="left-column">
            <h2>Login Pengisian Laporan</h2>
            <p>Silakan login untuk mengisi Laporan</p>
            <div class="infologin">
                Login Pelaporan untuk anggota yang ditunjuk oleh Ketua Satgas.
                Silakan mendaftar terlebih dahulu sesuai SK yang diberikan, jika anda belum terdaftar.
            </div>
        </div>
        <div class="right-column">
            <div class="login-container">
                <h2>Login Operator Satgas</h2>
                <form action="<?= base_url('cek_login') ?>" method="POST">
                    <?= csrf_field() ?>
                    <input type="text" id="username" name="username" placeholder="Username" required>
                    <input type="password" id="password" name="password" placeholder="Password" required>
                    <div id="infologin" style="color: red;">
                        <?php if (session()->getFlashdata('error')) : ?>
                            <?= session()->getFlashdata('error') ?>
                        <?php endif; ?>
                    </div>

                    <div class="info-text">
                        Klik <a href="<?= base_url() ?>register_satgas">disini</a> jika belum terdaftar.
                    </div>
                    <div class="btn-container">
                        <button type="submit" class="primary">Masuk</button>
                        <button type="button" class="secondary">Lupa Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById("username").addEventListener("input", function(event) {
        var infologin = document.getElementById("infologin");
        infologin.innerHTML = "";
    });
</script>

<?= $this->endSection(); ?>