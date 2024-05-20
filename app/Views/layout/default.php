<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TPPK</title>
    <link rel="icon" type="image/png" href="<?= base_url() ?>gambar/logotut.png">
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/my_style.css?v6.2">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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

        .search-area {
            min-height: 70px;
            padding-right: 0;
        }

        .nav-search {
            position: absolute;
            cursor: pointer;
            top: 35px;
            right: 15px;
            color: black;
        }

        .search-ok {
            position: absolute;
            cursor: pointer;
            top: 15px;
            right: 5px;
            color: black;
        }

        .nav-cari {
            position: absolute;
            cursor: pointer;
            top: 22px;
            right: 18px;
            color: #999;
        }

        @media (max-width: 991px) {
            .nav-search {
                top: 26px;
                right: 60px;
            }
        }

        .search-block {
            background-color: rgba(0, 0, 0, 0.65);
            display: none;
            padding: 10px;
            position: absolute;
            right: 15px;
            top: 52px;
            width: 300px;
            z-index: 10;
            margin-top: 0;
        }

        .search-block .form-control {
            background-color: #222;
            border: none;
            color: #fff;
            width: 100%;
            height: 40px;
            padding: 0 7xpx;
        }

        .search-block .search-close {
            color: #999;
            position: absolute;
            top: -28px;
            right: -4px;
            font-size: 27px;
            cursor: pointer;
            background: #23282d;
            padding: 5px;

        }

        @media (max-width: 991px) {
            .search-block {
                background-color: rgba(0, 0, 0, 0.65);
                display: none;
                padding: 5px;
                position: absolute;
                right: 25px;
                top: 110px;
                width: 300px;
                z-index: 10;
                margin-top: 0;
            }

            .search-block .search-close {
                top: -23px;
                right: 0px;
                padding: 0px 10px;
                font-size: 20px;
            }

            .search-block .form-control {
                background-color: #222;
                border: none;
                color: #fff;
                width: 280px;
                height: 40px;
                padding: 0px 10px;
            }

            .search-ok {
                position: absolute;
                cursor: pointer;
                top: 7px;
                right: 7px;
                color: black;
            }
        }

        .search-area .nav-search {
            top: 23px;
        }

        .search-area .search-block .search-close {
            top: -50px;
        }

        .search-area .search-block {
            right: 0;
        }
    </style>

</head>

<?php
$userlogin = session()->get('loggedIn');
$jenisinstansiid = session()->get('jenis_instansi_id');
$npsn = session()->get('npsn_user');
$asallogin = session()->get('asallogin');
$statustppk = session()->get('statustppk');
$namastatus = "";
if ($asallogin == "internal") {
    if ($jenisinstansiid == 5)
        $namastatus = "Akun Operator Sekolah";
    else if ($jenisinstansiid == 2)
        $namastatus = "Akun Dinas Provinsi";
    else if ($jenisinstansiid == 4)
        $namastatus = "Akun BPMP";
    else if ($jenisinstansiid == 18)
        $namastatus = "Akun BPPMPV";
    else if ($jenisinstansiid == 3)
        $namastatus = "Akun Dinas Kab/Kota";
    else if ($jenisinstansiid == 1)
        $namastatus = "Akun Pusat";
    else if ($jenisinstansiid == 99)
        $namastatus = "User Umum";
} else {
    if ($statustppk == "ketua" || $statustppk == "koordinator")
        $namastatus = "Ketua TPPK";
    else
        $namastatus = "Anggota TPPK";
}
?>

<body>

    <div class="logoatas"><a href="#"><img src="<?php echo base_url(); ?>/gambar/logo.png" alt=""></a></div>
    <nav class="nav_kanan">
        <div class="dlogin">
            <ul>
                <?php if (!$userlogin) : ?>
                    <li id="ilogin" class="dropdown">
                        <a href="#" onclick="showmasuk();">Masuk</a>
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
                <li><a href="<?php echo base_url(); ?>residu">Residu</a></li>
                <?php if ($userlogin && $asallogin == "eksternal") { ?>
                    <li><a href="<?php echo base_url(); ?>inputdata/daftar_laporan">Pelaporan</a></li>
                <?php } ?>
                <?php if ($userlogin && ($jenisinstansiid == "99" || $jenisinstansiid == "1" || $jenisinstansiid == "2" || $jenisinstansiid == "3")) { ?>
                    <li><a href="<?php echo base_url(); ?>status_laporan_kekerasan">Pelaporan</a></li>
                <?php } ?>
                <li><a href="<?php echo base_url(); ?>informasi">Informasi</a>
                </li>
            </ul>

        </div>
    </nav>

    <div class="nav-search" id="tbsearch" onclick="tampilsearch()">
        <span>Cari Sekolah/NPSN <i class="fa fa-search"></i></span>
    </div>
    <div class="search-block" id="s-block" style=" display: none;">
        <label for="search-field" class="w-100 mb-0">
            <input type="text" class="form-control" id="search-field" onkeypress="keypressInBox(event)" placeholder="Ketik Nama Sekolah / NPSN">
            <button onclick="yukcari()" class="search-ok">Cari</button>
        </label>
        <span onclick="tutupsearch()" class="search-close">&times;</span>
    </div>

    <div class="navbar-kanan">
        <button onclick="showmenu();" id="xmenu"><i data-feather="menu"></i></button>
    </div>

    <div class="submobile" id="imenu" style="display: none;">
        <ul style="list-style-type: none;">
            <li><a href="<?php echo base_url(); ?>home">Beranda</a></li>
            <li><a href="<?php echo base_url(); ?>dashboard">Dasbor</a></li>
            <li><a href="<?php echo base_url(); ?>tppk/wilayah">TPPK dan Satgas</a></li>
            <li><a href="<?php echo base_url(); ?>residu">Residu</a></li>
            <?php if ($userlogin && $asallogin == "eksternal") { ?>
                <li><a href="<?php echo base_url(); ?>inputdata/daftar_laporan">Pelaporan</a></li>
            <?php } ?>
            <?php if ($userlogin && ($jenisinstansiid == "99" || $jenisinstansiid == "1" || $jenisinstansiid == "2" || $jenisinstansiid == "3")) { ?>
                <li><a href="<?php echo base_url(); ?>status_laporan_kekerasan">Pelaporan</a></li>
            <?php } ?>
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
                <?php if ($jenisinstansiid != 1 && $jenisinstansiid != 4 && $jenisinstansiid != 18 && $jenisinstansiid != 99) { ?>
                    <td><a href="<?php echo base_url(); ?>inputdata">Input Anggota</a></td>
                <?php } ?>
            <?php } ?>
            </tr>
            <?php if ($jenisinstansiid == 1) { ?>
                <tr>
                    <td>
                        <a href="<?php echo base_url(); ?>inputdata/daftar_skbaru">Approve SK</a>
                    </td>
                </tr>
            <?php } ?>
            <?php if ($statustppk == "ketua" || $statustppk == "koordinator") { ?>
                <tr>
                    <td>
                        <a href="<?php echo base_url(); ?>inputdata/daftar_anggota_tppk">Pilih Petugas Pelaporan</a>
                    </td>
                </tr>
            <?php } ?>
            <?php if ($statustppk == "ketua" || $statustppk == "koordinator" || $statustppk == "anggota1" || $statustppk == "anggotalain") { ?>
                <tr>
                    <td>
                        <a href="<?php echo base_url(); ?>tppk/anggota/<?= $npsn ?>?k=0">Lihat TPPK</a>
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

    <div class="submobile2" id="imasuk" style="display: none;">
        <table>
            <tr>
                <td>
                    <a href="https://sso.data.kemdikbud.go.id/sys/login?appkey=<?= appid; ?>" class="dropbtn">Sebagai Operator Sekolah/Dinas</a>
                </td>
            </tr>
            <tr>
                <td>
                    <a href="<?= base_url('/login_dapodik') ?>" class="dropbtn">Sebagai Anggota TPPK</a>
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
    function tampilsearch() {
        document.getElementById('s-block').style.display = "block";
    };

    function tutupsearch() {
        document.getElementById('s-block').style.display = "none";
    };

    function keypressInBox(e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        var isicari = document.getElementById("search-field").value;
        if (code == 13) { // Enter keycode                        
            e.preventDefault();
            window.location.href = "<?php echo site_url('tppk/cari_sekolah/') ?>" + isicari;
        }
    };

    function yukcari() {
        isicari = document.getElementById("search-field").value;
        window.location.href = "<?php echo site_url('tppk/cari_sekolah/') ?>" + isicari;
    }

    function showmenu() {
        var x = document.getElementById("imenu");
        if (x.style.display == "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }

    function showmasuk() {
        var x = document.getElementById("imasuk");
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