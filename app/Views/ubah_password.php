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

    .password-container input[type="password"],
    .password-container input[type="text"] {
        width: 100%;
        padding-right: 40px;
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
                <h2>Silakan Update Password</h2>
                <form id="ubah-password-form" action="<?= base_url('add_operator_satgas_password') ?>" method="POST">
                    <?= csrf_field() ?>
                    Ketik password baru (minimal 8 karakter kombinasi huruf dan angka)
                    <div class="password-container">
                        <input type="password" id="password1" name="password1" placeholder="Password" required pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$" title="Password harus minimal 8 karakter dan mengandung setidaknya satu huruf dan satu angka.">
                        <span class="toggle-password" onclick="togglePasswordVisibility(1)">👁️</span>
                    </div>
                    Konfirmasi password baru
                    <div class="password-container">
                        <input type="password" id="password2" name="password2" placeholder="Password" required pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$" title="Password harus minimal 8 karakter dan mengandung setidaknya satu huruf dan satu angka.">
                        <span class="toggle-password" onclick="togglePasswordVisibility(2)">👁️</span>
                    </div>
                    <div id="error-message" style="color: red; display: none;">
                        Password dan Konfirmasi Password tidak sama.
                    </div>
                    <br>
                    <div class="btn-container">
                        <button type="submit" class="primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePasswordVisibility(indeks) {
        var passwordInput = document.getElementById("password" + indeks);
        var passwordType = passwordInput.getAttribute("type");
        if (passwordType === "password") {
            passwordInput.setAttribute("type", "text");
        } else {
            passwordInput.setAttribute("type", "password");
        }
    }

    document.getElementById('ubah-password-form').addEventListener('submit', function(event) {
        var password1 = document.getElementById("password1").value;
        var password2 = document.getElementById("password2").value;
        var errorMessage = document.getElementById("error-message");

        var pattern = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;

        if (!pattern.test(password1)) {
            errorMessage.textContent = "Password harus minimal 8 karakter dan mengandung setidaknya satu huruf dan satu angka.";
            errorMessage.style.display = "block";
            event.preventDefault(); // Mencegah form submit
            return;
        }

        if (password1 !== password2) {
            errorMessage.textContent = "Password dan Konfirmasi Password tidak sama.";
            errorMessage.style.display = "block";
            event.preventDefault(); // Mencegah form submit
            return;
        }

        errorMessage.style.display = "none";
    });
</script>

<?= $this->endSection(); ?>