<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TPPK</title>
    <link rel="icon" type="image/png" href="<?= base_url() ?>gambar/logotut.png">
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/my_style.css?v5.5">
    <script src="https://unpkg.com/feather-icons"></script>
    <?= $this->renderSection('header') ?>

    <style>
        .tab {
            display: none;
        }

        button {
            background-color: #ccc;
            border: none;
            color: #000;
            padding: 10px 20px;
            cursor: pointer;
        }

        .aktif {
            background-color: blue;
            color: #fff;
        }

        .menutab {
            margin: 80px auto 20px;
            max-width: 1000px;
        }

        .breadcrumps {
            max-width: 1000px;
            margin: 0 auto 20px;
        }
    </style>

</head>

<?php
$username = session()->get('username');
if ($username == "hardianto@kemdikbud.go.id") {
    // session()->set('npsn_user', '20613768');
    session()->set('npsn_user', '20237371');
    session()->set('jenis_instansi_id', '5');
    session()->set('wilayah_akses', '036200');
    // session()->set('wilayah_akses', '286300');
}
$userlogin = session()->get('loggedIn');
$jenisinstansiid = session()->get('jenis_instansi_id');
$npsn = session()->get('npsn_user');
$namastatus = "";

if ($jenisinstansiid == 5)
    $namastatus = "Akun Operator Sekolah";
else if ($jenisinstansiid == 2)
    $namastatus = "Akun Dinas Provinsi";
else if ($jenisinstansiid == 3)
    $namastatus = "Akun Dinas Kab/Kota";
else if ($jenisinstansiid == 1)
    $namastatus = "Akun Pusat";
?>

<body>

    <div class="logoatas"><a href="#"><img src="<?php echo base_url(); ?>/gambar/logo.png" alt=""></a></div>
    <nav class="nav_kanan">
        <div class="dlogin">
            <ul>
                <?php if (!$userlogin) : ?>
                    <li id="ilogin" class="dropdown">
                        <a href="https://sso.data.kemdikbud.go.id/sys/login?appkey=<?= appid; ?>" class="dropbtn">Masuk</a>
                    </li>
                <?php endif; ?>
                <?php if ($userlogin) : ?>
                    <li id="ilogout"><a href="#" onclick="showmenu2();"><img class="ikon" src="<?= base_url() ?>gambar/user.png" alt=""> <?= session()->get('nama'); ?></a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    <nav class="navbar">
        <div class="navbar-nav">
            <ul>
                <li><a href="<?php echo base_url(); ?>home">Beranda</a></li>
                <li><a href="<?php echo base_url(); ?>dashboard">Dasbor</a></li>
                <li><a href="<?php echo base_url(); ?>tppk/wilayah">TPPK dan Satuan Tugas</a></li>
                <li><a href="<?php echo base_url(); ?>informasi">Informasi</a>
                </li>
            </ul>

        </div>
    </nav>

    <div class="navbar-kanan">
        <button onclick="showmenu();" id="xmenu"><i data-feather="menu"></i></button>
    </div>

    <div class="submobile" id="imenu" style="display: none;">
        <ul style="list-style-type: none;">
            <li><a href="<?php echo base_url(); ?>home">Beranda</a></li>
            <li><a href="<?php echo base_url(); ?>dashboard">Dasbor</a></li>
            <li><a href="<?php echo base_url(); ?>tppk/wilayah">TPPK dan Satgas</a></li>
            <li><a href="<?php echo base_url(); ?>informasi">Informasi</a></li>
        </ul>
    </div>

    <div class="submobile2" id="imenu2" style="display: none;">
        <table>
            <tr style="background-color:#ccc;color:white;">
                <td>
                    &nbsp;<?= $namastatus ?>
                </td>
            </tr>
            <tr>
            </tr>
            <?php if ($jenisinstansiid == 5) { ?>
                <td><a href="<?php echo base_url() . 'tppk/anggota/' . $npsn ?>">Anggota</a></td>
            <?php } else { ?>
                <?php if ($jenisinstansiid != 1) { ?>
                    <td><a href="<?php echo base_url(); ?>inputdata">Input Anggota</a></td>
                <?php } ?>
            <?php } ?>
            </tr>
            <?php if ($jenisinstansiid == 1) { ?>
                <tr>
                    <td>
                        <a href="<?php echo base_url(); ?>inputdata/daftar_skbaru">Approval SK</a>
                    </td>
                </tr>
            <?php } ?>
            <tr>
                <td>
                    <hr>
                </td>
            </tr>
            <tr>
                <td>
                    <a href="<?php echo base_url(); ?>login/logout">Keluar</a>
                </td>
            </tr>
        </table>
    </div>

    <!-- dbo.app untuk local 4cade60a-2f9f-4946-8839-a4df754b1621 -->
    <!-- dbo.app untuk referensi.data D1D21323-6C8F-4F30-A005-3FA5DECA4C05 -->

    <?= $this->renderSection('konten') ?>

    <script>
        feather.replace()
    </script>

</body>

</html>

<script>
    function showmenu() {
        var x = document.getElementById("imenu");
        if (x.style.display == "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }

    function showmenu2() {
        var x = document.getElementById("imenu2");
        if (x.style.display == "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }
</script>
<?= $this->renderSection('scriptfooter') ?>