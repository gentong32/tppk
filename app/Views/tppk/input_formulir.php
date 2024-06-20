<?= $this->extend('layout/default') ?>
<?= $this->section('header') ?>

<?php $csrfToken = csrf_hash(); ?>

<link rel="stylesheet" href="<?= base_url() ?>css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="<?= base_url() ?>css/responsive.dataTables.min.css" />
<link rel="stylesheet" href="<?= base_url() ?>css/select2.min.css">

<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script src="<?= base_url() ?>js/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>js/dataTables.responsive.min.js"></script>

<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    .custom-table {
        border-collapse: collapse;
        width: 100%;
        margin-top: 20px;
    }

    .custom-table th,
    .custom-table td {
        text-align: left;
        padding: 8px;
        border-bottom: 1px solid #ddd;
        vertical-align: top;
    }

    .custom-table th {
        background-color: #f2f2f2;
    }

    .custom-table tr:hover {
        background-color: #f5f5f5;
        cursor: pointer;
    }

    .btn_biru {
        margin-top: 1px;
        margin-bottom: 1px;
    }

    .btn_ijo {
        margin-top: 1px;
        margin-bottom: 1px;
    }

    .btn_merah {
        margin-top: 1px;
        margin-bottom: 1px;
    }

    .btn_kuning {
        margin-top: 1px;
        margin-bottom: 1px;
    }

    .my-button-gray {
        background-color: #ccc;
    }
</style>

<style>
    #tabelakhir {
        margin-top: 10px;
        line-height: 20px;
        font-size: 14px;
        width: 100%;
    }

    #tabelakhir tr th {
        text-align: left;
        margin-left: 0;
    }

    .merah {
        background-color: darkred;
        color: white;
        padding: 10px;
    }

    .kelabu {
        background-color: lightgray;
        color: black;
        padding: 8px;
    }

    #akhir {
        display: none;
        transition: opacity 0.5s ease-in-out;
        padding: 20px;
    }

    #isian {
        display: none;
        transition: opacity 0.5s ease-in-out;
        padding: 20px;
    }

    .korban {
        display: none;
        transition: opacity 0.5s ease-in-out;
        padding: 20px;
    }

    .pelaku {
        display: none;
        transition: opacity 0.5s ease-in-out;
        padding: 20px;
    }

    #kronologi {
        display: none;
        transition: opacity 0.5s ease-in-out;
        padding: 20px;
    }

    #ikronologi {
        padding: 5px;
    }

    .fade-in {
        display: block !important;
        opacity: 1;
    }

    .tabelisian {
        width: 100%;
        padding: 20px;
        line-height: 20px;
        font-size: 14px;
        border-collapse: collapse;
    }

    .tabelisian tr td {
        border: 0.5px solid gray;
        padding: 5px;
        vertical-align: top;
    }

    .atas {
        margin: auto;
        padding-left: 20px;
        padding-right: 20px;
    }

    .judul {
        margin-top: 20px !important;
        font-size: 18px;
        text-align: center;
    }

    .btn_abu {
        margin-top: 1px;
        margin-bottom: 1px;
    }

    .btn_biru {
        margin-top: 1px;
        margin-bottom: 1px;
    }

    .btn_abu2 {
        background: #abaaaa;
        background-image: -webkit-linear-gradient(top, #a7a8ab, #a7a1ab);
        background-image: -moz-linear-gradient(top, #a7a8ab, #a7a1ab);
        background-image: -ms-linear-gradient(top, #a7a8ab, #a7a1ab);
        background-image: -o-linear-gradient(top, #a7a8ab, #a7a1ab);
        background-image: linear-gradient(to bottom, #a7a8ab, #a7a1ab);
        -webkit-border-radius: 9;
        -moz-border-radius: 9;
        border-radius: 9px;
        font-family: Arial;
        color: #ffffff;
        font-size: 14px;
        padding: 7px 16px 7px 16px;
        text-decoration: none;
        border: 0.5px solid lightgray;
        margin-top: 3px;
    }

    .btn_abu2:hover {
        background: #929291;
        background-image: -webkit-linear-gradient(top, #ada1ab, #adb1ab);
        background-image: -moz-linear-gradient(top, #ada1ab, #adb1ab);
        background-image: -ms-linear-gradient(top, #ada1ab, #adb1ab);
        background-image: -o-linear-gradient(top, #ada1ab, #adb1ab);
        background-image: linear-gradient(to bottom, #ada1ab, #adb1ab);
        text-decoration: none;
    }

    input[type="text"] {
        width: calc(100% - 16px);
        padding: 6px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        background-color: white;
    }

    .checkbox-container {
        display: flex;
        align-items: baseline;
        margin-bottom: 5px;
    }

    .checkbox-container input[type="checkbox"] {
        margin-right: 10px;
    }

    .checkbox-container input[type="radio"] {
        margin-right: 8px;
    }

    textarea {
        width: 100%;
        font-size: 16px;
        padding-left: 5px;
        box-sizing: border-box;
    }

    .catatan {
        margin-top: 25px;
        font-size: 14px;
        font-style: italic;
    }

    .catatan ul li {
        margin-left: 15px;
    }

    .info {
        color: red;
        font-style: italic;
        font-size: 12px;
    }

    .pilortu {
        font-size: 16px;
        padding-top: 2px;
        padding-bottom: 2px;
        margin-bottom: 2px;
    }

    .hide {
        display: none;
    }

    .tbaktif {
        cursor: pointer;
    }

    .tbnonaktif {
        cursor: not-allowed;
        background-color: #eee !important;
    }

    .aktif {
        background-color: blue;
    }

    #tabs-container {
        margin-left: 20px;
    }

    .tabs {
        display: inline-block;
        padding: 10px 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin: 1px;
        background-color: #fff;
        transition: 0.3s;
        text-align: center;
    }

    .tabs:hover {
        background-color: #ddd;
    }

    .tabs.active {
        background-color: #05f;
        color: #fff;
    }

    .wrapping {
        display: flex;
        max-width: 1000px;
    }

    .slider {
        position: relative;
        margin: 15px 10px 50px 20px;
        margin-left: auto;
        padding-right: 60px;
    }

    .toggle {
        display: none;
    }

    .slider-button {
        position: absolute;
        top: 0;
        left: 0;
        width: 50px;
        height: 30px;
        background-color: #5cb85c;
        border-radius: 30px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .slider-button:before {
        content: '';
        position: absolute;
        top: 50%;
        left: 5px;
        transform: translateY(-50%);
        width: 20px;
        height: 20px;
        background-color: #fff;
        border-radius: 50%;
        transition: left 0.3s;
    }

    .toggle:checked+.slider-button {
        background-color: #5cb85c;
    }

    .toggle:checked+.slider-button:before {
        left: 25px;
    }

    .format1 {
        position: absolute;
        top: -10px;
        left: 0px;
        transform: translateY(-50%);
        font-family: Arial, sans-serif;
    }

    .format2 {
        position: absolute;
        top: -10px;
        left: 30px;
        transform: translateY(-50%);
        font-family: Arial, sans-serif;
    }

    .js-pil {
        margin-right: 20px;
    }
</style>

<?= $this->endSection(); ?>

<?= $this->section('konten') ?>
<div id="content_wrap" class="content-wrap">

    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <input type="text" id="namaSekolahInput" placeholder="NPSN / Nama Sekolah">
            <button id="tbcari" style="margin-top:5px" onclick="submitSekolah()">Cari 5 Sekolah</button><br>
            <span class="info" id="infocarisekolah"></span>
            <div id="hasiltabel" style="display: none;">
                <table id="myTable" class="custom-table">
                    <thead>
                        <tr>
                            <th>NPSN</th>
                            <th>NAMA SEKOLAH</th>
                            <th>KAB / KOTA</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="judul">
        <br>
        <b>FORMULIR REKAPITULASI LAPORAN KEKERASAN</b>
    </div>

    <div class="wrapping">
        <div class="slider">
            <input type="checkbox" id="toggle" class="toggle">
            <label for="toggle" class="slider-button"></label>
            <span class="format1">Tampilan</span>
            <span class="format2"></span>
        </div>
    </div>

    <button style="display: none;" id="singleViewBtn">Tampilan 1</button>
    <button style="display: none;" id="multiViewBtn">Per Bagian</button>

    <div id="tabs-container">
        <button id="tb1" class="tabs tbaktif active" onclick="showTabContent('dif1')">Pengantar</button>
        <button id="tb2" disabled class="tabs tbnonaktif" onclick="showTabContent('dif2')">Laporan</button>
        <button id="tb3" disabled class="tabs tbnonaktif" onclick="showTabContent('dif3')">Korban</button>
        <button id="tb4" disabled class="tabs tbnonaktif" onclick="showTabContent('dif4')">Pelaku</button>
        <button id="tb5" disabled class="tabs tbnonaktif" onclick="showTabContent('dif5')">Kronologi</button>
        <button style="display: none;" id="tb6" disabled class="tabs tbnonaktif" onclick="showTabContent('dif6')">Terimakasih</button>
    </div>

    <div id="dif1">
        <div class="atas">
            <table class="tabelinfo">
                <tr>
                    <th class="merah">RAHASIA</th>
                </tr>
                <tr>
                    <td><br>
                        Saya, yang mengisi formulir ini, menyatakan bahwa informasi yang saya sampaikan adalah benar adanya. Saya bersedia menjamin bahwa saya tidak menyebarluaskan informasi yang saya isi di formulir kepada publik. Saya siap diproses secara hukum jika terbukti menyebarluaskan informasi yang saya catat.
                        <br><br>
                        <button id="tbtidakbersedia" class="btn_merah">Saya tidak bersedia</button> <button id="tbbersedia" class="btn_ijo">Saya bersedia</button>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div id="dif2">
        <div id="isian">
            <table class="tabelisian">
                <tr>
                    <th style="width:40%"></th>
                    <th style="width:10px;"></th>
                    <th></th>
                </tr>
                <tr>
                    <td>
                        Tanggal penerimaan laporan <sup>*</sup>
                    </td>
                    <td>:</td>
                    <td><input type="text" id="datepicker1" name="datepicker1" onblur="validasiTanggal(1)" value="<?= $tgl_sekarang ?>">
                        <span id="errorTanggal1" style="color: red;"></span>
                    </td>
                </tr>
                <tr>
                    <td>
                        Tanggal kejadian <sup>*</sup>
                    </td>
                    <td>:</td>
                    <td><input type="text" id="datepicker2" name="datepicker2" onblur="validasiTanggal(2)" value="<?= $tgl_sekarang ?>">
                        <span id="errorTanggal2" style="color: red;"></span>
                    </td>
                </tr>
                <tr>
                    <td>
                        Apakah kasus kekerasan sudah terbukti? <sup>*</sup>
                    </td>
                    <td>:</td>
                    <td>
                        <button class="btn_ijo" id="tbya">Ya</button><br>
                        <button class="btn_merah" id="tbtidak">Tidak</button><br>
                        <button class="btn_kuning" id="tbstop">Kasus Dihentikan</button>
                    </td>
                </tr>
                <tr id="alasanDihentikan" style="display:none;">
                    <td>Alasan kasus dihentikan <sup>*</sup></td>
                    <td>:</td>
                    <td>
                        <div class="checkbox-container">
                            <input type="checkbox" name="terlapor_meninggal" value="1" onchange="handleCheckbox(this)">
                            Terlapor meninggal dunia/tidak ditemukan/sakit berat berdasarkan keterangan dokter
                        </div>
                        <div class=" checkbox-container">
                            <input type="checkbox" name="korban_tidak_ditemukan" value="2" onchange="handleCheckbox(this)">
                            Korban tidak ditemukan
                        </div>
                        <div class=" checkbox-container">
                            <input type="checkbox" name="pembuktian_belum_cukup" value="3" onchange="handleCheckbox(this)">
                            Pembuktian belum cukup
                        </div>
                        <span id="erroralasan" style="color: red;"></span>
                    </td>
                </tr>
            </table>
            <div style="margin-top: 10px;">
                <button id="tbkorban" class="btn_ijo" style="display: none;">INPUT KORBAN</button>
            </div>
        </div>
    </div>

    <div id="dif3">
        <div id="lokasikorban">
            <div id="korban" class="korban">
                <table class="tabelisian">
                    <tr>
                        <th class="kelabu" colspan="3">Bagian 1: Formulir Korban</th>
                    </tr>
                    <tr>
                        <th style="width:40%"></th>
                        <th style="width:10px;"></th>
                        <th></th>
                    </tr>
                    <tr>
                        <td>
                            Status Korban *
                        </td>
                        <td>:</td>
                        <td>
                            <?php foreach ($daf_status_korban as $status) : ?>
                                <div class="checkbox-container">
                                    <input onchange="cekstatuskorban(0);" type="radio" name="status_korban" value="<?= $status['status_korban_pelaku_id'] ?>">
                                    <?= $status['nama'] ?>
                                </div>
                            <?php endforeach; ?>
                        </td>
                    </tr>
                    <tr id="npsnRowkorban" style="display: none;">
                        <td>
                            NPSN Korban
                        </td>
                        <td>:</td>
                        <td><input <?= ($sebagai == "sekolah") ? "disabled" : "" ?> maxlength="8" type="text" placeholder="" id="npsnkorban" name="npsnkorban" value="<?= $npsn ?>">
                            <span class="info" id="infonpsnkorban"></span>
                            <button <?= ($sebagai == "sekolah") ? "style='display:none'" : "" ?> id="tbnpsnkorban" class="btn_ijo" onclick="submitnpsnkorban(0)">Submit</button>
                            <button id="tbcarisekolahkorban" onclick="tampilmodal()" class="btn_biru">Cari NPSN/Sekolah</button>
                        </td>
                    </tr>
                    <tr id="sekolahRowkorban" style="display: none;">
                        <td>
                            Nama Sekolah / Instansi Korban
                        </td>
                        <td>:</td>
                        <td><textarea <?= ($sebagai == "sekolah") ? "disabled" : "" ?> id="sekolahkorban" name="sekolahkorban"><?= ($sebagai == "sekolah") ? $sekolah_saya['nama'] : "" ?></textarea>
                            <?php if ($sebagai == "sekolah") {
                                $xstatus = ($sekolah_saya['nama_sekolah'] == 1) ? "Negeri" : "Swasta";
                                $kec = substr($sekolah_saya['kecamatan'], 5);
                                $kota = (substr($sekolah_saya['kota'], 0, 3) == "Kab.") ? "Kab: " : "Kota: ";
                                $kota = $kota . substr($sekolah_saya['kota'], 5);
                                $provinsi = substr($sekolah_saya['provinsi'], 6);
                            }
                            ?>
                            <span class="info" id="infosekolahkorban">
                                <?php if ($sebagai == "sekolah") { ?>
                                    <div style='color:black; margin-left:10px'>Status: <?= $xstatus ?><br> Kec: <?= $kec ?><br> <?= $kota ?> <br> Provinsi: <?= $provinsi ?> </div>
                                <?php } ?>
                            </span>
                            <button onclick="konfirmsekolahkorban(0)" id="tbsekolahkorban" class="btn_ijo">Konfirmasi</button>
                        </td>
                    </tr>
                    <?php if ($sebagai == "sekolah") { ?>
                        <tr id="daftarpdRowkorban" style="display: none;">
                            <td>
                                Nama Korban *
                            </td>
                            <td>:</td>
                            <td>
                                <select class="js-pil" id="daftarpdkorban" name="daftarpdkorban" style="width: 100%;">
                                    <option value="000000">Pilih Siswa</option>
                                    <?php foreach ($daf_siswa as $key => $value) : ?>
                                        <option value="<?= $value['nisn'] ?>" data-induk="<?= $value['nik'] ?>"><?= $value['nama'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="info" id="infodaftarpdkorban"></span><br>
                            </td>
                        </tr>
                        <tr id="daftarptkRowkorban" style="display: none;">
                            <td>
                                Nama Korban *
                            </td>
                            <td>:</td>
                            <td>
                                <select class="js-pil" id="daftarptkkorban" name="daftarptkkorban" style="width: 100%;">
                                    <option value="000000">Pilih Pendidik</option>
                                    <option value="000001">-- Input Manual --</option>
                                    <?php foreach ($daf_pendidik as $key => $value) : ?>
                                        <option value="<?= $value['nuptk'] ?>" data-induk="<?= $value['nik'] ?>"><?= $value['nama'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="info" id="infodaftarptkkorban"></span><br>
                            </td>
                        </tr>
                        <tr id="daftarptk2Rowkorban" style="display: none;">
                            <td>
                                Nama Korban *
                            </td>
                            <td>:</td>
                            <td>
                                <select class="js-pil" id="daftarptk2korban" name="daftarptk2korban" style="width: 100%;">
                                    <option value="000000">Pilih TK</option>
                                    <option value="000001">-- Input Manual --</option>
                                    <?php foreach ($daf_tenagakependidikan as $key => $value) : ?>
                                        <option value="<?= $value['nuptk'] ?>" data-induk="<?= $value['nik'] ?>"><?= $value['nama'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="info" id="infodaftarptk2korban"></span><br>
                            </td>
                        </tr>
                        <tr id="daftarkepsekRowkorban" style="display: none;">
                            <td>
                                Nama Korban *
                            </td>
                            <td>:</td>
                            <td>
                                <select class="js-pil" id="daftarkepsekkorban" name="daftarkepsekkorban" style="width: 100%;">
                                    <?php foreach ($daf_kepsek as $key => $value) : ?>
                                        <option value="<?= $value['nuptk'] ?>" data-induk="<?= $value['nik'] ?>"><?= $value['nama'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="info" id="infodaftarkepsekkorban"></span><br>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr id="nisnRowkorban" style="display: none;">
                        <td>
                            NISN / NUPTK Korban
                        </td>
                        <td>:</td>
                        <td><input maxlength="16" type="text" placeholder="" id="nisnkorban" name="nisnkorban">
                            <span class="info" id="infonisnkorban"></span><br>
                            <button onclick="ceknisnkorban(0)" id="tbnisnkorban" class="btn_ijo">Cek</button>
                        </td>
                    </tr>
                    <tr id="namaRowkorban" style="display: none;">
                        <td>
                            Nama Korban *
                        </td>
                        <td>:</td>
                        <td><textarea id="namakorban" name="namakorban"></textarea>
                            <span class="info" id="infonamakorban"></span><br>
                            <!-- <button onclick="konfirmnamakorban(0)" id="tbnamakorban" class="btn_abu2">Konfirm</button> -->
                        </td>
                    </tr>
                    <tr id="nikpdptkRowkorban" style="display: none;">
                        <td>
                            NIK
                        </td>
                        <td>:</td>
                        <td><input maxlength="16" type="text" placeholder="" id="nikpdptkkorban" name="nikpdptkkorban">
                            <span class="info" id="infonikpdptkkorban"></span><br>
                            <button style="display: none;" onclick="ceknikpdptkkorban(0)" id="tbnikpdptkkorban" class="btn_ijo">Konfirmasi</button>
                            <button style="display: none;" onclick="ceknisnkorban(0)" id="tbnikselectkorban" class="btn_ijo">Konfirmasi</button>
                        </td>
                    </tr>
                    <tr id="nikRowkorban" style="display: none;">
                        <td>
                            NIK Korban <sup>*</sup>
                        </td>
                        <td>:</td>
                        <td><select class="pilortu" id="statusortukorban">
                                <option value="ayah">Ayah</option>
                                <option value="ibu">Ibu</option>
                                <option value="wali">Wali Murid</option>
                            </select>
                            <input maxlength="16" type="text" placeholder="" id="nikkorban" name="nikkorban">
                            <span class="info" id="infonikkorban"></span><br>
                            <button onclick="ceknikkorban(0)" id="tbnikkorban" class="btn_ijo">OK</button>
                        </td>
                    </tr>
                    <tr id="namaortuRowkorban" style="display: none;">
                        <td>
                            Nama Korban (Ortu)
                        </td>
                        <td>:</td>
                        <td><textarea id="namaortukorban" name="namaortukorban"></textarea>
                            <span class="info" id="infonamaortukorban"></span><br>
                            <!-- <button style="display: none;" onclick="konfirmnamaortukorban(0)" id="tbnamaortukorban" class="btn_ijo">Konfirm</button> -->
                        </td>
                    </tr>
                    <tr id="tgllahirRowkorban" style="display: none;">
                        <td>
                            Tanggal Lahir Korban
                        </td>
                        <td>:</td>
                        <td><input type="text" id="datepickerkorban" name="datepickerkorban" onblur=" validasiTanggalLahir()" placeholder="dd/mm/yyyy" value="">
                            <span id="errorTanggalLahirkorban" style="color: red; display: none;">Format tanggal tidak valid.</span>
                        </td>
                    </tr>
                    <tr id="usiaRowkorban" style="display: none;">
                        <td>
                            Usia Korban <sup>*</sup>
                        </td>
                        <td>:</td>
                        <td>
                            <input maxlength="3" type="text" placeholder="" id="usiakorban" name="usiakorban">
                            <span class="info" id="infousiakorban"></span>
                        </td><br>
                        <!-- <button onclick="cekusiakorban(0)" id="tbusiakorban" class="btn_ijo">OK</button> -->
                    </tr>
                    <tr id="jenis_kelaminRowkorban" style="display: none;">
                        <td>
                            Jenis Kelamin Korban <sup>*</sup>
                        </td>
                        <td>:</td>
                        <td>
                            <input type="radio" name="jenis_kelaminkorban" value="L"> Laki-laki<br>
                            <input type="radio" name="jenis_kelaminkorban" value="P"> Perempuan<br>
                            <span class="info" id="infojenis_kelaminkorban"></span><br>
                            <button style="display: none;" onclick="konfirmjenis_kelaminkorban(0)" id="tbjenis_kelaminkorban" class="btn_ijo">Konfirmasi</button>
                            <button onclick="ceknikdarijkkorban(0)" id="tbnikdarijkkorban" class="btn_ijo">Cek Dukcapil</button> <button style="display: none;" onclick="lanjutalamatkorban(0)" id="tblanjutdarijkkorban" class="btn_ijo">Lewati Cek Dukcapil</button>
                        </td>
                    </tr>
                    <tr id="alamatRowkorban" style="display: none;">
                        <td>
                            Alamat Korban <sup>*</sup>
                        </td>
                        <td>:</td>
                        <td><input type="text" placeholder="" id="alamatkorban" name="alamatkorban" style="display: none;">
                            <span class="info" id="infoalamatkorban"></span>
                        </td><br>
                        <!-- <button onclick="cekusiakorban(0)" id="tbusiakorban" class="btn_ijo">OK</button> -->
                    </tr>
                    <tr id="provinsiRowkorban" style="display: none;">
                        <td>
                            Provinsi <sup>*</sup>
                        </td>
                        <td>:</td>
                        <td>
                            <select class="pilortu" id="provinsikorban" onchange="getkota(0, this.value);">
                                <option value="-"> - pilih provinsi - </option>
                                <?php foreach ($daf_provinsi as $provinsi) : ?>
                                    <option value="<?= $provinsi['kode_wilayah'] ?>"><?= $provinsi['nama'] ?></option>

                                <?php endforeach; ?>
                            </select>
                            <br>
                            <span class="info" id="infoprovinsikorban"></span>
                        </td>
                    </tr>
                    <tr id="kotaRowkorban" style="display: none;">
                        <td>
                            Kab / Kota <sup>*</sup>
                        </td>
                        <td>:</td>
                        <td>
                            <select class="pilortu" id="kotakorban" onchange="getkecamatan(0, this.value);">
                                <option value='-'> - pilih kota/kab - </option>
                            </select>
                            <br>
                            <span class="info" id="infokotakorban"></span>
                        </td>
                    </tr>
                    <tr id="kecamatanRowkorban" style="display: none;">
                        <td>
                            Kecamatan <sup>*</sup>
                        </td>
                        <td>:</td>
                        <td>
                            <select class="pilortu" id="kecamatankorban" onchange="getdesa(0, this.value);">
                                <option value='-'> - pilih kecamatan - </option>
                            </select>
                            <br>
                            <span class="info" id="infokecamatankorban"></span>
                        </td>
                    </tr>
                    <tr id="desaRowkorban" style="display: none;">
                        <td>
                            Desa
                        </td>
                        <td>:</td>
                        <td>
                            <select class="pilortu" id="desakorban">
                                <option value='-'> - pilih desa - </option>
                            </select>
                        </td>
                    </tr>
                    <tr id="disabilitasRowkorban" style="display: none;">
                        <td>
                            Apakah korban memiliki disabilitas?
                        </td>
                        <td>:</td>
                        <td>

                            <input type="radio" name="disabilitaskorban" value="1" onclick="toggleInput(' korban',this, 1)"> Ya, sebutkan:

                            <input type="text" id="inputdisabilitaskorban" style="display: none;">
                            <br>

                            <div id="opsidisabilitasRowkorban" style="margin-left: 20px; display: none">
                                <button onclick="tampilinfoketunaan()" class="btn_biru" style="border-radius:2px;padding:3px !important">Info Disabilitas</button><br>
                                <?php
                                foreach ($daf_kebutuhan_khusus as $row) {
                                    $kd_kb = $row['kebutuhan_khusus'];
                                    $kodeexp = explode("-", $kd_kb);
                                    $kode = trim($kodeexp[0], " ");
                                    echo '<input type="checkbox" value="' . $row['kebutuhan_khusus_id'] . '" id="checkbox' . $kode . 'korban"> ' . $kd_kb . '<br>';
                                }
                                ?>
                            </div>

                            <input type="radio" checked name="disabilitaskorban" value="0" onclick="toggleInput('korban',this, 1)"> Tidak
                            <span class="info" id="infodisabilitaskorban"></span><br>
                            <br>
                            <button onclick="konfirmdisabilitaskorban(0)" id="tbdisabilitaskorban" class="btn_ijo">Konfirmasi</button>
                        </td>
                    </tr>
                </table>
                <div style="margin-top: 10px; display:inline">
                    <button id="tbkurangikorban" style="margin-top: 10px; display: none;" class="btn_merah" onclick="kurangiKorban(0)">HAPUS KORBAN INI</button>
                    <button id="tbtambahkorban" style="margin-top: 10px; display: none;" class="btn_ijo" onclick="tambahKorban(0)">INPUT KORBAN BERIKUTNYA</button>
                    <button id="tbpelakukorban" style="margin-top: 10px; display: none;" class="btn_ijo" onclick="tambahPelaku(0)"><span class="kelaspelaku">INPUT PELAKU</span></button>
                </div>
            </div>

        </div>
    </div>

    <div id="dif4">
        <div id="lokasipelaku">
            <div id="pelaku" class="pelaku">
                <table class="tabelisian">
                    <tr>
                        <th class="kelabu kelaspelaku" colspan="3">Bagian 2: Formulir Pelaku</th>
                    </tr>
                    <tr>
                        <th style="width:40%"></th>
                        <th style="width:10px;"></th>
                        <th></th>
                    </tr>
                    <tr>
                        <td class="kelaspelaku">
                            Status Pelaku *
                        </td>
                        <td>:</td>
                        <td>
                            <?php foreach ($daf_status_korban as $status) : ?>
                                <div class=" checkbox-container">
                                    <input onchange="cekstatuspelaku(0);" type="radio" name="status_pelaku" value="<?= $status['status_korban_pelaku_id'] ?>">
                                    <?= $status['nama'] ?>
                                </div>
                            <?php endforeach; ?>
                        </td>
                    </tr>
                    <tr id="npsnRowpelaku" style="display: none;">
                        <td class="kelaspelaku">
                            NPSN Pelaku
                        </td>
                        <td>:</td>
                        <td><input <?= ($sebagai == "sekolah") ? "disabled" : "" ?> maxlength="8" type="text" placeholder="" id="npsnpelaku" name="npsnpelaku" value="<?= $npsn ?>">
                            <span class="info" id="infonpsnpelaku"></span>
                            <button <?= ($sebagai == "sekolah") ? "style='display:none'" : "" ?> id="tbnpsnpelaku" class="btn_ijo" onclick="submitnpsnpelaku(0)">Submit</button>
                            <button id="tbcarisekolahpelaku" onclick="tampilmodal()" class="btn_biru">Cari NPSN/Sekolah</button>
                        </td>
                    </tr>
                    <tr id="sekolahRowpelaku" style="display: none;">
                        <td class="kelaspelaku">
                            Nama Sekolah / Instansi Pelaku
                        </td>
                        <td>:</td>
                        <td><textarea <?= ($sebagai == "sekolah") ? "disabled" : "" ?> id="sekolahpelaku" name="sekolahpelaku"><?= ($sebagai == "sekolah") ? $sekolah_saya['nama'] : "" ?></textarea>
                            <?php if ($sebagai == "sekolah") {
                                $xstatus = ($sekolah_saya['nama_sekolah'] == 1) ? "Negeri" : "Swasta";
                                $kec = substr($sekolah_saya['kecamatan'], 5);
                                $kota = (substr($sekolah_saya['kota'], 0, 3) == "Kab.") ? "Kab: " : "Kota: ";
                                $kota = $kota . substr($sekolah_saya['kota'], 5);
                                $provinsi = substr($sekolah_saya['provinsi'], 6);
                            } ?>
                            <span class="info" id="infosekolahpelaku">
                                <?php if ($sebagai == "sekolah") { ?>
                                    <div style='color:black; margin-left:10px'>Status: <?= $xstatus ?><br> Kec: <?= $kec ?><br> <?= $kota ?> <br> Provinsi: <?= $provinsi ?> </div>
                                <?php } ?>
                            </span>
                            <button onclick="konfirmsekolahpelaku(0)" id="tbsekolahpelaku" class="btn_ijo">Konfirmasi</button>
                        </td>
                    </tr>
                    <?php if ($sebagai == "sekolah") { ?>
                        <tr id="daftarpdRowpelaku" style="display: none;">
                            <td class="kelaspelaku">
                                Nama Pelaku *
                            </td>
                            <td>:</td>
                            <td>
                                <select class="js-pil" id="daftarpdpelaku" name="daftarpdpelaku" style="width: 100%;">
                                    <option value="000000">Pilih Siswa</option>
                                    <?php foreach ($daf_siswa as $key => $value) : ?>
                                        <option value="<?= $value['nisn'] ?>" data-induk="<?= $value['nik'] ?>"><?= $value['nama'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="info" id="infodaftarpdpelaku"></span><br>
                            </td>
                        </tr>
                        <tr id="daftarptkRowpelaku" style="display: none;">
                            <td class="kelaspelaku">
                                Nama Pelaku *
                            </td>
                            <td>:</td>
                            <td>
                                <select class="js-pil" id="daftarptkpelaku" name="daftarptkpelaku" style="width: 100%;">
                                    <option value="000000">Pilih Pendidik</option>
                                    <option value="000001">-- Input Manual --</option>
                                    <?php foreach ($daf_pendidik as $key => $value) : ?>
                                        <option value="<?= $value['nuptk'] ?>" data-induk="<?= $value['nik'] ?>"><?= $value['nama'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="info" id="infodaftarptkpelaku"></span><br>
                            </td>
                        </tr>
                        <tr id="daftarptk2Rowpelaku" style="display: none;">
                            <td class="kelaspelaku">
                                Nama Pelaku *
                            </td>
                            <td>:</td>
                            <td>
                                <select class="js-pil" id="daftarptk2pelaku" name="daftarptk2pelaku" style="width: 100%;">
                                    <option value="000000">Pilih TK</option>
                                    <option value="000001">-- Input Manual --</option>
                                    <?php foreach ($daf_tenagakependidikan as $key => $value) : ?>
                                        <option value="<?= $value['nuptk'] ?>" data-induk="<?= $value['nik'] ?>"><?= $value['nama'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="info" id="infodaftarptk2pelaku"></span><br>
                            </td>
                        </tr>
                        <tr id="daftarkepsekRowpelaku" style="display: none;">
                            <td class="kelaspelaku">
                                Nama Pelaku *
                            </td>
                            <td>:</td>
                            <td>
                                <select class="js-pil" id="daftarkepsekpelaku" name="daftarkepsekpelaku" style="width: 100%;">
                                    <?php foreach ($daf_kepsek as $key => $value) : ?>
                                        <option value="<?= $value['nuptk'] ?>" data-induk="<?= $value['nik'] ?>"><?= $value['nama'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="info" id="infodaftarkepsekpelaku"></span><br>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr id="nisnRowpelaku" style="display: none;">
                        <td class="kelaspelaku">
                            NISN / NUPTK Pelaku
                        </td>
                        <td>:</td>
                        <td><input maxlength="16" type="text" placeholder="" id="nisnpelaku" name="nisnpelaku">
                            <span class="info" id="infonisnpelaku"></span><br>
                            <button onclick="ceknisnpelaku(0)" id="tbnisnpelaku" class="btn_ijo">Cek</button>
                        </td>
                    </tr>
                    <tr id="namaRowpelaku" style="display: none;">
                        <td class="kelaspelaku">
                            Nama Pelaku *
                        </td>
                        <td>:</td>
                        <td><textarea id="namapelaku" name="namapelaku"></textarea>
                            <span class="info" id="infonamapelaku"></span><br>
                            <!-- <button onclick="konfirmnamapelaku(0)" id="tbnamapelaku" class="btn_abu2">Konfirm</button> -->
                        </td>
                    </tr>
                    <tr id="nikpdptkRowpelaku" style="display: none;">
                        <td class="kelaspelaku">
                            NIK
                        </td>
                        <td>:</td>
                        <td><input maxlength="16" type="text" placeholder="" id="nikpdptkpelaku" name="nikpdptkpelaku">
                            <span class="info" id="infonikpdptkpelaku"></span><br>
                            <button style="display: none;" onclick="ceknikpdptkpelaku(0)" id="tbnikpdptkpelaku" class="btn_ijo">Konfirmasi</button>
                            <button style="display: none;" onclick="ceknisnpelaku(0)" id="tbnikselectpelaku" class="btn_ijo">Konfirmasi</button>
                        </td>
                    </tr>
                    <tr id="nikRowpelaku" style="display: none;">
                        <td class="kelaspelaku">
                            NIK Pelaku <sup>*</sup>
                        </td>
                        <td>:</td>
                        <td><select class="pilortu" id="statusortupelaku">
                                <option value="ayah">Ayah</option>
                                <option value="ibu">Ibu</option>
                                <option value="wali">Wali Murid</option>
                            </select>
                            <input maxlength="16" type="text" placeholder="" id="nikpelaku" name="nikpelaku">
                            <span class="info" id="infonikpelaku"></span><br>
                            <button onclick="ceknikpelaku(0)" id="tbnikpelaku" class="btn_ijo">OK</button>
                        </td>
                    </tr>
                    <tr id="namaortuRowpelaku" style="display: none;">
                        <td class="kelaspelaku">
                            Nama Pelaku (Ortu)
                        </td>
                        <td>:</td>
                        <td><textarea id="namaortupelaku" name="namaortupelaku"></textarea>
                            <span class="info" id="infonamaortupelaku"></span><br>
                            <!-- <button style="display: none;" onclick="konfirmnamaortupelaku(0)" id="tbnamaortupelaku" class="btn_ijo">Konfirm</button> -->
                        </td>
                    </tr>
                    <tr id="tgllahirRowpelaku" style="display: none;">
                        <td class="kelaspelaku">
                            Tanggal Lahir Pelaku
                        </td>
                        <td>:</td>
                        <td><input type="text" id="datepickerpelaku" name="datepickerpelaku" onblur=" validasiTanggalLahir()" placeholder="dd/mm/yyyy" value="">
                            <span id="errorTanggalLahirpelaku" style="color: red; display: none;">Format tanggal tidak valid.</span>
                        </td>
                    </tr>
                    <tr id="usiaRowpelaku" style="display: none;">
                        <td class="kelaspelaku">
                            Usia Pelaku <sup>*</sup>
                        </td>
                        <td>:</td>
                        <td>
                            <input type="text" placeholder="" id="usiapelaku" name="usiapelaku">
                            <span class="info" id="infousiapelaku"></span>
                        </td><br>
                        <!-- <button onclick="cekusiapelaku(0)" id="tbusiapelaku" class="btn_ijo">OK</button> -->
                    </tr>
                    <tr id="jenis_kelaminRowpelaku" style="display: none;">
                        <td class="kelaspelaku">
                            Jenis Kelamin Pelaku <sup>*</sup>
                        </td>
                        <td>:</td>
                        <td>
                            <input type="radio" name="jenis_kelaminpelaku" value="L"> Laki-laki<br>
                            <input type="radio" name="jenis_kelaminpelaku" value="P"> Perempuan<br>
                            <span class="info" id="infojenis_kelaminpelaku"></span><br>
                            <button style="display: none;" onclick="konfirmjenis_kelaminpelaku(0)" id="tbjenis_kelaminpelaku" class="btn_ijo">Konfirmasi</button>
                            <button onclick="ceknikdarijkpelaku(0)" id="tbnikdarijkpelaku" class="btn_ijo">Cek Dukcapil</button> <button style="display: none;" onclick="lanjutalamatpelaku(0)" id="tblanjutdarijkpelaku" class="btn_ijo">Lewati Cek Dukcapil</button>
                        </td>
                    </tr>
                    <tr id="alamatRowpelaku" style="display: none;">
                        <td class="kelaspelaku">
                            Alamat Pelaku <sup>*</sup>
                        </td>
                        <td>:</td>
                        <td><input type="text" placeholder="" id="alamatpelaku" name="alamatpelaku" style="display: none;">
                            <span class="info" id="infoalamatpelaku"></span>
                        </td><br>
                        <!-- <button onclick="cekusiapelaku(0)" id="tbusiapelaku" class="btn_ijo">OK</button> -->
                    </tr>
                    <tr id="provinsiRowpelaku" style="display: none;">
                        <td>
                            Provinsi <sup>*</sup>
                        </td>
                        <td>:</td>
                        <td>
                            <select class="pilortu" id="provinsipelaku" onchange="getkota(0, this.value);">
                                <option value="-"> - pilih provinsi - </option>
                                <?php foreach ($daf_provinsi as $provinsi) : ?>
                                    <option value="<?= $provinsi['kode_wilayah'] ?>"><?= $provinsi['nama'] ?></option>

                                <?php endforeach; ?>
                            </select>
                            <br>
                            <span class="info" id="infoprovinsipelaku"></span>
                        </td>
                    </tr>
                    <tr id="kotaRowpelaku" style="display: none;">
                        <td>
                            Kab / Kota <sup>*</sup>
                        </td>
                        <td>:</td>
                        <td>
                            <select class="pilortu" id="kotapelaku" onchange="getkecamatan(0, this.value);">
                                <option value='-'> - pilih kota/kab - </option>
                            </select>
                            <br>
                            <span class="info" id="infokotapelaku"></span>
                        </td>
                    </tr>
                    <tr id="kecamatanRowpelaku" style="display: none;">
                        <td>
                            Kecamatan <sup>*</sup>
                        </td>
                        <td>:</td>
                        <td>
                            <select class="pilortu" id="kecamatanpelaku" onchange="getdesa(0, this.value);">
                                <option value='-'> - pilih kecamatan - </option>
                            </select>
                            <br>
                            <span class="info" id="infokecamatanpelaku"></span>
                        </td>
                    </tr>
                    <tr id="desaRowpelaku" style="display: none;">
                        <td>
                            Desa
                        </td>
                        <td>:</td>
                        <td>
                            <select class="pilortu" id="desapelaku">
                                <option value='-'> - pilih desa - </option>
                            </select>
                        </td>
                    </tr>
                    <tr id="disabilitasRowpelaku" style="display: none;">
                        <td class="kelaspelaku">
                            Apakah Pelaku memiliki disabilitas?
                        </td>
                        <td>:</td>
                        <td>

                            <input type="radio" name="disabilitaspelaku" value="1" onclick="toggleInput(' pelaku',this, 1)"> Ya, sebutkan:

                            <input type="text" id="inputdisabilitaspelaku" style="display: none;">
                            <br>

                            <div id="opsidisabilitasRowpelaku" style="margin-left: 20px; display: none">
                                <button onclick="tampilinfoketunaan()" class="btn_biru" style="border-radius:2px;padding:3px !important">Info Disabilitas</button><br>
                                <?php
                                foreach ($daf_kebutuhan_khusus as $row) {
                                    $kd_kb = $row['kebutuhan_khusus'];
                                    $kodeexp = explode("-", $kd_kb);
                                    $kode = trim($kodeexp[0], " ");
                                    echo '<input type="checkbox" value="' . $row['kebutuhan_khusus_id'] . '" id="checkbox' . $kode . 'pelaku"> ' . $kd_kb . '<br>';
                                }
                                ?>
                            </div>

                            <input type="radio" checked name="disabilitaspelaku" value="0" onclick="toggleInput('pelaku',this, 1)"> Tidak
                            <span class="info" id="infodisabilitaspelaku"></span><br>
                            <br>
                            <button onclick="konfirmdisabilitaspelaku(0)" id="tbdisabilitaspelaku" class="btn_ijo">Konfirmasi</button>
                        </td>
                    </tr>
                </table>
                <div style="margin-top: 10px; display:inline">
                    <button id="tbkurangipelaku" style="margin-top: 10px; display: none;" class="btn_merah" onclick="kurangiPelaku(0)"><span class="kelaspelaku">HAPUS PELAKU INI</span></button>
                    <button id="tbtambahpelaku" style="margin-top: 10px; display: none;" class="btn_ijo" onclick="tambahPelaku(0)"><span class="kelaspelaku">INPUT PELAKU BERIKUTNYA</span></button>
                    <button id="tbkronologi" style="margin-top: 10px; display: none;" class="btn_ijo" onclick="inputkronologiPelaku()">INPUT KRONOLOGI</button>

                </div>
            </div>

        </div>
    </div>

    <div id="dif5">
        <div id="kronologi">
            <table class="tabelisian">
                <tr>
                    <th class="kelabu" colspan="3">Bagian 3: Kronologi Kasus</th>
                </tr>
                <tr>
                    <th style="width:40%"></th>
                    <th style="width:10px;"></th>
                    <th></th>
                </tr>
                <tr>
                    <td>
                        Bentuk Kekerasan
                    </td>
                    <td>:</td>
                    <td>
                        <?php foreach ($daf_bentuk_kekerasan as $bentuk) : ?>
                            <div class="checkbox-container">
                                <input type="checkbox" name="k_<?= $bentuk['bentuk_kekerasan_id'] ?>">
                                <?= $bentuk['nama'] ?>
                            </div>
                        <?php endforeach; ?>
                        <span class="info" id="infobentukkekerasan"></span>
                    </td>
                </tr>
                <tr>
                    <td>
                        Cakupan Kekerasan
                    </td>
                    <td>:</td>
                    <td>
                        <div class="checkbox-container">
                            <input type="radio" name="cakupan" value="dalam">
                            Di dalam lokasi satuan pendidikan
                        </div>
                        <div class="checkbox-container">
                            <input type="radio" name="cakupan" value="luar">
                            Di luar lokasi satuan pendidikan (namun masih dalam kegiatan satuan pendidikan)
                        </div>
                        <div class="checkbox-container">
                            <input type="radio" name="cakupan" value="lebih">
                            Melibatkan lebih dari 1 (satu) satuan pendidikan
                        </div>
                        <span class="info" id="infocakupan"></span>

                    </td>
                </tr>
                <tr>
                    <td>
                        Kronologi peristiwa
                    </td>
                    <td>:</td>
                    <td>Tuliskan informasi singkat mengenai kejadian, khususnya waktu, lokasi/tempat spesifik terjadinya kekerasan, uraian proses terjadinya kekerasan.<br>
                        <textarea id="ikronologi" rows="5"></textarea>
                        <span class="info" id="infokronologi"></span>
                        <br>
                        <button onclick="submitkronologi(this)" id="tbsubmitkronologi" class="btn_ijo">Submit</button>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div id="dif6">
        <div id="akhir">
            <table id="tabelakhir">
                <tr>
                    <th class="kelabu">Halaman Akhir</th>
                </tr>
                <tr>
                    <td>Terima kasih telah mengisi formulir pencatatan kasus kekerasan di lingkungan satuan pendidikan.
                    </td>
                </tr>
            </table>

            <div class="catatan">
                Catatan:
                <ul>
                    <li>
                        Pengisi formulir adalah pendidik dan tenaga kependidikan yang merupakan anggota TPPK.
                    </li>
                    <li>
                        Formulir diisi paling lambat di akhir semester (Juni dan Desember).
                    </li>
                </ul>

            </div>
            <br>
            <button id="tbdaftar" class="btn_biru" onclick=kembali();>Kembali ke Daftar Laporan</button>
        </div>

    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scriptfooter') ?>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    var pilihanview = "single";
    document.addEventListener("DOMContentLoaded", function() {
        const singleViewBtn = document.getElementById('singleViewBtn');
        const multiViewBtn = document.getElementById('multiViewBtn');
        var toggle = document.getElementById("toggle");
        var sliderButton = document.querySelector(".slider-button");

        sliderButton.addEventListener("click", function() {
            event.preventDefault(); // Mencegah perilaku default saat tombol slider diklik

            // Jika slider aktif (ke kanan)
            if (toggle.checked) {
                showView('single');
                savePreference('single');
                pilihanview = "single";
                toggle.checked = false; // Set properti checked ke false
            } else {
                showView('multi');
                savePreference('multi');
                pilihanview = "multi";
                toggle.checked = true; // Set properti checked ke true
            }
        });

        function savePreference(viewType) {
            localStorage.setItem('viewPreference', viewType);
        }

        function loadPreference() {
            const preference = localStorage.getItem('viewPreference');
            if (preference) {
                pilihanview = preference;
                showView(preference);
            }

        }

        loadPreference();

        function showView(viewType) {
            if (viewType === 'single') {
                toggle.checked = false;
                document.getElementById('tabs-container').classList.add('hide');
                document.getElementById('singleViewBtn').classList.add('aktif');
                document.getElementById('multiViewBtn').classList.remove('aktif');
                // lokasikorban.appendChild(akhirDiv);
                for (var b = 1; b <= 6; b++)
                    if (document.getElementById('tb' + b).disabled == false) {
                        document.getElementById('dif' + b).style.display = "block";
                    }
            } else {
                // sliderButton.style.left = "calc(100% - 50px)";
                toggle.checked = true;
                document.getElementById('tabs-container').classList.remove('hide');
                document.getElementById('singleViewBtn').classList.remove('aktif');
                document.getElementById('multiViewBtn').classList.add('aktif');
                // document.getElementById('dif6').appendChild(akhirDiv);
                for (var b = 1; b <= 6; b++) {
                    document.getElementById('dif' + (b)).style.display = "none";
                    if (akhirDiv.classList.contains('fade-in'))
                        document.getElementById('dif6').style.display = "block";
                    if (document.getElementById('tb' + b).classList.contains("active")) {
                        document.getElementById('dif' + (b)).style.display = "block";
                    }
                }
            }

        }

        multiViewBtn.addEventListener('click', function() {
            showView('multi');
            savePreference('multi');
            pilihanview = "multi";
        });

        singleViewBtn.addEventListener('click', function() {
            showView('single');
            savePreference('single');
            pilihanview = "single";
        });


    });

    const divs = document.querySelectorAll('div[id^="dif"]');
    const tbs = document.querySelectorAll('div[id^="tb"]');

    function showTabContent(divId) {
        divs.forEach(div => div.style.display = "none");
        if (akhirDiv.classList.contains('fade-in'))
            document.getElementById('dif6').style.display = "block";

        document.getElementById(divId).style.display = "block";
        // tbs.forEach(tb => tb.classList.remove('active'));
        for (var a = 1; a <= 6; a++) {
            document.getElementById("tb" + a).classList.remove('active');
        }
        document.getElementById("tb" + divId.substring(3, 4)).classList.add('active');
    }

    const sebagai = '<?= $sebagai ?>';
    var btnTidakBersedia = document.getElementById('tbtidakbersedia');
    var btnBersedia = document.getElementById('tbbersedia');
    var lokasikorban = document.getElementById('lokasikorban');
    var lokasipelaku = document.getElementById('lokasipelaku');
    var akhirDiv = document.getElementById('akhir');
    var isianDiv = document.getElementById('isian');
    var korbanDiv;
    var pelakuDiv;
    var kronologiDiv = document.getElementById('kronologi');
    var tbya = document.getElementById('tbya');
    var tbtidak = document.getElementById('tbtidak');
    var tbstop = document.getElementById('tbstop');
    var pilstatus = {
        korban: [],
        pelaku: [],
    };

    var statuskasus = "";
    var xinfonis = "";

    var nama = "";
    var valnama = "-";
    var tgl_lahir = "";
    var valtgl_lahir = "-";
    var nik_pdptk = "";
    var jenis_kelamin = "";
    var valjenis_kelamin = "-";
    var usia = 0;
    var kode_wilayah = "000000";
    var nisn = "";
    var nama_sekolah = "";
    var nama_sekolah_asal = "<?= ($sebagai == "sekolah") ? $sekolah_saya['nama'] : "" ?>";
    var disabilitas = "";
    var pildisabilitas = "";
    var disabilitasortu = "";
    var pildisabilitasortu = "";
    var statusakhir = 0;
    var statussebelumnya = 0;
    var jenisnomor = "";
    var csrf = '<?= csrf_hash(); ?>';

    var xhrGet;

    var statuskorbanok = [];
    var statuspelakuok = [];
    var isikorbanmanual = [];
    var isipelakumanual = [];

    let counterkorban = 0;
    let counterpelaku = 0;

    var dafkodeKB = [];
    <?php
    foreach ($daf_kebutuhan_khusus as $row) {
        $kd_kb = $row['kebutuhan_khusus'];
        $kodeexp = explode("-", $kd_kb);
        $kode = trim($kodeexp[0], " ");
        echo 'dafkodeKB.push("' . $kode . '"); ';
    }
    ?>

    function cekstatuskorban(idx) {
        cekstatus("korban", idx);
    }

    function cekstatuspelaku(idx) {
        cekstatus("pelaku", idx);
    }

    function cekpilihjkkorban(idx) {
        cekpilihjk("korban", idx);
    }

    function cekpilihjkpelaku(idx) {
        cekpilihjk("pelaku", idx);
    }

    function kembali() {
        opsi = "";
        if (sebagai == "dinas") {
            opsi = "?laporan=dinas";
            window.open("<?= base_url('status_laporan_kekerasan') ?>" + opsi, "_self");
        } else {
            window.open("<?= base_url('inputdata/daftar_laporan') ?>" + opsi, "_self");
        }
    }

    function cekpilihjk(siapa, idx) {
        document.getElementById('infojenis_kelamin' + siapa + idx).innerHTML = "";
    }

    function cekstatus(siapa, idx) {
        if (siapa == "korban") {
            statuskorbanok[idx] = 0;
        } else {
            statuspelakuok[idx] = 0;
        }
        statussebelumnya = statusakhir;
        valid = true;
        if (statuskasus == 3) {
            var terlapor_meninggal = $('input[name="terlapor_meninggal"]:checked').length > 0 ? "tm," : "";
            var korban_tidak_ditemukan = $('input[name="korban_tidak_ditemukan"]:checked').length > 0 ? "ktd," : "";
            var pembuktian_belum_cukup = $('input[name="pembuktian_belum_cukup"]:checked').length > 0 ? "pbc," : "";
            var pilhenti = terlapor_meninggal + korban_tidak_ditemukan + pembuktian_belum_cukup;
            valid = true;
            if (pilhenti == "") {
                document.getElementById('erroralasan').innerHTML = "Pilih minimal 1 alasan";
                // valid = false;
            } else {
                document.getElementById('erroralasan').innerHTML = "";
            }
        }

        if (xhrGet && xhrGet.readyState != 4) {
            xhrGet.abort(); // Menghentikan proses AJAX sebelumnya
        }


        if (valid) {
            var nrow;
            const radioButtons = document.getElementsByName('status_' + siapa + idx);
            let selectedValuestatus = 0;
            statusakhir = selectedValuestatus;
            for (let i = 0; i < radioButtons.length; i++) {
                if (radioButtons[i].checked) {
                    selectedValuestatus = radioButtons[i].value;
                    break;
                }
            }

            statusakhir = selectedValuestatus;

            const buttons = document.querySelectorAll('.btn_abu');

            buttons.forEach(btn => {
                if (!btn.classList.contains('clicked')) {
                    // btn.disabled = true;
                } else {
                    // btn.removeAttribute('disabled');
                }
            });



            var checkboxes = document.querySelectorAll('#container input[type="checkbox"]');

            checkboxes.forEach(function(checkbox) {
                // checkbox.disabled = true;
            });

            ///cek JK dipilih apa gak
            var radios = document.getElementsByName('jenis_kelamin' + siapa + idx);
            var adaJKTerpilih = false;

            for (var i = 0; i < radios.length; i++) {
                if (radios[i].checked) {
                    adaJKTerpilih = true;
                    break;
                }
            }

            const npsnrow = document.getElementById('npsnRow' + siapa + idx);
            const npsn = document.getElementById('npsn' + siapa + idx);
            const tbnpsn = document.getElementById('tbnpsn' + siapa + idx);
            const tbcarisekolah = document.getElementById('tbcarisekolah' + siapa + idx);
            const labelnpsn = npsnrow.getElementsByTagName('td');
            if (sebagai == "sekolah") {
                // alert('infodaftarpd' + siapa + idx);
                var daftarpdrow = document.getElementById('daftarpdRow' + siapa + idx);
                var daftarptkrow = document.getElementById('daftarptkRow' + siapa + idx);
                var daftarptk2row = document.getElementById('daftarptk2Row' + siapa + idx);
                var infodaftarpd = document.getElementById('infodaftarpd' + siapa + idx);
                var infodaftarptk = document.getElementById('infodaftarptk' + siapa + idx);
                var infodaftarptk2 = document.getElementById('infodaftarptk2' + siapa + idx);
                var daftarkepsekrow = document.getElementById('daftarkepsekRow' + siapa + idx);
                var infodaftarkepsek = document.getElementById('infodaftarkepsek' + siapa + idx);
            }
            const infousia = document.getElementById('infousia' + siapa + idx);
            const nisnrow = document.getElementById('nisnRow' + siapa + idx);
            const nisn = document.getElementById('nisn' + siapa + idx);
            const labels = nisnrow.getElementsByTagName('td');
            const nikrow = document.getElementById('nikRow' + siapa + idx);
            const tbnik = document.getElementById('tbnik' + siapa + idx);
            const statusortu = document.getElementById('statusortu' + siapa + idx);
            const labelnik2 = nikrow.getElementsByTagName('td');
            const isinik = document.getElementById('nik' + siapa + idx);
            const infonik = document.getElementById('infonik' + siapa + idx);
            const nikpdptkrow = document.getElementById('nikpdptkRow' + siapa + idx);
            const labelnikpdptk = nikpdptkrow.getElementsByTagName('td');
            const nikpdptk = document.getElementById('nikpdptk' + siapa + idx);
            const sekolahrow = document.getElementById('sekolahRow' + siapa + idx);
            const sekolah = document.getElementById('sekolah' + siapa + idx);
            const infosekolah = document.getElementById('infosekolah' + siapa + idx);
            const tbsekolah = document.getElementById('tbsekolah' + siapa + idx);
            const labels2 = sekolahrow.getElementsByTagName('td');
            const namarow = document.getElementById('namaRow' + siapa + idx);
            const nama = document.getElementById('nama' + siapa + idx);
            const infonama = document.getElementById('infonama' + siapa + idx);
            const infonamaortu = document.getElementById('infonamaortu' + siapa + idx);
            const labelnama = namarow.getElementsByTagName('td');
            const namaorturow = document.getElementById('namaortuRow' + siapa + idx);
            const namaortu = document.getElementById('namaortu' + siapa + idx);
            const labelnama2 = namaorturow.getElementsByTagName('td');
            const usiarow = document.getElementById('usiaRow' + siapa + idx);
            const usia = document.getElementById('usia' + siapa + idx);
            const tglahirrow = document.getElementById('tgllahirRow' + siapa + idx);
            const jenis_kelaminrow = document.getElementById('jenis_kelaminRow' + siapa + idx);
            const tbjenis_kelamin = document.getElementById('tbjenis_kelamin' + siapa + idx);
            const infojenis_kelamin = document.getElementById('infojenis_kelamin' + siapa + idx);
            const tbnikdarijk = document.getElementById('tbnikdarijk' + siapa + idx);
            const labeljenis_kelamin = jenis_kelaminrow.getElementsByTagName('td');
            const alamatrow = document.getElementById('alamatRow' + siapa + idx);
            const alamat = document.getElementById('alamat' + siapa + idx);
            const provinsirow = document.getElementById('provinsiRow' + siapa + idx);
            const kotarow = document.getElementById('kotaRow' + siapa + idx);
            const kecamatanrow = document.getElementById('kecamatanRow' + siapa + idx);
            const desarow = document.getElementById('desaRow' + siapa + idx);
            const disabilitasrow = document.getElementById('disabilitasRow' + siapa + idx);

            tekssiapa = siapa;
            if (siapa == "pelaku") {
                if (statuskasus == 1) {
                    tekssiapa = "pelaku";
                } else {
                    tekssiapa = "terlapor";
                }
            }
            var xsiapa = capitalizeFirstLetter(tekssiapa);
            var xsiapa2 = "";
            if (selectedValuestatus == 2) {
                xsiapa2 = xsiapa + " (" + capitalizeFirstLetter(statusortu.value) + ")";
                xsiapa = "Peserta Didik";
                namaorturow.style.display = 'table-row';
            } else if (selectedValuestatus == 6) {
                xsiapa2 = xsiapa;

            }

            labelnpsn[0].innerHTML = 'NPSN ' + xsiapa + ' <sup>*</sup>';
            labelnama[0].innerHTML = 'Nama ' + xsiapa + ' <sup>*</sup>';
            labelnikpdptk[0].innerHTML = 'NIK ' + xsiapa + ' <sup>*</sup>';
            labelnik2[0].innerHTML = 'NIK ' + xsiapa2 + ' <sup>*</sup>';
            labelnama2[0].innerHTML = 'Nama ' + xsiapa2 + ' <sup>*</sup>';
            labels[0].innerHTML = 'NUPTK ' + xsiapa;
            labels2[0].innerHTML = 'Nama Sekolah ' + xsiapa + ' *';

            jenis_kelaminrow.style.display = 'none';
            disabilitasrow.style.display = 'none';

            if (selectedValuestatus >= 1 && selectedValuestatus <= 2) {
                if (sebagai == "sekolah") {
                    $('#daftarpd' + siapa + idx).val('000000').trigger('change.select2');
                    $('#daftarptk' + siapa + idx).val('000000').trigger('change.select2');
                    $('#daftarptk2' + siapa + idx).val('000000').trigger('change.select2');
                    infodaftarpd.innerHTML = "";
                    infodaftarptk.innerHTML = "";
                    infodaftarptk2.innerHTML = "";
                    daftarpdrow.style.display = 'table-row';
                    daftarptkrow.style.display = 'none';
                    daftarptk2row.style.display = 'none';
                    infodaftarkepsek.innerHTML = "";
                    daftarkepsekrow.style.display = 'none';

                    var selectElement = document.getElementById('daftarpd' + siapa + idx);
                    var selectedIndex = selectElement.selectedIndex;
                    var selectedOption = selectElement.options[selectedIndex];
                    var selectedVal = selectedOption.value;
                }

                nisn.value = "";
                nisnrow.style.display = 'none';
                nikpdptkrow.style.display = 'none';
                jenis_kelaminrow.style.display = 'none';
                disabilitasrow.style.display = 'none';

                tglahirrow.style.display = 'none';
                alamatrow.style.display = 'none';
                nikrow.style.display = 'none';
                npsnrow.style.display = 'table-row';
                npsnrow.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });

                if (sebagai == "sekolah") {
                    sekolahrow.style.display = 'table-row'
                } else {
                    tbsekolah.style.display = 'table-row';
                    sekolahrow.style.display = 'none'
                    tbnpsn.style.display = 'table-row';
                }

                if (selectedValuestatus == 2 && selectedVal != "000000" && statussebelumnya == 1) {
                    // statusortu.style.display = 'table-row';
                    // nikrow.style.display = 'table-row';
                }

                nisn.maxLength = 10;
                xinfonis = "NISN tidak ditemukan";
                tbsekolah.innerText = "Konfirmasi";
                if (nisn.value == "" && sebagai != "sekolah")
                    tbsekolah.style.display = 'table-row';
                if (tbsekolah.style.display == 'none') {
                    // nisnrow.style.display = "table-row";
                }
                if (tbnpsn.style.display != 'none') {
                    sekolahrow.style.display = "none";
                }
                if (nisn.value == "")
                    nisnrow.style.display = 'none';
                if (nama.value == "")
                    namarow.style.display = 'none';
                if (nisnrow.style.display == 'none')
                    namarow.style.display = 'none';
                usiarow.style.display = 'none';
                provinsirow.style.display = 'none';
                kotarow.style.display = 'none';
                kecamatanrow.style.display = 'none';
                desarow.style.display = 'none';

                if (!adaJKTerpilih || statussebelumnya > 2) {
                    jenis_kelaminrow.style.display = 'none';
                    disabilitasrow.style.display = 'none';
                }

            } else if (selectedValuestatus >= 3 && selectedValuestatus <= 5) {
                if ((selectedValuestatus == 3 || selectedValuestatus == 4) && (statussebelumnya == 3 || statussebelumnya == 4)) {

                } else {

                }

                if (sebagai == "sekolah") {
                    sekolahrow.style.display = 'table-row'
                } else {
                    tbsekolah.style.display = 'table-row';
                    sekolahrow.style.display = 'none'
                    npsnrow.style.display = 'table-row';
                    tbnpsn.style.display = 'table-row';
                    nisn.value = "";
                    nisnrow.style.display = 'none';
                    npsnrow.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }

                if (sebagai == "sekolah") {
                    $('#daftarpd' + siapa + idx).val('000000').trigger('change.select2');
                    $('#daftarptk' + siapa + idx).val('000000').trigger('change.select2');
                    $('#daftarptk2' + siapa + idx).val('000000').trigger('change.select2');
                    infodaftarpd.innerHTML = "";
                    infodaftarptk.innerHTML = "";
                    infodaftarptk2.innerHTML = "";
                    daftarpdrow.style.display = 'none';
                    daftarptkrow.style.display = 'none';
                    daftarptk2row.style.display = 'none';
                    infodaftarkepsek.innerHTML = "";
                    daftarkepsekrow.style.display = 'none';
                    if (selectedValuestatus == 3)
                        daftarptkrow.style.display = 'table-row';
                    if (selectedValuestatus == 4)
                        daftarptk2row.style.display = 'table-row';
                    if (selectedValuestatus == 5)
                        daftarkepsekrow.style.display = 'table-row';
                }

                nisnrow.style.display = 'none';
                nikpdptkrow.style.display = 'none';
                jenis_kelaminrow.style.display = 'none';
                disabilitasrow.style.display = 'none';

                nikrow.style.display = 'none';
                tglahirrow.style.display = 'none';
                alamatrow.style.display = 'none';
                npsnrow.style.display = 'table-row';
                npsnrow.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });

                nisn.maxLength = 16;
                xinfonis = "NUPTK tidak tersedia";
                tbsekolah.innerText = "Konfirmasi";
                if (nisn.value == "")
                    tbsekolah.style.display = 'table-row';
                if (tbsekolah.style.display == 'none' && sebagai != "sekolah") {
                    nisnrow.style.display = "table-row";
                    infosekolah.style.display = "table-row";
                }
                if (tbnpsn.style.display != 'none') {
                    sekolahrow.style.display = "none";
                }
                if (nisn.value == "")
                    nisnrow.style.display = 'none';
                if (nama.value == "")
                    namarow.style.display = 'none';
                if (nisnrow.style.display == 'none')
                    namarow.style.display = 'none';
                usiarow.style.display = 'none';
                provinsirow.style.display = 'none';
                kotarow.style.display = 'none';
                kecamatanrow.style.display = 'none';
                desarow.style.display = 'none';
                if (!adaJKTerpilih) {
                    jenis_kelaminrow.style.display = 'none';
                    disabilitasrow.style.display = 'none';
                }
            } else {
                if (sebagai == "sekolah") {
                    $('#daftarpd' + siapa + idx).val('000000').trigger('change.select2');
                    $('#daftarptk' + siapa + idx).val('000000').trigger('change.select2');
                    infodaftarpd.innerHTML = "";
                    infodaftarptk.innerHTML = "";
                    infodaftarptk2.innerHTML = "";
                }
                npsnrow.style.display = 'none';
                nikrow.style.display = 'table-row';
                tbnik.style.display = 'none';
                isinik.maxLength = 16;
                statusortu.style.display = 'none';
                tglahirrow.style.display = 'table-row';
                usiarow.style.display = 'table-row';
                usia.value = "";
                disabilitasrow.style.display = 'none';
                usia.style.display = 'table-row';
                alamatrow.style.display = 'none';
                alamat.style.display = 'table-row';
                jenis_kelaminrow.style.display = 'table-row';
                // if (alamat.value != "")
                // alamatrow.style.display = 'table-row';
                // provinsirow.style.display = 'table-row';
                // kotarow.style.display = 'table-row';
                // kecamatanrow.style.display = 'table-row';
                // desarow.style.display = 'table-row';
                tbsekolah.style.display = 'none';
                labels2[0].innerText = 'Instansi ' + xsiapa;
                sekolahrow.style.display = "table-row";
                sekolah.disabled = false;
                infosekolah.style.display = "none";
                sekolahrow.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
                nisnrow.style.display = "none";
                tbsekolah.innerText = "OK";
                infonama.innerHTML = "";
                infonik.innerHTML = "";
            }



            if (sebagai == "sekolah") {
                npsn.disabled = true;
                tbcarisekolah.style.display = 'none';
                document.getElementById('infonisn' + siapa + idx).style.display = 'block';
                document.getElementById('infonama' + siapa + idx).style.display = 'block';
                document.getElementById('infodaftarpd' + siapa + idx).style.display = 'block';
                document.getElementById('infonikpdptk' + siapa + idx).style.display = 'block';
                if (nisn.value == "") {
                    window['konfirmsekolah' + siapa](idx);
                } else
                    changenisn(siapa, idx);
            } else {

            }

            if (selectedValuestatus == 6) {
                namarow.style.display = 'table-row';
                nikrow.style.display = 'table-row';
                jenis_kelaminrow.style.display = 'table-row';
                tbjenis_kelamin.style.display = 'none';
                tbnik.style.display = 'table-row';
                tbnik.innerHTML = "Cek";
                infosekolah.style.display = "none";
                if (sebagai == "sekolah") {
                    daftarpdrow.style.display = "none";
                    daftarptkrow.style.display = "none";
                    daftarptk2row.style.display = "none";
                    daftarkepsekrow.style.display = "none";
                }
                nikpdptkrow.style.display = "none";
                sekolah.disabled = false;
                sekolah.value = "";
                isinik.value = "";
                tbnikdarijk.style.display = 'table-row';
                infousia.innerHTML = "";
                nama.value = "";
            } else {
                namarow.style.display = 'none';
                infosekolah.style.display = "table-row";
                sekolah.disabled = true;
                sekolah.value = nama_sekolah_asal;
                tbnikdarijk.style.display = 'none';
                // tbnik.style.display = 'none';
            }
            namaorturow.style.display = "none";
            if (selectedValuestatus != 2) {
                labeljenis_kelamin[0].innerHTML = "Jenis Kelamin " + capitalizeFirstLetter(xsiapa) + " *";
            }

            var radios = document.getElementsByName('jenis_kelamin' + siapa + idx);
            if (selectedValuestatus == 2 && (jenis_kelaminrow.style.display == "table-row")) {
                if (statussebelumnya == 1) {
                    nikrow.style.display = "table-row";
                    namaorturow.style.display = "table-row";
                    if (isinik.value != "" && isinik.value != "null" && namaortu.value != "" && namaortu.value != "null") {
                        // alert("disini145");
                        if (infonamaortu.innerHTML.substring(0, 8) != "Dukcapil") {
                            infonamaortu.innerHTML = "tunggu...";
                            tbnik.style.display = "none";
                            window['ceknik' + siapa](idx);
                        }
                    }
                }
                if (statusortu.value == "ayah")
                    radios[0].checked = true;
                else if (jenisortu == "ibu")
                    radios[1].checked = true;
                else {
                    radios[0].checked = false;
                    radios[1].checked = false;
                }
                infojenis_kelamin.innerHTML = "";
            }

            if (selectedValuestatus != 2) {
                radios[0].checked = false;
                radios[1].checked = false;
                infojenis_kelamin.innerHTML = "";
                if (selectedValuestatus != 6) {
                    if (jenis_kelamin == "L") {
                        radios[0].checked = true;
                        infojenis_kelamin.innerHTML = "Dukcapil: Laki-laki";
                    } else if (jenis_kelamin == "P") {
                        radios[1].checked = true;
                        infojenis_kelamin.innerHTML = "Dukcapil: Perempuan";
                    }
                }
                // 
            }

            if (selectedValuestatus == 5) {

                if (sebagai == "sekolah") {
                    var selectElement = document.getElementById('daftarkepsek' + siapa + idx);
                    var selectedIndex = selectElement.selectedIndex;
                    var selectedOption = selectElement.options[selectedIndex];
                    var nik = selectedOption.getAttribute('data-induk');
                    var nuptk = selectedOption.value;

                    document.getElementById('infodaftarkepsek' + siapa + idx).innerHTML = "tunggu...";
                    window['ceknisn' + siapa](idx);
                }

                document.getElementById('infonik' + siapa + idx).innerHTML = "tunggu...";
                document.getElementById('infonamaortu' + siapa + idx).innerHTML = "tunggu...";
                document.getElementById('infojenis_kelamin' + siapa + idx).innerHTML = "tunggu...";
                document.getElementById('nik' + siapa + idx).value = "";
                document.getElementById('namaortu' + siapa + idx).value = "";

                document.getElementById('nikpdptk' + siapa + idx).value = nik;
                document.getElementById('nisn' + siapa + idx).value = nuptk;
                document.getElementById('statusortu' + siapa + idx).value = "ayah";

            }

            if ((nisn.value.length < 16 && selectedValuestatus >= 3 && selectedValuestatus != 6) || (nisn.value.length == 16 && selectedValuestatus <= 2) || statussebelumnya == 5) {
                nisnrow.style.display = "none";
                nikpdptkrow.style.display = "none";
                jenis_kelaminrow.style.display = "none";
                disabilitasrow.style.display = "none";
                if (sebagai == "sekolah") {
                    document.getElementById('infodaftarpd' + siapa + idx).innerHTML = "";
                    document.getElementById('infodaftarptk' + siapa + idx).innerHTML = "";
                    document.getElementById('infodaftarptk2' + siapa + idx).innerHTML = "";
                    $('#daftarpd' + siapa + idx).val('000000').trigger('change.select2');
                    $('#daftarptk' + siapa + idx).val('000000').trigger('change.select2');
                }
            }

            if (selectedValuestatus == 6) {
                jenis_kelaminrow.style.display = "table-row";
                tbnik.style.display = 'none';
            }

            ///////////////BUAT CEK----------------------

        }
    }

    function capitalizeFirstLetter(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    function tambahDataIndex($select, index) {
        $select.find('option').each(function(i) {
            $(this).attr('data-idx', index);
        });
    }

    //////////////////----------------------------------------------------

    function onchangeptk_kepsek(jenisptk, siapa, ini) {
        var selectedOption = ini.find(':selected');
        var nik = selectedOption.data('induk');
        var indeks = selectedOption.data('idx');
        var nuptk = selectedOption.val();

        window['isi' + siapa + 'manual'][indeks] = false;

        if (nuptk == "000000") {
            tbnik = document.getElementById('tbnikselect' + siapa + indeks);
            document.getElementById('infodaftar' + jenisptk + siapa + indeks).innerHTML = "";
            document.getElementById('infonik' + siapa + indeks).innerHTML = "";
            document.getElementById('infonamaortu' + siapa + indeks).innerHTML = "";
            document.getElementById('infojenis_kelamin' + siapa + indeks).innerHTML = "";
            document.getElementById('namaRow' + siapa + indeks).style.display = "none";
            document.getElementById('nama' + siapa + indeks).value = "";
            document.getElementById('nisnRow' + siapa + indeks).style.display = "none";
            document.getElementById('nik' + siapa + indeks).value = "";
            document.getElementById('namaortu' + siapa + indeks).value = "";
            document.getElementById('nikpdptkRow' + siapa + indeks).style.display = "none";
            document.getElementById('jenis_kelaminRow' + siapa + indeks).style.display = "none";
            document.getElementById('disabilitasRow' + siapa + indeks).style.display = "none";
            document.getElementById('tbnisn' + siapa + indeks).style.display = "none";

            document.getElementById('statusortu' + siapa + indeks).value = "ayah";

            var radioButtons = document.getElementsByName('jenis_kelamin' + siapa + indeks);
            radioButtons[0].checked = false;
            radioButtons[1].checked = false;
        } else if (nuptk == "000001") {
            window['isi' + siapa + 'manual'][indeks] = true;
            tbnik = document.getElementById('tbnikselect' + siapa + indeks);
            document.getElementById('infodaftar' + jenisptk + siapa + indeks).innerHTML = "";
            document.getElementById('infonik' + siapa + indeks).innerHTML = "";
            document.getElementById('infonikpdptk' + siapa + indeks).innerHTML = "";
            document.getElementById('infonamaortu' + siapa + indeks).innerHTML = "";
            document.getElementById('infonama' + siapa + indeks).innerHTML = "";
            document.getElementById('infojenis_kelamin' + siapa + indeks).innerHTML = "";
            document.getElementById('namaRow' + siapa + indeks).style.display = "table-row";
            document.getElementById('nama' + siapa + indeks).value = "";
            document.getElementById('nisnRow' + siapa + indeks).style.display = "table-row";
            document.getElementById('nik' + siapa + indeks).value = "";
            document.getElementById('nisn' + siapa + indeks).value = "";
            document.getElementById('namaortu' + siapa + indeks).value = "";
            document.getElementById('nikpdptkRow' + siapa + indeks).style.display = "table-row";
            document.getElementById('nikpdptk' + siapa + indeks).value = "";
            document.getElementById('jenis_kelaminRow' + siapa + indeks).style.display = "none";
            document.getElementById('disabilitasRow' + siapa + indeks).style.display = "none";
            document.getElementById('tbnisn' + siapa + indeks).style.display = "none";
            tbnik.style.display = "table-row";

            tbnik.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });

            document.getElementById('statusortu' + siapa + indeks).value = "ayah";

            var radioButtons = document.getElementsByName('jenis_kelamin' + siapa + indeks);
            radioButtons[0].checked = false;
            radioButtons[1].checked = false;
        } else {
            document.getElementById('infodaftar' + jenisptk + siapa + indeks).innerHTML = "tunggu...";
            document.getElementById('infonik' + siapa + indeks).innerHTML = "tunggu...";
            document.getElementById('infonamaortu' + siapa + indeks).innerHTML = "tunggu...";
            document.getElementById('infojenis_kelamin' + siapa + indeks).innerHTML = "tunggu...";
            document.getElementById('nik' + siapa + indeks).value = "";
            document.getElementById('namaortu' + siapa + indeks).value = "";
            document.getElementById('namaRow' + siapa + indeks).style.display = "none";
            document.getElementById('statusortu' + siapa + indeks).value = "ayah";

            var radioButtons = document.getElementsByName('jenis_kelamin' + siapa + indeks);
            radioButtons[0].checked = true;

            document.getElementById('nisn' + siapa + indeks).value = nuptk;
            document.getElementById('nikpdptk' + siapa + indeks).value = nik;
            window['ceknisn' + siapa](indeks);
        }
    }

    ////////////// KORBAN ////////////////////////////////////////////////

    function tambahKorban(index) {
        idx = index + 1;
        counterkorban++;

        if (index == 1) {
            if (pilihanview == 'multi') {
                document.getElementById('dif1').style.display = 'none';
                document.getElementById('dif2').style.display = 'none';
                document.getElementById('dif3').style.display = 'block';
            }
            document.getElementById('tb3').classList.remove('tbnonaktif');
            document.getElementById('tb3').classList.add('tbaktif');
            document.getElementById('tb2').classList.remove('active');
            document.getElementById('tb3').classList.add('active');
            document.getElementById('tb3').disabled = false;

        }

        pilstatus['korban'][idx] = "";

        const clone = document.getElementById('korban').cloneNode(true);

        updateElementIdskorban(clone);
        updateElementNameskorban(clone);

        clone.id = 'korban' + idx;
        clone.querySelectorAll('th.kelabu').forEach(th => {
            if (idx == 1)
                th.textContent = th.textContent.replace('Bagian 1: Formulir Korban', 'Bagian 1: Formulir Korban');
            else
                th.textContent = th.textContent.replace('Bagian 1: Formulir Korban', 'Formulir Korban ' + idx);
        });

        clone.querySelectorAll('[name^="datepickerkorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.setAttribute('onblur', `validasiTanggalLahirkorban(${idx})`);
        });

        clone.querySelectorAll('[name^="status_korban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.setAttribute('onchange', `cekstatuskorban(${idx})`);
        });

        clone.querySelectorAll('[name^="disabilitaskorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.setAttribute('onclick', `toggleInput('korban',this, ${idx})`);
        });

        clone.querySelectorAll('[id^="npsnkorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.addEventListener('change', function(event) {
                changenpsn("korban", idx);
            });

            btn.addEventListener('input', function(event) {
                changenpsn("korban", idx);
            });
        });

        clone.querySelectorAll('[id^="tbnpsnkorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.setAttribute('onclick', `submitnpsnkorban(${idx})`);
        });

        clone.querySelectorAll('[id^="sekolahkorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.addEventListener('change', function(event) {
                changesekolah("korban", idx);
            });

            btn.addEventListener('input', function(event) {
                changesekolah("korban", idx);
            });
        });

        clone.querySelectorAll('[id^="tbcarisekolahkorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.setAttribute('onclick', `tampilmodalkorban(${idx})`);
        });

        clone.querySelectorAll('[id^="nisnkorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.addEventListener('change', function(event) {
                changenisn("korban", idx);
            });

            btn.addEventListener('input', function(event) {
                changenisn("korban", idx);
            });
        });

        clone.querySelectorAll('[id^="tbnisnkorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.setAttribute('onclick', `ceknisnkorban(${idx})`);
        });

        clone.querySelectorAll('[id^="tbnikkorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.setAttribute('onclick', `ceknikkorban(${idx})`);
        });

        clone.querySelectorAll('[id^="tbnikdarijkkorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.setAttribute('onclick', `ceknikdarijkkorban(${idx})`);
        });

        clone.querySelectorAll('[id^="tblanjutdarijkkorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.setAttribute('onclick', `lanjutalamatkorban(${idx})`);
        });

        clone.querySelectorAll('[id^="nikkorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.addEventListener('change', function(event) {
                changenik("korban", idx);
            });

            btn.addEventListener('input', function(event) {
                changenik("korban", idx);
            });
        });

        clone.querySelectorAll('[id^="nikpdptkkorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.addEventListener('change', function(event) {
                changenikpdptk("korban", idx);
            });

            btn.addEventListener('input', function(event) {
                changenikpdptk("korban", idx);
            });
        });

        clone.querySelectorAll('[id^="tbnikpdptkkorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.setAttribute('onclick', `ceknikpdptkkorban(${idx})`);
        });

        clone.querySelectorAll('[id^="tbnamakorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.setAttribute('onclick', `konfirmnamakorban(${idx})`);
        });

        clone.querySelectorAll('[id^="namakorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.addEventListener('change', function(event) {
                changenama("korban", idx);
            });

            btn.addEventListener('input', function(event) {
                changenama("korban", idx);
            });
        });

        clone.querySelectorAll('[id^="statusortukorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.setAttribute('onchange', `changestatusortukorban(${idx})`);
        });

        clone.querySelectorAll('[id^="tbnamaortukorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.setAttribute('onclick', `konfirmnamaortukorban(${idx})`);
        });

        clone.querySelectorAll('[id^="namaortukorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.addEventListener('change', function(event) {
                changenamaortu("korban", idx);
            });

            btn.addEventListener('input', function(event) {
                changenamaortu("korban", idx);
            });
        });

        clone.querySelectorAll('[id^="usiakorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.addEventListener('change', function(event) {
                changeusia("korban", idx);
            });

            btn.addEventListener('input', function(event) {
                changeusia("korban", idx);
            });
        });

        clone.querySelectorAll('[id^="alamatkorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.addEventListener('change', function(event) {
                changealamat("korban", idx);
            });

            btn.addEventListener('input', function(event) {
                changealamat("korban", idx);
            });
        });

        clone.querySelectorAll('[id^="tbnisnkorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.setAttribute('onclick', `ceknisnkorban(${idx})`);
        });

        clone.querySelectorAll('[id^="tbnikselectkorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.setAttribute('onclick', `ceknikselectkorban(${idx})`);
        });

        clone.querySelectorAll('[id^="tbjenis_kelaminkorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.setAttribute('onclick', `konfirmjenis_kelaminkorban(${idx})`);
        });

        clone.querySelectorAll('[name^="jenis_kelaminkorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.setAttribute('onchange', `cekpilihjkkorban(${idx})`);
        });

        clone.querySelectorAll('[id^="tbsekolahkorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.setAttribute('onclick', `konfirmsekolahkorban(${idx})`);
        });

        clone.querySelectorAll('[id^="tbdisabilitaskorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.setAttribute('onclick', `konfirmdisabilitaskorban(${idx})`);
        });

        clone.querySelectorAll('[id^="tbtambahkorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.setAttribute('onclick', `tambahKorban(${idx})`);
        });

        clone.querySelectorAll('[id^="tbkurangikorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.setAttribute('onclick', `kurangiKorban(${idx})`);
        });

        clone.querySelectorAll('[id^="tbpelakukorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            if (statuskasus == 1)
                btn.setAttribute('onclick', 'tambahPelaku(0)');
            else
                btn.setAttribute('onclick', 'tambahPelaku(0)');
        });

        clone.querySelectorAll('[id^="provinsikorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.setAttribute('onchange', `getkota("korban", ${idx}, this.value)`);
        });

        clone.querySelectorAll('[id^="kotakorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.setAttribute('onchange', `getkecamatan("korban", ${idx}, this.value)`);
        });

        clone.querySelectorAll('[id^="kecamatankorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.setAttribute('onchange', `getdesa("korban", ${idx}, this.value)`);
        });

        lokasikorban.appendChild(clone);

        const datePickerElement = $(clone).find("#datepickerkorban" + idx);

        datePickerElement.datepicker({
            dateFormat: 'dd/mm/yy',
            changeMonth: true,
            changeYear: true,
            yearRange: "c-100:c+10",
            onSelect: function(dateText, inst) {
                validasiTanggalLahir("korban", idx);
            }
        });

        //// UNTUK DAFTAR PD ////////////////////
        const daftarpdElement = $(clone).find("#daftarpdkorban" + idx);
        daftarpdElement.select2();
        const daftarpdOptions = daftarpdElement.find('option');
        daftarpdOptions.each(function(index) {
            $(this).attr('data-idx', idx);
        });
        daftarpdElement.on('change', function() {
            var selectedOption = $(this).find(':selected');
            var nik = selectedOption.data('induk');
            var indeks = selectedOption.data('idx');
            var nisn = selectedOption.val();

            if (nisn == "000000") {
                document.getElementById('nisnRowkorban' + indeks).style.display = 'none';
                document.getElementById('nikpdptkRowkorban' + indeks).style.display = 'none';
                document.getElementById('jenis_kelaminRowkorban' + indeks).style.display = 'none';
                document.getElementById('disabilitasRowkorban' + indeks).style.display = 'none';
                document.getElementById('infodaftarpdkorban' + indeks).innerHTML = "";
                document.getElementById('namaortuRowkorban' + indeks).style.display = 'none';
                document.getElementById('nikRowkorban' + indeks).style.display = 'none';
            } else {

                document.getElementById('infodaftarpdkorban' + indeks).innerHTML = "tunggu...";
                document.getElementById('infonikkorban' + indeks).innerHTML = "tunggu...";
                document.getElementById('infonamaortukorban' + indeks).innerHTML = "tunggu...";
                document.getElementById('infojenis_kelaminkorban' + indeks).innerHTML = "tunggu...";
                document.getElementById('nikkorban' + indeks).value = "";
                document.getElementById('namaortukorban' + indeks).value = "";

                document.getElementById('statusortukorban' + indeks).style.display = 'table-row';
                document.getElementById('statusortukorban' + indeks).value = "ayah";

                var radioButtons = document.getElementsByName('jenis_kelaminkorban' + indeks);
                radioButtons[0].checked = true;

                document.getElementById('nisnkorban' + indeks).value = nisn;
                document.getElementById('nikpdptkkorban' + indeks).value = nik;
                ceknisnkorban(indeks);
            }
        });

        //// UNTUK DAFTAR PENDIDIK ////////////////////
        const daftarptkElement = $(clone).find("#daftarptkkorban" + idx);
        daftarptkElement.select2();
        const daftarptkOptions = daftarptkElement.find('option');
        daftarptkOptions.each(function(index) {
            $(this).attr('data-idx', idx);
        });
        daftarptkElement.on('change', function() {
            onchangeptk_kepsek('ptk', 'korban', $(this));
        });

        //// UNTUK DAFTAR TENAGAKEPENDIDIKAN ////////////////////
        const daftarptk2Element = $(clone).find("#daftarptk2korban" + idx);
        daftarptk2Element.select2();
        const daftarptk2Options = daftarptk2Element.find('option');
        daftarptk2Options.each(function(index) {
            $(this).attr('data-idx', idx);
        });
        daftarptk2Element.on('change', function() {
            onchangeptk_kepsek('ptk2', 'korban', $(this));
        });

        //// UNTUK DAFTAR Kepsek ////////////////////
        const daftarkepsekElement = $(clone).find("#daftarkepsekkorban" + idx);
        daftarkepsekElement.select2();
        const daftarkepsekOptions = daftarkepsekElement.find('option');
        daftarkepsekOptions.each(function(index) {
            $(this).attr('data-idx', idx);
        });

        korbanDiv = document.getElementById('korban' + idx);
        korbanDiv.classList.add('fade-in');
        korbanDiv.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });

        if (idx > 0) {
            tbkorban = document.getElementById('tbkorban');
            tbkorban.style.display = 'none';
            if (idx > 1) {
                tbkurangikorban = document.getElementById('tbkurangikorban' + idx);
                tbkurangikorban.style.display = 'inline';
                tbtambahkorbanprev = document.getElementById('tbtambahkorban' + (idx - 1));
                tbtambahkorbanprev.style.display = 'none';
                tbkurangikorbanprev = document.getElementById('tbkurangikorban' + (idx - 1));
                tbkurangikorbanprev.style.display = 'none';
                tbpelaku = document.getElementById('tbpelakukorban' + (idx - 1));
                tbpelaku.style.display = 'none';
            }
        }

    }

    function kurangiKorban(index) {
        if (confirm("Yakin akan menghapus Korban ini?")) {
            const clonedElement = document.getElementById('korban' + index);
            clonedElement.remove();
            counterkorban--;
            statuskorbanok[index] = 0;
            if (index > 1) {
                tbtambahkorbanprev = document.getElementById('tbtambahkorban' + (index - 1));
                tbtambahkorbanprev.style.display = 'inline';
                if (counterpelaku == 0) {
                    tbpelaku = document.getElementById('tbpelakukorban' + (index - 1));
                    tbpelaku.style.display = 'inline';
                }
                if (index > 2) {
                    tbkurangikorbanprev = document.getElementById('tbkurangikorban' + (index - 1));
                    tbkurangikorbanprev.style.display = 'inline';
                }
            } else {
                tbkorban = document.getElementById('tbkorban');
                tbkorban.style.display = 'inline';
            }

        }
    }

    function updateElementIdskorban(element) {
        const inputs = element.querySelectorAll('[id]');
        inputs.forEach(input => {
            const newId = input.id + counterkorban;
            input.id = newId;
        });
    }

    function updateElementNameskorban(element) {
        const inputs = element.querySelectorAll('[name]');
        inputs.forEach(input => {
            const newName = input.name + counterkorban;
            input.name = newName;
        });

    }
    //////////////////////////////////////////////////////////////////////

    ////////////// PELAKU ////////////////////////////////////////////////

    function tambahPelaku(index) {
        idx = index + 1;
        counterpelaku++;

        pilstatus['pelaku'][idx] = "";

        const clone = document.getElementById('pelaku').cloneNode(true);

        updateElementIdspelaku(clone);
        updateElementNamespelaku(clone);

        clone.id = 'pelaku' + idx;
        clone.querySelectorAll('th.kelabu').forEach(th => {
            if (idx == 1) {
                th.textContent = th.textContent.replace('Bagian 2: Formulir Pelaku', 'Bagian 2: Formulir Pelaku');
                th.textContent = th.textContent.replace('Bagian 2: Formulir Terlapor', 'Bagian 2: Formulir Terlapor');
            } else {
                th.textContent = th.textContent.replace('Bagian 2: Formulir Pelaku', 'Formulir Pelaku ' + idx);
                th.textContent = th.textContent.replace('Bagian 2: Formulir Terlapor', 'Formulir Terlapor ' + idx);
            }
        });

        clone.querySelectorAll('[name^="datepickerpelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.setAttribute('onblur', `validasiTanggalLahirpelaku(${idx})`);
        });

        clone.querySelectorAll('[name^="status_pelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.setAttribute('onchange', `cekstatuspelaku(${idx})`);
        });

        clone.querySelectorAll('[name^="disabilitaspelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.setAttribute('onclick', `toggleInput('pelaku',this, ${idx})`);
        });

        clone.querySelectorAll('[id^="npsnpelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.addEventListener('change', function(event) {
                changenpsn("pelaku", idx);
            });

            btn.addEventListener('input', function(event) {
                changenpsn("pelaku", idx);
            });
        });

        clone.querySelectorAll('[id^="tbnpsnpelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.setAttribute('onclick', `submitnpsnpelaku(${idx})`);
        });

        clone.querySelectorAll('[id^="sekolahpelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.addEventListener('change', function(event) {
                changesekolah("pelaku", idx);
            });

            btn.addEventListener('input', function(event) {
                changesekolah("pelaku", idx);
            });
        });

        clone.querySelectorAll('[id^="tbcarisekolahpelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.setAttribute('onclick', `tampilmodalpelaku(${idx})`);
        });

        clone.querySelectorAll('[id^="nisnpelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.addEventListener('change', function(event) {
                changenisn("pelaku", idx);
            });

            btn.addEventListener('input', function(event) {
                changenisn("pelaku", idx);
            });
        });

        clone.querySelectorAll('[id^="tbnisnpelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.setAttribute('onclick', `ceknisnpelaku(${idx})`);
        });

        clone.querySelectorAll('[id^="tbnikpelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.setAttribute('onclick', `ceknikpelaku(${idx})`);
        });

        clone.querySelectorAll('[id^="tbnikdarijkpelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.setAttribute('onclick', `ceknikdarijkpelaku(${idx})`);
        });

        clone.querySelectorAll('[id^="tblanjutdarijkpelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.setAttribute('onclick', `lanjutalamatpelaku(${idx})`);
        });

        clone.querySelectorAll('[id^="nikpelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.addEventListener('change', function(event) {
                changenik("pelaku", idx);
            });

            btn.addEventListener('input', function(event) {
                changenik("pelaku", idx);
            });
        });

        clone.querySelectorAll('[id^="nikpdptkpelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.addEventListener('change', function(event) {
                changenikpdptk("pelaku", idx);
            });

            btn.addEventListener('input', function(event) {
                changenikpdptk("pelaku", idx);
            });
        });

        clone.querySelectorAll('[id^="tbnikpdptkpelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.setAttribute('onclick', `ceknikpdptkpelaku(${idx})`);
        });

        clone.querySelectorAll('[id^="tbnamapelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.setAttribute('onclick', `konfirmnamapelaku(${idx})`);
        });

        clone.querySelectorAll('[id^="namapelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.addEventListener('change', function(event) {
                changenama("pelaku", idx);
            });

            btn.addEventListener('input', function(event) {
                changenama("pelaku", idx);
            });
        });

        clone.querySelectorAll('[id^="statusortupelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.setAttribute('onchange', `changestatusortupelaku(${idx})`);
        });

        clone.querySelectorAll('[id^="tbnamaortupelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.setAttribute('onclick', `konfirmnamaortupelaku(${idx})`);
        });

        clone.querySelectorAll('[id^="namaortupelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.addEventListener('change', function(event) {
                changenamaortu("pelaku", idx);
            });

            btn.addEventListener('input', function(event) {
                changenamaortu("pelaku", idx);
            });
        });

        clone.querySelectorAll('[id^="usiapelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.addEventListener('change', function(event) {
                changeusia("pelaku", idx);
            });

            btn.addEventListener('input', function(event) {
                changeusia("pelaku", idx);
            });
        });

        clone.querySelectorAll('[id^="alamatpelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.addEventListener('change', function(event) {
                changealamat("pelaku", idx);
            });

            btn.addEventListener('input', function(event) {
                changealamat("pelaku", idx);
            });
        });

        clone.querySelectorAll('[id^="tbnisnpelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.setAttribute('onclick', `ceknisnpelaku(${idx})`);
        });

        clone.querySelectorAll('[id^="tbnikselectpelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.setAttribute('onclick', `ceknikselectpelaku(${idx})`);
        });

        clone.querySelectorAll('[id^="tbjenis_kelaminpelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.setAttribute('onclick', `konfirmjenis_kelaminpelaku(${idx})`);
        });

        clone.querySelectorAll('[name^="jenis_kelaminpelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.setAttribute('onchange', `cekpilihjkpelaku(${idx})`);
        });

        clone.querySelectorAll('[id^="tbsekolahpelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.setAttribute('onclick', `konfirmsekolahpelaku(${idx})`);
        });

        clone.querySelectorAll('[id^="tbdisabilitaspelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.setAttribute('onclick', `konfirmdisabilitaspelaku(${idx})`);
        });

        clone.querySelectorAll('[id^="tbtambahpelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.setAttribute('onclick', `tambahPelaku(${idx})`);
        });

        clone.querySelectorAll('[id^="tbkurangipelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.setAttribute('onclick', `kurangiPelaku(${idx})`);
        });

        clone.querySelectorAll('[id^="provinsipelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.setAttribute('onchange', `getkota("pelaku", ${idx}, this.value)`);
        });

        clone.querySelectorAll('[id^="kotapelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.setAttribute('onchange', `getkecamatan("pelaku", ${idx}, this.value)`);
        });

        clone.querySelectorAll('[id^="kecamatanpelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + idx;
            btn.setAttribute('onchange', `getdesa("pelaku", ${idx}, this.value)`);
        });

        lokasipelaku.appendChild(clone);

        const datePickerElement = $(clone).find("#datepickerpelaku" + idx);

        datePickerElement.datepicker({
            dateFormat: 'dd/mm/yy',
            changeMonth: true,
            changeYear: true,
            yearRange: "c-100:c+10",
            onSelect: function(dateText, inst) {
                validasiTanggalLahir("pelaku", idx);
            }
        });

        //// UNTUK DAFTAR PD ////////////////////
        const daftarpdElement = $(clone).find("#daftarpdpelaku" + idx);
        daftarpdElement.select2();
        const daftarpdOptions = daftarpdElement.find('option');
        daftarpdOptions.each(function(index) {
            $(this).attr('data-idx', idx);
        });
        daftarpdElement.on('change', function() {
            var selectedOption = $(this).find(':selected');
            var nik = selectedOption.data('induk');
            var indeks = selectedOption.data('idx');
            var nisn = selectedOption.val();

            document.getElementById('infodaftarpdpelaku' + indeks).innerHTML = "tunggu...";
            document.getElementById('infonikpelaku' + indeks).innerHTML = "tunggu...";
            document.getElementById('infonamaortupelaku' + indeks).innerHTML = "tunggu...";
            document.getElementById('infojenis_kelaminpelaku' + indeks).innerHTML = "tunggu...";
            document.getElementById('nikpelaku' + indeks).value = "";
            document.getElementById('namaortupelaku' + indeks).value = "";

            document.getElementById('statusortupelaku' + indeks).value = "ayah";

            var radioButtons = document.getElementsByName('jenis_kelaminpelaku' + indeks);
            radioButtons[0].checked = true;

            document.getElementById('nisnpelaku' + indeks).value = nisn;
            document.getElementById('nikpdptkpelaku' + indeks).value = nik;
            ceknisnpelaku(indeks);
        });

        //// UNTUK DAFTAR PENDIDIK ////////////////////
        const daftarptkElement = $(clone).find("#daftarptkpelaku" + idx);
        daftarptkElement.select2();
        const daftarptkOptions = daftarptkElement.find('option');
        daftarptkOptions.each(function(index) {
            $(this).attr('data-idx', idx);
        });
        daftarptkElement.on('change', function() {
            onchangeptk_kepsek('ptk', 'pelaku', $(this));
        });

        //// UNTUK DAFTAR TENAGAKEPENDIDIKAN ////////////////////
        const daftarptk2Element = $(clone).find("#daftarptk2pelaku" + idx);
        daftarptk2Element.select2();
        const daftarptk2Options = daftarptk2Element.find('option');
        daftarptk2Options.each(function(index) {
            $(this).attr('data-idx', idx);
        });
        daftarptk2Element.on('change', function() {
            onchangeptk_kepsek('ptk2', 'pelaku', $(this));
        });

        //// UNTUK DAFTAR Kepsek ////////////////////
        const daftarkepsekElement = $(clone).find("#daftarkepsekpelaku" + idx);
        daftarkepsekElement.select2();
        const daftarkepsekOptions = daftarkepsekElement.find('option');
        daftarkepsekOptions.each(function(index) {
            $(this).attr('data-idx', idx);
        });


        pelakuDiv = document.getElementById('pelaku' + idx);
        pelakuDiv.classList.add('fade-in');
        pelakuDiv.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });

        tbkurangipelakuprev = document.getElementById('tbkurangipelaku' + (idx));
        tbkurangipelakuprev.style.display = 'inline';

        if (idx == 1) {
            if (pilihanview == 'multi') {
                document.getElementById('dif1').style.display = 'none';
                document.getElementById('dif2').style.display = 'none';
                document.getElementById('dif3').style.display = 'none';
                document.getElementById('dif4').style.display = 'block';
                tbkurangipelakuprev.style.display = 'none';
            } else {
                // tbtambahkorban = document.getElementById('tbtambahkorban' + counterkorban);
                // tbtambahkorban.style.display = 'none';
                // tbkurangikorban = document.getElementById('tbkurangikorban' + counterkorban);
                // tbkurangikorban.style.display = 'none';
            }
            document.getElementById('tb4').classList.remove('tbnonaktif');
            document.getElementById('tb4').classList.add('tbaktif');
            document.getElementById('tb3').classList.remove('active');
            document.getElementById('tb4').classList.add('active');
            document.getElementById('tb4').disabled = false;

            tbpelaku = document.getElementById('tbpelakukorban' + counterkorban);
            tbpelaku.style.display = 'none';

        } else if (idx > 1) {
            tbtambahpelakuprev = document.getElementById('tbtambahpelaku' + (idx - 1));
            tbtambahpelakuprev.style.display = 'none';
            tbkurangipelakuprev = document.getElementById('tbkurangipelaku' + (idx - 1));
            tbkurangipelakuprev.style.display = 'none';
            tbkronologi = document.getElementById('tbkronologi' + (idx - 1));
            tbkronologi.style.display = 'none';
        }


    }

    function kurangiPelaku(index) {
        if (confirm("Yakin akan menghapus Pelaku ini?")) {
            const clonedElement = document.getElementById('pelaku' + index);
            clonedElement.remove();
            counterpelaku--;
            if (index > 1) {
                tbtambahpelakuprev = document.getElementById('tbtambahpelaku' + (index - 1));
                tbtambahpelakuprev.style.display = 'inline';
                if (index > 2) {
                    tbkurangipelakuprev = document.getElementById('tbkurangipelaku' + (index - 1));
                    tbkurangipelakuprev.style.display = 'inline';
                }
                tbkronologi = document.getElementById('tbkronologi' + (index - 1));
                tbkronologi.style.display = 'inline';
            } else {
                tbpelaku = document.getElementById('tbpelakukorban' + counterkorban);
                tbpelaku.style.display = 'inline';
                tbtambahkorban = document.getElementById('tbtambahkorban' + counterkorban);
                tbtambahkorban.style.display = 'inline';
                tbkurangikorban = document.getElementById('tbkurangikorban' + counterkorban);
                tbkurangikorban.style.display = 'inline';
            }

        }
    }

    function updateElementIdspelaku(element) {
        const inputs = element.querySelectorAll('[id]');
        inputs.forEach(input => {
            const newId = input.id + counterpelaku;
            input.id = newId;
        });
    }

    function updateElementNamespelaku(element) {
        const inputs = element.querySelectorAll('[name]');
        inputs.forEach(input => {
            const newName = input.name + counterpelaku;
            input.name = newName;
        });

    }
    //////////////////////////////////////////////////////////////////////

    function hitungUsia(siapa, idx) {

    }

    function get_data(siapa, jenis, idx) {

        var npsn = document.getElementById('npsn' + siapa + idx).value;
        var nik = document.getElementById('nikpdptk' + siapa + idx).value;
        var nisn = document.getElementById('nisn' + siapa + idx).value;
        var usiarow = document.getElementById('usiaRow' + siapa + idx);
        var desarow = document.getElementById('desaRow' + siapa + idx);
        var namarow = document.getElementById('namaRow' + siapa + idx);
        var usianya = document.getElementById('usia' + siapa + idx);
        var desanya = document.getElementById('desa' + siapa + idx);
        var iinfonisn = document.getElementById('infonisn' + siapa + idx);
        const nisnrow = document.getElementById('nisnRow' + siapa + idx);
        const labelnnisn = nisnrow.getElementsByTagName('td');
        const nikrow = document.getElementById('nikpdptkRow' + siapa + idx);
        const labelnik = nikrow.getElementsByTagName('td');
        const tbnikselect = document.getElementById('tbnikselect' + siapa + idx);
        const tbdisabilitas = document.getElementById('tbdisabilitas' + siapa + idx);
        const nik_ayah = document.getElementById('nik' + siapa + idx);
        // const nama = document.getElementById('nama' + siapa + idx);
        const nama_ayah = document.getElementById('namaortu' + siapa + idx);
        const infonik = document.getElementById('infonik' + siapa + idx);
        const infonikpdptk = document.getElementById('infonikpdptk' + siapa + idx);
        const infonamaortu = document.getElementById('infonamaortu' + siapa + idx);
        const statusortu = document.getElementById('statusortu' + siapa + idx);

        tekssiapa = siapa;
        if (siapa == "pelaku") {
            if (statuskasus == 1) {
                tekssiapa = "pelaku";
            } else {
                tekssiapa = "terlapor";
            }
        }

        alamat = '<?= base_url() . "inputdata/get_data_p" ?>';

        var url = alamat;
        var data = {
            npsn: npsn,
            nik: nik,
            jenis: jenis,
            csrf_test_name: csrf,
        };

        xhrGet = $.ajax({
            url: url,
            type: 'POST',
            data: data,
            dataType: 'json',
            cache: false,
            success: function(result) {
                // alert("kucil");
                // nisn = result.nama_siswa;

                csrf = result.csrf;

                if (nisn == "")
                    iinfonisn.innerText = xinfonis;
                else {
                    iinfonisn.innerText = "";
                    document.getElementById('tbnisn' + siapa + idx).style.display = 'none';
                }
                nisnrow.style.display = "table-row";
                valnama = result.valnama_siswa;
                nisn = result.nisn;
                valnik = result.valnik;

                if (sebagai != "sekolah") {
                    nik_pdptk = result.nik;
                    namarow.style.display = "table-row";
                    nama = result.nama_siswa;
                }

                if (statusakhir == 2) {
                    if (statusortu.value == "ayah")
                        jenis_kelamin = "L";
                    else if (statusortu.value == "ibu")
                        jenis_kelamin = "P";
                    else
                        jenis_kelamin = "";
                    valjenis_kelamin = "";
                } else {
                    jenis_kelamin = result.jenis_kelamin;
                    valjenis_kelamin = result.valjenis_kelamin;
                }
                kode_wilayah = result.kode_wilayah;
                usia = result.usia;
                nik_ayah.value = result.nik_ayah;
                nama_ayah.value = result.nama_ayah;
                if (nik_ayah.value == "" || nik_ayah.value == null)
                    infonik.innerHTML = "NIK harus 16 digit";
                else
                    infonik.innerHTML = "";
                if (nama_ayah.value == "" || nama_ayah.value == null)
                    infonamaortu.innerHTML = "Nama " + siapa + " harus diisi";
                else
                    infonamaortu.innerHTML = "";

                infonikpdptk.innerHTML = "Dukcapil: " + valnik;

                jenisnomor = result.nomor;
                tbnikselect.style.display = 'none';
                tbdisabilitas.style.display = 'block';
                // alert(usia);
                // nama_sekolah = result.nama_sekolah;
                if (jenis == 1) {
                    if (result.kebutuhan_khusus_id > 0) {
                        pildisabilitas = "1";
                        disabilitas = result.kebutuhan_khusus;
                    } else {
                        pildisabilitas = "0";
                        disabilitas = "";
                    }
                } else {
                    pildisabilitas = "0";
                    document.getElementById('namaRow' + siapa + idx).style.display = "none";
                    if (sebagai == "sekolah") {
                        document.getElementById('infodaftarkepsek' + siapa + idx).innerHTML = "";
                    }
                    if (statusakhir <= 2)
                        labelnnisn[0].innerText = result.nomor + " " + capitalizeFirstLetter(tekssiapa);
                    else if (statusakhir <= 5)
                        labelnnisn[0].innerText = 'NUPTK' + " " + capitalizeFirstLetter(tekssiapa);
                }

                pdmasy = "Peserta Didik";
                if (statusakhir != 2)
                    pdmasy = capitalizeFirstLetter(tekssiapa);


                if (result.nomor == "NIK") {
                    // document.getElementById('nikpdptk' + siapa + idx).value = nisn;
                    labelnik[0].innerText = "NIK " + capitalizeFirstLetter(tekssiapa) + ' *';
                } else {
                    // document.getElementById('nikpdptk' + siapa + idx).value = nik_pdptk;
                    labelnik[0].innerHTML = "NIK " + pdmasy + ' *';
                }

                // usiarow.style.display = "table-row";
                usianya.value = usia;
                // desarow.style.display = "table-row";
                desanya.innerHTML = "<option value='" + kode_wilayah + "'>- pilih desa -</option>";

                const tbnisn = document.getElementById('tbnisn' + siapa + idx);
                tbnisn.disabled = false;
                tbnisn.style.display = 'none';

                tampilkannamadll(siapa, idx);

            }
        });

    }

    function get_ortu(jenis, nik, siapa, idx) {

        var nikortu = document.getElementById('nik' + siapa + idx);
        var infonik = document.getElementById('infonik' + siapa + idx);
        var namaortu = document.getElementById('namaortu' + siapa + idx);
        var infonama = document.getElementById('infonamaortu' + siapa + idx);

        infonik.innerHTML = "tunggu ...";
        infonama.innerHTML = "tunggu ...";
        nikortu.value = "";
        namaortu.value = "";

        alamat = '<?= base_url() . "inputdata/get_ortu" ?>';

        var url = alamat;
        var data = {
            jenis: jenis,
            nik: nik,
            csrf_test_name: csrf,
        };

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            dataType: 'json',
            cache: false,
            success: function(result) {
                nikortu.value = result.nikortu;
                namaortu.value = result.namaortu;
                csrf = result.kodhes;

                if (result.nikortu == "" || result.nikortu == null) {
                    infonik.style.display = "block";
                    infonik.innerHTML = "NIK " + jenis + " tidak tersedia";
                } else {
                    infonik.innerHTML = "";
                }

                if (result.namaortu == "" || result.namaortu == null) {
                    infonama.style.display = "block";
                    infonama.innerHTML = "Nama " + jenis + " tidak tersedia";
                } else {
                    infonama.innerHTML = "";
                }

                if (infonik.innerHTML == "" && infonama.innerHTML == "") {
                    infonama.innerHTML = "tunggu...";
                    window['ceknik' + siapa](idx);
                }

            },
            error: function(xhr, status, error) {
                // Penanganan kesalahan koneksi ke server
                console.log('Terjadi kesalahan koneksi:', error);
            }
        });

    }

    function tampilkannamadll(siapa, idx) {
        var namarow = document.getElementById('namaRow' + siapa + idx);
        var inama = document.getElementById('nama' + siapa + idx);
        var iinfonama = document.getElementById('infonama' + siapa + idx);
        if (sebagai == "sekolah") {
            var iinfodaftarpd = document.getElementById('infodaftarpd' + siapa + idx);
            var iinfodaftarptk = document.getElementById('infodaftarptk' + siapa + idx);
            var iinfodaftarptk2 = document.getElementById('infodaftarptk2' + siapa + idx);
            var iinfodaftarkepsek = document.getElementById('infodaftarkepsek' + siapa + idx);
        } else {
            namarow.style.display = "table-row";
        }
        var selectedValue;
        const radioButtons1 = document.querySelectorAll('input[name="status_' + siapa + idx + '"]');
        radioButtons1.forEach((radio) => {
            if (radio.checked) {
                selectedValue = radio.value;
            }
        });
        // var nikpdptk = document.getElementById('nikpdptk' + siapa + idx).value;
        inama.value = nama;
        if (valnama == null)
            valnama = "Belum Valid";
        iinfonama.innerText = "Dukcapil: " + valnama;

        if (sebagai == "sekolah") {
            if (selectedValue <= 2)
                iinfodaftarpd.innerText = "Dukcapil: " + valnama;
            else if (selectedValue == 3 && window['isi' + siapa + 'manual'][idx] == false)
                iinfodaftarptk.innerText = "Dukcapil: " + valnama;
            else if (selectedValue == 4 && window['isi' + siapa + 'manual'][idx] == false)
                iinfodaftarptk2.innerText = "Dukcapil: " + valnama;
            else if (selectedValue == 5 && window['isi' + siapa + 'manual'][idx] == false)
                iinfodaftarkepsek.innerText = "Dukcapil: " + valnama;
        }

        if (selectedValue == 2 || selectedValue == 6) {
            tampilkannikpesertadidik(siapa, idx);
        } else {
            tampilkannikkorban(siapa, idx);
        }

        namarow.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });

    }

    function tampilkannikkorban(siapa, idx) {
        var nikrow = document.getElementById('nikpdptkRow' + siapa + idx);
        // var nik = document.getElementById('nikpdptk' + siapa + idx);

        nikrow.style.display = "table-row";
        // if (jenisnomor == "NUPTK")
        //     nik.value = nik_pdptk;
        // else
        //     nik.value = nisn;

        tampilkanJK(siapa, idx);
    }

    function tampilkannikpesertadidik(siapa, idx) {
        var nikrow = document.getElementById('nikpdptkRow' + siapa + idx);
        var niksiswa = document.getElementById('nikpdptk' + siapa + idx);
        // var nik = document.getElementById('nikpdptk' + siapa + idx);
        // var tbnik = document.getElementById('tbnikpdptk' + siapa + idx);
        var tbnik = document.getElementById('tbnikselect' + siapa + idx);
        var nikrowortu = document.getElementById('nikRow' + siapa + idx);
        var tbnikortu = document.getElementById('tbnik' + siapa + idx);
        var namarowortu = document.getElementById('namaortuRow' + siapa + idx);
        var nikortu = document.getElementById('nik' + siapa + idx);
        var namaortu = document.getElementById('namaortu' + siapa + idx);
        var infonamaortu = document.getElementById('infonamaortu' + siapa + idx);

        nikrow.style.display = "table-row";
        nikrowortu.style.display = "table-row";
        namarowortu.style.display = "table-row";
        tbnikortu.style.display = "none";

        // nik.value = nik_pdptk;
        if (niksiswa.value == "" && statusakhir == 1)
            tbnik.style.display = "table-row";
        tbnik.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });

        if (nikortu.value != "" && nikortu.value != "null" && namaortu.value != "" && namaortu.value != "null") {
            infonamaortu.innerHTML = "tunggu...";
            ceknik(siapa, idx);
        }

        if (sebagai == "sekolah")
            tampilkanJK(siapa, idx);

    }

    function tampilkaninputortumasy(siapa, idx) {
        var nikrow = document.getElementById('nikpdptkRow' + siapa + idx);
        var nik = document.getElementById('nikpdptk' + siapa + idx);
        var nikmasyrow = document.getElementById('nikRow' + siapa + idx);
        var nikmasy = document.getElementById('nik' + siapa + idx);

        nikrow.style.display = "table-row";
        // nik.value = nik_pdptk;

        nikmasyrow.style.display = "table-row";
    }

    function get_data_masy(siapa, jenis, idx) {
        // alert("AA01");
        if (window['isi' + siapa + 'manual'][idx] == true && (statusakhir == 3 || statusakhir == 4)) {
            var nik = document.getElementById('nikpdptk' + siapa + idx).value;
            var iinfonik = document.getElementById('infonikpdptk' + siapa + idx);
        } else {
            var nik = document.getElementById('nik' + siapa + idx).value;
            var iinfonik = document.getElementById('infonik' + siapa + idx);
        }
        // var tbnama = document.getElementById('tbnama' + siapa + idx);
        var iinfonama = document.getElementById('infonama' + siapa + idx);
        var namarow = document.getElementById('namaRow' + siapa + idx);
        var inama = document.getElementById('nama' + siapa + idx).value;

        alamat = '<?= base_url() . "inputdata/get_data_m" ?>';

        var url = alamat;
        var data = {
            nik: nik,
            nama: inama,
            csrf_test_name: csrf,
        };

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            dataType: 'json',
            cache: false,
            success: function(result) {
                nama = result.nama_siswa;
                if (nama == "")
                    iinfonik.innerText = "NIK tidak sesuai"
                else {
                    iinfonik.innerText = "";
                    document.getElementById('tbnik' + siapa + idx).style.display = 'none';
                }

                csrf = result.csrf;

                valnama = result.valnama_siswa;
                valnik = result.valnik;
                jenis_kelamin = result.jenis_kelamin;
                valjenis_kelamin = result.valjenis_kelamin;
                if (jenis == 1) {
                    if (result.disabilitas_id > 0) {
                        pildisabilitas = "1";
                        disabilitas = result.disabilitas;
                    } else {
                        pildisabilitas = "0";
                    }
                } else {
                    pildisabilitas = "0";
                }

                // tbnama.style.display = "none";
                iinfonama.innerText = "Dukcapil: " + valnama;

                if (window['isi' + siapa + 'manual'][idx] == true && (statusakhir == 3 || statusakhir == 4 || statusakhir == 5)) {
                    const tbnik = document.getElementById('tbnikselect' + siapa + idx);
                    tbnik.innerHTML = "Konfirmasi";
                    tbnik.style.display = "none";
                    const disabilitas = document.getElementById('disabilitasRow' + siapa + idx);
                    disabilitas.style.display = "table-row";
                    const tbdisabilitas = document.getElementById('tbdisabilitas' + siapa + idx);
                    tbdisabilitas.style.display = "table-row";
                }

                iinfonik.innerText = "Dukcapil: " + valnik;

                tampilkanJKMasy(siapa, idx);

                namarow.style.display = "table-row";

                namarow.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });

    }

    btnTidakBersedia.addEventListener('click', function() {
        btnTidakBersedia.style.display = 'none';
        btnBersedia.style.display = 'none';
        // document.getElementById('tb6').classList.add('active');
        document.getElementById('dif6').style.display = 'block';
        // document.getElementById('tb6').classList.remove('tbnonaktif');
        // document.getElementById('tb6').classList.add('tbaktif');
        // document.getElementById('tb6').disabled = false;
        // document.getElementById('tb1').classList.remove('active');
        if (pilihanview == 'multi') {
            // document.getElementById('dif1').style.display = 'none';
            // document.getElementById('dif6').appendChild(akhirDiv);
        } else {
            // lokasikorban.appendChild(akhirDiv);
        }
        akhirDiv.classList.add('fade-in');
        akhirDiv.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    });

    btnBersedia.addEventListener('click', function() {
        if (pilihanview == 'multi') {
            document.getElementById('dif1').style.display = 'none';
        }
        document.getElementById('dif2').style.display = 'block';
        document.getElementById('tb2').classList.remove('tbnonaktif');
        document.getElementById('tb2').classList.add('tbaktif');
        document.getElementById('tb1').classList.remove('active');
        document.getElementById('tb2').classList.add('active');
        document.getElementById('tb2').disabled = false;
        btnTidakBersedia.style.display = 'none';
        btnBersedia.style.display = 'none';
        isianDiv.classList.add('fade-in');
        isianDiv.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });

    });

    function handleCheckbox(checkbox) {
        // resetRadiobuttons();
    }

    function resetRadiobuttons() {
        var radiobuttons = document.getElementsByName('status_korban1');
        for (var i = 0; i < radiobuttons.length; i++) {
            radiobuttons[i].checked = false;
        }
    }

    tbya.addEventListener('click', function() {
        tbya.classList.remove('btn_abu')
        tbtidak.classList.add('btn_abu');
        tbstop.classList.add('btn_abu');
        // tbstop.disabled = true;
        alasanDihentikan.style.display = 'none';
        if (counterkorban == 0)
            tbkorban.style.display = 'block';
        statuskasus = 1;
        pelakuatauterlapor();
    });

    tbtidak.addEventListener('click', function() {
        tbya.classList.add('btn_abu')
        tbtidak.classList.remove('btn_abu');
        tbstop.classList.add('btn_abu');
        alasanDihentikan.style.display = 'none';
        if (counterkorban == 0)
            tbkorban.style.display = 'block';
        statuskasus = 2;
        pelakuatauterlapor();
    });

    tbstop.addEventListener('click', function() {
        tbya.classList.add('btn_abu')
        tbtidak.classList.add('btn_abu');
        tbstop.classList.remove('btn_abu');
        var alasanDihentikan = document.getElementById('alasanDihentikan');
        alasanDihentikan.style.display = 'table-row';
        if (counterkorban == 0)
            tbkorban.style.display = 'block';
        statuskasus = 3;
        pelakuatauterlapor();
    });

    function pelakuatauterlapor() {
        var elemenStatusPelaku = document.getElementsByClassName("kelaspelaku");

        if (statuskasus == 1) {
            tb4.innerText = "Pelaku";
            for (var i = 0; i < elemenStatusPelaku.length; i++) {
                var teks = elemenStatusPelaku[i].innerText;
                var teksBaru = teks.replace(/\bTerlapor\b/g, "Pelaku");
                teksBaru = teksBaru.replace(/\bTERLAPOR\b/g, "PELAKU"); // Memeriksa huruf kapital
                elemenStatusPelaku[i].innerText = teksBaru;
            }
        } else {
            tb4.innerText = "Terlapor";
            for (var i = 0; i < elemenStatusPelaku.length; i++) {
                var teks = elemenStatusPelaku[i].innerText;
                var teksBaru = teks.replace(/\bPelaku\b/g, "Terlapor");
                teksBaru = teksBaru.replace(/\bPELAKU\b/g, "TERLAPOR"); // Memeriksa huruf kapital
                elemenStatusPelaku[i].innerText = teksBaru;
            }

        }
    }



    tbkorban.addEventListener('click', function() {

        if (pilihanview == 'multi') {
            document.getElementById('dif1').style.display = 'none';
            document.getElementById('dif2').style.display = 'none';
        }
        document.getElementById('dif3').style.display = 'block';
        document.getElementById('tb3').classList.remove('tbnonaktif');
        document.getElementById('tb3').classList.add('tbaktif');
        document.getElementById('tb2').classList.remove('active');
        document.getElementById('tb3').classList.add('active');
        document.getElementById('tb3').disabled = false;

        let tgllaporan = document.getElementById('datepicker1').value;
        let tglkejadian = document.getElementById('datepicker2').value;

        var tanggall = new Date(tgllaporan.split('/').reverse().join('-'));
        var tanggalk = new Date(tglkejadian.split('/').reverse().join('-'));
        var tanggals = new Date();
        tanggall.setHours(0, 0, 0, 0);
        tanggalk.setHours(0, 0, 0, 0);
        tanggals.setHours(0, 0, 0, 0);

        valid = true;

        if (tanggall < tanggalk) {
            document.getElementById('errorTanggal1').innerHTML = "Laporan diterima sebelum tanggal kejadian";
            valid = false;
        }
        if (tanggall > tanggals) {
            document.getElementById('errorTanggal1').innerHTML = "Tanggal laporan melewati tanggal sekarang";
            valid = false;
        }
        if (tanggalk > tanggals) {
            document.getElementById('errorTanggal2').innerHTML = "Tanggal kejadian melewati tanggal sekarang";
            valid = false;
        }

        if (statuskasus == 3) {
            var terlapor_meninggal = $('input[name="terlapor_meninggal"]:checked').length > 0 ? "tm," : "";
            var korban_tidak_ditemukan = $('input[name="korban_tidak_ditemukan"]:checked').length > 0 ? "ktd," : "";
            var pembuktian_belum_cukup = $('input[name="pembuktian_belum_cukup"]:checked').length > 0 ? "pbc," : "";
            var pilhenti = terlapor_meninggal + korban_tidak_ditemukan + pembuktian_belum_cukup;
            if (pilhenti == "") {
                document.getElementById('erroralasan').innerHTML = "Pilih minimal 1 alasan";
                valid = false;
            } else {
                document.getElementById('erroralasan').innerHTML = "";
            }
        }


        if (valid) {
            document.getElementById('errorTanggal1').innerHTML = "";
            // document.getElementById('datepicker1').disabled = true;
            // document.getElementById('datepicker2').disabled = true;
            tambahKorban(0);
        }
    });

    function showtbsubmitkorban(idx) {
        showtbsubmit('korban', idx);
    }

    function showtbsubmitpelaku(idx) {
        showtbsubmit('pelaku', idx);
    }

    function showtbsubmit(siapa, idx) {
        const tbsubmit = document.getElementById('tbnpsn' + siapa + idx);
        const tbsekolah = document.getElementById('tbsekolah' + siapa + idx);
        const nisnrow = document.getElementById('nisnRow' + siapa + idx);
        const sekolahrow = document.getElementById('sekolahRow' + siapa + idx);
        const sekolah = document.getElementById('sekolah' + siapa + idx);
        tbsubmit.style.display = 'block';
        sekolahrow.style.display = 'none';
        sekolah.value = "";
        if (sebagai != "sekolah") {
            nisnrow.style.display = "none";
            tbsekolah.style.display = "table-row";
        }
        document.getElementById('infonpsn' + siapa + idx).innerHTML = "";
    }

    function submitnpsnkorban(idx) {
        submitnpsn('korban', idx);
    }

    function submitnpsnpelaku(idx) {
        submitnpsn('pelaku', idx);
    }

    function submitnpsn(siapa, idx) {
        var radios = document.getElementsByName('status_' + siapa + idx);
        var tbnpsn = document.getElementById('tbnpsn' + siapa + idx);
        var npsn = document.getElementById('npsn' + siapa + idx);

        pilstatus[siapa][idx] = "";
        for (var i = 0; i < radios.length; i++) {
            radios[i].addEventListener('change', function() {
                document.getElementById('infonpsn' + siapa + idx).innerHTML = "";
            });

            if (radios[i].checked) {
                pilstatus[siapa][idx] = radios[i].value;
                break;
            }
        }

        if (pilstatus[siapa][idx] == "") {
            document.getElementById('infonpsn' + siapa + idx).innerHTML = "Silakan pilih status " + siapa + "!<br>";
        } else if ((npsn.value.trim()).length != 8) {
            document.getElementById('infonpsn' + siapa + idx).innerHTML = "NPSN 8 digit!<br>";
        } else {
            tbnpsn.innerHTML = "tunggu...";
            // tbnpsn.disabled = true;
            getnamasekolah(document.getElementById('npsn' + siapa + idx).value, siapa, idx);
        }

        // alert(pilstatus[siapa][idx]);

    };

    function getnamasekolah(npsn, siapa, idx) {
        var tbnpsn = document.getElementById('tbnpsn' + siapa + idx);
        if (npsn == "88010101" || npsn == "88010102" || npsn == "88020103" || npsn == "88020104" || npsn == "88030101") {
            var sekolahrow = document.getElementById('sekolahRow' + siapa + idx);
            var sekolah = document.getElementById('sekolah' + siapa + idx);
            var xstatus = "-";
            var kec = "-"
            var kota = "Kab./Kota: -";
            var provinsi = "-";

            document.getElementById('infonpsn' + siapa + idx).innerHTML = "NPSN tidak valid!";
            if (npsn == "88010101") {
                kec = "Baru";
                sekolah.value = "Sekolah Satu";
                xstatus = "Negeri";
                kota = "Kota: BCD";
                provinsi = "ABC";
            } else if (npsn == "88010102") {
                kec = "Baru";
                sekolah.value = "Sekolah Dua";
                xstatus = "Negeri";
                kota = "Kota: BCD";
                provinsi = "ABC";
            } else if (npsn == "88020103") {
                kec = "Lama";
                sekolah.value = "Sekolah Tiga";
                xstatus = "Negeri";
                kota = "Kota: DEF";
                provinsi = "ABC";
            } else if (npsn == "88020104") {
                kec = "Lama";
                sekolah.value = "Sekolah Empat";
                xstatus = "Negeri";
                kota = "Kota: DEF";
                provinsi = "ABC";
            } else if (npsn == "88030101") {
                kec = "Pagi";
                sekolah.value = "Sekolah Ahad";
                xstatus = "Negeri";
                kota = "Kab.: CBA";
                provinsi = "ABC";
            }

            document.getElementById('infonpsn' + siapa + idx).innerHTML = "";
            tbnpsn.innerHTML = "Submit";
            tbnpsn.style.display = 'none';

            document.getElementById('infosekolah' + siapa + idx).innerHTML = "<div style='color:black; margin-left:10px'>Status: " + xstatus + "<br> Kec: " + kec + " <br> " + kota + " <br> Provinsi: " + provinsi + " </div>";

            sekolahrow.style.display = 'table-row';

            sekolahrow.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        } else {
            $.ajax({
                type: 'GET',
                url: '<?= base_url() ?>inputdata/ceknpsnsekolah',
                data: {
                    npsn: npsn,
                },
                success: function(response) {
                    var sekolahrow = document.getElementById('sekolahRow' + siapa + idx);
                    var sekolah = document.getElementById('sekolah' + siapa + idx);
                    var xstatus = "-";
                    var kec = "-"
                    var kota = "Kab./Kota: -";
                    var provinsi = "-";

                    document.getElementById('infonpsn' + siapa + idx).innerHTML = "NPSN tidak valid!";

                    if (response != null) {
                        kec = response.kecamatan.substring(5);
                        sekolah.value = response.nama_sekolah;
                        if (response.status_sekolah == 1)
                            xstatus = "Negeri";
                        else if (response.status_sekolah == 2)
                            xstatus = "Swasta";

                        if (response.kota.substring(0, 3) == "Kab.")
                            kota = "Kab: " + response.kota.substring(5);
                        else
                            kota = "Kota: " + response.kota.substring(5);

                        provinsi = response.provinsi.substring(6);
                        document.getElementById('infonpsn' + siapa + idx).innerHTML = "";
                    }

                    tbnpsn.innerHTML = "Submit";
                    tbnpsn.style.display = 'none';

                    document.getElementById('infosekolah' + siapa + idx).innerHTML = "<div style='color:black; margin-left:10px'>Status: " + xstatus + "<br> Kec: " + kec + " <br> " + kota + " <br> Provinsi: " + provinsi + " </div>";

                    sekolahrow.style.display = 'table-row';

                    sekolahrow.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                },
                error: function() {
                    document.getElementById('infonpsn' + siapa + idx).innerHTML = "NPSN tidak valid!<br>";
                    tbnpsn.innerHTML = "Submit";
                }
            });
        }
    }

    function ceknikkorban(idx) {
        if (statusakhir == 6)
            ceknikmas("korban", idx);
        else
            ceknik("korban", idx);
    }

    function ceknikpelaku(idx) {
        if (statusakhir == 6)
            ceknikmas("pelaku", idx);
        else
            ceknik("pelaku", idx);
    }

    function ceknikdarijkpelaku(idx) {
        ceknikdarijk("pelaku", idx);
    }

    function ceknikdarijkkorban(idx) {
        ceknikdarijk("korban", idx);
    }

    function ceknikdarijk(siapa, idx) {
        var nama = document.getElementById('nama' + siapa + idx);
        var infonama = document.getElementById('infonama' + siapa + idx);
        var nik = document.getElementById('nik' + siapa + idx);
        var infonik = document.getElementById('infonik' + siapa + idx);
        var usia = document.getElementById('usia' + siapa + idx);
        var infousia = document.getElementById('infousia' + siapa + idx);
        var infojenis_kelamin = document.getElementById('infojenis_kelamin' + siapa + idx);

        var valid = true;
        if (nik.value == "") {
            infonik.innerHTML = "NIK harus 16 digit";
            valid = false;
        } else {
            infonik.innerHTML = "";
        }

        if (nama.value == "") {
            infonama.innerHTML = "Nama " + siapa + " harus diisi";
            valid = false;
        }

        if (usia.value == "") {
            infousia.innerHTML = "Usia " + siapa + " harus diisi";
            valid = false;
        }

        var radios = document.getElementsByName('jenis_kelamin' + siapa + idx);

        if (radios[0].checked == false && radios[1].checked == false) {
            infojenis_kelamin.innerHTML = "Jenis kelamin " + siapa + " harus diisi";
            valid = false;
        }

        if (valid) {
            infojenis_kelamin.innerHTML = "tunggu...";
            infonama.innerHTML = "tunggu...";
            infonik.innerHTML = "tunggu...";
            ceknikmas(siapa, idx);
        }
    }



    function lanjutalamatkorban(idx) {
        lanjutalamat("korban", idx);
    }

    function lanjutalamatpelaku(idx) {
        lanjutalamat("pelaku", idx);
    }

    function lanjutalamat(siapa, idx) {

        const alamatrow = document.getElementById('alamatRow' + siapa + idx);
        const provinsirow = document.getElementById('provinsiRow' + siapa + idx);
        const kotarow = document.getElementById('kotaRow' + siapa + idx);
        const kecamatanrow = document.getElementById('kecamatanRow' + siapa + idx);
        const desarow = document.getElementById('desaRow' + siapa + idx);
        const disabilitasrow = document.getElementById('disabilitasRow' + siapa + idx);
        const tbnik = document.getElementById('tbnikdarijk' + siapa + idx);
        const tblanjut = document.getElementById('tblanjutdarijk' + siapa + idx);

        tbnik.style.display = 'none';
        tblanjut.style.display = 'none';


        alamatrow.style.display = 'table-row';
        provinsirow.style.display = 'table-row';
        kotarow.style.display = 'table-row';
        kecamatanrow.style.display = 'table-row';
        desarow.style.display = 'table-row';
        disabilitasrow.style.display = 'table-row';

        disabilitasrow.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }

    function konfirmsekolahmas(siapa, idx) {
        document.getElementById('tbsekolah' + siapa + idx).style.display = "none";
        document.getElementById('tbnik' + siapa + idx).style.display = "none";
        document.getElementById('statusortu' + siapa + idx).style.display = "none";
        document.getElementById('nikRow' + siapa + idx).style.display = "table-row";
        document.getElementById('namaortuRow' + siapa + idx).style.display = "table-row";
        document.getElementById('tgllahirRow' + siapa + idx).style.display = "table-row";
        document.getElementById('usiaRow' + siapa + idx).style.display = "table-row";
        document.getElementById('usia' + siapa + idx).style.display = "table-row";
        document.getElementById('jenis_kelaminRow' + siapa + idx).style.display = "table-row";
        document.getElementById('tbjenis_kelamin' + siapa + idx).style.display = "table-row";
    }

    function ceknik(siapa, idx) {
        const npsn = document.getElementById('npsn' + siapa + idx).value;
        const niksiswa = document.getElementById('nikpdptk' + siapa + idx).value;
        const nikortu = document.getElementById('nik' + siapa + idx).value;
        const nikorturow = document.getElementById('nikRow' + siapa + idx);
        const labelnikortu = nikorturow.getElementsByTagName('td');
        const infonik = document.getElementById('infonik' + siapa + idx);
        const statusortu = document.getElementById('statusortu' + siapa + idx).value;
        const namaorturow = document.getElementById('namaortuRow' + siapa + idx);
        const labelnamaortu = namaorturow.getElementsByTagName('td');
        const namaortu = document.getElementById('namaortu' + siapa + idx);
        const infonamaortu = document.getElementById('infonamaortu' + siapa + idx);
        const jenis_kelaminrow = document.getElementById('jenis_kelaminRow' + siapa + idx);
        const labeljkortu = jenis_kelaminrow.getElementsByTagName('td');
        var jenis_kelamin = document.getElementsByName('jenis_kelamin' + siapa + idx);
        const infojenis_kelamin = document.getElementById('infojenis_kelamin' + siapa + idx);
        const disabliitasrow = document.getElementById('disabilitasRow' + siapa + idx);
        const labeldisabilitasortu = disabliitasrow.getElementsByTagName('td');
        const tbnik = document.getElementById('tbnik' + siapa + idx);

        tekssiapa = siapa;
        if (siapa == "pelaku") {
            if (statuskasus == 1) {
                tekssiapa = "pelaku";
            } else {
                tekssiapa = "terlapor";
            }
        }

        if (nikortu.length != 16 && nikortu != "-")
            infonik.innerHTML = "Nomor NIK 16 digit";
        else {
            infonik.innerHTML = "";
            tbnik.innerHTML = 'tunggu...';
            $.ajax({
                url: '<?= base_url() ?>inputdata/ceknikortu',
                type: 'POST',
                data: {
                    niksiswa: niksiswa,
                    nikortu: nikortu,
                    statusortu: statusortu,
                    csrf_test_name: csrf,
                },
                success: function(response) {
                    tbnik.style.display = 'none';
                    // var sekolahrow = document.getElementById('sekolahRow' + siapa + idx);

                    csrf = response.csrf;

                    if (response != null) {

                        if (response.ortu == "-") {
                            document.getElementById('infonik' + siapa + idx).innerHTML = "NIK tidak sesuai Dukcapil!<br>";
                        }
                        // kec = response.kecamatan.substring(5);

                        labelnikortu[0].innerHTML = 'NIK ' + capitalizeFirstLetter(tekssiapa) + ' (' + capitalizeFirstLetter(statusortu) + ') <sup>*</sup>';
                        labelnamaortu[0].innerHTML = 'Nama ' + capitalizeFirstLetter(tekssiapa) + ' (' + capitalizeFirstLetter(statusortu) + ') <sup>*</sup>';
                        namaorturow.style.display = "table-row";
                        // namaortu.value = response.nama;
                        infonamaortu.innerHTML = 'Dukcapil: ' + response.valnama;
                        for (var i = 0; i < jenis_kelamin.length; i++) {
                            if (jenis_kelamin[i].value === response.jenis_kelamin.substring(0, 1)) {
                                jenis_kelamin[i].checked = true;
                                break;
                            }
                        }

                        if (response.disabilitas_id > 0) {
                            pildisabilitasortu = "1";
                            disabilitasortu = result.disabilitas;
                        } else {
                            pildisabilitasortu = "0";
                        }

                        // labeljkortu[0].innerText = 'Jenis Kelamin ' + capitalizeFirstLetter(siapa) + ' (' + response.ortu + ')';
                        if (statusakhir == 2)
                            infojenis_kelamin.innerHTML = '';
                        else
                            infojenis_kelamin.innerHTML = 'Dukcapil: ' + response.valjenis_kelamin;

                        jenis_kelaminrow.style.display = "table-row";

                        // labeldisabilitasortu[0].innerText = 'Apakah ' + siapa + ' (' + response.ortu + ') memiliki disabilitas ? ';
                        disabliitasrow.style.display = "table-row";
                        disabliitasrow.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }

                },
                error: function() {
                    document.getElementById('infonik' + siapa + idx).innerHTML = "NIK orang tua tidak sesuai Dukcapil!<br>";
                }
            });

        }

    };

    function changenpsn(siapa, idx) {
        document.getElementById('sekolah' + siapa + idx).disabled = false;
        document.getElementById('tbnpsn' + siapa + idx).disabled = false;
        showtbsubmit(siapa, idx);
    }

    function changenisn(siapa, idx) {
        if (sebagai != "sekolah") {
            document.getElementById('nama' + siapa + idx).value = "";
            document.getElementById('infonisn' + siapa + idx).innerHTML = "";
            document.getElementById('infonama' + siapa + idx).innerHTML = "";

            document.getElementById('jenis_kelaminRow' + siapa + idx).style.display = "none";
            document.getElementById('disabilitasRow' + siapa + idx).style.display = "none";
            document.getElementById('namaRow' + siapa + idx).style.display = "none";
            document.getElementById('nikpdptkRow' + siapa + idx).style.display = "none";
            document.getElementById('tbnisn' + siapa + idx).style.display = "table-row";
            document.getElementById('tbnisn' + siapa + idx).innerText = "Cek";
            document.getElementById('tbnisn' + siapa + idx).disabled = false;
            // document.getElementById('nikRow' + siapa + idx).style.display = 'none';
        } else {
            document.getElementById('infodaftarpd' + siapa + idx).innerHTML = "";
            document.getElementById('nikpdptk' + siapa + idx).value = "";
        }
    }

    function changenik(siapa, idx) {
        tekssiapa = siapa;
        if (siapa == "pelaku") {
            if (statuskasus == 1) {
                tekssiapa = "pelaku";
            } else {
                tekssiapa = "terlapor";
            }
        }
        if (statusakhir != 2 && statusakhir != 6) {
            document.getElementById('infonik' + siapa + idx).innerHTML = "";
            document.getElementById('tbnik' + siapa + idx).style.display = "table-row";
            document.getElementById('tbnik' + siapa + idx).innerHTML = "Cek";
            document.getElementById('namaortuRow' + siapa + idx).style.display = "none";
            document.getElementById('jenis_kelaminRow' + siapa + idx).style.display = "none";
            document.getElementById('disabilitasRow' + siapa + idx).style.display = "none";
            var statusortu = capitalizeFirstLetter(document.getElementById('statusortu' + siapa + idx).value);
            var nikrow = document.getElementById('nikRow' + siapa + idx);
            var labelnikstatus = nikrow.getElementsByTagName('td');
            labelnikstatus[0].innerHTML = "NIK " + capitalizeFirstLetter(tekssiapa) + " (" + statusortu + ") <sup>*</sup>";
            var jkrow = document.getElementById('jenis_kelaminRow' + siapa + idx);
            var labeljkstatus = jkrow.getElementsByTagName('td');
            labeljkstatus[0].innerHTML = "Jenis Kelamin " + capitalizeFirstLetter(tekssiapa) + " (" + statusortu + ") <sup>*</sup>";
        } else {
            document.getElementById('infonik' + siapa + idx).innerHTML = "";
        }

        if (statusakhir == 2) {
            document.getElementById('tbnik' + siapa + idx).style.display = "table-row";
            document.getElementById('tbnik' + siapa + idx).innerHTML = "Cek";
        }

        if (statusakhir == 6) {
            document.getElementById('tbnikdarijk' + siapa + idx).style.display = "table-row";
            document.getElementById('tbnikdarijk' + siapa + idx).innerHTML = "Cek Dukcapil";
        }
    }

    function changeusia(siapa, idx) {
        document.getElementById('infousia' + siapa + idx).innerHTML = "";
    }

    function changealamat(siapa, idx) {
        document.getElementById('infoalamat' + siapa + idx).innerHTML = "";
    }

    function changenikpdptk(siapa, idx) {
        if (sebagai == "sekolah") {
            const tbnisn = document.getElementById('tbnikselect' + siapa + idx);
        } else {
            const tbnisn = document.getElementById('tbnikpdptk' + siapa + idx);
        }

        tbnisn.innerHTML = "Konfirmasi";
        tbnisn.style.display = "block";

        document.getElementById('infonikpdptk' + siapa + idx).innerHTML = "";
        document.getElementById('tbdisabilitas' + siapa + idx).style.display = "none";
    }

    function changesekolah(siapa, idx) {
        document.getElementById('infosekolah' + siapa + idx).style.display = "none";
    }

    function changenama(siapa, idx) {
        document.getElementById('infonama' + siapa + idx).innerHTML = "";

        const tbcek = document.getElementById('tbnama' + siapa + idx);
        var selectedValue;
        const radioButtons1 = document.querySelectorAll('input[name="status_' + siapa + idx + '"]');
        radioButtons1.forEach((radio) => {
            if (radio.checked) {
                selectedValue = radio.value;
            }
        });

        if (selectedValue == 6) {
            document.getElementById('tbnikdarijk' + siapa + idx).style.display = "table-row";
            document.getElementById('tbnikdarijk' + siapa + idx).innerHTML = "Cek Dukcapil";
            document.getElementById('infonik' + siapa + idx).innerHTML = "";
            document.getElementById('infojenis_kelamin' + siapa + idx).innerHTML = "";
        }
    }

    function changestatusortukorban(idx) {
        changestatusortu("korban", idx);
    }

    function changestatusortupelaku(idx) {
        changestatusortu("pelaku", idx);
    }

    function changestatusortu(siapa, idx) {
        tekssiapa = siapa;
        if (siapa == "pelaku") {
            if (statuskasus == 1) {
                tekssiapa = "pelaku";
            } else {
                tekssiapa = "terlapor";
            }
        }
        jenisortu = document.getElementById('statusortu' + siapa + idx).value;
        var statusortu = capitalizeFirstLetter(jenisortu);
        var nikrow = document.getElementById('nikRow' + siapa + idx);
        var niksiswa = document.getElementById('nikpdptk' + siapa + idx).value;
        var labelnikstatus = nikrow.getElementsByTagName('td');
        var namarow = document.getElementById('namaortuRow' + siapa + idx);
        var labelnamastatus = namarow.getElementsByTagName('td');
        labelnikstatus[0].innerHTML = "NIK " + capitalizeFirstLetter(tekssiapa) + " (" + statusortu + ") <sup>*</sup>";
        labelnamastatus[0].innerHTML = "Nama " + capitalizeFirstLetter(tekssiapa) + " (" + statusortu + ") <sup>*</sup>";
        var radios = document.getElementsByName('jenis_kelamin' + siapa + idx);
        if (jenisortu == "ayah")
            radios[0].checked = true;
        else if (jenisortu == "ibu")
            radios[1].checked = true;
        else {
            radios[0].checked = false;
            radios[1].checked = false;
        }

        document.getElementById('infojenis_kelamin' + siapa + idx).innerHTML = "";

        if (sebagai == "sekolah" || sebagai != "sekolah") {
            get_ortu(jenisortu, niksiswa, siapa, idx);
        } else
            changenik("korban", idx);
    }

    // function tampilkannisnkorban(idx) {
    //     tampilkannisn("korban", idx);
    // }

    // function tampilkannisn(siapa, idx) {
    //     var daftarpd = document.getElementById('daftarpd' + siapa + idx);
    //     var selectedOption = daftarpd.find(':selected');
    //     var nisn = selectedOption.val();
    //     var nik = selectedOption.data('induk');
    //     alert(nisn);
    // }

    function changenamaortu(siapa, idx) {
        document.getElementById('infonamaortu' + siapa + idx).innerHTML = "";
    }

    function ceknik_nama(siapa, idx) {
        const nik = document.getElementById('nik' + siapa + idx);
        const nama = document.getElementById('nama' + siapa + idx);
        const infonama = document.getElementById('infonama' + siapa + idx);
        const infodaftarpd = document.getElementById('infodaftarpd' + siapa + idx);

        if (nik.value == "" || nama.value == "") {
            infonama.innerHTML = "NIK dan Nama harus diisi";
        } else {
            return get_data_masy(siapa, 3, idx);

        }

    };

    function konfirmnamakorban(idx) {
        konfirmnama("korban", idx);
    }

    function konfirmnamapelaku(idx) {
        konfirmnama("pelaku", idx);
    }

    function konfirmnama(siapa, idx) {

        var selectedValue;
        const radioButtons1 = document.querySelectorAll('input[name="status_' + siapa + idx + '"]');
        radioButtons1.forEach((radio) => {
            if (radio.checked) {
                selectedValue = radio.value;
            }
        });

        if (selectedValue < 6) {
            document.getElementById('tbnama' + siapa + idx).style.display = 'none';
            document.getElementById('infonama' + siapa + idx).style.display = 'none';
            document.getElementById('infodaftarpd' + siapa + idx).style.display = 'none';
            // document.getElementById('nisn' + siapa + idx).disabled = true;
            // document.getElementById('nama' + siapa + idx).disabled = true;

            var radioButtons = document.querySelectorAll('input[name="status_' + siapa + idx + '"]');
            radioButtons.forEach(function(radioButton) {
                // radioButton.disabled = true;
            });

            tampilkannikpdptk(siapa, idx);
        } else {
            // alert("DISINI");
            var radioButtons = document.querySelectorAll('input[name="status_' + siapa + idx + '"]');
            radioButtons.forEach(function(radioButton) {
                // radioButton.disabled = true;
            });
            ceknik_nama(siapa, idx);
        }


    };

    function konfirmnamaortukorban(idx) {
        konfirmnamaortu("korban", idx);
    }

    function konfirmnamaortupelaku(idx) {
        konfirmnamaortu("pelaku", idx);
    }

    function konfirmnamaortu(siapa, idx) {

        if (statusakhir < 6) {
            document.getElementById('tbnamaortu' + siapa + idx).style.display = 'none';
            // document.getElementById('namaortu' + siapa + idx).disabled = true;
            tampilkanJKOrtu(siapa, idx);
        }

        // var disabilitasrow = document.getElementById('disabilitasRow' + siapa + idx);
        // disabilitasrow.style.display = 'table-row';

        // disabilitasrow.scrollIntoView({
        //     behavior: 'smooth',
        //     block: 'start'
        // });
    };

    function tampilkannikpdptk(siapa, idx) {
        var NIKKrow = document.getElementById('nikpdptkRow' + siapa + idx);
        document.getElementById('nikpdptk' + siapa + idx).value = nik_pdptk;

        NIKKrow.style.display = 'table-row';
        NIKKrow.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }

    function ceknikpdptkkorban(idx) {
        ceknikpdptk("korban", idx);
    }

    function ceknikpdptkpelaku(idx) {
        ceknikpdptk("pelaku", idx);
    }

    function ceknikpdptk(siapa, idx) {
        document.getElementById('nik' + siapa + idx).value = "";
        document.getElementById('tbnik' + siapa + idx).style.display = 'block';

        valid = true;
        namanya = document.getElementById('nama' + siapa + idx).value;
        niknya = document.getElementById('nikpdptk' + siapa + idx).value;

        const nikrow = document.getElementById('nikpdptkRow' + siapa + idx);
        const labelnik = nikrow.getElementsByTagName('td');

        if (namanya == "" && sebagai != "sekolah") {
            document.getElementById('infonama' + siapa + idx).innerHTML = "Nama harus diisi";
            valid = false;
        }

        if (niknya.length != 16) {
            if (labelnik[0].innerText.substring(0, 3) == 'NIK' + siapa + " <sup>*</sup>") {
                document.getElementById('infonikpdptk' + siapa + idx).innerHTML = "NIK harus 16 digit";
            } else if (labelnik[0].innerText.substring(0, 5) == 'NUPTK' + siapa)
                document.getElementById('infonikpdptk' + siapa + idx).innerHTML = "NUPTK harus 16 digit";
            valid = false;
        }

        if (valid) {
            // document.getElementById('nisn' + siapa + idx).disabled = true;
            // document.getElementById('nama' + siapa + idx).disabled = true;
            document.getElementById('infonama' + siapa + idx).style.display = 'none';
            if (sebagai == "sebagai") {
                document.getElementById('infodaftarpd' + siapa + idx).style.display = 'none';
            }
            document.getElementById('infonikpdptk' + siapa + idx).style.display = 'none';
            document.getElementById('infonisn' + siapa + idx).style.display = 'none';
            // document.getElementById('nikpdptk' + siapa + idx).disabled = true;
            document.getElementById('tbnikpdptk' + siapa + idx).style.display = 'none';
            tampilkaninputortumasy(siapa, idx);
        }
    }

    function tampilkanJK(siapa, idx) {
        var JKrow = document.getElementById('jenis_kelaminRow' + siapa + idx);
        var statusortu = document.getElementById('statusortu' + siapa + idx);

        if ((statusakhir == 2 && statusortu == "wali") || statusakhir != 2) {
            var radios = document.getElementsByName('jenis_kelamin' + siapa + idx);
            for (var i = 0; i < radios.length; i++) {
                if (radios[i].value === jenis_kelamin) {
                    radios[i].checked = true;
                    break;
                }
            }
        }

        JKl = "-";
        if (jenis_kelamin == "L")
            JKl = "Laki-laki";
        else if (jenis_kelamin == "P")
            JKl = "Perempuan";

        if (statusakhir == 2)
            document.getElementById('infojenis_kelamin' + siapa + idx).innerText = "";
        else
            document.getElementById('infojenis_kelamin' + siapa + idx).innerText = "Dukcapil: " + JKl;

        JKrow.style.display = "table-row";

        tampilkandisabilitas(siapa, idx);
    }

    function ambilSukuKata(data) {
        var sukuKataArray = data.split('-')[0].split(',');
        sukuKataArray = sukuKataArray.map(function(sukuKata) {
            return sukuKata.trim();
        });
        return sukuKataArray;
    }

    function tampilkandisabilitas(siapa, idx) {
        var radios = document.getElementsByName('disabilitas' + siapa + idx);
        for (var i = 0; i < radios.length; i++) {
            if (radios[i].value === pildisabilitas) {
                radios[i].checked = true;
                toggleInput(siapa, radios[i], idx);
                break;
            }
        }

        <?php
        foreach ($daf_kebutuhan_khusus as $row) {
            $kd_kb = $row['kebutuhan_khusus'];
            $kodeexp = explode("-", $kd_kb);
            $kode = trim($kodeexp[0], " ");
            echo "$('#checkbox" . $kode . "' + siapa + idx).prop('checked', false);";
        }
        ?>

        var dataArray = ambilSukuKata(disabilitas);

        $(document).ready(function() {
            $.each(dataArray, function(index, value) {
                $('#checkbox' + value + siapa + idx).prop('checked', true);
            });
        });

        var selectedValue;
        const radioButtons1 = document.querySelectorAll('input[name="status_' + siapa + idx + '"]');
        radioButtons1.forEach((radio) => {
            if (radio.checked) {
                selectedValue = radio.value;
            }
        });

        if (selectedValue == 6) {
            // document.getElementById('sekolah' + siapa + idx).disabled = true;
            // document.getElementById('nama' + siapa + idx).disabled = true;
            // document.getElementById('nik' + siapa + idx).disabled = true;
        }

        document.getElementById('tbjenis_kelamin' + siapa + idx).style.display = 'none';
        // document.getElementById('infojenis_kelamin' + siapa + idx).style.display = 'none';

        // var radioButtons = document.querySelectorAll('input[name="jenis_kelamin' + siapa + idx + '"]');
        // radioButtons.forEach(function(radioButton) {
        //     radioButton.disabled = true;
        // });

        var disabilitasrow = document.getElementById('disabilitasRow' + siapa + idx);
        // var inputdisabilitas = document.getElementById('inputdisabilitas' + siapa + idx);

        disabilitasrow.style.display = 'table-row';
        // inputdisabilitas.style.display = 'table-row';
        disabilitasrow.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });


    }

    function tampilkanJKMasy(siapa, idx) {
        var JKrow = document.getElementById('jenis_kelaminRow' + siapa + idx);
        var radios = document.getElementsByName('jenis_kelamin' + siapa + idx);
        if (valjenis_kelamin == "Sesuai")
            jenis_kelamin = "L";
        else
            jenis_kelamin = "P";
        for (var i = 0; i < radios.length; i++) {
            if (radios[i].value === jenis_kelamin) {
                radios[i].checked = true;
                break;
            }
        }

        JKl = "Perempuan";
        if (jenis_kelamin == "L")
            JKl = "Laki-laki";
        document.getElementById('infojenis_kelamin' + siapa + idx).innerText = "Dukcapil: " + JKl;

        if (document.getElementById('infonama' + siapa + idx).innerText == "Dukcapil: -") {
            document.getElementById('infojenis_kelamin' + siapa + idx).innerText = "";
            radios[0].checked = false;
            radios[1].checked = false;
        }

        JKrow.style.display = 'table-row';
        JKrow.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }

    function tampilkanJKOrtu(siapa, idx) {
        var JKrow = document.getElementById('jenis_kelaminRow' + siapa + idx);

        JKrow.style.display = 'table-row';
        JKrow.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }

    function ceknikselectkorban(idx) {
        const nikkorban = document.getElementById('nikpdptkkorban' + idx);
        const nama = document.getElementById('namakorban' + idx);
        const infonama = document.getElementById('infonamakorban' + idx);
        const infonik = document.getElementById('infonikpdptkkorban' + idx);
        const tbnisn = document.getElementById('tbnikselectkorban' + idx);
        var valid = true;

        if (nikkorban.value.length != 16) {
            infonik.innerHTML = "Harus 16 digit";
            valid = false;
        }

        if (nama.value.length == 0 && ((window['isikorbanmanual'][idx] == false && (statusakhir == 3 || statusakhir == 4 || statusakhir == 5)))) {
            infonama.innerHTML = "Nama harus diisi";
            valid = false;
        }

        if (valid) {
            infonik.value = "";
            tbnisn.innerHTML = "tunggu...";
            ceknisn("korban", idx);
        }

    }

    function ceknikselectpelaku(idx) {
        const nikpelaku = document.getElementById('nikpdptkpelaku' + idx);
        const nama = document.getElementById('namapelaku' + idx);
        const infonama = document.getElementById('infonamapelaku' + idx);
        const infonik = document.getElementById('infonikpdptkpelaku' + idx);
        const tbnisn = document.getElementById('tbnikselectpelaku' + idx);
        var valid = true;

        if (nikpelaku.value.length != 16) {
            infonik.innerHTML = "Harus 16 digit";
            valid = false;
        }

        if (nama.value.length == 0 && ((window['isipelakumanual'][idx] == false && (statusakhir == 3 || statusakhir == 4 || statusakhir == 5)))) {
            infonama.innerHTML = "Nama harus diisi";
            valid = false;
        }

        if (valid) {
            infonik.value = "";
            tbnisn.innerHTML = "tunggu...";
            ceknisn("pelaku", idx);
        }
    }

    function ceknisnkorban(idx) {
        ceknisn("korban", idx);
    }

    function ceknisnpelaku(idx) {
        ceknisn("pelaku", idx);
    }

    function ceknisn(siapa, idx) {
        var selectedValue;
        const radioButtons1 = document.querySelectorAll('input[name="status_' + siapa + idx + '"]');
        radioButtons1.forEach((radio) => {
            if (radio.checked) {
                selectedValue = radio.value;
            }
            // radio.disabled = true;
        });

        valid = true;

        if (selectedValue <= 2 && document.getElementById('nisn' + siapa + idx).value == "" && sebagai != "sekolah") {
            document.getElementById('infonisn' + siapa + idx).innerHTML = "NISN harus diisi atau '-'";
            valid = false;
        } else {
            document.getElementById('infonisn' + siapa + idx).innerHTML = "";
        }
        if (selectedValue <= 2 && document.getElementById('nikpdptk' + siapa + idx).value == "") {
            document.getElementById('infonikpdptk' + siapa + idx).innerHTML = "NIK harus 16 digit";
            valid = false;
        } else {
            document.getElementById('infonikpdptk' + siapa + idx).innerHTML = "";
        }
        if (selectedValue > 2 && document.getElementById('nisn' + siapa + idx).value == "") {
            document.getElementById('infonisn' + siapa + idx).innerHTML = "NIK/NUPTK harus diisi";
            valid = false;
        }
        if (selectedValue == 6 && document.getElementById('nisn' + siapa + idx).value == "") {
            document.getElementById('infonisn' + siapa + idx).innerHTML = "NIK harus 16 digit";
            valid = false;
        } else {
            document.getElementById('infonisn' + siapa + idx).innerHTML = "";
        }

        if (selectedValue > 2 && document.getElementById('nisn' + siapa + idx).value.length != 16) {
            document.getElementById('infonisn' + siapa + idx).innerHTML = "NIK/NUPTK harus 16 digit";
            valid = false;
        }

        if (selectedValue == 6 && document.getElementById('nisn' + siapa + idx).value.length != 16) {
            document.getElementById('infonisn' + siapa + idx).innerHTML = "NIK harus 16 digit";
            valid = false;
        }

        if (selectedValue <= 2 && document.getElementById('nisn' + siapa + idx).value.length != 10 && document.getElementById('nisn' + siapa + idx).value != "-" && document.getElementById('nisn' + siapa + idx).value != "") {
            document.getElementById('infonisn' + siapa + idx).innerHTML = "NISN harus 10 digit";
            valid = false;
        }

        if (valid) {

        } {
            if (sebagai != "sekolah") {
                const tbnisn = document.getElementById('tbnisn' + siapa + idx);
                const npsn = document.getElementById('npsn' + siapa + idx).value;
                const nisn = document.getElementById('nisn' + siapa + idx).value;
                const nikpdptk = document.getElementById('nikpdptk' + siapa + idx);
                tbnisn.innerHTML = "tunggu...";
                // tbnisn.disabled = true;
                alamat = '<?= base_url() . "inputdata/nik_siswa" ?>';

                var url = alamat;
                var data = {
                    jenis: selectedValue,
                    nisn: nisn,
                    npsn: npsn,
                    csrf_test_name: csrf,
                };

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: data,
                    dataType: 'json',
                    cache: false,
                    success: function(result) {
                        nikpdptk.value = result.niksiswa;
                        csrf = result.kodhes;

                        return grabdatanya(selectedValue, siapa, idx);
                    },
                    error: function(xhr, status, error) {
                        // Penanganan kesalahan koneksi ke server
                        console.log('Terjadi kesalahan koneksi:', error);
                    }
                });
            } else
                return grabdatanya(selectedValue, siapa, idx);

        }
    }

    function grabdatanya(selectedValue, siapa, idx) {
        if (selectedValue == 1 || selectedValue == 2) {
            if (document.getElementById('nisn' + siapa + idx).value == "-") {
                if (selectedValue == 1) {
                    // document.getElementById('nisnRow' + siapa + idx).style.display = "table-row";
                    // document.getElementById('namaRow' + siapa + idx).style.display = "table-row";
                    document.getElementById('nikpdptkRow' + siapa + idx).style.display = "table-row";
                    document.getElementById('jenis_kelaminRow' + siapa + idx).style.display = "table-row";
                    var disabilitasrow = document.getElementById('disabilitasRow' + siapa + idx);
                    disabilitasrow.style.display = "table-row";
                    tbnisn.style.display = 'none';
                    disabilitasrow.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                } else {
                    // document.getElementById('nisnRow' + siapa + idx).style.display = "table-row";
                    // document.getElementById('namaRow' + siapa + idx).style.display = "table-row";
                    document.getElementById('nikpdptkRow' + siapa + idx).style.display = "table-row";
                    document.getElementById('tbnikpdptk' + siapa + idx).style.display = "table-row";
                    tbnisn.style.display = 'none';
                }
            } else {
                return get_data(siapa, 1, idx);
            }
        } else if (selectedValue >= 3 && selectedValue <= 5) {
            if (window['isi' + siapa + 'manual'][idx] == true && (selectedValue == 3 || selectedValue == 4))
                return get_data_masy(siapa, 2, idx);
            else
                return get_data(siapa, 2, idx);
        }
    }

    function konfirmjenis_kelaminkorban(idx) {
        konfirmjenis_kelamin("korban", idx);
    }

    function konfirmjenis_kelaminpelaku(idx) {
        konfirmjenis_kelamin("pelaku", idx);
    }

    function konfirmjenis_kelamin(siapa, idx) {
        if (statusakhir < 6) {
            document.getElementById('infonama' + siapa + idx).style.display = 'none';
            document.getElementById('infodaftarpd' + siapa + idx).style.display = 'none';
            var radios = document.getElementsByName('disabilitas' + siapa + idx);
            for (var i = 0; i < radios.length; i++) {
                if (radios[i].value === pildisabilitas) {
                    radios[i].checked = true;
                    toggleInput(siapa, radios[i], idx);
                    break;
                }
            }

            // var selectedValue;
            // const radioButtons1 = document.querySelectorAll('input[name="status_' + siapa + idx + '"]');
            // radioButtons1.forEach((radio) => {
            //     if (radio.checked) {
            //         selectedValue = radio.value;
            //     }
            // });

            // if (selectedValue == 6) {
            //     document.getElementById('sekolah' + siapa + idx).disabled = true;
            //     document.getElementById('nama' + siapa + idx).disabled = true;
            //     document.getElementById('nik' + siapa + idx).disabled = true;
            // }

            document.getElementById('tbjenis_kelamin' + siapa + idx).style.display = 'none';
            document.getElementById('infojenis_kelamin' + siapa + idx).style.display = 'none';

            var radioButtons = document.querySelectorAll('input[name="jenis_kelamin' + siapa + idx + '"]');
            radioButtons.forEach(function(radioButton) {
                // radioButton.disabled = true;
            });

            var disabilitasrow = document.getElementById('disabilitasRow' + siapa + idx);

            disabilitasrow.style.display = 'table-row';

            disabilitasrow.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        } else {
            const nikmasy = document.getElementById('nik' + siapa + idx).value;
            // ceknikmas(siapa, idx);

        }

    };

    function ceknikmas(siapa, idx) {
        const tbnik = document.getElementById('tbnikdarijk' + siapa + idx);
        const nik_masy = document.getElementById('nik' + siapa + idx).value;
        const nama_masy = document.getElementById('nama' + siapa + idx).value;
        const infonama = document.getElementById('infonama' + siapa + idx);
        const infonik = document.getElementById('infonik' + siapa + idx);
        const infojenis_kelamin = document.getElementById('infojenis_kelamin' + siapa + idx);

        const tblanjut = document.getElementById('tblanjutdarijk' + siapa + idx);

        const alamatrow = document.getElementById('alamatRow' + siapa + idx);
        const provinsirow = document.getElementById('provinsiRow' + siapa + idx);
        const kotarow = document.getElementById('kotaRow' + siapa + idx);
        const kecamatanrow = document.getElementById('kecamatanRow' + siapa + idx);
        const desarow = document.getElementById('desaRow' + siapa + idx);
        const disabilitasrow = document.getElementById('disabilitasRow' + siapa + idx);

        var radios = document.getElementsByName('jenis_kelamin' + siapa + idx);

        var jeniskel = "Laki-Laki";
        var valid = false;

        if (radios[0].checked == true) {
            jeniskel = "Laki-Laki";
        } else if (radios[1].checked == true) {
            jeniskel = "Perempuan";
        } else {
            radios[0].checked = true;
        }

        $.ajax({
            url: '<?= base_url() ?>inputdata/ceknikmasy',
            type: 'POST',
            data: {
                nik_masy: nik_masy,
                nama_masy: nama_masy,
                jk_masy: jeniskel,
                tgllahir: '2000/01/01',
                csrf_test_name: csrf,
            },
            success: function(response) {
                // tbnik.style.display = 'none';

                if (response != null) {
                    valid = true;
                    // if (response.ortu == "-") {
                    //     document.getElementById('infonik' + siapa + idx).innerHTML = "NIK tidak sesuai Dukcapil!<br>";
                    // }

                    infonama.innerHTML = "Dukcapil: " + response.valnama;
                    infonik.style.display = 'table-row';
                    infonik.innerHTML = "Dukcapil: " + response.valnik;
                    csrf = response.csrf;

                    if ((jeniskel == "Laki-Laki" && response.valjenis_kelamin == "Sesuai") || (jeniskel == "Perempuan" && response.valjenis_kelamin == "Tidak Sesuai"))
                        infojenis_kelamin.innerHTML = "Dukcapil: Laki-laki";
                    else if ((jeniskel == "Perempuan" && response.valjenis_kelamin == "Sesuai") || (jeniskel == "Laki-Laki" && response.valjenis_kelamin == "Tidak Sesuai"))
                        infojenis_kelamin.innerHTML = "Dukcapil: Perempuan";
                    else {
                        infojenis_kelamin.innerHTML = "Dukcapil: -";
                    }

                    if (response.valjenis_kelamin == "-") {
                        valid = false;
                        tblanjut.style.display = "table-row";
                    }

                    if (valid) {
                        alamatrow.style.display = 'table-row';
                        provinsirow.style.display = 'table-row';
                        kotarow.style.display = 'table-row';
                        kecamatanrow.style.display = 'table-row';
                        desarow.style.display = 'table-row';
                        disabilitasrow.style.display = 'table-row';

                        disabilitasrow.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                }

            },
            error: function() {
                document.getElementById('infonik' + siapa + idx).innerHTML = "NIK tidak sesuai Dukcapil!<br>";
            }
        });
    }

    function konfirmsekolahkorban(idx) {
        if (statusakhir == 6)
            konfirmsekolahmas("korban", idx);
        else
            konfirmsekolah("korban", idx);
    }

    function konfirmsekolahpelaku(idx) {
        if (statusakhir == 6)
            konfirmsekolahmas("pelaku", idx);
        else
            konfirmsekolah("pelaku", idx);
    }

    function konfirmsekolah(siapa, idx) {

        valid = true;
        if (document.getElementById('sekolah' + siapa + idx).value == "") {
            //document.getElementById('infosekolah' + siapa + idx).innerHTML = "Nama sekolah harus diisi";
            valid = false;
        }

        if (valid) {
            var selectedValue;
            const radioButtons1 = document.querySelectorAll('input[name="status_' + siapa + idx + '"]');
            radioButtons1.forEach((radio) => {
                if (radio.checked) {
                    selectedValue = radio.value;
                }
            });

            if (selectedValue < 6) {

                var daftarpdrow = document.getElementById('daftarpdRow' + siapa + idx);
                var daftarptkrow = document.getElementById('daftarptkRow' + siapa + idx);
                var daftarptk2row = document.getElementById('daftarptk2Row' + siapa + idx);
                var daftarkepsekrow = document.getElementById('daftarkepsekRow' + siapa + idx);
                var nisnrow = document.getElementById('nisnRow' + siapa + idx);
                var labelnisn = nisnrow.getElementsByTagName('td');
                var tbnisn = document.getElementById('tbnisn' + siapa + idx);
                var namarow = document.getElementById('namaRow' + siapa + idx);
                var nikpdptkrow = document.getElementById('nikpdptkRow' + siapa + idx);
                var tbnikpdptk = document.getElementById('tbnikpdptk' + siapa + idx);
                document.getElementById('tbsekolah' + siapa + idx).style.display = 'none';
                var nisn = document.getElementById('nisn' + siapa + idx).value;
                // document.getElementById('sekolah' + siapa + idx).disabled = true;
                document.getElementById('tbcarisekolah' + siapa + idx).style.display = 'none';
                if (sebagai == "sekolah") {
                    if (selectedValue <= 2) {
                        daftarpdrow.style.display = 'table-row';
                        daftarpdrow.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    } else if (selectedValue == 3) {
                        daftarptkrow.style.display = 'table-row';
                        daftarptkrow.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    } else if (selectedValue == 4) {
                        daftarptk2row.style.display = 'table-row';
                        daftarptk2row.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    } else {
                        daftarkepsekrow.style.display = 'table-row';
                        daftarkepsekrow.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }

                } else {
                    // tbnisn.style.display = 'none';
                    if (selectedValue == 1)
                        labelnisn[0].innerText = 'NISN ' + siapa;
                    else if (selectedValue == 2)
                        labelnisn[0].innerText = 'NISN peserta didik';
                    else if (selectedValue <= 5) {
                        labelnisn[0].innerText = 'NUPTK ' + siapa;
                        if (selectedValue == 5) {
                            ambildatakepsek(siapa, idx);
                        }
                    }

                    nisnrow.style.display = 'table-row';
                    // namarow.style.display = 'table-row';
                    // nikpdptkrow.style.display = 'table-row';
                    // tbnikpdptk.style.display = 'table-row';
                    nisnrow.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }

            } else {
                document.getElementById('tbsekolah' + siapa + idx).style.display = 'none';

                var nik = document.getElementById('nikRow' + siapa + idx);
                nik.style.display = 'table-row';
                nik.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }
    }

    function ambildatakepsek(siapa, idx) {
        var npsnkepsek = (document.getElementById('npsn' + siapa + idx).value);
        var nisn = (document.getElementById('nisn' + siapa + idx));
        var tbnisn = (document.getElementById('tbnisn' + siapa + idx));
        var nikrow = (document.getElementById('nikpdptkRow' + siapa + idx));
        var namarow = (document.getElementById('namaRow' + siapa + idx));
        var nik = (document.getElementById('nikpdptk' + siapa + idx));
        var nama = (document.getElementById('nama' + siapa + idx));

        var url = '<?= base_url() . "inputdata/get_kepsek" ?>';
        var data = {
            npsn: npsnkepsek,
            csrf_test_name: csrf,
        };

        nisn.value = "";

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            dataType: 'json',
            cache: false,
            success: function(result) {
                nisn.value = result.nuptkkepsek;
                tbnisn.style.display = 'none';
                nik.value = result.nikkepsek;
                nama.value = result.namakepsek;
                nisn.style.display = 'table-row';
                namarow.style.display = 'table-row';
                nikrow.style.display = 'table-row';
                csrf = result.kodhes;
                ceknisn(siapa, idx);
            },
            error: function(xhr, status, error) {
                console.log('Terjadi kesalahan koneksi:', error);
            }
        });
    }

    function konfirmdisabilitaskorban(idx) {
        konfirmdisabilitas("korban", idx);
    }

    function konfirmdisabilitaspelaku(idx) {
        konfirmdisabilitas("pelaku", idx);
    }

    function konfirmdisabilitas(siapa, idx) {
        const radioStatus = document.getElementsByName('status_' + siapa + idx);
        let selectedValuestatus = 0;
        for (let i = 0; i < radioStatus.length; i++) {
            if (radioStatus[i].checked) {
                selectedValuestatus = radioStatus[i].value;
                break;
            }
        }

        pilstatus[siapa][idx] = selectedValuestatus;

        valid = true;

        if (document.getElementById('nik' + siapa + idx).value == "" && selectedValuestatus == 2) {
            document.getElementById('infonik' + siapa + idx).style.display = "table-row";
            document.getElementById('infonik' + siapa + idx).innerHTML = "NIK harus 16 digit";
            valid = false;
        } else {
            document.getElementById('infonik' + siapa + idx).style.display = "none";
            // document.getElementById('infonik' + siapa + idx).innerHTML = "";
        }

        if (document.getElementById('namaortu' + siapa + idx).value == "" && selectedValuestatus == 2) {
            document.getElementById('infonamaortu' + siapa + idx).style.display = "table-row";
            document.getElementById('infonamaortu' + siapa + idx).innerHTML = "Nama " + siapa + " harus diisi";
            valid = false;
        } else {
            document.getElementById('infonamaortu' + siapa + idx).style.display = "none";
            // document.getElementById('infonamaortu' + siapa + idx).innerHTML = "";
        }

        if (document.getElementById('nama' + siapa + idx).value == "" && sebagai != "sekolah") {
            document.getElementById('infonama' + siapa + idx).innerHTML = "Nama " + siapa + " harus diisi";
            valid = false;
        }

        if (document.getElementById('nama' + siapa + idx).value == "" && selectedValuestatus == 6) {
            document.getElementById('infonama' + siapa + idx).innerHTML = "Nama " + siapa + " harus diisi";
            valid = false;
        }

        dipilih = 0;
        var radioButtonsjk = document.querySelectorAll('input[name="jenis_kelamin' + siapa + idx + '"]');
        radioButtonsjk.forEach(function(radioButton) {
            if (radioButton.checked) {
                dipilih = 1;
            }
        });
        if (dipilih == 0) {
            document.getElementById('infojenis_kelamin' + siapa + idx).innerHTML = "Jenis kelamin " + siapa + " harus diisi";
            valid = false;
        } else {
            document.getElementById('infojenis_kelamin' + siapa + idx).innerHTML = "";
        }

        const radioKB = document.getElementsByName('disabilitas' + siapa + idx);
        let terpilihKB = 0;
        for (let i = 0; i < radioKB.length; i++) {
            if (radioKB[i].checked) {
                terpilihKB = radioKB[i].value;
                break;
            }
        }

        jmlpilKB = 0;
        dafkodeKB.forEach(function(element) {
            if (document.getElementById('checkbox' + element + siapa + idx).checked)
                jmlpilKB++;
        });
        if (jmlpilKB == 0 && terpilihKB == 1) {
            document.getElementById('infodisabilitas' + siapa + idx).innerHTML = "<br>Pilih minimal satu disabilitas " + siapa;
            valid = false;
        }

        if (statusakhir == 6) {
            if (document.getElementById('alamat' + siapa + idx).value == "") {
                document.getElementById('infoalamat' + siapa + idx).innerHTML = "Alamat harus diisi";
                valid = false;
            } else {
                document.getElementById('infoalamat' + siapa + idx).innerHTML = "";
            }

            if (document.getElementById('nik' + siapa + idx).value.length != 16) {
                document.getElementById('infonik' + siapa + idx).innerHTML = "NIK harus 16 digit";
                valid = false;
            } else {
                // document.getElementById('infonik' + siapa + idx).innerHTML = "";
                document.getElementById('infonik' + siapa + idx).style.display = "none";
            }

            provinsi = document.getElementById('provinsi' + siapa + idx).value;
            if (provinsi == "-") {
                document.getElementById('infoprovinsi' + siapa + idx).innerHTML = "Provinsi wajib diisi";
                valid = false;
            } else {
                document.getElementById('infoprovinsi' + siapa + idx).innerHTML = "";
            }

            kota = document.getElementById('kota' + siapa + idx).value;
            if (kota == "-") {
                document.getElementById('infokota' + siapa + idx).innerHTML = "Kota wajib diisi";
                valid = false;
            } else {
                document.getElementById('infokota' + siapa + idx).innerHTML = "";
            }

            kecamatan = document.getElementById('kecamatan' + siapa + idx).value;
            if (kecamatan == "-") {
                document.getElementById('infokecamatan' + siapa + idx).innerHTML = "Kecamatan wajib diisi";
                valid = false;
            } else {
                document.getElementById('infokecamatan' + siapa + idx).innerHTML = "";
            }

            usia = document.getElementById('usia' + siapa + idx).value;
            if (usia == "") {
                document.getElementById('infousia' + siapa + idx).innerHTML = "Usia wajib diisi";
                valid = false;
            } else {
                document.getElementById('infousia' + siapa + idx).innerHTML = "";
            }
        }

        // document.getElementById('infonisn' + siapa + idx).innerHTML = "";
        const nikrow = document.getElementById('nikpdptkRow' + siapa + idx);
        const labelnik = nikrow.getElementsByTagName('td');

        if (statusakhir < 6)

        {
            if (document.getElementById('nikpdptk' + siapa + idx).value.length != 16) {
                if (labelnik[0].innerText.substring(0, 3) == 'NIK') {
                    document.getElementById('infonikpdptk' + siapa + idx).innerHTML = "NIK harus 16 digit";
                    valid = false;
                } else if (labelnik[0].innerText.substring(0, 5) == 'NUPTK') {
                    if (document.getElementById('nikpdptk' + siapa + idx).value != "-") {
                        document.getElementById('infonikpdptk' + siapa + idx).innerHTML = "NUPTK harus 16 digit atau diisi tanda '-'";
                        valid = false;
                    }
                }
            } else {
                // document.getElementById('infonikpdptk' + siapa + idx).innerHTML = "";
                document.getElementById('infonikpdptk' + siapa + idx).style.display = "none";
            }
        }

        // if (sebagai == "sekolah") {
        //     document.getElementById('infodaftarpd' + siapa + idx).innerHTML = "";
        //     document.getElementById('infodaftarptk' + siapa + idx).innerHTML = "";
        //     document.getElementById('infodaftarptk2' + siapa + idx).innerHTML = "";
        //     document.getElementById('infodaftarkepsek' + siapa + idx).innerHTML = "";
        // }
        // document.getElementById('infonama' + siapa + idx).innerHTML = "";

        if (sebagai == "sekolah") {
            document.getElementById('infodaftarpd' + siapa + idx).style.display = "none";
            document.getElementById('infodaftarptk' + siapa + idx).style.display = "none";
            document.getElementById('infodaftarptk2' + siapa + idx).style.display = "none";
            document.getElementById('infodaftarkepsek' + siapa + idx).style.display = "none";
        }
        document.getElementById('infonama' + siapa + idx).style.display = "none";

        if (valid) {
            if (siapa == "korban") {
                statuskorbanok[idx] = 1;
            } else {
                statuspelakuok[idx] = 1;
            }
            if (statusakhir == 6) {
                var radioButtons = document.querySelectorAll('input[name="status_' + siapa + idx + '"]');
                radioButtons.forEach(function(radioButton) {
                    // radioButton.disabled = true;
                });
                // document.getElementById('sekolah' + siapa + idx).disabled = true;
                // document.getElementById('datepicker' + siapa + idx).disabled = true;
                // document.getElementById('usia' + siapa + idx).disabled = true;
                // document.getElementById('alamat' + siapa + idx).disabled = true;
                // document.getElementById('provinsi' + siapa + idx).disabled = true;
                // document.getElementById('kota' + siapa + idx).disabled = true;
                // document.getElementById('kecamatan' + siapa + idx).disabled = true;
                // document.getElementById('desa' + siapa + idx).disabled = true;
            }
            // document.getElementById('statusortu' + siapa + idx).disabled = true;
            document.getElementById('tbdisabilitas' + siapa + idx).style.display = 'none';
            document.getElementById('infodisabilitas' + siapa + idx).innerHTML = "";
            // document.getElementById('infonik' + siapa + idx).innerHTML = "";
            document.getElementById('infonik' + siapa + idx).style.display = "none";
            dafkodeKB.forEach(function(element) {
                // document.getElementById('checkbox' + element + siapa + idx).disabled = true;
            });

            var radioButtons = document.querySelectorAll('input[name="disabilitas' + siapa + idx + '"]');
            radioButtons.forEach(function(radioButton) {
                // radioButton.disabled = true;
            });
            // document.getElementById('nama' + siapa + idx).disabled = true;
            // document.getElementById('namaortu' + siapa + idx).disabled = true;
            // document.getElementById('nikpdptk' + siapa + idx).disabled = true;
            // document.getElementById('nik' + siapa + idx).disabled = true;
            // document.getElementById('nisn' + siapa + idx).disabled = true;

            radioButtonsjk.forEach(function(radioButton) {
                // radioButton.disabled = true;
            });
            var radioButtons = document.querySelectorAll('input[id^="disabilitas' + siapa + idx + '"]');
            radioButtons.forEach(function(radioButton) {
                // radioButton.disabled = true;
            });



            var pelakuterlapor;

            if (statuskasus == 1) {
                pelakuterlapor = " PELAKU";
            } else {
                pelakuterlapor = " TERLAPOR";
            }

            if (siapa == 'korban') {
                tbtambahkorban = document.getElementById('tbtambah' + siapa + counterkorban);
                tbtambahkorban.innerHTML = "INPUT KORBAN KE-" + (counterkorban + 1);
                tbtambahkorban.style.display = 'inline';
                if (counterpelaku == 0) {
                    tbpelaku = document.getElementById('tbpelaku' + siapa + counterkorban);
                    tbpelaku.innerText = "INPUT" + pelakuterlapor;
                    tbpelaku.style.display = 'inline';
                }

                if (counterkorban > 1) {
                    tbkurangikorban = document.getElementById('tbkurangi' + siapa + counterkorban);
                    tbkurangikorban.style.display = 'inline';

                    tbtambahkorbanprev = document.getElementById('tbtambah' + siapa + (counterkorban - 1));
                    tbtambahkorbanprev.style.display = 'none';
                    tbkurangikorbanprev = document.getElementById('tbkurangi' + siapa + (counterkorban - 1));
                    // tbkurangikorbanprev.style.display = 'none';
                    tbpelaku = document.getElementById('tbpelakukorban' + (counterkorban - 1));
                    tbpelaku.style.display = 'none';
                }
            } else if (siapa == 'pelaku') {
                tbtambahpelaku = document.getElementById('tbtambah' + siapa + counterpelaku);
                tbtambahpelaku.innerHTML = "<span class='kelaspelaku'>INPUT " + pelakuterlapor + " KE-" + (counterpelaku + 1) + "</span>";
                tbtambahpelaku.style.display = 'inline';
                tbkronologi = document.getElementById('tbkronologi' + counterpelaku);
                tbkronologi.style.display = 'inline';

                if (counterpelaku > 1) {
                    tbkurangipelaku = document.getElementById('tbkurangi' + siapa + counterpelaku);
                    tbkurangipelaku.style.display = 'inline';

                    tbtambahpelakuprev = document.getElementById('tbtambah' + siapa + (counterpelaku - 1));
                    tbtambahpelakuprev.style.display = 'none';
                    tbkurangipelakuprev = document.getElementById('tbkurangi' + siapa + (counterpelaku - 1));
                    tbkurangipelakuprev.style.display = 'none';
                    tbkronologiprev = document.getElementById('tbkronologi' + (counterpelaku - 1));
                    tbkronologiprev.style.display = 'none';
                }

            }
        }

    };

    function inputkronologiPelaku() {
        inputkronologi("pelaku");
    }

    function inputkronologi(siapa) {

        if (pilihanview == 'multi') {
            document.getElementById('dif1').style.display = 'none';
            document.getElementById('dif2').style.display = 'none';
            document.getElementById('dif3').style.display = 'none';
            document.getElementById('dif4').style.display = 'none';
            document.getElementById('dif5').style.display = 'block';
        }
        document.getElementById('tb5').classList.remove('tbnonaktif');
        document.getElementById('tb5').classList.add('tbaktif');
        document.getElementById('tb4').classList.remove('active');
        document.getElementById('tb5').classList.add('active');
        document.getElementById('tb5').disabled = false;

        // tbkurangipelakuterlapor = document.getElementById('tbkurangi' + siapa + counterpelaku);
        // tbkurangipelakuterlapor.style.display = 'none';

        // tbtambahpelakuterlapor = document.getElementById('tbtambah' + siapa + counterpelaku);
        // tbtambahpelakuterlapor.style.display = 'none';

        tbkronologi = document.getElementById('tbkronologi' + counterpelaku);
        tbkronologi.style.display = 'none';

        const kronologiDiv = document.getElementById('kronologi');

        kronologiDiv.classList.add('fade-in');
        kronologiDiv.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }

    function submitkronologi() {

        if (pilihanview == 'multi') {
            // document.getElementById('dif5').style.display = 'none';
            //document.getElementById('dif6').style.display = 'block';
            // document.getElementById('tb6').classList.remove('tbnonaktif');
            // document.getElementById('tb6').classList.add('tbaktif');
            // document.getElementById('tb5').classList.remove('active');
            // document.getElementById('tb6').classList.add('active');
            // document.getElementById('tb6').disabled = false;
        }

        valid = true;

        document.getElementById('tbkronologi').style.display = 'none';
        event.preventDefault();

        var xnoreg = "<?= $nomor_register ?>";
        var xtgl_lapor = $('#datepicker1').val();
        var xtgl_kasus = $('#datepicker2').val();

        var xsts_kasus = statuskasus;
        var terlapor_meninggal = $('input[name="terlapor_meninggal"]:checked').length > 0 ? "tm," : "";
        var korban_tidak_ditemukan = $('input[name="korban_tidak_ditemukan"]:checked').length > 0 ? "ktd," : "";
        var pembuktian_belum_cukup = $('input[name="pembuktian_belum_cukup"]:checked').length > 0 ? "pbc," : "";
        var alasan_dihentikan = terlapor_meninggal + korban_tidak_ditemukan + pembuktian_belum_cukup;

        var bentuk_kekerasan = "";
        <?php foreach ($daf_bentuk_kekerasan as $bentuk) {
            echo "var k_" . $bentuk['bentuk_kekerasan_id'] . " = $('input[name=\"k_" . $bentuk['bentuk_kekerasan_id'] . "\"]:checked').length > 0 ? 'k" . $bentuk['bentuk_kekerasan_id'] . ",' : '';\n";
            echo "bentuk_kekerasan = bentuk_kekerasan + k_" . $bentuk['bentuk_kekerasan_id'] . ";";
        } ?>

        if (bentuk_kekerasan == "") {
            document.getElementById('infobentukkekerasan').innerHTML = "Pilih minimal 1 bentuk kekerasan";
            valid = false;
        } else {

        }

        var cakupan_kekerasan = "";
        const rbCakupan = document.querySelectorAll('input[name="cakupan"]');
        var pilcakupan = 0;
        rbCakupan.forEach((radio) => {
            if (radio.checked) {
                pilcakupan++;
                cakupan_kekerasan = radio.value;
            }
        });

        if (pilcakupan == 0) {
            document.getElementById('infocakupan').innerHTML = "Pilih cakupan kekerasan";
            valid = false;
        } else {

        }

        var kronologi = $('#ikronologi').val();

        if (kronologi == "") {
            document.getElementById('infokronologi').innerHTML = "Tuliskan kronologi peristiwa";
            valid = false;
        } else {

        }

        valid2 = false;

        if (valid) {
            semuakorban = 0;
            semuapelaku = 0;
            for (var a = 1; a <= counterkorban; a++) {
                semuakorban = semuakorban + statuskorbanok[a];
            }
            for (var a = 1; a <= counterpelaku; a++) {
                semuapelaku = semuapelaku + statuspelakuok[a];
            }
            if (semuakorban == counterkorban && semuapelaku == counterpelaku) {
                if (confirm("Silakan periksa kembali. Data yang sudah dimasukkan tidak dapat dihapus")) {
                    valid2 = true;
                }
            } else {
                alert("Ada korban / pelaku yang belum selesai pengisian datanya atau belum dikonfirmasi");
            }
        }


        if (valid2) {
            {
                //////////// KUNCI KRONOLOGI =============================
                document.getElementById('infobentukkekerasan').innerHTML = "";
                <?php foreach ($daf_bentuk_kekerasan as $bentuk) {
                    echo "$('input[name=\"k_" . $bentuk['bentuk_kekerasan_id'] . "\"]').prop('disabled', true);";
                } ?>

                document.getElementById('infocakupan').innerHTML = "";
                rbCakupan.forEach((radio) => {
                    radio.disabled = true;
                });

                document.getElementById('ikronologi').disabled = true;
                document.getElementById('infokronologi').innerHTML = "";

                document.getElementById('tbsubmitkronologi').style.display = 'none';

                ////////////////////////===================================

                /////////////////// data korban dan pelaku ////////////
                // var selectedValue = $('#daftarpd' + siapa + idx).val();
                // var selectedDataInduk = $('#daftarpd' + siapa + idx + ' option:selected').data('induk');
                ///////////////////////////////////////////////////////
                let dataKorban = []; // Array untuk menampung data korban

                for (let i = 1; i <= counterkorban; i++) {
                    let status = pilstatus['korban'][i];
                    // alert("Status korban" + status);
                    let nik = $(`#nikkorban${i}`).val();
                    let nikpdptk = $(`#nikpdptkkorban${i}`).val();
                    let npsn = $(`#npsnkorban${i}`).val();
                    let nisn = $(`#nisnkorban${i}`).val();
                    // let nama = $(`#namakorban${i}`).val();

                    namaortunya = "";
                    statusortunya = "";
                    if (sebagai == "sekolah") {
                        if (status == 1) {
                            namakorbannya = $(`#daftarpdkorban${i} option:selected`).text();
                            ver_nama = $(`#infodaftarpdkorban${i}`).html();
                            ver_nik = $(`#infonikpdptkkorban${i}`).html();
                        } else if (status == 2) {
                            namakorbannya = $(`#daftarpdkorban${i} option:selected`).text();
                            namaortunya = $(`#namaortukorban${i}`).val();
                            statusortunya = $(`#statusortukorban${i}`).val();
                            ver_nama = $(`#infonamaortukorban${i}`).html();
                            ver_nik = $(`#infonikpdptkkorban${i}`).html();
                        } else if (window['isikorbanmanual'][i] == true) {
                            namakorbannya = $(`#namakorban${i}`).val();
                            ver_nama = $(`#infonamakorban${i}`).html();
                            ver_nik = $(`#infonikpdptkkorban${i}`).html();
                        } else if (status == 3) {
                            namakorbannya = $(`#daftarptkkorban${i} option:selected`).text();
                            ver_nama = $(`#infodaftarptkkorban${i}`).html();
                            ver_nik = $(`#infonikpdptkkorban${i}`).html();
                        } else if (status == 4) {
                            namakorbannya = $(`#daftarptk2korban${i} option:selected`).text();
                            ver_nama = $(`#infodaftarptk2korban${i}`).html();
                            ver_nik = $(`#infonikpdptkkorban${i}`).html();
                        } else if (status == 5) {
                            namakorbannya = $(`#daftarkepsekkorban${i} option:selected`).text();
                            ver_nama = $(`#infodaftarkepsekkorban${i}`).html();
                            ver_nik = $(`#infonikpdptkkorban${i}`).html();
                        } else {
                            namakorbannya = $(`#namakorban${i}`).val();
                            ver_nama = $(`#infonamakorban${i}`).html();
                            ver_nik = $(`#infonikkorban${i}`).html();
                            npsn = "";
                            nisn = "";
                        }

                        if (namakorbannya == "-- Input Manual --") {
                            namakorbannya = $(`#namakorban${i}`).val();
                            ver_nama = $(`#infonamakorban${i}`).html();
                        }
                    } else {
                        if (status == 2) {
                            namakorbannya = $(`#namakorban${i}`).val();
                            namaortunya = $(`#namaortukorban${i}`).val();
                            statusortunya = $(`#statusortukorban${i}`).val();
                            ver_nama = $(`#infonamaortukorban${i}`).html();
                            ver_nik = $(`#infonikkorban${i}`).html();
                        } else {
                            namakorbannya = $(`#namakorban${i}`).val();
                            ver_nama = $(`#infonamakorban${i}`).html();
                            ver_nik = $(`#infonikpdptkkorban${i}`).html();
                        }
                    }

                    let nama = namakorbannya;
                    let nama2 = namaortunya;
                    let statusortu = statusortunya;

                    let jenis_kelamin = $(`input[name='jenis_kelaminkorban${i}']:checked`).val();
                    let nama_sekolah = $(`#sekolahkorban${i}`).val();
                    let disabilitas = $(`input[name='disabilitaskorban${i}']:checked`).val();
                    // let inputdisabilitas = $(`#inputdisabilitaskorban${i}`).val();
                    var tgl_lahir_masy = $(`#datepickerkorban${i}`).val();
                    var usia = $(`#usiakorban${i}`).val();
                    var alamat = $(`#alamatkorban${i}`).val();
                    var jumlahKB = 0;
                    dafkodeKB.forEach(function(element) {
                        if ($('#checkbox' + element + "korban" + i).prop('checked')) {
                            // selectedCheckboxes.push($('#checkbox' + element + siapa + idx).val());
                            jumlahKB += parseInt($('#checkbox' + element + "korban" + i).val());
                        }
                    });

                    // provinsi = $(`#provinsikorban${i}`).val();
                    // kota = $(`#kotakorban${i}`).val();
                    kecamatan = $(`#kecamatankorban${i}`).val();
                    desa = $(`#desakorban${i}`).val();

                    var kodewilayah = desa;
                    if (desa == "-") {
                        kodewilayah = kecamatan;
                    }

                    var urutan = i;

                    // Buat objek untuk setiap data korban
                    // alert(nama + "," + status + ",");

                    let korbanData = {
                        urutan: urutan,
                        status: status,
                        nikpdptk: nikpdptk,
                        nik: nik,
                        npsn: npsn,
                        nisn: nisn,
                        nama: nama,
                        nama2: nama2,
                        ver_nama: ver_nama,
                        ver_nik: ver_nik,
                        statusortu: statusortu,
                        jenis_kelamin: jenis_kelamin,
                        nama_sekolah: nama_sekolah,
                        disabilitas: disabilitas,
                        inputdisabilitas: jumlahKB,
                        tgl_lahir: tgl_lahir_masy,
                        usia: usia,
                        alamat: alamat,
                        kodewilayah: kodewilayah,
                    };

                    dataKorban.push(korbanData);
                }

                let dataPelaku = [];

                for (let i = 1; i <= counterpelaku; i++) {
                    let status = pilstatus['pelaku'][i];
                    // alert("Status pelaku" + status);
                    let nik = $(`#nikpelaku${i}`).val();
                    let nikpdptk = $(`#nikpdptkpelaku${i}`).val();
                    let npsn = $(`#npsnpelaku${i}`).val();
                    let nisn = $(`#nisnpelaku${i}`).val();
                    // let nama = $(`#namapelaku${i}`).val();
                    namaortunya = "";
                    statusortunya = "";
                    if (sebagai == "sekolah") {
                        if (status == 1) {
                            namapelakunya = $(`#daftarpdpelaku${i} option:selected`).text();
                            ver_nama = $(`#infodaftarpdpelaku${i}`).html();
                            ver_nik = $(`#infonikpdptkpelaku${i}`).html();
                        } else if (status == 2) {
                            namapelakunya = $(`#daftarpdpelaku${i} option:selected`).text();
                            namaortunya = $(`#namaortupelaku${i}`).val();
                            statusortunya = $(`#statusortupelaku${i}`).val();
                            ver_nama = $(`#infonamaortupelaku${i}`).html();
                            ver_nik = $(`#infonikpdptkpelaku${i}`).html();
                        } else if (window['isipelakumanual'][i] == true) {
                            namapelakunya = $(`#namapelaku${i}`).val();
                            ver_nama = $(`#infonamapelaku${i}`).html();
                            ver_nik = $(`#infonikpdptkpelaku${i}`).html();
                        } else if (status == 3) {
                            namapelakunya = $(`#daftarptkpelaku${i} option:selected`).text();
                            ver_nama = $(`#infodaftarptkpelaku${i}`).html();
                            ver_nik = $(`#infonikpdptkpelaku${i}`).html();
                        } else if (status == 4) {
                            namapelakunya = $(`#daftarptk2pelaku${i} option:selected`).text();
                            ver_nama = $(`#infodaftarptk2pelaku${i}`).html();
                            ver_nik = $(`#infonikpdptkpelaku${i}`).html();
                        } else if (status == 5) {
                            namapelakunya = $(`#daftarkepsekpelaku${i} option:selected`).text();
                            ver_nama = $(`#infodaftarkepsekpelaku${i}`).html();
                            ver_nik = $(`#infonikpdptkpelaku${i}`).html();
                        } else {
                            namapelakunya = $(`#namapelaku${i}`).val();
                            ver_nama = $(`#infonamapelaku${i}`).html();
                            ver_nik = $(`#infonikpelaku${i}`).html();
                            npsn = "";
                            nisn = "";
                        }

                        if (namapelakunya == "-- Input Manual --") {
                            namapelakunya = $(`#namapelaku${i}`).val();
                            ver_nama = $(`#infonamapelaku${i}`).html();
                        }
                    } else {
                        if (status == 2) {
                            namapelakunya = $(`#namapelaku${i}`).val();
                            namaortunya = $(`#namaortupelaku${i}`).val();
                            statusortunya = $(`#statusortupelaku${i}`).val();
                            ver_nama = $(`#infonamaortupelaku${i}`).html();
                            ver_nik = $(`#infonikpelaku${i}`).html();
                        } else {
                            namapelakunya = $(`#namapelaku${i}`).val();
                            ver_nama = $(`#infonamapelaku${i}`).html();
                            ver_nik = $(`#infonikpdptkpelaku${i}`).html();
                        }
                    }

                    let nama = namapelakunya;
                    let nama2 = namaortunya;
                    let statusortu = statusortunya;

                    let jenis_kelamin = $(`input[name='jenis_kelaminpelaku${i}']:checked`).val();
                    let nama_sekolah = $(`#sekolahpelaku${i}`).val();
                    let disabilitas = $(`input[name='disabilitaspelaku${i}']:checked`).val();
                    // let inputdisabilitas = $(`#inputdisabilitaspelaku${i}`).val();
                    var tgl_lahir_masy = $(`#datepickerpelaku${i}`).val();
                    var usia = $(`#usiapelaku${i}`).val();
                    var alamat = $(`#alamatpelaku${i}`).val();
                    var jumlahKB = 0;
                    dafkodeKB.forEach(function(element) {
                        if ($('#checkbox' + element + "pelaku" + i).prop('checked')) {
                            // selectedCheckboxes.push($('#checkbox' + element + siapa + idx).val());
                            jumlahKB += parseInt($('#checkbox' + element + "pelaku" + i).val());
                        }
                    });

                    kecamatan = $(`#kecamatanpelaku${i}`).val();
                    desa = $(`#desapelaku${i}`).val();

                    var kodewilayah = desa;
                    if (desa == "-") {
                        kodewilayah = kecamatan;
                    }

                    var urutan = i;

                    let pelakuData = {
                        urutan: urutan,
                        status: status,
                        nikpdptk: nikpdptk,
                        nik: nik,
                        npsn: npsn,
                        nisn: nisn,
                        nama: nama,
                        nama2: nama2,
                        ver_nama: ver_nama,
                        ver_nik: ver_nik,
                        statusortu: statusortu,
                        jenis_kelamin: jenis_kelamin,
                        nama_sekolah: nama_sekolah,
                        disabilitas: disabilitas,
                        inputdisabilitas: jumlahKB,
                        tgl_lahir: tgl_lahir_masy,
                        usia: usia,
                        alamat: alamat,
                        kodewilayah: kodewilayah,
                    };

                    dataPelaku.push(pelakuData);
                }

                alamat = '<?= base_url() . "inputdata/simpan_kasus" ?>';

                $.ajax({
                    type: 'POST',
                    url: alamat,
                    data: {
                        ceknpsn: '<?= $npsn ?>',
                        cekkodewilayah: '<?= $wilayah ?>',
                        cekinstansi: '<?= $sebagai ?>',
                        xnoreg: xnoreg,
                        xtgl_lapor: xtgl_lapor,
                        xtgl_kasus: xtgl_kasus,
                        xsts_kasus: xsts_kasus,
                        alasan_dihentikan: alasan_dihentikan,
                        bentuk_kekerasan: bentuk_kekerasan,
                        cakupan_kekerasan: cakupan_kekerasan,
                        kronologi: kronologi,
                        datakorban: dataKorban,
                        datapelaku: dataPelaku,
                        csrf_test_name: csrf,
                    },
                    success: function(response) {
                        document.getElementById('dif6').style.display = 'block';
                        akhirDiv.classList.add('fade-in');
                        akhirDiv.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                        disabledall();
                    },
                    error: function() {
                        alert('Terjadi kesalahan saat mengirim data.');
                    }
                });
            }
        }
    };

    function disabledall() {
        var inputs = document.querySelectorAll('input, textarea, select, button');
        var tbdaftar = document.getElementById('tbdaftar');
        var toggle = document.getElementById('toggle');
        var tb1 = document.getElementById('tb1');
        var tb2 = document.getElementById('tb2');
        var tb3 = document.getElementById('tb3');
        var tb4 = document.getElementById('tb4');
        var tb5 = document.getElementById('tb5');

        for (var i = 0; i < inputs.length; i++) {
            if (inputs[i] !== tbdaftar && inputs[i] !== toggle && inputs[i] !== tb1 && inputs[i] !== tb2 && inputs[i] !== tb3 && inputs[i] !== tb4 && inputs[i] !== tb5) {
                inputs[i].disabled = true;
            }
        }
    }

    function validasiTanggal(idx) {
        var input = document.getElementById('datepicker' + idx).value;
        var regex = /^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[0-2])\/\d{4}$/;

        if (regex.test(input)) {
            document.getElementById('errorTanggal' + idx).innerHTML = "";
        } else {
            document.getElementById('errorTanggal' + idx).innerHTML = "Format tanggal tidak valid.";
        }
    }

    function validasiTanggalLahirkorban(idx) {
        validasiTanggalLahir("korban", idx);
    }

    function validasiTanggalLahirpelaku(idx) {
        validasiTanggalLahir("pelaku", idx);
    }

    function validasiTanggalLahir(siapa, idx) {
        var input = document.getElementById('datepicker' + siapa + idx).value;
        var regex = /^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[0-2])\/\d{4}$/;

        if (regex.test(input)) {
            document.getElementById('errorTanggalLahir' + siapa + idx).style.display = 'none';
            var parts = input.split("/");
            var birthDate = new Date(parts[2], parts[1] - 1, parts[0]);
            var today = new Date();
            var age = today.getFullYear() - birthDate.getFullYear();

            if (today.getMonth() < birthDate.getMonth() || (today.getMonth() === birthDate.getMonth() && today.getDate() < birthDate.getDate())) {
                age--;
            }
            document.getElementById('usia' + siapa + idx).value = age;
            document.getElementById('infousia' + siapa + idx).style.display = 'none';
        } else {
            if (input != "")
                document.getElementById('errorTanggalLahir' + siapa + idx).style.display = 'block';
        }
    }

    function toggleInput(siapa, radio, idx) {
        var input = document.getElementById('opsidisabilitasRow' + siapa + idx);
        if (radio.value === '1') {
            input.style.display = 'block';
        } else {
            input.style.display = 'none';
        }
    }

    const buttons = document.querySelectorAll('.btn_abu');

    buttons.forEach(button => {
        button.addEventListener('click', function() {
            buttons.forEach(btn => btn.classList.remove('clicked'));
            this.classList.add('clicked');
        });
    });
</script>
<script>
    $(function() {
        $("#datepicker1").datepicker({
            dateFormat: 'dd/mm/yy',
            changeMonth: true,
            changeYear: true,
            yearRange: "c-100:c+10"
        });

        $("#datepicker2").datepicker({
            dateFormat: 'dd/mm/yy',
            changeMonth: true,
            changeYear: true,
            yearRange: "c-100:c+10"
        });

        $("#datepicker").datepicker({
            dateFormat: 'dd/mm/yy',
            changeMonth: true,
            changeYear: true,
            yearRange: "c-100:c+10"
        });
    });
</script>

<script>
    const modal = document.getElementById('myModal');
    const spanClose = document.getElementsByClassName('close')[0];
    var modalterakhir;
    var idxterakhir;

    function tampilmodalkorban(idx) {
        tampilmodal("korban", idx);
    }

    function tampilmodalpelaku(idx) {
        tampilmodal("pelaku", idx);
    }

    function tampilmodal(siapa, idx) {
        modal.style.display = 'block';
        modalterakhir = siapa;
        idxterakhir = idx;
    };

    spanClose.onclick = function() {
        modal.style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }

    document.querySelector('#namaSekolahInput').addEventListener('change', function(event) {
        changecari();
    });

    document.querySelector('#namaSekolahInput').addEventListener('input', function(event) {
        changecari();
    });

    function changecari() {
        document.getElementById("infocarisekolah").innerHTML = "";
    }

    function submitSekolah() {
        var tableBody = document.querySelector("#myTable tbody");
        var namaSekolah = document.querySelector('#namaSekolahInput').value;
        var tbcari = document.getElementById("tbcari");
        var infocari = document.getElementById("infocarisekolah");


        var valid = true;
        if (namaSekolah == parseInt(namaSekolah) && namaSekolah.length != 8) {
            infocari.innerHTML = "NPSN adalah 8 digit";
            valid = false;
        }

        if (valid) {
            tbcari.innerText = "tunggu...";

            $.ajax({
                type: 'GET',
                url: '<?= base_url() ?>inputdata/cari_sekolah',
                data: {
                    nama_sekolah: namaSekolah
                },
                success: function(response) {
                    var hasiltabel = document.getElementById('hasiltabel');
                    var sekolahrow = document.getElementById('sekolahRow' + modalterakhir + idxterakhir);
                    var sekolah = document.getElementById('sekolah' + modalterakhir + idxterakhir);
                    var tbnpsn = document.getElementById('tbnpsn' + modalterakhir + idxterakhir);
                    tableBody.innerHTML = "";
                    if (response == "") {
                        var row = document.createElement("tr");

                        var cell1 = document.createElement("td");
                        var cell2 = document.createElement("td");
                        var cell3 = document.createElement("td");
                        cell1.textContent = "";
                        cell2.textContent = "";
                        cell3.textContent = "";
                        row.appendChild(cell1);
                        row.appendChild(cell2);
                        row.appendChild(cell3);

                        tableBody.appendChild(row);
                        hasiltabel.style.display = 'block';
                        tbcari.innerText = "Cari";
                        document.getElementById('infonpsn' + modalterakhir + idxterakhir).innerHTML = "";
                    } else {
                        response.forEach(function(item) {
                            var row = document.createElement("tr");

                            var cell1 = document.createElement("td");
                            var cell2 = document.createElement("td");
                            var cell3 = document.createElement("td");

                            cell1.textContent = item.npsn;
                            cell2.textContent = item.nama_sekolah;
                            cell3.textContent = item.kota;

                            row.appendChild(cell1);
                            row.appendChild(cell2);
                            row.appendChild(cell3);

                            row.addEventListener("click", function() {
                                document.getElementById('npsn' + modalterakhir + idxterakhir).value = item.npsn;
                                sekolahrow.style.display = 'table-row';
                                tbnpsn.style.display = 'none';
                                sekolahrow.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'start'
                                });
                                sekolah.value = item.nama_sekolah;
                                modal.style.display = 'none';
                                var xstatus = "-";
                                var kec = item.kecamatan.substring(5);
                                var kota = "";
                                sekolah.value = item.nama_sekolah;
                                if (item.status_sekolah == 1)
                                    xstatus = "Negeri";
                                else if (item.status_sekolah == 2)
                                    xstatus = "Swasta";

                                if (item.kota.substring(0, 3) == "Kab.")
                                    kota = "Kab: " + item.kota.substring(5);
                                else
                                    kota = "Kota: " + item.kota.substring(5);

                                var provinsi = item.provinsi.substring(6);
                                document.getElementById('infosekolah' + modalterakhir + idxterakhir).innerHTML = "<div style='color:black; margin-left:10px'>Status: " + xstatus + "<br> Kec: " + kec + " <br> " + kota + " <br> Provinsi: " + provinsi + " </div>"
                            });

                            tableBody.appendChild(row);
                            hasiltabel.style.display = 'block';
                            tbcari.innerText = "Cari";
                            document.getElementById('infonpsn' + modalterakhir + idxterakhir).innerHTML = "";


                        });
                    }
                },


                error: function() {
                    alert('Gagal memuat data sekolah.');
                }
            });
        }
    }

    function pilihSekolah(npsn, namaSekolah) {
        // alert(npsn);
        // document.getElementById('npsnkorban').value = npsn;

        // var sekolahRow = document.getElementById('sekolahRowkorban');
        // sekolahRow.style.display = 'table-row';
        // sekolahRow.innerHTML = '<td>Nama Sekolah</td><td>:</td><td>' + namaSekolah + '</td>';
    }

    function getkota(siapa, id, selectedProvinsi) {
        document.getElementById('infoprovinsi' + siapa + id).innerHTML = "";
        $.ajax({
            type: 'GET',
            url: '<?= base_url() . "inputdata/get_daf_kota" ?>',
            data: {
                kodeprov: selectedProvinsi
            },
            dataType: 'json',
            success: function(data) {
                var desaSelect = $('#desa' + siapa + id);
                desaSelect.empty();
                desaSelect.append('<option value = "-"> - pilih desa - </option>');
                var kecamatanSelect = $('#kecamatan' + siapa + id);
                kecamatanSelect.empty();
                kecamatanSelect.append('<option value = "-"> - pilih kecamatan - </option>');
                var kotaSelect = $('#kota' + siapa + id);
                kotaSelect.empty();
                kotaSelect.append('<option value="-"> - pilih kota/kab - </option>');
                $.each(data, function(key, value) {
                    kotaSelect.append('<option value="' + value.kode_wilayah + '">' + value.nama + '</option>');
                });
            }
        });
    }

    function getkecamatan(siapa, id, selectedKota) {
        document.getElementById('infokota' + siapa + id).innerHTML = "";
        $.ajax({
            type: 'GET',
            url: '<?= base_url() . "inputdata/get_daf_kecamatan" ?>',
            data: {
                kodekota: selectedKota
            },
            dataType: 'json',
            success: function(data) {
                var desaSelect = $('#desa' + siapa + id);
                desaSelect.empty();
                desaSelect.append('<option value = "-"> - pilih desa - </option>');
                var kecamatanSelect = $('#kecamatan' + siapa + id);
                kecamatanSelect.empty();
                kecamatanSelect.append('<option value = "-"> - pilih kecamatan - </option>');
                $.each(data, function(key, value) {
                    kecamatanSelect.append('<option value="' + value.kode_wilayah + '">' + value.nama + '</option>');
                });
            }
        });
    }

    function getdesa(siapa, id, selectedKecamatan) {
        document.getElementById('infokecamatan' + siapa + id).innerHTML = "";
        $.ajax({
            type: 'GET',
            url: '<?= base_url() . "inputdata/get_daf_desa" ?>',
            data: {
                kodekecamatan: selectedKecamatan
            },
            dataType: 'json',
            success: function(data) {
                var desaSelect = $('#desa' + siapa + id);
                desaSelect.empty();
                desaSelect.append('<option value = "-"> - pilih desa - </option>');
                $.each(data, function(key, value) {
                    desaSelect.append('<option value="' + value.kode_wilayah + '">' + value.nama + '</option>');
                });
            }
        });
    }

    function kliropsi(siapa, id) {
        var kotaSelect = $('#kota' + siapa + id);
        kotaSelect.empty();
        kotaSelect.append('<option value="0">-</option>');
        var kecamatanSelect = $('#kecamatan' + siapa + id);
        kecamatanSelect.empty();
        kecamatanSelect.append('<option value="0">-</option>');
        var desaSelect = $('#desa' + siapa + id);
        desaSelect.empty();
        desaSelect.append('<option value="0">-</option>');
    }

    function tampilinfoketunaan() {
        window.open("<?= base_url() ?>informasi/ketunaan", "_blank");
    }
</script>


<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<?= $this->endSection(); ?>