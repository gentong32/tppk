<?= $this->extend('layout/default') ?>

<?= $this->section('header') ?>
<style>
    .content-wrap {
        box-sizing: border-box;
        padding: 10px;
        margin-top: 0px !important;
    }

    .container {
        display: flex;
        flex-wrap: wrap;
        align-items: stretch;
        width: 100%;
        max-width: 900px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        top: 20px !important;
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

    #infologin {
        margin-bottom: 20px;
        /* Tambahkan margin bawah */
    }

    .password-container {
        position: relative;
    }

    .password-container .toggle-password {
        position: absolute;
        right: 30px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
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
                Login Pelaporan untuk Ketua Satgas dan anggota yang ditunjuk.<br><br>
                Username diisi alamat email yang terdaftar pada SK Satgas.<br>
                Password diisi menggunakan password yang telah Anda buat. <br><br>Jika baru pertama kali login, silakan klik Reset Password, maka "kode password" awal akan dikirimkan ke alamat email Anda.
            </div>
        </div>
        <div class="right-column">
            <div class="login-container">
                <h2>Login Operator Satgas</h2>
                <form action="<?= base_url('cek_login') ?>" method="POST">
                    <?= csrf_field() ?>
                    <input type="email" id="username" name="username" placeholder="Username" required>
                    <div class="password-container">
                        <input type="password" id="password" name="password" placeholder="Password" required>
                        <span class="toggle-password" onclick="togglePasswordVisibility()">👁️</span>
                    </div>
                    <div id="infologin" style="color: red;">
                        <?php if (session()->getFlashdata('error')) : ?>
                            <?= session()->getFlashdata('error') ?>
                        <?php endif; ?>
                    </div>
                    <br>
                    <div class="btn-container">
                        <button type="submit" class="primary">Masuk</button>
                        <button type="button" id="luppass" class="secondary">Reset Password</button>
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

    document.getElementById("luppass").addEventListener("click", function(event) {
        window.open("<?= base_url('reset_password') ?>", "_self");
    });

    function togglePasswordVisibility() {
        var passwordInput = document.getElementById("password");
        var passwordType = passwordInput.getAttribute("type");
        if (passwordType === "password") {
            passwordInput.setAttribute("type", "text");
        } else {
            passwordInput.setAttribute("type", "password");
        }
    }
</script>

<?= $this->endSection(); ?>