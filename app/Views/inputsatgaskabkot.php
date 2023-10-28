<?= $this->extend('layout/default') ?>

<?= $this->section('header') ?>
<!-- Custom stylesheet -->
<link rel="stylesheet" href="<?= base_url() ?>css/select2.min.css">
<!-- Autocomplete -->
<!-- <link rel="stylesheet" href="<? //= base_url() 
                                    ?>css/smoothness_jquery-ui.css"> -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script> -->
<!-- <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="<?= base_url() ?>js/jquery-ui-i18n.min.js"></script>

<style>
    * {
        box-sizing: border-box;
    }

    body {
        font-size: 12px;
        /* background: linear-gradient(to bottom, #DDDDE1, #F9F9FC); */
    }

    .landing-page {
        /* min-height: 100vh; */
        /* display: flex; */
        justify-content: center;
        align-items: center;
    }

    .infoul {
        margin-left: 0px;
        margin-top: 20px;
        list-style-type: none;
        font-size: 13px;
    }

    .info-container {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.5s ease;
    }

    .info-container.show {
        max-height: 370px;
    }

    .multilineInput {
        max-width: 350px;
        height: 60px;
        width: 100%;
        padding: 2px;
    }

    #tbtambah {
        background-color: dodgerblue;
        color: #ffffff;
        cursor: pointer;
        margin: auto;
        text-align: center;
        width: 130px;
        padding: 10px;
        justify-content: center;
        align-items: center;
        border: 1px solid gray;
    }

    #tbtambah:hover {
        background-color: deepskyblue;
    }

    #tbkurang {
        background-color: chocolate;
        color: #ffffff;
        cursor: pointer;
        margin: auto;
        text-align: center;
        width: 130px;
        padding: 10px;
        justify-content: center;
        align-items: center;
        border: 1px solid gray;
    }

    #tbkurang:hover {
        background-color: coral;
    }

    .tbcek {
        background-color: sandybrown;
        color: #000;
        cursor: pointer;
        margin: auto;
        text-align: center;
        width: 110px;
        height: 30px;
        padding: 2px;
        justify-content: center;
        align-items: center;
        border: 1px solid gray;
    }

    .tbcek:hover {
        background-color: wheat;
    }
</style>
</style>
<?= $this->endSection() ?>

<?php
$instansianggota = [];
$namaanggota = [];
$nikanggota = [];
$tglahiranggota = [];
$sexanggota = [];
$hapeanggota = [];
$emailanggota = [];
$jmlanggota = 0;

if ($opsi == "edit") {
    foreach ($anggotasatgas as $row) {
        $instansianggota[] = $row['jenis_instansi_id'];
        $namaanggota[] = $row['namaanggota'];
        $nikanggota[] = $row['nik'];
        $tglahiranggota[] = $row['tanggal_lahir'];
        $sexanggota[] = $row['sex'];
        $hapeanggota[] = $row['telepon'];
        $emailanggota[] = $row['email'];
        $dukcapilanggota[] = $row['status_dukcapil'];
        $jmlanggota++;
    }
}

if ($jmlanggota == 0) {
    $tglahiranggota[0] = '';
    $instansianggota[0] = '00';
}

for ($a = $jmlanggota + 1; $a <= 28; $a++) {
    $tglahiranggota[$a] = '';
    $instansianggota[$a] = '00';
}

?>

<?= $this->section('konten') ?>
<br>
<div class="content-wrap">
    <div class="landing-page">
        <div class="form-container">
            <h2 class="form-title">Satuan Tugas Kabupaten/Kota</h2>
            <form action="<?= base_url() ?>inputdata/simpansatgas" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="id_level_wilayah" id="id_level_wilayah" value="2">
                <div class="form-group">
                    <label for="ipropinsi">Provinsi</label>
                    <div id="dpropinsi">
                        <select <?= ($sebagai == "dinaskota") ? "disabled" : "" ?> class="single" id="ipropinsi" name="ipropinsi">
                            <option value="00">- Pilih Provinsi -</option>
                            <?php foreach ($namaPropinsi as $row) :
                                $cekkode = "";
                                if (trim($wilayahsaya) == trim($row->kode_wilayah))
                                    $cekkode = "selected";
                                echo "<option " . $cekkode . " value='" . trim($row->kode_wilayah) . "'>" . (substr($row->nama, 0, 4) == "Prov" ? substr($row->nama, 5) : $row->nama) . "</option>";
                            endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="ikota">Kota/Kabupaten</label>
                    <div id="dkota">
                        <select <?= ($sebagai == "dinaskota") ? "disabled" : "" ?> class="single" id="ikota" name="ikota">
                            <option value="00">- Pilih Kota/Kabupaten -</option>
                            <?php
                            if ($sebagai == "dinaskota") {
                                foreach ($namaKota as $row) :
                                    $cekkode = "";
                                    if (trim($wilayahkotasaya) == trim($row->kode_wilayah))
                                        $cekkode = "selected";
                                    echo "<option " . $cekkode . " value='" . trim($row->kode_wilayah) . "'>" . (substr($row->nama, 0, 4) == "Prov" ? substr($row->nama, 5) : $row->nama) . "</option>";
                                endforeach;
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="nomor_sk">Nomor SK</label>
                    <input type="text" id="nomor_sk" name="nomor_sk" value="<?= ($opsi == 'edit') ? $datask['nomor_sk'] : '' ?>">
                </div>
                <div class="form-group">
                    <label for="tanggal_sk">Tanggal SK</label>
                    <input type="text" id="tanggal_sk" name="tanggal_sk" value="<?= ($opsi == 'edit') ? date('d-m-Y', strtotime($datask['tanggal_sk'])) : '' ?>">
                </div>

                <div class="form-group">
                    <label for="file_sk">FIle SK</label>
                    <input type="file" id="file_sk" name="file_sk" accept=".jpg,.jpeg,.png,.pdf">
                </div>

                <?php
                if ($opsi == "edit") {
                    $namafileoke = preg_replace("/[^a-zA-Z0-9]/", "", $datask['nomor_sk']);
                    $namafilebaru = "sk_" . trim($wilayahsaya) . "_" . $namafileoke;
                    echo "<span style='color:grey;margin-left:130px;'><i>" . $namafilebaru . "</i></span>";
                }
                ?>
                <div style="margin-bottom: 25px;"></div>

                <h2 class="form-title">Keanggotaan</h2>



                <ul class="infoul">
                    <li>
                        <a href="#" onclick="toggleInfo(event,0)">
                            <h3 style="margin-bottom:15px;">KETUA: DINAS PENDIDIKAN &#9660;</h3>
                        </a>
                        <div id="info0" class="fanggota info-container" style="margin-bottom:10px">
                            <div class="form-group ctim">
                                <label for="inama0">Nama</label>
                                <input type="text" id="inama0" name="inama0" value="<?= ($opsi == 'edit') ? $namaanggota[0] : '' ?>">
                            </div>
                            <div class="form-group ctim">
                                <label for="inik1">NIK</label>
                                <input type="text" maxlength="16" id="inik0" name="inik0" value="<?= ($opsi == 'edit') ? $nikanggota[0] : '' ?>">
                            </div>
                            <div class="form-group ctim">
                                <label for="itglahir0">Tanggal Lahir</label>
                                <input type="text" id="itglahir0" name="itglahir0" value="<?= ($opsi == 'edit' && $tglahiranggota[0] != '') ? date('d-m-Y', strtotime($tglahiranggota[0])) : '' ?>">
                            </div>
                            <div class="form-group ctim">
                                <label for="isex0">Jenis Kelamin</label>
                                <select class="single" id="isex0" name="isex0">
                                    <option value="0">- Pilih Jenis Kelamin -</option>
                                    <option <?= ($opsi == 'edit' && $sexanggota[0] == 1) ? 'selected' : '' ?> value="1">Laki-laki</option>
                                    <option <?= ($opsi == 'edit' && $sexanggota[0] == 2) ? 'selected' : '' ?> value="2">Perempuan</option>
                                </select>
                            </div>
                            <div class="form-group ctim">
                                <label for="ihp0">Nomor HP</label>
                                <input type="text" id="ihp0" name="ihp0" value="<?= ($opsi == 'edit') ? $hapeanggota[0] : '' ?>">
                            </div>
                            <div class="form-group ctim">
                                <label for="iemail0">Email</label>
                                <input type="text" id="iemail0" name="iemail0" value="<?= ($opsi == 'edit') ? $emailanggota[0] : '' ?>">
                            </div>
                            <div class="form-group ctim">
                                <label for="idukcapil0">Status Dukcapil</label>
                                <textarea readonly id="idukcapil0" name="idukcapil0" class="multilineInput"><?= ($opsi == 'edit') ? $dukcapilanggota[0] : '' ?></textarea>
                            </div>
                            <button class="tbcek" onclick="return ceknama(0);">Cek Dukcapil</button>
                        </div>
                        <hr class="hrtim">
                    </li>
                    <li>
                        <a href="#" onclick="toggleInfo(event,1)">
                            <h3 style="margin-bottom:15px;">ANGGOTA 1: DINAS PENDIDIKAN &#9660;</h3>
                        </a>
                        <div id="info1" class="fanggota info-container" style="margin-bottom:10px">
                            <div class="form-group ctim">
                                <label for="inama1">Nama</label>
                                <input type="text" id="inama1" name="inama1" value="<?= ($opsi == 'edit') ? $namaanggota[1] : '' ?>">
                            </div>
                            <div class="form-group ctim">
                                <label for="inik1">NIK</label>
                                <input type="text" maxlength="16" id="inik1" name="inik1" value="<?= ($opsi == 'edit') ? $nikanggota[1] : '' ?>">
                            </div>
                            <div class="form-group ctim">
                                <label for="itglahir1">Tanggal Lahir</label>
                                <input type="text" id="itglahir1" name="itglahir1" value="<?= ($opsi == 'edit' && $tglahiranggota[1] != '') ? date('d-m-Y', strtotime($tglahiranggota[1])) : '' ?>">
                            </div>
                            <div class="form-group ctim">
                                <label for="isex1">Jenis Kelamin</label>
                                <select class="single" id="isex1" name="isex1">
                                    <option value="0">- Pilih Jenis Kelamin -</option>
                                    <option <?= ($opsi == 'edit' && $sexanggota[1] == 1) ? 'selected' : '' ?> value="1">Laki-laki</option>
                                    <option <?= ($opsi == 'edit' && $sexanggota[1] == 2) ? 'selected' : '' ?> value="2">Perempuan</option>
                                </select>
                            </div>
                            <div class="form-group ctim">
                                <label for="ihp1">Nomor HP</label>
                                <input type="text" id="ihp1" name="ihp1" value="<?= ($opsi == 'edit') ? $hapeanggota[1] : '' ?>">
                            </div>
                            <div class="form-group ctim">
                                <label for="iemail1">Email</label>
                                <input type="text" id="iemail1" name="iemail1" value="<?= ($opsi == 'edit') ? $emailanggota[1] : '' ?>">
                            </div>
                            <div class="form-group ctim">
                                <label for="idukcapil1">Status Dukcapil</label>
                                <textarea readonly id="idukcapil1" name="idukcapil1" class="multilineInput"><?= ($opsi == 'edit') ? $dukcapilanggota[1] : '' ?></textarea>
                            </div>
                            <button class="tbcek" onclick="return ceknama(1);">Cek Dukcapil</button>
                        </div>
                        <hr class="hrtim">
                    </li>
                    <li>
                        <a href="#" onclick="toggleInfo(event,2)">
                            <h3 style="margin-bottom:15px;">ANGGOTA 2: DINAS SOSIAL &#9660;</h3>
                        </a>
                        <div id="info2" class="fanggota info-container" style="margin-bottom:10px">
                            <div class="form-group ctim">
                                <label for="inama2">Nama</label>
                                <input type="text" id="inama2" name="inama2" value="<?= ($opsi == 'edit') ? $namaanggota[2] : '' ?>">
                            </div>
                            <div class="form-group ctim">
                                <label for="inik2">NIK</label>
                                <input type="text" maxlength="16" id="inik2" name="inik2" value="<?= ($opsi == 'edit') ? $nikanggota[2] : '' ?>">
                            </div>
                            <div class="form-group ctim">
                                <label for="itglahir2">Tanggal Lahir</label>
                                <input type="text" id="itglahir2" name="itglahir2" value="<?= ($opsi == 'edit' && $tglahiranggota[2] != '') ? date('d-m-Y', strtotime($tglahiranggota[2])) : '' ?>">
                            </div>
                            <div class="form-group ctim">
                                <label for="isex2">Jenis Kelamin</label>
                                <select class="single" id="isex2" name="isex2">
                                    <option value="0">- Pilih Jenis Kelamin -</option>
                                    <option <?= ($opsi == 'edit' && $sexanggota[2] == 1) ? 'selected' : '' ?> value="1">Laki-laki</option>
                                    <option <?= ($opsi == 'edit' && $sexanggota[2] == 2) ? 'selected' : '' ?> value="2">Perempuan</option>
                                </select>
                            </div>
                            <div class="form-group ctim">
                                <label for="ihp2">Nomor HP</label>
                                <input type="text" id="ihp2" name="ihp2" value="<?= ($opsi == 'edit') ? $hapeanggota[2] : '' ?>">
                            </div>
                            <div class="form-group ctim">
                                <label for="iemail2">Email</label>
                                <input type="text" id="iemail2" name="iemail2" value="<?= ($opsi == 'edit') ? $emailanggota[2] : '' ?>">
                            </div>
                            <div class="form-group ctim">
                                <label for="idukcapil2">Status Dukcapil</label>
                                <textarea readonly id="idukcapil2" name="idukcapil2" class="multilineInput"><?= ($opsi == 'edit') ? $dukcapilanggota[2] : '' ?></textarea>
                            </div>
                            <button class="tbcek" onclick="return ceknama(2);">Cek Dukcapil</button>
                        </div>
                        <hr class="hrtim">
                    </li>
                    <li>
                        <a href="#" onclick="toggleInfo(event,3)">
                            <h3 style="margin-bottom:15px;">ANGGOTA 3: DINAS PPPA &#9660;</h3>
                        </a>
                        <div id="info3" class="fanggota info-container" style="margin-bottom:10px">
                            <div class="form-group ctim">
                                <label for="inama3">Nama</label>
                                <input type="text" id="inama3" name="inama3" value="<?= ($opsi == 'edit') ? $namaanggota[3] : '' ?>">
                            </div>
                            <div class="form-group ctim">
                                <label for="inik3">NIK</label>
                                <input type="text" maxlength="16" id="inik3" name="inik3" value="<?= ($opsi == 'edit') ? $nikanggota[3] : '' ?>">
                            </div>
                            <div class="form-group ctim">
                                <label for="itglahir3">Tanggal Lahir</label>
                                <input type="text" id="itglahir3" name="itglahir3" value="<?= ($opsi == 'edit' && $tglahiranggota[3] != '') ? date('d-m-Y', strtotime($tglahiranggota[3])) : '' ?>">
                            </div>
                            <div class="form-group ctim">
                                <label for="isex3">Jenis Kelamin</label>
                                <select class="single" id="isex3" name="isex3">
                                    <option value="0">- Pilih Jenis Kelamin -</option>
                                    <option <?= ($opsi == 'edit' && $sexanggota[3] == 1) ? 'selected' : '' ?> value="1">Laki-laki</option>
                                    <option <?= ($opsi == 'edit' && $sexanggota[3] == 2) ? 'selected' : '' ?> value="2">Perempuan</option>
                                </select>
                            </div>
                            <div class="form-group ctim">
                                <label for="ihp3">Nomor HP</label>
                                <input type="text" id="ihp3" name="ihp3" value="<?= ($opsi == 'edit') ? $hapeanggota[3] : '' ?>">
                            </div>
                            <div class="form-group ctim">
                                <label for="iemail3">Email</label>
                                <input type="text" id="iemail3" name="iemail3" value="<?= ($opsi == 'edit') ? $emailanggota[3] : '' ?>">
                            </div>
                            <div class="form-group ctim">
                                <label for="idukcapil3">Status Dukcapil</label>
                                <textarea readonly id="idukcapil3" name="idukcapil3" class="multilineInput"><?= ($opsi == 'edit') ? $dukcapilanggota[3] : '' ?></textarea>
                            </div>
                            <button class="tbcek" onclick="return ceknama(3);">Cek Dukcapil</button>
                        </div>
                        <hr class="hrtim">
                    </li>
                    <li>
                        <a href="#" onclick="toggleInfo(event,4)">
                            <h3 style="margin-bottom:15px;">ANGGOTA 4 &#9660;</h3>
                        </a>
                        <?php $a = 4; ?>
                        <div id="info4" class="fanggota info-container" style="margin-bottom:10px">
                            <div class="form-group ctim">
                                <label for="djenis<?= $a ?>">Instansi</label>
                                <div id="djenis<?= $a ?>">
                                    <select class="single" id="idinas<?= $a ?>" name="idinas<?= $a ?>">
                                        <option value="00">- Pilih Instansi -</option>
                                        <option <?= ($opsi == 'edit' && $jmlanggota >= ($a + 1) && $instansianggota[$a] == 20) ? 'selected' : '' ?> value="20">Dinas Pendidikan</option>
                                        <option <?= ($opsi == 'edit' && $jmlanggota >= ($a + 1) && $instansianggota[$a] == 21) ? 'selected' : '' ?> value="21">Dinas Sosial</option>
                                        <option <?= ($opsi == 'edit' && $jmlanggota >= ($a + 1) && $instansianggota[$a] == 22) ? 'selected' : '' ?> value="22">Dinas PPPA</option>
                                        <option <?= ($opsi == 'edit' && $jmlanggota >= ($a + 1) && $instansianggota[$a] == 23) ? 'selected' : '' ?> value="23">Dinas Kesehatan</option>
                                        <option <?= ($opsi == 'edit' && $jmlanggota >= ($a + 1) && $instansianggota[$a] == 24) ? 'selected' : '' ?> value="24">UPTD PPA</option>
                                        <option <?= ($opsi == 'edit' && $jmlanggota >= ($a + 1) && $instansianggota[$a] == 25) ? 'selected' : '' ?> value="25">Kepolisian</option>
                                        <option <?= ($opsi == 'edit' && $jmlanggota >= ($a + 1) && $instansianggota[$a] == 26) ? 'selected' : '' ?> value="26">Balai Pemasyarakatan</option>
                                        <option <?= ($opsi == 'edit' && $jmlanggota >= ($a + 1) && $instansianggota[$a] == 27) ? 'selected' : '' ?> value="27">Fasilitas Kesehatan</option>
                                        <option <?= ($opsi == 'edit' && $jmlanggota >= ($a + 1) && $instansianggota[$a] == 28) ? 'selected' : '' ?> value="28">Fasilitas Rehab Sosial</option>
                                        <option <?= ($opsi == 'edit' && $jmlanggota >= ($a + 1) && $instansianggota[$a] == 29) ? 'selected' : '' ?> value="29">Tokoh Adat / Masyarakat</option>
                                        <option <?= ($opsi == 'edit' && $jmlanggota >= ($a + 1) && $instansianggota[$a] == 30) ? 'selected' : '' ?> value="30">Lembaga Swadaya Masyarakat</option>
                                        <option <?= ($opsi == 'edit' && $jmlanggota >= ($a + 1) && $instansianggota[$a] == 31) ? 'selected' : '' ?> value="31">Lainnya</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group ctim">
                                <label for="inama<?= $a ?>">Nama</label>
                                <input type="text" id="inama<?= $a ?>" name="inama<?= $a ?>" value="<?= ($opsi == 'edit' && $jmlanggota >= ($a + 1)) ? $namaanggota[$a] : '' ?>">
                            </div>
                            <div class="form-group ctim">
                                <label for="inik<?= $a ?>">NIK</label>
                                <input type="text" maxlength="16" id="inik<?= $a ?>" name="inik<?= $a ?>" value="<?= ($opsi == 'edit' && $jmlanggota >= ($a + 1)) ? $nikanggota[$a] : '' ?>">
                            </div>
                            <div class="form-group ctim">
                                <label for="itglahir<?= $a ?>">Tanggal Lahir</label>
                                <input type="text" id="itglahir<?= $a ?>" name="itglahir<?= $a ?>" value="<?= ($opsi == 'edit' && $jmlanggota >= ($a + 1) && $tglahiranggota[$a] != '') ? date('d-m-Y', strtotime($tglahiranggota[$a])) : '' ?>">
                            </div>
                            <div class="form-group ctim">
                                <label for="isex<?= $a ?>">Jenis Kelamin</label>
                                <select class="single" id="isex<?= $a ?>" name="isex<?= $a ?>">
                                    <option value="0">- Pilih Jenis Kelamin -</option>
                                    <option <?= ($opsi == 'edit' && $jmlanggota >= ($a + 1) && $sexanggota[$a] == 1) ? 'selected' : '' ?> value="1">Laki-laki</option>
                                    <option <?= ($opsi == 'edit' && $jmlanggota >= ($a + 1) && $sexanggota[$a] == 2) ? 'selected' : '' ?> value="2">Perempuan</option>
                                </select>
                            </div>
                            <div class="form-group ctim">
                                <label for="ihp<?= $a ?>">Nomor HP</label>
                                <input type="text" id="ihp<?= $a ?>" name="ihp<?= $a ?>" value="<?= ($opsi == 'edit' && $jmlanggota >= ($a + 1)) ? $hapeanggota[$a] : '' ?>">
                            </div>
                            <div class="form-group ctim">
                                <label for="iemail<?= $a ?>">Email</label>
                                <input type="text" id="iemail<?= $a ?>" name="iemail<?= $a ?>" value="<?= ($opsi == 'edit' && $jmlanggota >= ($a + 1)) ? $emailanggota[$a] : '' ?>">
                            </div>
                            <div class="form-group ctim">
                                <label for="idukcapil<?= $a ?>">Status Dukcapil</label>
                                <textarea readonly id="idukcapil<?= $a ?>" name="idukcapil<?= $a ?>" class="multilineInput"><?= ($opsi == 'edit' && $jmlanggota >= ($a + 1)) ? $dukcapilanggota[$a] : '' ?></textarea>
                            </div>
                            <button class="tbcek" onclick="return ceknama(<?= $a ?>);">Cek Dukcapil</button>
                        </div>
                        <hr class="hrtim">
                    </li>
                    <?php for ($a = 5; $a <= 29; $a++) { ?>
                        <div id="danggota<?= $a ?>" style="display:<?= ($jmlanggota >= ($a + 1) && $opsi == 'edit') ? 'block' : 'none' ?>;">
                            <li>
                                <a href="#" onclick="toggleInfo(event,<?= $a ?>)">
                                    <h3 style="margin-bottom:15px;">ANGGOTA <?= $a ?> &#9660;</h3>
                                </a>
                                <div id="info<?= $a ?>" class="fanggota info-container" style="margin-bottom:10px">
                                    <div class="form-group ctim">
                                        <label for="djenis<?= $a ?>">Instansi</label>
                                        <div id="djenis<?= $a ?>">
                                            <select class="single" id="idinas<?= $a ?>" name="idinas<?= $a ?>">
                                                <option value="00">- Pilih Instansi -</option>
                                                <option <?= ($opsi == 'edit' && $jmlanggota >= ($a + 1) && $instansianggota[$a] == 20) ? 'selected' : '' ?> value="20">Dinas Pendidikan</option>
                                                <option <?= ($opsi == 'edit' && $jmlanggota >= ($a + 1) && $instansianggota[$a] == 21) ? 'selected' : '' ?> value="21">Dinas Sosial</option>
                                                <option <?= ($opsi == 'edit' && $jmlanggota >= ($a + 1) && $instansianggota[$a] == 22) ? 'selected' : '' ?> value="22">Dinas PPPA</option>
                                                <option <?= ($opsi == 'edit' && $jmlanggota >= ($a + 1) && $instansianggota[$a] == 23) ? 'selected' : '' ?> value="23">Dinas Kesehatan</option>
                                                <option <?= ($opsi == 'edit' && $jmlanggota >= ($a + 1) && $instansianggota[$a] == 24) ? 'selected' : '' ?> value="24">UPTD PPA</option>
                                                <option <?= ($opsi == 'edit' && $jmlanggota >= ($a + 1) && $instansianggota[$a] == 25) ? 'selected' : '' ?> value="25">Kepolisian</option>
                                                <option <?= ($opsi == 'edit' && $jmlanggota >= ($a + 1) && $instansianggota[$a] == 26) ? 'selected' : '' ?> value="26">Balai Pemasyarakatan</option>
                                                <option <?= ($opsi == 'edit' && $jmlanggota >= ($a + 1) && $instansianggota[$a] == 27) ? 'selected' : '' ?> value="27">Fasilitas Kesehatan</option>
                                                <option <?= ($opsi == 'edit' && $jmlanggota >= ($a + 1) && $instansianggota[$a] == 28) ? 'selected' : '' ?> value="28">Fasilitas Rehab Sosial</option>
                                                <option <?= ($opsi == 'edit' && $jmlanggota >= ($a + 1) && $instansianggota[$a] == 29) ? 'selected' : '' ?> value="29">Tokoh Adat / Masyarakat</option>
                                                <option <?= ($opsi == 'edit' && $jmlanggota >= ($a + 1) && $instansianggota[$a] == 30) ? 'selected' : '' ?> value="30">Lembaga Swadaya Masyarakat</option>
                                                <option <?= ($opsi == 'edit' && $jmlanggota >= ($a + 1) && $instansianggota[$a] == 31) ? 'selected' : '' ?> value="31">Lainnya</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group ctim">
                                        <label for="inama<?= $a ?>">Nama</label>
                                        <input type="text" id="inama<?= $a ?>" name="inama<?= $a ?>" value="<?= ($opsi == 'edit' && $jmlanggota >= ($a + 1)) ? $namaanggota[$a] : '' ?>">
                                    </div>
                                    <div class="form-group ctim">
                                        <label for="inik<?= $a ?>">NIK</label>
                                        <input type="text" maxlength="16" id="inik<?= $a ?>" name="inik<?= $a ?>" value="<?= ($opsi == 'edit' && $jmlanggota >= ($a + 1)) ? $nikanggota[$a] : '' ?>">
                                    </div>
                                    <div class="form-group ctim">
                                        <label for="itglahir<?= $a ?>">Tanggal Lahir</label>
                                        <input type="text" id="itglahir<?= $a ?>" name="itglahir<?= $a ?>" value="<?= ($opsi == 'edit' && $jmlanggota >= ($a + 1) && $tglahiranggota[$a] != '') ? date('d-m-Y', strtotime($tglahiranggota[$a])) : '' ?>">
                                    </div>
                                    <div class="form-group ctim">
                                        <label for="isex<?= $a ?>">Jenis Kelamin</label>
                                        <select class="single" id="isex<?= $a ?>" name="isex<?= $a ?>">
                                            <option value="0">- Pilih Jenis Kelamin -</option>
                                            <option <?= ($opsi == 'edit' && $jmlanggota >= ($a + 1) && $sexanggota[$a] == 1) ? 'selected' : '' ?> value="1">Laki-laki</option>
                                            <option <?= ($opsi == 'edit' && $jmlanggota >= ($a + 1) && $sexanggota[$a] == 2) ? 'selected' : '' ?> value="2">Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="form-group ctim">
                                        <label for="ihp<?= $a ?>">Nomor HP</label>
                                        <input type="text" id="ihp<?= $a ?>" name="ihp<?= $a ?>" value="<?= ($opsi == 'edit' && $jmlanggota >= ($a + 1)) ? $hapeanggota[$a] : '' ?>">
                                    </div>
                                    <div class="form-group ctim">
                                        <label for="iemail<?= $a ?>">Email</label>
                                        <input type="text" id="iemail<?= $a ?>" name="iemail<?= $a ?>" value="<?= ($opsi == 'edit' && $jmlanggota >= ($a + 1)) ? $emailanggota[$a] : '' ?>">
                                    </div>
                                    <div class="form-group ctim">
                                        <label for="idukcapil<?= $a ?>">Status Dukcapil</label>
                                        <textarea readonly id="idukcapil<?= $a ?>" name="idukcapil<?= $a ?>" class="multilineInput"><?= ($opsi == 'edit' && $jmlanggota >= ($a + 1)) ? $dukcapilanggota[$a] : '' ?></textarea>
                                    </div>
                                    <button class="tbcek" onclick="return ceknama(<?= $a ?>);">Cek Dukcapil</button>
                                </div>
                                <hr class="hrtim">
                            </li>
                        <?php } ?>
                </ul>

                <div style="margin:auto;margin-top:20px;margin-bottom:20px;">
                    <center>
                        <button id="tbtambah" onclick="return tambahInput()">Tambah Anggota</button>&nbsp;
                        <button id="tbkurang" onclick="return kurangiInput()">Kurangi Anggota</button>
                    </center>
                </div>


                <input type="hidden" id="addedit" name="addedit" value="<?= ($opsi == "edit") ? "edit" : "add" ?>">
                <input type="hidden" id="skid" name="skid" value="<?= ($opsi == "edit") ? $skid : "" ?>">
                <input type="hidden" id="jmlpengguna" name="jmlpengguna" value="5">
                <input type="hidden" id="idinas0" name="idinas0" value="20">
                <input type="hidden" id="idinas1" name="idinas1" value="20">
                <input type="hidden" id="idinas2" name="idinas2" value="21">
                <input type="hidden" id="idinas3" name="idinas3" value="22">
                <input type="hidden" id="ipropinsion" name="ipropinsion" value="">
                <input type="hidden" id="ikotaon" name="ikotaon" value="">
                <?php for ($a = 0; $a <= 28; $a++) { ?>
                    <input type="hidden" id="istatusdukcapil<?= $a ?>" name="istatusdukcapil<?= $a ?>" value="">
                <?php } ?>
                <center>
                    <?php if ($opsi == "edit") : ?>
                        <div class="tengah2">
                            <input onclick="return batal();" type="button" value="Batal">
                            <input onclick="return cekinput();" type="submit" value="Kirim">
                        </div>
                    <?php else : ?>
                        <div class="tengah">
                            <input onclick="return cekinput();" type="submit" value="Kirim">
                        </div>
                    <?php endif ?>
                </center>
            </form>
        </div>
    </div>
</div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scriptfooter') ?>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    var sekolahid;
    var jabatan = [];
    var counter = 5;
    <?php if ($jmlanggota >= 5) {
        echo "counter = " . ($jmlanggota + 1) . ";\n";
    } ?>

    <?php if ($opsi == "edit") : ?>
        var info0 = document.getElementById("info0");
        var info1 = document.getElementById("info1");
        var info2 = document.getElementById("info2");
        var info3 = document.getElementById("info3");
        var info4 = document.getElementById("info4");
        info0.classList.toggle("show");
        info1.classList.toggle("show");
        info2.classList.toggle("show");
        info3.classList.toggle("show");
        info4.classList.toggle("show");
        <?php for ($d = 5; $d <= $jmlanggota + 1; $d++) { ?>
            if (document.getElementById("idukcapil<?= $d ?>").value != "") {
                document.getElementById("danggota<?= $d ?>").style.display = "block";
                document.getElementById("info<?= $d ?>").classList.toggle("show");
            }
        <?php } ?>

    <?php endif ?>

    <?php if ($jmlanggota <= 4) : ?>
        $("#tbkurang").hide();
    <?php endif ?>

    $(document).ready(function() {

        $("#tanggal_sk").datepicker({
            dateFormat: "dd-mm-yy",
        });

        for (var n = 0; n <= 28; n++)
            $("#itglahir" + n).datepicker({
                dateFormat: "dd-mm-yy",
            });

        $.datepicker.setDefaults($.datepicker.regional['id']);

        $('.single').select2();

    });

    function tambahInput() {
        $("#tbkurang").show();
        $("#danggota" + counter).show();
        $("#danggota" + (counter + 1)).show();
        if (counter <= 27)
            counter = counter + 2;
        if (counter == 29)
            $("#tbtambah").hide();
        return false;
    }

    function kurangiInput() {
        $("#tbtambah").show();
        if (counter > 2)
            counter = counter - 2;
        if (counter == 5)
            $("#tbkurang").hide();
        $("#danggota" + counter).hide();
        $("#danggota" + (counter + 1)).hide();
        return false;
    }

    $('#ipropinsi').change(function() {
        getkota();
    });

    function getkota() {
        var kode = $('#ipropinsi').val();
        $.ajax({
            type: 'GET',
            data: {
                kode: kode,
                level: 2
            },
            dataType: 'json',
            cache: false,
            url: '<?php echo base_url() ?>inputdata/getNamaWilayah',
            success: function(result) {
                isihtml1 = '<select class="single" id="ikota" name="ikota">';
                isihtml2 = '<option value="00">- Pilih Kota/Kabupaten -</option>';
                $.each(result, function(i, result) {
                    isihtml2 = isihtml2 + "<option value='" + result.kode_wilayah + "'>" + result.nama + "</option>";
                });
                isihtml3 = '</select>';
                $('#dkota').html(isihtml1 + isihtml2 + isihtml3);
                $('.single').select2();
            }
        });
    }

    function clearTextarea(index) {
        var textarea = document.getElementById('idukcapil' + index);
        textarea.value = '';
    }

    function observeChange(inputElement, index) {
        inputElement.addEventListener('input', function() {
            clearTextarea(index);
        });
    }

    function observeChangeSelect2(selectElement, index) {
        selectElement.on('select2:select', function() {
            clearTextarea(index);
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        for (var i = 0; i < 10; i++) {
            var inama = document.getElementById('inama' + i);
            var inik = document.getElementById('inik' + i);
            var itglahir = document.getElementById('itglahir' + i);

            observeChange(inama, i);
            observeChange(inik, i);
            observeChange(itglahir, i);
        }
    });

    $(document).ready(function() {
        for (var i = 0; i < 10; i++) {
            var isex = $('#isex' + i);
            isex.select2();
            observeChangeSelect2(isex, i);
        }
    });

    function toggleInfo(event, idx) {
        event.preventDefault();

        var info = document.getElementById("info" + idx);
        info.classList.toggle("show");
    }

    function batal() {
        history.back();
    }


    function pilihdinas(idx) {
        if ($('#idinas' + idx).val() == "004") {
            $('#dsubjenis' + idx).show();
        } else {
            $('#dsubjenis' + idx).hide();
        }

    }

    function resetptk() {
        isihtml1 = '<select class="single" id="inama1" name="inama1">';
        isihtml2 = '<option value="00">- Pilih Nama -</option>';
        isihtml3 = '</select>';
        $('#dnama').html(isihtml1 + isihtml2 + isihtml3);

        for (var i = 1; i <= 0; i++) {
            isihtml1 = '<select class="single" id="inama' + i + '" name="inama' + i + '">';
            isihtml2 = '<option value="00">- Pilih Nama -</option>';
            isihtml3 = '</select>';
            $('#dnama' + i).html(isihtml1 + isihtml2 + isihtml3);
        }
    }

    function isValidDate(dateString) {
        var parts = dateString.split("-");
        var day = parseInt(parts[0], 10);
        var month = parseInt(parts[1], 10);
        var year = parseInt(parts[2], 10);

        if (isNaN(day) || isNaN(month) || isNaN(year)) {
            return false;
        }

        if (month < 1 || month > 12) {
            return false;
        }

        var daysInMonth = new Date(year, month, 0).getDate();
        if (day < 1 || day > daysInMonth) {
            return false;
        }

        return true;
    }

    function cekemailvalid(idx) {
        var email = $("#iemail" + idx).val();
        if (validateEmail(email)) {
            return true;
        } else {
            return false;
        }
    }

    function validateEmail(email) {
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }

    function checkUnique(inputArray) {
        var uniqueArray = [];
        for (var i = 0; i < inputArray.length; i++) {
            if (uniqueArray.includes(inputArray[i])) {
                return false; // Ada elemen yang sama
            }
            uniqueArray.push(inputArray[i]);
        }
        return true; // Tidak ada elemen yang sama
    }

    function cekinput() {
        var oke = true;
        var namaunik = true;
        var arrayinputnya = [];
        var emailvalid = true;
        var edit = false;
        <?php if ($opsi == "edit") : ?>
            edit = true;
        <?php endif ?>

        valsk = document.getElementById("file_sk").value;
        fileExt = valsk.split('.').pop();
        valtgl = document.getElementById("tanggal_sk").value;

        // arrayinputnya.push(inamaketua);
        // arrayinputnya.push(inamaanggota1);

        if (edit == false && valsk == "") {
            oke = false;
        }

        for (var a = 0; a < counter; a++) {
            if (document.getElementById("idinas" + a).value == "00" || document.getElementById("inama" + a).value == "" || document.getElementById("inik" + a).value == "" || document.getElementById("itglahir" + a).value == "" || document.getElementById("isex" + a).value == "0" || document.getElementById("ihp" + a).value == "" || document.getElementById("idukcapil" + a).value == "") {
                oke = false;
            }
            if (cekemailvalid(a) == false && document.getElementById("iemail" + a).value != "") {
                emailvalid = false;
            }
            arrayinputnya.push(document.getElementById("inama" + a).value);
        }




        if (edit == false && fileExt != "jpg" && fileExt != "jpeg" && fileExt != "png" && fileExt != "pdf") {
            oke = false;
        }

        if (valtgl == "") {
            oke = false;
        } else if (!isValidDate(valtgl)) {
            alert("Tanggal tidak sesuai format");
            oke = false;
        }

        if (checkUnique(arrayinputnya) == false && document.getElementById("inama" + a).value != "") {
            alert("Ada nama yang sama");
            oke = false;
        }

        if (emailvalid == false) {
            // alert("Alamat email tidak valid");

        }



        if (oke) {
            // alert("Berhasil.... Hanya Uji Coba Dahulu");
            document.getElementById("jmlpengguna").value = counter;
            document.getElementById("ipropinsion").value = document.getElementById("ipropinsi").value;
            document.getElementById("ikotaon").value = document.getElementById("ikota").value;
            for (a = 0; a < counter; a++) {
                document.getElementById("istatusdukcapil" + a).value = document.getElementById("idukcapil" + a).value;
            }

            return true;
        } else {
            alert("Silakan periksa kembali ...");
            return false;
        }
    }

    function ceknama(idx) {
        var datanik = document.getElementById('inik' + idx).value;
        var datanama = document.getElementById('inama' + idx).value;
        var datatglahir = document.getElementById('itglahir' + idx).value;
        var datasex = document.getElementById('isex' + idx).value;
        var sexnya = "Laki-Laki";
        if (datasex == 2)
            sexnya = "Perempuan";

        if (datanik.length != 16) {
            alert("Jumlah karakter NIK harus 16 digit");
            return false;
        }

        $.ajax({
            type: 'GET',
            data: {
                nik: datanik,
                nama: datanama,
                tglahir: datatglahir,
                sex: sexnya
            },
            dataType: 'json',
            cache: false,
            url: '<?php echo base_url() ?>inputdata/padankandata',
            success: function(result) {
                var jsonData = JSON.parse(result);

                // Mengambil nilai NIK
                var nikValue = jsonData.NIK;
                var namaValue = jsonData.NAMA_LGKP;
                var tglahirValue = jsonData.TGL_LHR;
                var sexValue = jsonData.JENIS_KLMIN;
                // alert("NIK:" + nikValue + ", NAMA:" + namaValue + ", TGL_LAHIR:" + tglahirValue + ", JNS KELAMIN:" + sexValue);
                document.getElementById('idukcapil' + idx).value = "NIK:" + nikValue + ", NAMA:" + namaValue + ", TGL_LAHIR:" + tglahirValue + ", JNS_KELAMIN:" + sexValue;
                return false;
            }
        });
        return false;
    }
</script>
<?= $this->endSection(); ?>