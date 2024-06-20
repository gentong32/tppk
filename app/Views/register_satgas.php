<?= $this->extend('layout/default') ?>

<?= $this->section('header') ?>
<style>

</style>
<link rel="stylesheet" href="<?= base_url() ?>css/myregister.css?v1.1">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<?= $this->endSection() ?>


<?= $this->section('konten') ?>
<div class="register-container">
    <h2>Register User Baru</h2>

    <?php if (session()->getFlashdata('error')) : ?>
        <div style="color: red;">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <form id="registerForm" action="<?= base_url('add_operator_satgas'); ?>" method="POST">
        <label for="nik">NIK:</label>
        <input type="text" id="nik" name="nik" maxlength="16" required>
        <div class="errorinfo" id="nik_info">NIK sudah terdaftar. Silakan login atau gunakan NIK lain.</div>

        <label for="nama_lengkap">Nama Lengkap:</label>
        <input type="text" id="nama_lengkap" name="nama_lengkap" required>

        <label for="nama_lengkap">Tempat Lahir:</label>
        <input type="text" id="tempat_lahir" name="tempat_lahir" required>

        <label for="tanggal_lahir">Tanggal Lahir:</label>
        <input type="text" id="tanggal_lahir" name="tanggal_lahir" required>

        <label for="jenis_kelamin">Jenis Kelamin:</label>
        <select id="jenis_kelamin" name="jenis_kelamin" required>
            <option value="Laki-Laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
        </select>
        <div style="display: none;" id="info_padandata" rows="4" cols="50" readonly></div>

        <button id="tbcek" onclick="return cekvalid();">Cek Dukcapil</button>

        <div id="extraFields" style="display: none;">
            <label for="alamat">Alamat Rumah:</label>
            <textarea id="alamat" name="alamat" required></textarea>

            <label for="no_hp">No. HP:</label>
            <input type="tel" id="no_hp" name="no_hp" required>

            <label for="email">Alamat Email:</label>
            <input type="email" id="email" name="email" required>
            <div class="errorinfo" id="email_info">Email sudah terdaftar. Silakan login atau gunakan email lain.</div>

            <label for="password">Password:</label>
            <div class="password-container">
                <input type="password" id="password" name="password" required>
                <span class="toggle-password" onclick="togglePasswordVisibility('password')">👁️</span>
            </div>

            <label for="konfirm_password">Ulangi Password:</label>
            <div class="password-container">
                <input type="password" id="konfirm_password" name="konfirm_password" required>
                <span class="toggle-password" onclick="togglePasswordVisibility('konfirm_password')">👁️</span>
            </div>
            <div class="errorinfo" id="passwordError">Password dan Ulangi Password tidak sama.</div>

            <label for="provinsi">Provinsi:</label>
            <select id="provinsi" name="provinsi" required>
                <?php
                foreach ($daf_provinsi as $row) {
                    if (trim($row['kode_wilayah']) == "350000")
                        continue;
                    echo "<option value='" . $row['kode_wilayah'] . "'>" . $row['nama'] . "</option>";
                }
                ?>
            </select>

            <label for="kota">Kota/Kabupaten: <span style=color:red><sup>*) diisi jika dari dinas kabupaten</sup></span></label>
            <select id="kota" name="kota" required>
            </select>

            <label for="captcha">Captcha:</label>
            <div class="captcha-container">
                <canvas id="captchaCanvas" width="100" height="40"></canvas>
                <button type="button" onclick="generateCaptcha()">Refresh</button>
            </div>
            <input type="text" id="captcha" name="captcha" placeholder="Enter captcha" required>
            <input type="hidden" id="csrf_test_name" name="csrf_test_name" value="<?= csrf_hash() ?>">

            <button type="submit">Register</button>

        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    var csrfToken;
    var isTidakSesuai = false;
    var klirpisan = false;
    var klirsekali = false;
    document.addEventListener("DOMContentLoaded", function() {
        const provinsiSelect = document.getElementById("provinsi");
        const nikInput = document.getElementById("nik");
        const jenisKelaminSelect = document.getElementById("jenis_kelamin");

        nikInput.addEventListener("input", function() {
            if (this.value.length === 16) {
                const karakterKe6 = parseInt(this.value.charAt(6), 10);
                if (karakterKe6 >= 4) {
                    jenisKelaminSelect.value = "Perempuan";
                } else {
                    jenisKelaminSelect.value = "Laki-Laki";
                }
            }
        });

        provinsiSelect.addEventListener("change", function() {
            const selectedProvinsi = this.value;
            getkota(selectedProvinsi);

        });

        $('#tanggal_lahir').datepicker({
            dateFormat: "dd-mm-yy",
            changeMonth: true,
            changeYear: true,
            yearRange: "c-100:c-10",
        });

        getkota(provinsiSelect.value);
        generateCaptcha();
    });

    function generateCaptcha() {
        const canvas = document.getElementById("captchaCanvas");
        const ctx = canvas.getContext("2d");

        ctx.clearRect(0, 0, canvas.width, canvas.height);

        const captchaText = Math.floor(Math.random() * 10000).toString().padStart(4, '0');

        document.getElementById("captcha").setAttribute("data-captcha", captchaText);

        ctx.font = "30px Arial";
        ctx.textBaseline = "middle";

        for (let i = 0; i < captchaText.length; i++) {
            const char = captchaText[i];
            const x = 10 + i * 20;
            const y = 20;
            const angle = Math.random() * 0.4 - 0.2;

            ctx.save();
            ctx.translate(x, y);
            ctx.rotate(angle);
            ctx.fillText(char, 0, 0);
            ctx.restore();
        }

        for (let i = 0; i < 8; i++) {
            ctx.beginPath();
            ctx.moveTo(Math.random() * canvas.width, Math.random() * canvas.height);
            ctx.lineTo(Math.random() * canvas.width, Math.random() * canvas.height);
            ctx.strokeStyle = `rgba(0, 0, 0, ${Math.random()})`;
            ctx.lineWidth = Math.random() * 2;
            ctx.stroke();
        }
    }

    document.getElementById("registerForm").addEventListener("submit", function(event) {
        const captchaInput = document.getElementById("captcha").value;
        const captchaData = document.getElementById("captcha").getAttribute("data-captcha");

        if (captchaInput !== captchaData) {
            alert("Captcha tidak sesuai");
            event.preventDefault();
        }
    });

    function getkota(kode_provinsi) {
        const kotaSelect = document.getElementById("kota");
        fetch(`<?php echo base_url() ?>inputdata/getNamaWilayah?kode=${kode_provinsi}&level=2`)
            .then(response => response.json())
            .then(result => {
                kotaSelect.innerHTML = '<option value="0"> --- </option>';
                result.forEach(item => {
                    const option = document.createElement("option");
                    option.value = item.kode_wilayah;
                    option.textContent = item.nama;
                    kotaSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching kota:', error));
    }

    function cekvalid() {
        var datanik = document.getElementById('nik').value;
        var datanama = document.getElementById('nama_lengkap').value;
        var datatptahir = document.getElementById('tempat_lahir').value;
        var datatglahir = document.getElementById('tanggal_lahir').value;
        var datajeniskelamin = document.getElementById('jenis_kelamin').value;
        csrfToken = document.getElementById('csrf_test_name');

        if (datanik.length != 16) {
            alert("Jumlah karakter NIK harus 16 digit");
            return false;
        }

        fetch('<?php echo base_url() ?>inputdata/padankandata', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken.value,
                },
                body: JSON.stringify({
                    nik: datanik,
                    nama: datanama,
                    tptahir: datatptahir,
                    tglahir: datatglahir,
                    sex: datajeniskelamin
                })
            })
            .then(response => response.json())
            .then(result => {
                // console.log(result);
                csrfToken.value = result.csrf;

                if (result.NAMA_LGKP) {
                    var NAMA_LGKP = result.NAMA_LGKP;
                    var TPT_LAHIR = result.TMPT_LHR;
                    var TGL_LAHIR = result.TGL_LHR;
                    var NIK = result.NIK;
                    var JENIS_KLMIN = result.JENIS_KLMIN;

                    NAMA_LGKP = NAMA_LGKP.split('(')[0];
                    TPT_LAHIR = TPT_LAHIR.split('(')[0];


                    if ((NAMA_LGKP).includes("Tidak"))
                        NAMA_LGKP = "<span style='color:red'>" + NAMA_LGKP + "</span>";
                    else
                        NAMA_LGKP = "<span style='color:green'>" + NAMA_LGKP + "</span>";
                    if ((TPT_LAHIR).includes("Tidak"))
                        TPT_LAHIR = "<span style='color:red'>" + TPT_LAHIR + "</span>";
                    else
                        TPT_LAHIR = "<span style='color:green'>" + TPT_LAHIR + "</span>";
                    if ((TGL_LAHIR).includes("Tidak"))
                        TGL_LAHIR = "<span style='color:red'>" + TGL_LAHIR + "</span>";
                    else
                        TGL_LAHIR = "<span style='color:green'>" + TGL_LAHIR + "</span>";
                    if ((NIK).includes("Tidak"))
                        NIK = "<span style='color:red'>" + NIK + "</span>";
                    else
                        NIK = "<span style='color:green'>" + NIK + "</span>";
                    if ((JENIS_KLMIN).includes("Tidak"))
                        JENIS_KLMIN = "<span style='color:red'>" + JENIS_KLMIN + "</span>";
                    else
                        JENIS_KLMIN = "<span style='color:green'>" + JENIS_KLMIN + "</span>";

                    var infoText = "NIK: " + NIK + "<br>";
                    infoText += "Nama Lengkap: " + NAMA_LGKP + "<br>";
                    infoText += "Tempat Lahir: " + TPT_LAHIR + "<br>";
                    infoText += "Tanggal Lahir: " + TGL_LAHIR + "<br>";
                    infoText += "Jenis Kelamin: " + JENIS_KLMIN + "<br>";

                    isTidakSesuai = infoText.includes("Tidak");

                } else {
                    isTidakSesuai = true;
                    infoText = "<span style='color:red'>LAYANAN DUKCAPIL SUDAH TUTUP (PUKUL 20:00 WIB). SILAKAN REGISTRASI KEMBALI BESOK PAGI MULAI PUKUL 07:00 WIB.</span>";
                    document.getElementById("tbcek").style.display = "none";
                }

                document.getElementById("info_padandata").innerHTML = infoText;
                document.getElementById("info_padandata").style.display = "block";

                if (isTidakSesuai) {
                    document.getElementById("extraFields").style.display = "none";
                } else {
                    document.getElementById("tbcek").style.display = "none";
                    document.getElementById("extraFields").style.display = "block";
                }

            })
            .catch(error => {
                alert("ERROR");
            });

        return false;
    }

    var inputFields = document.querySelectorAll('#nik, #nama_lengkap, #tempat_lahir, #tanggal_lahir, #jenis_kelamin');

    inputFields.forEach(function(input) {
        input.addEventListener('input', function() {
            document.getElementById("tbcek").style.display = "block";
            document.getElementById("info_padandata").style.display = "none";
            document.getElementById("extraFields").style.display = "none";
        });
    });

    function togglePasswordVisibility(id) {
        var passwordField = document.getElementById(id);
        var type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);
    }

    document.getElementById("registerForm").addEventListener("submit", function(event) {
        var password = document.getElementById("password").value;
        var confirmPassword = document.getElementById("konfirm_password").value;
        var passwordError = document.getElementById("passwordError");

        if (password !== confirmPassword) {
            passwordError.style.display = "block";
            event.preventDefault();
        } else {
            passwordError.style.display = "none";
        }
    });

    document.getElementById("nik").addEventListener("input", function(event) {
        var nikinfo = document.getElementById("nik_info");
        if (klirpisan == false) {
            klirpisan = true;
            nikinfo.style.display = "none";
        }
    });

    document.getElementById("email").addEventListener("input", function(event) {
        var emailinfo = document.getElementById("email_info");
        if (klirsekali == false) {
            klirsekali = true;
            emailinfo.style.display = "none";
        }
    });

    document.getElementById("nik").addEventListener("change", function(event) {
        var nik = this.value;
        var nikinfo = document.getElementById("nik_info");
        csrfToken = document.getElementById('csrf_test_name');

        fetch('<?php echo base_url() ?>cek_nik', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken.value,
                },
                body: JSON.stringify({
                    nik: nik,
                })
            })
            .then(response => response.json())
            .then(result => {
                if (result.exists) {
                    nikinfo.style.display = "block";
                    klirpisan = false;
                } else {
                    nikinfo.style.display = "none";
                }
                csrfToken.value = result.csrf;
            })
            .catch(error => {
                alert("error");
            });
    });

    document.getElementById("email").addEventListener("change", function(event) {
        var email = this.value;
        var emailinfo = document.getElementById("email_info");
        csrfToken = document.getElementById('csrf_test_name');

        fetch('<?php echo base_url() ?>cek_email', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken.value,
                },
                body: JSON.stringify({
                    email: email,
                })
            })
            .then(response => response.json())
            .then(result => {
                if (result.exists) {
                    emailinfo.style.display = "block";
                    klirsekali = false;
                } else {
                    emailinfo.style.display = "none";
                }
                csrfToken.value = result.csrf;
            })
            .catch(error => {
                alert("error");
                // console.error(error);
            });
    });
</script>

<?= $this->endSection(); ?>