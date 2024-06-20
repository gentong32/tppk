<?= $this->extend('layout/default') ?>
<?= $this->section('header') ?>
<?php $csrfToken = csrf_hash(); ?>

<link rel="stylesheet" href="<?= base_url() ?>css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="<?= base_url() ?>css/responsive.dataTables.min.css" />

<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<!-- <script src="<?= base_url() ?>js/jquery-3.5.1.js"></script> -->
<script src="<?= base_url() ?>js/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>js/dataTables.responsive.min.js"></script>

<style>
    /* CSS untuk modal */
    .modal {
        display: none;
        /* Tetapkan awalnya menjadi display none */
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
        /* Latar belakang redup */
    }

    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    }

    /* Tombol close */
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
        transition: opacity 0.5s ease-in-out;
        padding: 20px;
    }

    #isian {
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

    .terlapor {
        display: none;
        transition: opacity 0.5s ease-in-out;
        padding: 20px;
    }

    #kronologi {
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
        /* Mengurangi 16px untuk padding */
        padding: 6px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        background-color: white;
        /* Menyesuaikan padding ke dalam lebar input */
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
        <button id="tb2" class="tabs tbaktif" onclick="showTabContent('dif2')">Laporan</button>
        <button id="tb3" class="tabs tbaktif" onclick="showTabContent('dif3')">Korban</button>
        <button id="tb4" class="tabs tbaktif" onclick="showTabContent('dif4')">Pelaku</button>
        <button id="tb5" class="tabs tbaktif" onclick="showTabContent('dif5')">Kronologi</button>
        <button style="display: none;" id="tb6" class="tabs tbaktif" onclick="showTabContent('dif6')">Terimakasih</button>
    </div>

    <div id="dif1">
        <div class="atas">
            <table class="tabelinfo">
                <tr>
                    <th class="merah">RAHASIA</th>
                </tr>
                <tr>
                    <td><b>Pernyataan yang perlu diisi oleh TPPK:</b><br><br>
                        Saya, yang mengisi formulir ini, menyatakan bahwa informasi yang saya sampaikan adalah benar adanya. Saya bersedia menjamin bahwa saya tidak menyebarluaskan informasi yang saya isi di formulir kepada publik. Saya siap diproses secara hukum jika terbukti menyebarluaskan informasi yang saya catat.
                        <br><br>
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
                        Tanggal penerimaan laporan *
                    </td>
                    <td>:</td>
                    <td><input disabled type="text" id="datepicker1" name="datepicker1" onblur="validasiTanggal(1)" value="<?= tgl_jam(substr($data_pelaporan['tanggal_pelaporan'], 0, 10)) ?>">
                        <span id="errorTanggal" style="color: red; display: none;">Format tanggal tidak valid.</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        Tanggal kejadian *
                    </td>
                    <td>:</td>
                    <td><input disabled type="text" id="datepicker2" name="datepicker2" onblur="validasiTanggal(2)" value="<?= tgl_jam(substr($data_pelaporan['tanggal_kejadian'], 0, 10)) ?>">
                        <span id="errorTanggal" style="color: red; display: none;">Format tanggal tidak valid.</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        Apakah kasus kekerasan sudah terbukti?
                    </td>
                    <td>:</td>
                    <td>
                        <button class="btn_abu <?= ($data_pelaporan['status_kasus'] == 1) ? 'clicked' : 'disabled' ?>" id="tbya">Ya</button><br>
                        <button class="btn_abu <?= ($data_pelaporan['status_kasus'] == 2) ? 'clicked' : 'disabled' ?>" id="tbtidak">Tidak</button><br>
                        <button class="btn_abu <?= ($data_pelaporan['status_kasus'] == 3) ? 'clicked' : 'disabled' ?>" id="tbstop">Kasus Dihentikan</button>
                    </td>
                </tr>
                <tr id="alasanDihentikan" style="display:none;">
                    <td>Alasan kasus dihentikan</td>
                    <td>:</td>
                    <td>
                        <div class="checkbox-container">
                            <input type="checkbox" name="terlapor_meninggal">
                            Terlapor meninggal dunia/tidak ditemukan/sakit berat berdasarkan keterangan dokter
                        </div>
                        <div class="checkbox-container">
                            <input type="checkbox" name="korban_tidak_ditemukan">
                            Korban tidak ditemukan
                        </div>
                        <div class="checkbox-container">
                            <input type="checkbox" name="pembuktian_belum_cukup">
                            Pembuktian belum cukup
                        </div>
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
                        <td><input type="text" placeholder="" id="npsnkorban" name="npsnkorban" value="<?= $npsn ?>">
                            <span class="info" id="infonpsnkorban"></span>
                            <button id="tbnpsnkorban" class="btn_abu2" onclick="submitnpsnkorban(0)">Submit</button>
                            <button id="tbcarisekolahkorban" onclick="tampilmodal()" class="btn_abu2">Cari NPSN/Sekolah</button>
                        </td>
                    </tr>
                    <tr id="sekolahRowkorban" style="display: none;">
                        <td>
                            Nama Sekolah / Instansi Korban
                        </td>
                        <td>:</td>
                        <td><textarea id="sekolahkorban" name="sekolahkorban"></textarea>
                            <span class="info" id="infosekolahkorban"></span>
                            <button onclick="konfirmsekolahkorban(0)" id="tbsekolahkorban" class="btn_abu2">Konfirm</button>
                        </td>
                    </tr>
                    <tr id="nisnRowkorban" style="display: none;">
                        <td>
                            NISN / NUPTK Korban
                        </td>
                        <td>:</td>
                        <td><input type="text" placeholder="" id="nisnkorban" name="nisnkorban">
                            <span class="info" id="infonisnkorban"></span><br>
                            <button onclick="ceknisnkorban(0)" id="tbnisnkorban" class="btn_abu2">Cek</button>
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
                        <td><input type="text" placeholder="" id="nikpdptkkorban" name="nikpdptkkorban">
                            <span class="info" id="infonikpdptkkorban"></span><br>
                            <button style="display: none;" onclick="ceknikpdptkkorban(0)" id="tbnikpdptkkorban" class="btn_abu2">Konfirm</button>
                        </td>
                    </tr>
                    <tr id="nikRowkorban" style="display: none;">
                        <td>
                            NIK Korban *
                        </td>
                        <td>:</td>
                        <td><select class="pilortu" id="statusortukorban">
                                <option value="ayah">Ayah</option>
                                <option value="ibu">Ibu</option>
                                <option value="wali">Wali Murid</option>
                            </select>
                            <input type="text" placeholder="" id="nikkorban" name="nikkorban">
                            <span class="info" id="infonikkorban"></span><br>
                            <button onclick="ceknikkorban(0)" id="tbnikkorban" class="btn_abu2">OK</button>
                        </td>
                    </tr>
                    <tr id="namaortuRowkorban" style="display: none;">
                        <td>
                            Nama Korban *
                        </td>
                        <td>:</td>
                        <td><textarea id="namaortukorban" name="namaortukorban"></textarea>
                            <span class="info" id="infonamaortukorban"></span><br>
                            <!-- <button style="display: none;" onclick="konfirmnamaortukorban(0)" id="tbnamaortukorban" class="btn_abu2">Konfirm</button> -->
                        </td>
                    </tr>
                    <tr id="tgllahirRowkorban" style="display: none;">
                        <td>
                            Tanggal Lahir Korban
                        </td>
                        <td>:</td>
                        <td><input type="text" id="datepickerkorban" name="datepickerkorban" onblur="validasiTanggalLahir()" placeholder="dd/mm/yyyy" value="">
                            <span id="errorTanggalLahirkorban" style="color: red; display: none;">Format tanggal tidak valid.</span>
                        </td>
                    </tr>
                    <tr id="usiaRowkorban" style="display: none;">
                        <td>
                            Usia Korban
                        </td>
                        <td>:</td>
                        <td>
                            <input type="text" placeholder="" id="usiakorban" name="usiakorban" style="display: none;">
                            <span class="info" id="infousiakorban"></span>
                        </td><br>
                        <!-- <button onclick="cekusiakorban(0)" id="tbusiakorban" class="btn_abu2">OK</button> -->
                    </tr>
                    <tr id="jenis_kelaminRowkorban" style="display: none;">
                        <td>
                            Jenis Kelamin Korban *
                        </td>
                        <td>:</td>
                        <td>
                            <input type="radio" name="jenis_kelaminkorban" value="L"> Laki-laki<br>
                            <input type="radio" name="jenis_kelaminkorban" value="P"> Perempuan<br>
                            <span class="info" id="infojenis_kelaminkorban"></span><br>
                            <button style="display: none;" onclick="konfirmjenis_kelaminkorban(0)" id="tbjenis_kelaminkorban" class="btn_abu2">Konfirm</button>
                        </td>
                    </tr>
                    <tr id="alamatRowkorban" style="display: none;">
                        <td>
                            Alamat Korban *
                        </td>
                        <td>:</td>
                        <td><input type="text" placeholder="" id="alamatkorban" name="alamatkorban" style="display: none;">
                            <span class="info" id="infoalamatkorban"></span>
                        </td><br>
                        <!-- <button onclick="cekusiakorban(0)" id="tbusiakorban" class="btn_abu2">OK</button> -->
                    </tr>
                    <tr id="provinsiRowkorban" style="display: none;">
                        <td>
                            Provinsi
                        </td>
                        <td>:</td>
                        <td>
                            <select class="pilortu" id="provinsikorban" onchange="getkota(0, this.value);">
                                <option value="-"> - pilih provinsi - </option>
                                <?php foreach ($daf_provinsi as $provinsi) : ?>
                                    <option value="<?= $provinsi['kode_wilayah'] ?>"><?= $provinsi['nama'] ?></option>

                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr id="kotaRowkorban" style="display: none;">
                        <td>
                            Kab / Kota
                        </td>
                        <td>:</td>
                        <td>
                            <select class="pilortu" id="kotakorban" onchange="getkecamatan(0, this.value);">
                                <option> - pilih kota/kab - </option>
                            </select>
                        </td>
                    </tr>
                    <tr id="kecamatanRowkorban" style="display: none;">
                        <td>
                            Kecamatan
                        </td>
                        <td>:</td>
                        <td>
                            <select class="pilortu" id="kecamatankorban" onchange="getdesa(0, this.value);">
                                <option> - pilih kecamatan - </option>
                            </select>
                        </td>
                    </tr>
                    <tr id="desaRowkorban" style="display: none;">
                        <td>
                            Desa
                        </td>
                        <td>:</td>
                        <td>
                            <select class="pilortu" id="desakorban">
                                <option> - pilih desa - </option>
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
                                <?php
                                foreach ($daf_kebutuhan_khusus as $row) {
                                    $kd_kb = $row['kebutuhan_khusus'];
                                    $kodeexp = explode("-", $kd_kb);
                                    $kode = trim($kodeexp[0], " ");
                                    echo '<input type="checkbox" value="' . $row['kebutuhan_khusus_id'] . '" id="checkbox' . $kode . 'korban"> ' . $kd_kb . '<br>';
                                }
                                ?>
                            </div>

                            <input type="radio" name="disabilitaskorban" value="0" onclick="toggleInput('korban',this, 1)"> Tidak
                            <span class="info" id="infodisabilitaskorban"></span><br>
                            <br>
                            <button onclick="konfirmdisabilitaskorban(0)" id="tbdisabilitaskorban" class="btn_abu2">Konfirm</button>
                        </td>
                    </tr>
                </table>
                <div style="margin-top: 10px; display:inline">
                    <button id="tbkurangikorban" style="margin-top: 10px; display: none;" class="btn_merah" onclick="kurangiKorban()">HAPUS KORBAN INI</button>
                    <button id="tbtambahkorban" style="margin-top: 10px; display: none;" class="btn_ijo" onclick="tambahKorban()">INPUT KORBAN BERIKUTNYA</button>
                    <button id="tbpelakukorban" style="margin-top: 10px; display: none;" class="btn_ijo" onclick="tambahPelaku()">INPUT PELAKU</button>
                </div>
            </div>

            <?php
            $jmlkorban = 0;
            foreach ($data_korban as $korban) {
                $jmlkorban++;
                $statuskorban = $korban['status_korban_pelaku'];
                $tgllahir = ($korban['tanggal_lahir'] != null) ? substr($korban['tanggal_lahir'], 8, 2) . "/" . substr($korban['tanggal_lahir'], 5, 2) . "/" . substr($korban['tanggal_lahir'], 0, 4) : "-";
            ?>
                <div id="korban<?= $jmlkorban ?>" class="korban" style="display:block">
                    <table class="tabelisian">
                        <tr>
                            <th class="kelabu" colspan="3"><?= ($jmlkorban == 1) ? 'Bagian 1: ' : '' ?>Formulir Korban <?= $jmlkorban ?></th>
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
                                        <input disabled <?= ($status['status_korban_pelaku_id'] == $statuskorban) ? 'checked' : '' ?> onchange="cekstatuskorban(<?= $jmlkorban ?>);" type="radio" name="status_korban<?= $jmlkorban ?>" value="<?= $status['status_korban_pelaku_id'] ?>">
                                        <?= $status['nama'] ?>
                                    </div>
                                <?php endforeach; ?>
                            </td>
                        </tr>
                        <tr id="npsnRowkorban<?= $jmlkorban ?>" <?= ($statuskorban == 6) ? "style='display:none;'" : "" ?>>
                            <td>
                                <?= ($statuskorban == 2) ? "NPSN Peserta Didik *" : "NPSN Korban *" ?>
                            </td>
                            <td>:</td>
                            <td><input disabled type="text" placeholder="" id="npsnkorban<?= $jmlkorban ?>" name="npsnkorban<?= $jmlkorban ?>" value="<?= $korban['npsn'] ?>">
                                <span class="info" id="infonpsnkorban<?= $jmlkorban ?>"></span>
                            </td>
                        </tr>
                        <tr id="sekolahRowkorban<?= $jmlkorban ?>">
                            <td>
                                <?= ($statuskorban < 6 && $statuskorban != 2) ? 'Nama Sekolah Korban *' : (($statuskorban == 2) ? 'Nama Sekolah Peserta Didik *' : 'Instansi Korban') ?>
                            </td>
                            <td>:</td>
                            <td><textarea disabled id="sekolahkorban<?= $jmlkorban ?>" name="sekolahkorban<?= $jmlkorban ?>"><?= $korban['nama_instansi'] ?></textarea>
                                <span class="info" id="infosekolahkorban<?= $jmlkorban ?>"></span>
                                <button style="display: none;" onclick="konfirmsekolahkorban(<?= $jmlkorban ?>)" id="tbsekolahkorban<?= $jmlkorban ?>" class="btn_abu2">Konfirm</button>
                            </td>
                        </tr>
                        <tr id="nisnRowkorban<?= $jmlkorban ?>" <?= ($statuskorban == 6) ? "style='display:none;'" : "" ?>>
                            <td>
                                <?= ($statuskorban == 1) ? 'NISN Korban' : (($statuskorban == 2) ? 'NISN Peserta Didik' : 'NUPTK Korban') ?>
                            </td>
                            <td>:</td>
                            <td><input disabled type="text" placeholder="" id="nisnkorban<?= $jmlkorban ?>" name="nisnkorban<?= $jmlkorban ?>" value="<?= $korban['nisn'] ?>">
                                <span class="info" id="infonisnkorban<?= $jmlkorban ?>"></span><br>
                                <button style="display: none;" onclick="ceknisnkorban(<?= $jmlkorban ?>)" id="tbnisnkorban<?= $jmlkorban ?>" class="btn_abu2">Cek</button>
                            </td>
                        </tr>
                        <tr id="namaRowkorban<?= $jmlkorban ?>">
                            <td>
                                <?= ($statuskorban != 2) ? 'Nama Korban *' : 'Nama Peserta Didik *' ?>
                            </td>
                            <td>:</td>
                            <td><textarea disabled id="namakorban<?= $jmlkorban ?>" name="namakorban<?= $jmlkorban ?>"><?= $korban['nama'] ?></textarea>
                                <span class="info" id="infonamakorban<?= $jmlkorban ?>"></span><br>
                                <!-- <button onclick="konfirmnamakorban(0)" id="tbnamakorban" class="btn_abu2">Konfirm</button> -->
                            </td>
                        </tr>
                        <tr id="nikpdptkRowkorban<?= $jmlkorban ?>" <?= ($statuskorban == 6) ? "style='display:none;'" : "" ?>>
                            <td>
                                NIK Korban *
                            </td>
                            <td>:</td>
                            <td><input disabled type="text" placeholder="" id="nikpdptkkorban<?= $jmlkorban ?>" name="nikpdptkkorban<?= $jmlkorban ?>" value="<?= $korban['nikpdptk'] ?>">
                                <span class="info" id="infonikpdptkkorban<?= $jmlkorban ?>"></span><br>
                                <button style="display: none;" onclick="ceknikpdptkkorban(<?= $jmlkorban ?>)" id="tbnikpdptkkorban<?= $jmlkorban ?>" class="btn_abu2">Konfirm</button>
                            </td>
                        </tr>
                        <tr id="nikRowkorban<?= $jmlkorban ?>" <?= ($statuskorban == 2 || $statuskorban == 6) ? '' : 'style="display:none"' ?>>
                            <td>
                                <?= ($statuskorban != 2) ? 'NIK Korban *' : 'NIK Peserta Didik *' ?>
                            </td>
                            <td>:</td>
                            <td><select <?= ($statuskorban == 6) ? "style='display:none;'" : "" ?> disabled class="pilortu" id="statusortukorban<?= $jmlkorban ?>">
                                    <option <?= ($korban['status_ortu'] == "ayah") ? 'selected' : '' ?> value="ayah">Ayah</option>
                                    <option <?= ($korban['status_ortu'] == "ibu") ? 'selected' : '' ?> value="ibu">Ibu</option>
                                    <option <?= ($korban['status_ortu'] == "wali") ? 'selected' : '' ?> value="wali">Wali Murid</option>
                                </select>
                                <input disabled type="text" placeholder="" id="nikkorban<?= $jmlkorban ?>" name="nikkorban<?= $jmlkorban ?>" value="<?= $korban['nik'] ?>">
                                <span class="info" id="infonikkorban<?= $jmlkorban ?>"></span><br>
                                <button style="display: none;" onclick="ceknikkorban(<?= $jmlkorban ?>)" id="tbnikkorban<?= $jmlkorban ?>" class="btn_abu2">OK</button>
                            </td>
                        </tr>
                        <tr id="namaortuRowkorban<?= $jmlkorban ?>" <?= ($statuskorban == 2) ? '' : 'style="display:none"' ?>>
                            <td>
                                Nama Korban *
                            </td>
                            <td>:</td>
                            <td><textarea disabled id="namaortukorban<?= $jmlkorban ?>" name="namaortukorban<?= $jmlkorban ?>"><?= $korban['nama2'] ?></textarea>
                                <span class="info" id="infonamaortukorban<?= $jmlkorban ?>"></span><br>
                                <!-- <button style="display: none;" onclick="konfirmnamaortukorban(0)" id="tbnamaortukorban" class="btn_abu2">Konfirm</button> -->
                            </td>
                        </tr>
                        <tr id="tgllahirRowkorban<?= $jmlkorban ?>" <?= ($statuskorban == 6) ? '' : 'style="display:none"' ?>>
                            <td>
                                Tanggal Lahir Korban
                            </td>
                            <td>:</td>
                            <td><input disabled type="text" id="datepickerkorban<?= $jmlkorban ?>" name="datepickerkorban<?= $jmlkorban ?>" onblur="validasiTanggalLahir()" placeholder="dd/mm/yyyy" value="<?= $tgllahir ?>">
                                <span id="errorTanggalLahirkorban<?= $jmlkorban ?>" style="color: red; display: none;">Format tanggal tidak valid.</span>
                            </td>
                        </tr>
                        <tr id="usiaRowkorban<?= $jmlkorban ?>" <?= ($statuskorban == 6) ? '' : 'style="display:none"' ?>>
                            <td>
                                Usia Korban
                            </td>
                            <td>:</td>
                            <td>
                                <input disabled type="text" placeholder="" id="usiakorban<?= $jmlkorban ?>" name="usiakorban<?= $jmlkorban ?>" value="<?= $korban['usia'] ?>">
                                <span class="info" id="infousiakorban<?= $jmlkorban ?>"></span>
                            </td><br>
                            <!-- <button onclick="cekusiakorban(0)" id="tbusiakorban" class="btn_abu2">OK</button> -->
                        </tr>
                        <tr id="jenis_kelaminRowkorban<?= $jmlkorban ?>">
                            <td>
                                Jenis Kelamin Korban *
                            </td>
                            <td>:</td>
                            <td>
                                <input <?= ($korban['jenis_kelamin'] == "L") ? 'checked' : '' ?> disabled type="radio" name="jenis_kelaminkorban<?= $jmlkorban ?>" value="L"> Laki-laki<br>
                                <input <?= ($korban['jenis_kelamin'] == "P") ? 'checked' : '' ?> disabled type="radio" name="jenis_kelaminkorban<?= $jmlkorban ?>" value="P"> Perempuan<br>
                                <span class="info" id="infojenis_kelaminkorban<?= $jmlkorban ?>"></span><br>
                                <button style="display: none;" onclick="konfirmjenis_kelaminkorban(<?= $jmlkorban ?>)" id="tbjenis_kelaminkorban<?= $jmlkorban ?>" class="btn_abu2">Konfirm</button>
                            </td>
                        </tr>
                        <tr id="alamatRowkorban<?= $jmlkorban ?>" <?= ($statuskorban == 6) ? '' : 'style="display:none"' ?>>
                            <td>
                                Alamat Korban *
                            </td>
                            <td>:</td>
                            <td><input disabled type="text" placeholder="" id="alamatkorban<?= $jmlkorban ?>" name="alamatkorban<?= $jmlkorban ?>" value="<?= $korban['alamat'] ?>">
                                <span class="info" id="infoalamatkorban<?= $jmlkorban ?>"></span>
                            </td><br>
                            <!-- <button onclick="cekusiakorban(0)" id="tbusiakorban" class="btn_abu2">OK</button> -->
                        </tr>
                        <tr id="provinsiRowkorban<?= $jmlkorban ?>" <?= ($statuskorban == 6) ? '' : 'style="display:none"' ?>>
                            <td>
                                Provinsi *
                            </td>
                            <td>:</td>
                            <td>
                                <select disabled class="pilortu" id="provinsikorban<?= $jmlkorban ?>" onchange="getkota(0, this.value);">
                                    <?php foreach ($daf_provinsi as $provinsi) :
                                        $selected = "";
                                        $pilprov = substr($korban['kode_wilayah'], 0, 2) . "0000";
                                        if (trim($provinsi['kode_wilayah']) == $pilprov)
                                            $selected = "selected";
                                    ?>
                                        <option <?= $selected ?> value="<?= $provinsi['kode_wilayah'] ?>"><?= $provinsi['nama'] ?></option>

                                    <?php endforeach; ?>
                                </select>
                            </td>
                        </tr>
                        <tr id="kotaRowkorban<?= $jmlkorban ?>" <?= ($statuskorban == 6) ? '' : 'style="display:none"' ?>>
                            <td>
                                Kab / Kota *
                            </td>
                            <td>:</td>
                            <td>
                                <select disabled class="pilortu" id="kotakorban<?= $jmlkorban ?>" onchange="getkecamatan(0, this.value);">
                                    <option><?= $korban['kota'] ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr id="kecamatanRowkorban<?= $jmlkorban ?>" <?= ($statuskorban == 6) ? '' : 'style="display:none"' ?>>
                            <td>
                                Kecamatan *
                            </td>
                            <td>:</td>
                            <td>
                                <select disabled class="pilortu" id="kecamatankorban<?= $jmlkorban ?>" onchange="getdesa(0, this.value);">
                                    <option><?= $korban['kecamatan'] ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr id="desaRowkorban<?= $jmlkorban ?>" <?= ($statuskorban == 6) ? '' : 'style="display:none"' ?>>
                            <td>
                                Desa
                            </td>
                            <td>:</td>
                            <td>
                                <select disabled class="pilortu" id="desakorban<?= $jmlkorban ?>">
                                    <option><?= $korban['desa'] ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr id="disabilitasRowkorban<?= $jmlkorban ?>">
                            <td>
                                Apakah korban memiliki disabilitas?
                            </td>
                            <td>:</td>
                            <td>
                                <input disabled type="radio" <?= ($korban['disabilitas'] == 1) ? "checked" : "" ?> name="disabilitaskorban<?= $jmlkorban ?>" value="1" onclick="toggleInput(' korban',this, 1)"> Ya, sebutkan:

                                <input disabled type="text" id="inputdisabilitaskorban<?= $jmlkorban ?>" style="display: none;">
                                <br>
                                <div id="opsidisabilitasRowkorban<?= $jmlkorban ?>" style="margin-left: 20px; display: <?= ($korban['disabilitas'] == 1) ? "block" : "none" ?>">
                                    <?php
                                    $nilai_yang_dicari = explode('-', $korban['kebutuhan_khusus']);
                                    $nilai_yang_dicari = explode(',', $nilai_yang_dicari[0]);
                                    $nilai_yang_dicari = array_map('trim', $nilai_yang_dicari);

                                    foreach ($daf_kebutuhan_khusus as $row) {
                                        $kd_kb = $row['kebutuhan_khusus'];
                                        $kodeexp = explode("-", $kd_kb);
                                        $kode = trim($kodeexp[0], " ");
                                        $checked = "";
                                        if (in_array($kode, $nilai_yang_dicari)) {
                                            $checked = " checked ";
                                        }
                                        echo '<input ' . $checked . ' disabled type="checkbox" value="' . $row['kebutuhan_khusus_id'] . '" id="checkbox' . $kode . 'korban' . $jmlkorban . '"> ' . $kd_kb . '<br>';
                                    }
                                    ?>
                                </div>

                                <input disabled type="radio" <?= ($korban['disabilitas'] == 0) ? "checked" : "" ?> name="disabilitaskorban<?= $jmlkorban ?>" value="0" onclick="toggleInput('korban',this, 1)"> Tidak
                                <span class="info" id="infodisabilitaskorban<?= $jmlkorban ?>"></span><br>
                                <br>
                                <button <?= ($statuskorban == 6) ? '' : 'style="display:none"' ?> onclick="konfirmdisabilitaskorban(<?= $jmlkorban ?>)" id="tbdisabilitaskorban<?= $jmlkorban ?><?= $jmlkorban ?>" class="btn_abu2">Konfirm</button>
                            </td>
                        </tr>
                    </table>
                    <div style="margin-top: 10px; display:inline">
                        <button id="tbkurangikorban" style="margin-top: 10px; display: none;" class="btn_merah" onclick="kurangiKorban()">HAPUS KORBAN INI</button>
                        <button id="tbtambahkorban" style="margin-top: 10px; display: none;" class="btn_ijo" onclick="tambahKorban()">INPUT KORBAN BERIKUTNYA</button>
                        <button id="tbpelakukorban" style="margin-top: 10px; display: none;" class="btn_ijo" onclick="tambahPelaku()">INPUT PELAKU</button>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>

    <div id="dif4">
        <div id="lokasipelaku">
            <div id="pelaku" class="pelaku">
                <table class="tabelisian">
                    <tr>
                        <th class="kelabu" colspan="3">Bagian 2: Formulir Pelaku</th>
                    </tr>
                    <tr>
                        <th style="width:40%"></th>
                        <th style="width:10px;"></th>
                        <th></th>
                    </tr>
                    <tr>
                        <td>
                            Status Pelaku
                        </td>
                        <td>:</td>
                        <td>
                            <?php foreach ($daf_status_korban as $status) : ?>
                                <div class="checkbox-container">
                                    <input onchange="cekstatuspelaku(0);" type="radio" name="status_pelaku" value="<?= $status['status_korban_pelaku_id'] ?>">
                                    <?= $status['nama'] ?>
                                </div>
                            <?php endforeach; ?>
                        </td>
                    </tr>
                    <tr id="npsnRowpelaku" style="display: none;">
                        <td>
                            NPSN Pelaku
                        </td>
                        <td>:</td>
                        <td><input type="text" placeholder="" id="npsnpelaku" name="npsnpelaku" value="<?= $npsn ?>">
                            <span class="info" id="infonpsnpelaku"></span>
                            <button id="tbnpsnpelaku" class="btn_abu2" onclick="submitnpsnpelaku(0)">Submit</button>
                            <button id="tbcarisekolahpelaku" onclick="tampilmodal()" class="btn_abu2">Cari NPSN/Sekolah</button>
                        </td>
                    </tr>
                    <tr id="sekolahRowpelaku" style="display: none;">
                        <td>
                            Nama Sekolah / Instansi Pelaku
                        </td>
                        <td>:</td>
                        <td><textarea id="sekolahpelaku" name="sekolahpelaku"></textarea>
                            <span class="info" id="infosekolahpelaku"></span>
                            <button onclick="konfirmsekolahpelaku(0)" id="tbsekolahpelaku" class="btn_abu2">Konfirm</button>
                        </td>
                    </tr>
                    <tr id="nisnRowpelaku" style="display: none;">
                        <td>
                            NISN / NUPTK Pelaku
                        </td>
                        <td>:</td>
                        <td><input type="text" placeholder="" id="nisnpelaku" name="nisnpelaku">
                            <span class="info" id="infonisnpelaku"></span><br>
                            <button onclick="ceknisnpelaku(0)" id="tbnisnpelaku" class="btn_abu2">Cek</button>
                        </td>
                    </tr>
                    <tr id="namaRowpelaku" style="display: none;">
                        <td>
                            Nama Pelaku *
                        </td>
                        <td>:</td>
                        <td><textarea id="namapelaku" name="namapelaku"></textarea>
                            <span class="info" id="infonamapelaku"></span><br>
                            <!-- <button onclick="konfirmnamapelaku(0)" id="tbnamapelaku" class="btn_abu2">Konfirm</button> -->
                        </td>
                    </tr>
                    <tr id="nikpdptkRowpelaku" style="display: none;">
                        <td>
                            NIK
                        </td>
                        <td>:</td>
                        <td><input type="text" placeholder="" id="nikpdptkpelaku" name="nikpdptkpelaku">
                            <span class="info" id="infonikpdptkpelaku"></span><br>
                            <button style="display: none;" onclick="ceknikpdptkpelaku(0)" id="tbnikpdptkpelaku" class="btn_abu2">Konfirm</button>
                        </td>
                    </tr>
                    <tr id="nikRowpelaku" style="display: none;">
                        <td>
                            NIK Pelaku *
                        </td>
                        <td>:</td>
                        <td><select class="pilortu" id="statusortupelaku">
                                <option value="ayah">Ayah</option>
                                <option value="ibu">Ibu</option>
                                <option value="wali">Wali Murid</option>
                            </select>
                            <input type="text" placeholder="" id="nikpelaku" name="nikpelaku">
                            <span class="info" id="infonikpelaku"></span><br>
                            <button onclick="ceknikpelaku(0)" id="tbnikpelaku" class="btn_abu2">OK</button>
                        </td>
                    </tr>
                    <tr id="namaortuRowpelaku" style="display: none;">
                        <td>
                            Nama Pelaku *
                        </td>
                        <td>:</td>
                        <td><textarea id="namaortupelaku" name="namaortupelaku"></textarea>
                            <span class="info" id="infonamaortupelaku"></span><br>
                            <!-- <button style="display: none;" onclick="konfirmnamaortupelaku(0)" id="tbnamaortupelaku" class="btn_abu2">Konfirm</button> -->
                        </td>
                    </tr>
                    <tr id="tgllahirRowpelaku" style="display: none;">
                        <td>
                            Tanggal Lahir Pelaku
                        </td>
                        <td>:</td>
                        <td><input type="text" id="datepickerpelaku" name="datepickerpelaku" onblur="validasiTanggalLahir()" placeholder="dd/mm/yyyy" value="">
                            <span id="errorTanggalLahirpelaku" style="color: red; display: none;">Format tanggal tidak valid.</span>
                        </td>
                    </tr>
                    <tr id="usiaRowpelaku" style="display: none;">
                        <td>
                            Usia Pelaku
                        </td>
                        <td>:</td>
                        <td>
                            <input type="text" placeholder="" id="usiapelaku" name="usiapelaku" style="display: none;">
                            <span class="info" id="infousiapelaku"></span>
                        </td><br>
                        <!-- <button onclick="cekusiapelaku(0)" id="tbusiapelaku" class="btn_abu2">OK</button> -->
                    </tr>
                    <tr id="jenis_kelaminRowpelaku" style="display: none;">
                        <td>
                            Jenis Kelamin Pelaku
                        </td>
                        <td>:</td>
                        <td>
                            <input type="radio" name="jenis_kelaminpelaku" value="L"> Laki-laki<br>
                            <input type="radio" name="jenis_kelaminpelaku" value="P"> Perempuan<br>
                            <span class="info" id="infojenis_kelaminpelaku"></span><br>
                            <button style="display: none;" onclick="konfirmjenis_kelaminpelaku(0)" id="tbjenis_kelaminpelaku" class="btn_abu2">Konfirm</button>
                        </td>
                    </tr>
                    <tr id="alamatRowpelaku" style="display: none;">
                        <td>
                            Alamat Pelaku *
                        </td>
                        <td>:</td>
                        <td><input type="text" placeholder="" id="alamatpelaku" name="alamatpelaku" style="display: none;">
                            <span class="info" id="infoalamatpelaku"></span>
                        </td><br>
                        <!-- <button onclick="cekusiapelaku(0)" id="tbusiapelaku" class="btn_abu2">OK</button> -->
                    </tr>
                    <tr id="provinsiRowpelaku" style="display: none;">
                        <td>
                            Provinsi
                        </td>
                        <td>:</td>
                        <td>
                            <select class="pilortu" id="provinsipelaku" onchange="getkota(0, this.value);">
                                <option value="-"> - pilih provinsi - </option>
                                <?php foreach ($daf_provinsi as $provinsi) : ?>
                                    <option value="<?= $provinsi['kode_wilayah'] ?>"><?= $provinsi['nama'] ?></option>

                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr id="kotaRowpelaku" style="display: none;">
                        <td>
                            Kab / Kota
                        </td>
                        <td>:</td>
                        <td>
                            <select class="pilortu" id="kotapelaku" onchange="getkecamatan(0, this.value);">
                                <option> - pilih kota/kab - </option>
                            </select>
                        </td>
                    </tr>
                    <tr id="kecamatanRowpelaku" style="display: none;">
                        <td>
                            Kecamatan
                        </td>
                        <td>:</td>
                        <td>
                            <select class="pilortu" id="kecamatanpelaku" onchange="getdesa(0, this.value);">
                                <option> - pilih kecamatan - </option>
                            </select>
                        </td>
                    </tr>
                    <tr id="desaRowpelaku" style="display: none;">
                        <td>
                            Desa
                        </td>
                        <td>:</td>
                        <td>
                            <select class="pilortu" id="desapelaku">
                                <option> - pilih desa - </option>
                            </select>
                        </td>
                    </tr>
                    <tr id="disabilitasRowpelaku" style="display: none;">
                        <td>
                            Apakah pelaku memiliki disabilitas?
                        </td>
                        <td>:</td>
                        <td>

                            <input type="radio" name="disabilitaspelaku" value="1" onclick="toggleInput('pelaku',this, 1)"> Ya, sebutkan:

                            <input type="text" id="inputdisabilitaspelaku" style="display: none;">
                            <br>
                            <div id="opsidisabilitasRowpelaku" style="margin-left: 20px; display: none">
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
                            <button onclick="konfirmdisabilitaspelaku(0)" id="tbdisabilitaspelaku" class="btn_abu2">Konfirm</button>
                        </td>
                    </tr>
                </table>
                <div style="margin-top: 10px; display:inline">
                    <button id="tbkurangipelaku" style="margin-top: 10px; display: none;" class="btn_merah" onclick="kurangiPelaku()">HAPUS PELAKU INI</button>
                    <button id="tbtambahpelaku" style="margin-top: 10px; display: none;" class="btn_ijo" onclick="tambahPelaku()">INPUT PELAKU BERIKUTNYA</button>
                    <button id="tbkronologi" style="margin-top: 10px; display: none;" class="btn_ijo" onclick="inputkronologiPelaku()">INPUT KRONOLOGI</button>
                </div>
            </div>

            <?php
            $jmlpelaku = 0;
            foreach ($data_pelaku as $pelaku) {
                $jmlpelaku++;
                $statuspelaku = $pelaku['status_korban_pelaku'];
                $tgllahir = ($pelaku['tanggal_lahir'] != null) ? substr($pelaku['tanggal_lahir'], 8, 2) . "/" . substr($pelaku['tanggal_lahir'], 5, 2) . "/" . substr($pelaku['tanggal_lahir'], 0, 4) : "-";
            ?>
                <div id="pelaku<?= $jmlpelaku ?>" class="pelaku" style="display:block">
                    <table class="tabelisian">
                        <tr>
                            <th class="kelabu" colspan="3"><?= ($jmlpelaku == 1) ? 'Bagian 2: ' : '' ?>Formulir Pelaku <?= $jmlpelaku ?></th>
                        </tr>
                        <tr>
                            <th style="width:40%"></th>
                            <th style="width:10px;"></th>
                            <th></th>
                        </tr>
                        <tr>
                            <td>
                                Status Pelaku *
                            </td>
                            <td>:</td>
                            <td>
                                <?php foreach ($daf_status_korban as $status) : ?>
                                    <div class="checkbox-container">
                                        <input disabled <?= ($status['status_korban_pelaku_id'] == $statuspelaku) ? 'checked' : '' ?> onchange="cekstatuspelaku(<?= $jmlpelaku ?>);" type="radio" name="status_pelaku<?= $jmlpelaku ?>" value="<?= $status['status_korban_pelaku_id'] ?>">
                                        <?= $status['nama'] ?>
                                    </div>
                                <?php endforeach; ?>
                            </td>
                        </tr>
                        <tr id="npsnRowpelaku<?= $jmlpelaku ?>" <?= ($statuspelaku == 6) ? "style='display:none;'" : "" ?>>
                            <td>
                                <?= ($statuspelaku == 2) ? "NPSN Peserta Didik *" : "NPSN Pelaku *" ?>
                            </td>
                            <td>:</td>
                            <td><input disabled type="text" placeholder="" id="npsnpelaku<?= $jmlpelaku ?>" name="npsnpelaku<?= $jmlpelaku ?>" value="<?= $pelaku['npsn'] ?>">
                                <span class="info" id="infonpsnpelaku<?= $jmlpelaku ?>"></span>
                            </td>
                        </tr>
                        <tr id="sekolahRowpelaku<?= $jmlpelaku ?>">
                            <td>
                                <?= ($statuspelaku < 6 && $statuspelaku != 2) ? 'Nama Sekolah Pelaku *' : (($statuspelaku == 2) ? 'Nama Sekolah Peserta Didik *' : 'Instansi Pelaku') ?>
                            </td>
                            <td>:</td>
                            <td><textarea disabled id="sekolahpelaku<?= $jmlpelaku ?>" name="sekolahpelaku<?= $jmlpelaku ?>"><?= $pelaku['nama_instansi'] ?></textarea>
                                <span class="info" id="infosekolahpelaku<?= $jmlpelaku ?>"></span>
                                <button style="display: none;" onclick="konfirmsekolahpelaku(<?= $jmlpelaku ?>)" id="tbsekolahpelaku<?= $jmlpelaku ?>" class="btn_abu2">Konfirm</button>
                            </td>
                        </tr>
                        <tr id="nisnRowpelaku<?= $jmlpelaku ?>" <?= ($statuspelaku == 6) ? "style='display:none;'" : "" ?>>
                            <td>
                                <?= ($statuspelaku == 1) ? 'NISN Pelaku' : (($statuspelaku == 2) ? 'NISN Peserta Didik' : 'NUPTK Pelaku') ?>
                            </td>
                            <td>:</td>
                            <td><input disabled type="text" placeholder="" id="nisnpelaku<?= $jmlpelaku ?>" name="nisnpelaku<?= $jmlpelaku ?>" value="<?= $pelaku['nisn'] ?>">
                                <span class="info" id="infonisnpelaku<?= $jmlpelaku ?>"></span><br>
                                <button style="display: none;" onclick="ceknisnpelaku(<?= $jmlpelaku ?>)" id="tbnisnpelaku<?= $jmlpelaku ?>" class="btn_abu2">Cek</button>
                            </td>
                        </tr>
                        <tr id="namaRowpelaku<?= $jmlpelaku ?>">
                            <td>
                                <?= ($statuspelaku != 2) ? 'Nama Pelaku *' : 'Nama Peserta Didik *' ?>
                            </td>
                            <td>:</td>
                            <td><textarea disabled id="namapelaku<?= $jmlpelaku ?>" name="namapelaku<?= $jmlpelaku ?>"><?= $pelaku['nama'] ?></textarea>
                                <span class="info" id="infonamapelaku<?= $jmlpelaku ?>"></span><br>
                                <!-- <button onclick="konfirmnamapelaku(0)" id="tbnamapelaku" class="btn_abu2">Konfirm</button> -->
                            </td>
                        </tr>
                        <tr id="nikpdptkRowpelaku<?= $jmlpelaku ?>" <?= ($statuspelaku == 6) ? "style='display:none;'" : "" ?>>
                            <td>
                                NIK Pelaku *
                            </td>
                            <td>:</td>
                            <td><input disabled type="text" placeholder="" id="nikpdptkpelaku<?= $jmlpelaku ?>" name="nikpdptkpelaku<?= $jmlpelaku ?>" value="<?= $pelaku['nikpdptk'] ?>">
                                <span class="info" id="infonikpdptkpelaku<?= $jmlpelaku ?>"></span><br>
                                <button style="display: none;" onclick="ceknikpdptkpelaku(<?= $jmlpelaku ?>)" id="tbnikpdptkpelaku<?= $jmlpelaku ?>" class="btn_abu2">Konfirm</button>
                            </td>
                        </tr>
                        <tr id="nikRowpelaku<?= $jmlpelaku ?>" <?= ($statuspelaku == 2 || $statuspelaku == 6) ? '' : 'style="display:none"' ?>>
                            <td>
                                <?= ($statuspelaku != 2) ? 'NIK Pelaku *' : 'NIK Peserta Didik *' ?>
                            </td>
                            <td>:</td>
                            <td><select <?= ($statuspelaku == 6) ? "style='display:none;'" : "" ?> disabled class="pilortu" id="statusortupelaku<?= $jmlpelaku ?>">
                                    <option <?= ($pelaku['status_ortu'] == "ayah") ? 'selected' : '' ?> value="ayah">Ayah</option>
                                    <option <?= ($pelaku['status_ortu'] == "ibu") ? 'selected' : '' ?> value="ibu">Ibu</option>
                                    <option <?= ($pelaku['status_ortu'] == "wali") ? 'selected' : '' ?> value="wali">Wali Murid</option>
                                </select>
                                <input disabled type="text" placeholder="" id="nikpelaku<?= $jmlpelaku ?>" name="nikpelaku<?= $jmlpelaku ?>" value="<?= $pelaku['nik'] ?>">
                                <span class="info" id="infonikpelaku<?= $jmlpelaku ?>"></span><br>
                                <button style="display: none;" onclick="ceknikpelaku(<?= $jmlpelaku ?>)" id="tbnikpelaku<?= $jmlpelaku ?>" class="btn_abu2">OK</button>
                            </td>
                        </tr>
                        <tr id="namaortuRowpelaku<?= $jmlpelaku ?>" <?= ($statuspelaku == 2) ? '' : 'style="display:none"' ?>>
                            <td>
                                Nama Pelaku *
                            </td>
                            <td>:</td>
                            <td><textarea disabled id="namaortupelaku<?= $jmlpelaku ?>" name="namaortupelaku<?= $jmlpelaku ?>"><?= $pelaku['nama2'] ?></textarea>
                                <span class="info" id="infonamaortupelaku<?= $jmlpelaku ?>"></span><br>
                                <!-- <button style="display: none;" onclick="konfirmnamaortupelaku(0)" id="tbnamaortupelaku" class="btn_abu2">Konfirm</button> -->
                            </td>
                        </tr>
                        <tr id="tgllahirRowpelaku<?= $jmlpelaku ?>" <?= ($statuspelaku == 6) ? '' : 'style="display:none"' ?>>
                            <td>
                                Tanggal Lahir Pelaku
                            </td>
                            <td>:</td>
                            <td><input type="text" id="datepickerpelaku<?= $jmlpelaku ?>" name="datepickerpelaku<?= $jmlpelaku ?>" onblur="validasiTanggalLahir()" placeholder="dd/mm/yyyy" value="<?= $tgllahir ?>">
                                <span id="errorTanggalLahirpelaku<?= $jmlpelaku ?>" style="color: red; display: none;">Format tanggal tidak valid.</span>
                            </td>
                        </tr>
                        <tr id="usiaRowpelaku<?= $jmlpelaku ?>" <?= ($statuspelaku == 6) ? '' : 'style="display:none"' ?>>
                            <td>
                                Usia Pelaku
                            </td>
                            <td>:</td>
                            <td>
                                <input disabled type="text" placeholder="" id="usiapelaku<?= $jmlpelaku ?>" name="usiapelaku<?= $jmlpelaku ?>" value="<?= $pelaku['usia'] ?>">
                                <span class="info" id="infousiapelaku<?= $jmlpelaku ?>"></span>
                            </td><br>
                            <!-- <button onclick="cekusiapelaku(0)" id="tbusiapelaku" class="btn_abu2">OK</button> -->
                        </tr>
                        <tr id="jenis_kelaminRowpelaku<?= $jmlpelaku ?>">
                            <td>
                                Jenis Kelamin Pelaku *
                            </td>
                            <td>:</td>
                            <td>
                                <input <?= ($pelaku['jenis_kelamin'] == "L") ? 'checked' : '' ?> disabled type="radio" name="jenis_kelaminpelaku<?= $jmlpelaku ?>" value="L"> Laki-laki<br>
                                <input <?= ($pelaku['jenis_kelamin'] == "P") ? 'checked' : '' ?> disabled type="radio" name="jenis_kelaminpelaku<?= $jmlpelaku ?>" value="P"> Perempuan<br>
                                <span class="info" id="infojenis_kelaminpelaku<?= $jmlpelaku ?>"></span><br>
                                <button style="display: none;" onclick="konfirmjenis_kelaminpelaku(<?= $jmlpelaku ?>)" id="tbjenis_kelaminpelaku<?= $jmlpelaku ?>" class="btn_abu2">Konfirm</button>
                            </td>
                        </tr>
                        <tr id="alamatRowpelaku<?= $jmlpelaku ?>" <?= ($statuspelaku == 6) ? '' : 'style="display:none"' ?>>
                            <td>
                                Alamat Pelaku *
                            </td>
                            <td>:</td>
                            <td><input disabled type="text" placeholder="" id="alamatpelaku<?= $jmlpelaku ?>" name="alamatpelaku<?= $jmlpelaku ?>" value="<?= $pelaku['alamat'] ?>">
                                <span class="info" id="infoalamatpelaku<?= $jmlpelaku ?>"></span>
                            </td><br>
                            <!-- <button onclick="cekusiapelaku(0)" id="tbusiapelaku" class="btn_abu2">OK</button> -->
                        </tr>
                        <tr id="provinsiRowpelaku<?= $jmlpelaku ?>" <?= ($statuspelaku == 6) ? '' : 'style="display:none"' ?>>
                            <td>
                                Provinsi *
                            </td>
                            <td>:</td>
                            <td>
                                <select disabled class="pilortu" id="provinsipelaku<?= $jmlpelaku ?>" onchange="getkota(0, this.value);">
                                    <?php foreach ($daf_provinsi as $provinsi) :
                                        $selected = "";
                                        $pilprov = substr($pelaku['kode_wilayah'], 0, 2) . "0000";
                                        if (trim($provinsi['kode_wilayah']) == $pilprov)
                                            $selected = "selected";
                                    ?>
                                        <option <?= $selected ?> value="<?= $provinsi['kode_wilayah'] ?>"><?= $provinsi['nama'] ?></option>

                                    <?php endforeach; ?>
                                </select>
                            </td>
                        </tr>
                        <tr id="kotaRowpelaku<?= $jmlpelaku ?>" <?= ($statuspelaku == 6) ? '' : 'style="display:none"' ?>>
                            <td>
                                Kab / Kota *
                            </td>
                            <td>:</td>
                            <td>
                                <select disabled class="pilortu" id="kotapelaku<?= $jmlpelaku ?>" onchange="getkecamatan(0, this.value);">
                                    <option><?= $pelaku['kota'] ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr id="kecamatanRowpelaku<?= $jmlpelaku ?>" <?= ($statuspelaku == 6) ? '' : 'style="display:none"' ?>>
                            <td>
                                Kecamatan *
                            </td>
                            <td>:</td>
                            <td>
                                <select disabled class="pilortu" id="kecamatanpelaku<?= $jmlpelaku ?>" onchange="getdesa(0, this.value);">
                                    <option><?= $pelaku['kecamatan'] ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr id="desaRowpelaku<?= $jmlpelaku ?>" <?= ($statuspelaku == 6) ? '' : 'style="display:none"' ?>>
                            <td>
                                Desa
                            </td>
                            <td>:</td>
                            <td>
                                <select disabled class="pilortu" id="desapelaku<?= $jmlpelaku ?>">
                                    <option><?= $pelaku['desa'] ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr id="disabilitasRowpelaku<?= $jmlpelaku ?>">
                            <td>
                                Apakah pelaku memiliki disabilitas?
                            </td>
                            <td>:</td>
                            <td>

                                <input disabled type="radio" <?= ($pelaku['disabilitas'] == 1) ? "checked" : "" ?> name="disabilitaspelaku<?= $jmlpelaku ?>" value="1" onclick="toggleInput(' pelaku',this, 1)"> Ya, sebutkan:

                                <input disabled type="text" id="inputdisabilitaspelaku<?= $jmlpelaku ?>" style="display: none;">
                                <br>
                                <div id="opsidisabilitasRowpelaku<?= $jmlpelaku ?>" style="margin-left: 20px; display: <?= ($pelaku['disabilitas'] == 1) ? "block" : "none" ?>">
                                    <?php
                                    $nilai_yang_dicari = explode('-', $pelaku['kebutuhan_khusus']);
                                    $nilai_yang_dicari = explode(',', $nilai_yang_dicari[0]);
                                    $nilai_yang_dicari = array_map('trim', $nilai_yang_dicari);

                                    foreach ($daf_kebutuhan_khusus as $row) {
                                        $kd_kb = $row['kebutuhan_khusus'];
                                        $kodeexp = explode("-", $kd_kb);
                                        $kode = trim($kodeexp[0], " ");
                                        $checked = "";
                                        if (in_array($kode, $nilai_yang_dicari)) {
                                            $checked = " checked ";
                                        }
                                        echo '<input ' . $checked . ' disabled type="checkbox" value="' . $row['kebutuhan_khusus_id'] . '" id="checkbox' . $kode . 'pelaku' . $jmlpelaku . '"> ' . $kd_kb . '<br>';
                                    }
                                    ?>
                                </div>

                                <input disabled type="radio" <?= ($pelaku['disabilitas'] == 0) ? "checked" : "" ?> name="disabilitaspelaku<?= $jmlpelaku ?>" value="0" onclick="toggleInput('pelaku',this, 1)"> Tidak
                                <span class="info" id="infodisabilitaspelaku<?= $jmlpelaku ?>"></span><br>
                                <br>
                                <button <?= ($statuspelaku == 6) ? '' : 'style="display:none"' ?> onclick="konfirmdisabilitaspelaku(<?= $jmlpelaku ?>)" id="tbdisabilitaspelaku<?= $jmlpelaku ?><?= $jmlpelaku ?>" class="btn_abu2">Konfirm</button>
                            </td>
                        </tr>
                    </table>
                    <div style="margin-top: 10px; display:inline">
                        <button id="tbkurangipelaku" style="margin-top: 10px; display: none;" class="btn_merah" onclick="kurangiPelaku()">HAPUS PELAKU INI</button>
                        <button id="tbtambahpelaku" style="margin-top: 10px; display: none;" class="btn_ijo" onclick="tambahPelaku()">INPUT PELAKU BERIKUTNYA</button>
                        <button id="tbkronologi" style="margin-top: 10px; display: none;" class="btn_ijo" onclick="inputkronologiPelaku()">INPUT KRONOLOGI</button>
                    </div>
                </div>
            <?php } ?>

        </div>

        <div id="lokasiterlapor">
            <div id="terlapor" class="terlapor">
                <table class="tabelisian">
                    <tr>
                        <th class="kelabu" colspan="3">Bagian 2: Formulir Terlapor</th>
                    </tr>
                    <tr>
                        <th style="width:40%"></th>
                        <th style="width:10px;"></th>
                        <th></th>
                    </tr>
                    <tr>
                        <td>
                            Status Terlapor
                        </td>
                        <td>:</td>
                        <td>
                            <?php foreach ($daf_status_korban as $status) : ?>
                                <div class="checkbox-container">
                                    <input onchange="cekstatusterlapor(0);" type="radio" name="status_terlapor" value="<?= $status['status_korban_pelaku_id'] ?>">
                                    <?= $status['nama'] ?>
                                </div>
                            <?php endforeach; ?>
                        </td>
                    </tr>
                    <tr id="npsnRowterlapor" style="display: none;">
                        <td>
                            NPSN Terlapor
                        </td>
                        <td>:</td>
                        <td><input type="text" placeholder="" id="npsnterlapor" name="npsnterlapor" value="<?= $npsn ?>">
                            <span class="info" id="infonpsnterlapor"></span>
                            <button id="tbnpsnterlapor" class="btn_abu2" onclick="submitnpsnterlapor(0)">Submit</button>
                            <button id="tbcarisekolahterlapor" onclick="tampilmodal()" class="btn_abu2">Cari NPSN/Sekolah</button>
                        </td>
                    </tr>
                    <tr id="sekolahRowterlapor" style="display: none;">
                        <td>
                            Nama Sekolah / Instansi Terlapor
                        </td>
                        <td>:</td>
                        <td><textarea id="sekolahterlapor" name="sekolahterlapor"></textarea>
                            <span class="info" id="infosekolahterlapor"></span>
                            <button onclick="konfirmsekolahterlapor(0)" id="tbsekolahterlapor" class="btn_abu2">Konfirm</button>
                        </td>
                    </tr>
                    <tr id="nisnRowterlapor" style="display: none;">
                        <td>
                            NISN / NUPTK Terlapor
                        </td>
                        <td>:</td>
                        <td><input type="text" placeholder="" id="nisnterlapor" name="nisnterlapor">
                            <span class="info" id="infonisnterlapor"></span><br>
                            <button onclick="ceknisnterlapor(0)" id="tbnisnterlapor" class="btn_abu2">Cek</button>
                        </td>
                    </tr>
                    <tr id="namaRowterlapor" style="display: none;">
                        <td>
                            Nama Terlapor *
                        </td>
                        <td>:</td>
                        <td><textarea id="namaterlapor" name="namaterlapor"></textarea>
                            <span class="info" id="infonamaterlapor"></span><br>
                            <!-- <button onclick="konfirmnamaterlapor(0)" id="tbnamaterlapor" class="btn_abu2">Konfirm</button> -->
                        </td>
                    </tr>
                    <tr id="nikpdptkRowterlapor" style="display: none;">
                        <td>
                            NIK
                        </td>
                        <td>:</td>
                        <td><input type="text" placeholder="" id="nikpdptkterlapor" name="nikpdptkterlapor">
                            <span class="info" id="infonikpdptkterlapor"></span><br>
                            <button style="display: none;" onclick="ceknikpdptkterlapor(0)" id="tbnikpdptkterlapor" class="btn_abu2">Konfirm</button>
                        </td>
                    </tr>
                    <tr id="nikRowterlapor" style="display: none;">
                        <td>
                            NIK Terlapor
                        </td>
                        <td>:</td>
                        <td><select class="pilortu" id="statusortuterlapor">
                                <option value="ayah">Ayah</option>
                                <option value="ibu">Ibu</option>
                                <option value="wali">Wali Murid</option>
                            </select>
                            <input type="text" placeholder="" id="nikterlapor" name="nikterlapor">
                            <span class="info" id="infonikterlapor"></span><br>
                            <button onclick="ceknikterlapor(0)" id="tbnikterlapor" class="btn_abu2">OK</button>
                        </td>
                    </tr>
                    <tr id="namaortuRowterlapor" style="display: none;">
                        <td>
                            Nama Terlapor (Ortu)
                        </td>
                        <td>:</td>
                        <td><textarea id="namaortuterlapor" name="namaortuterlapor"></textarea>
                            <span class="info" id="infonamaortuterlapor"></span><br>
                            <!-- <button style="display: none;" onclick="konfirmnamaortuterlapor(0)" id="tbnamaortuterlapor" class="btn_abu2">Konfirm</button> -->
                        </td>
                    </tr>
                    <tr id="tgllahirRowterlapor" style="display: none;">
                        <td>
                            Tanggal Lahir Terlapor
                        </td>
                        <td>:</td>
                        <td><input type="text" id="datepickerterlapor" name="datepickerterlapor" onblur="validasiTanggalLahir()" placeholder="dd/mm/yyyy" value="">
                            <span id="errorTanggalLahirterlapor" style="color: red; display: none;">Format tanggal tidak valid.</span>
                        </td>
                    </tr>
                    <tr id="usiaRowterlapor" style="display: none;">
                        <td>
                            Usia Terlapor
                        </td>
                        <td>:</td>
                        <td>
                            <input type="text" placeholder="" id="usiaterlapor" name="usiaterlapor" style="display: none;">
                            <span class="info" id="infousiaterlapor"></span>
                        </td><br>
                        <!-- <button onclick="cekusiaterlapor(0)" id="tbusiaterlapor" class="btn_abu2">OK</button> -->
                    </tr>
                    <tr id="jenis_kelaminRowterlapor" style="display: none;">
                        <td>
                            Jenis Kelamin Terlapor
                        </td>
                        <td>:</td>
                        <td>
                            <input type="radio" name="jenis_kelaminterlapor" value="L"> Laki-laki<br>
                            <input type="radio" name="jenis_kelaminterlapor" value="P"> Perempuan<br>
                            <span class="info" id="infojenis_kelaminterlapor"></span><br>
                            <button style="display: none;" onclick="konfirmjenis_kelaminterlapor(0)" id="tbjenis_kelaminterlapor" class="btn_abu2">Konfirm</button>
                        </td>
                    </tr>
                    <tr id="alamatRowterlapor" style="display: none;">
                        <td>
                            Alamat Terlapor *
                        </td>
                        <td>:</td>
                        <td><input type="text" placeholder="" id="alamatterlapor" name="alamatterlapor" style="display: none;">
                            <span class="info" id="infoalamatterlapor"></span>
                        </td><br>
                        <!-- <button onclick="cekusiaterlapor(0)" id="tbusiaterlapor" class="btn_abu2">OK</button> -->
                    </tr>
                    <tr id="provinsiRowterlapor" style="display: none;">
                        <td>
                            Provinsi
                        </td>
                        <td>:</td>
                        <td>
                            <select class="pilortu" id="provinsiterlapor" onchange="getkota(0, this.value);">
                                <option value="-"> - pilih provinsi - </option>
                                <?php foreach ($daf_provinsi as $provinsi) : ?>
                                    <option value="<?= $provinsi['kode_wilayah'] ?>"><?= $provinsi['nama'] ?></option>

                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr id="kotaRowterlapor" style="display: none;">
                        <td>
                            Kab / Kota
                        </td>
                        <td>:</td>
                        <td>
                            <select class="pilortu" id="kotaterlapor" onchange="getkecamatan(0, this.value);">
                                <option> - pilih kota/kab - </option>
                            </select>
                        </td>
                    </tr>
                    <tr id="kecamatanRowterlapor" style="display: none;">
                        <td>
                            Kecamatan
                        </td>
                        <td>:</td>
                        <td>
                            <select class="pilortu" id="kecamatanterlapor" onchange="getdesa(0, this.value);">
                                <option> - pilih kecamatan - </option>
                            </select>
                        </td>
                    </tr>
                    <tr id="desaRowterlapor" style="display: none;">
                        <td>
                            Desa
                        </td>
                        <td>:</td>
                        <td>
                            <select class="pilortu" id="desaterlapor">
                                <option> - pilih desa - </option>
                            </select>
                        </td>
                    </tr>
                    <tr id="disabilitasRowterlapor" style="display: none;">
                        <td>
                            Apakah terlapor memiliki disabilitas?
                        </td>
                        <td>:</td>
                        <td>

                            <input type="radio" name="disabilitasterlapor" value="1" onclick="toggleInput('terlapor',this, 1)"> Ya, sebutkan:

                            <input type="text" id="inputdisabilitasterlapor" style="display: none;">
                            <br>
                            <div id="opsidisabilitasRowterlapor" style="margin-left: 20px; display: none">
                                <?php
                                foreach ($daf_kebutuhan_khusus as $row) {
                                    $kd_kb = $row['kebutuhan_khusus'];
                                    $kodeexp = explode("-", $kd_kb);
                                    $kode = trim($kodeexp[0], " ");
                                    echo '<input type="checkbox" value="' . $row['kebutuhan_khusus_id'] . '" id="checkbox' . $kode . 'terlapor"> ' . $kd_kb . '<br>';
                                }
                                ?>
                            </div>

                            <input type="radio" checked name="disabilitasterlapor" value="0" onclick="toggleInput('terlapor',this, 1)"> Tidak
                            <span class="info" id="infodisabilitasterlapor"></span><br>
                            <br>
                            <button onclick="konfirmdisabilitasterlapor(0)" id="tbdisabilitasterlapor" class="btn_abu2">Konfirm</button>
                        </td>
                    </tr>
                </table>
                <div style="margin-top: 10px; display:inline">
                    <button id="tbkurangiterlapor" style="margin-top: 10px; display: none;" class="btn_merah" onclick="kurangiTerlapor()">HAPUS PELAKU INI</button>
                    <button id="tbtambahterlapor" style="margin-top: 10px; display: none;" class="btn_ijo" onclick="tambahTerlapor()">INPUT PELAKU BERIKUTNYA</button>
                    <button id="tbkronologi" style="margin-top: 10px; display: none;" class="btn_ijo" onclick="inputkronologiTerlapor()">INPUT KRONOLOGI</button>
                </div>
            </div>

            <?php
            $jmlterlapor = 0;
            foreach ($data_terlapor as $terlapor) {
                $jmlterlapor++;
                $statusterlapor = $terlapor['status_korban_pelaku'];
                $tgllahir = ($terlapor['tanggal_lahir'] != null) ? substr($terlapor['tanggal_lahir'], 8, 2) . "/" . substr($terlapor['tanggal_lahir'], 5, 2) . "/" . substr($terlapor['tanggal_lahir'], 0, 4) : "-";
            ?>
                <div id="terlapor<?= $jmlterlapor ?>" class="terlapor" style="display:block">
                    <table class="tabelisian">
                        <tr>
                            <th class="kelabu" colspan="3"><?= ($jmlterlapor == 1) ? 'Bagian 2: ' : '' ?>Formulir Terlapor <?= $jmlterlapor ?></th>
                        </tr>
                        <tr>
                            <th style="width:40%"></th>
                            <th style="width:10px;"></th>
                            <th></th>
                        </tr>
                        <tr>
                            <td>
                                Status Terlapor *
                            </td>
                            <td>:</td>
                            <td>
                                <?php foreach ($daf_status_korban as $status) : ?>
                                    <div class="checkbox-container">
                                        <input disabled <?= ($status['status_korban_pelaku_id'] == $statusterlapor) ? 'checked' : '' ?> onchange="cekstatusterlapor(<?= $jmlterlapor ?>);" type="radio" name="status_terlapor<?= $jmlterlapor ?>" value="<?= $status['status_korban_pelaku_id'] ?>">
                                        <?= $status['nama'] ?>
                                    </div>
                                <?php endforeach; ?>
                            </td>
                        </tr>
                        <tr id="npsnRowterlapor<?= $jmlterlapor ?>" <?= ($statusterlapor == 6) ? "style='display:none;'" : "" ?>>
                            <td>
                                <?= ($statusterlapor == 2) ? "NPSN Peserta Didik *" : "NPSN Terlapor *" ?>
                            </td>
                            <td>:</td>
                            <td><input disabled type="text" placeholder="" id="npsnterlapor<?= $jmlterlapor ?>" name="npsnterlapor<?= $jmlterlapor ?>" value="<?= $terlapor['npsn'] ?>">
                                <span class="info" id="infonpsnterlapor<?= $jmlterlapor ?>"></span>
                            </td>
                        </tr>
                        <tr id="sekolahRowterlapor<?= $jmlterlapor ?>">
                            <td>
                                <?= ($statusterlapor < 6 && $statusterlapor != 2) ? 'Nama Sekolah Terlapor *' : (($statusterlapor == 2) ? 'Nama Sekolah Peserta Didik *' : 'Instansi Terlapor') ?>
                            </td>
                            <td>:</td>
                            <td><textarea disabled id="sekolahterlapor<?= $jmlterlapor ?>" name="sekolahterlapor<?= $jmlterlapor ?>"><?= $terlapor['nama_instansi'] ?></textarea>
                                <span class="info" id="infosekolahterlapor<?= $jmlterlapor ?>"></span>
                                <button style="display: none;" onclick="konfirmsekolahterlapor(<?= $jmlterlapor ?>)" id="tbsekolahterlapor<?= $jmlterlapor ?>" class="btn_abu2">Konfirm</button>
                            </td>
                        </tr>
                        <tr id="nisnRowterlapor<?= $jmlterlapor ?>" <?= ($statusterlapor == 6) ? "style='display:none;'" : "" ?>>
                            <td>
                                <?= ($statusterlapor == 1) ? 'NISN Terlapor' : (($statusterlapor == 2) ? 'NISN Peserta Didik' : 'NUPTK Terlapor') ?>
                            </td>
                            <td>:</td>
                            <td><input disabled type="text" placeholder="" id="nisnterlapor<?= $jmlterlapor ?>" name="nisnterlapor<?= $jmlterlapor ?>" value="<?= $terlapor['nisn'] ?>">
                                <span class="info" id="infonisnterlapor<?= $jmlterlapor ?>"></span><br>
                                <button style="display: none;" onclick="ceknisnterlapor(<?= $jmlterlapor ?>)" id="tbnisnterlapor<?= $jmlterlapor ?>" class="btn_abu2">Cek</button>
                            </td>
                        </tr>
                        <tr id="namaRowterlapor<?= $jmlterlapor ?>">
                            <td>
                                <?= ($statusterlapor != 2) ? 'Nama Terlapor *' : 'Nama Peserta Didik *' ?>
                            </td>
                            <td>:</td>
                            <td><textarea disabled id="namaterlapor<?= $jmlterlapor ?>" name="namaterlapor<?= $jmlterlapor ?>"><?= $terlapor['nama'] ?></textarea>
                                <span class="info" id="infonamaterlapor<?= $jmlterlapor ?>"></span><br>
                                <!-- <button onclick="konfirmnamaterlapor(0)" id="tbnamaterlapor" class="btn_abu2">Konfirm</button> -->
                            </td>
                        </tr>
                        <tr id="nikpdptkRowterlapor<?= $jmlterlapor ?>" <?= ($statusterlapor == 6) ? "style='display:none;'" : "" ?>>
                            <td>
                                <?= ($statusterlapor != 2) ? 'NIK Terlapor *' : 'NIK Peserta Didik *' ?>
                            </td>
                            <td>:</td>
                            <td><input disabled type="text" placeholder="" id="nikpdptkterlapor<?= $jmlterlapor ?>" name="nikpdptkterlapor<?= $jmlterlapor ?>" value="<?= $terlapor['nikpdptk'] ?>">
                                <span class="info" id="infonikpdptkterlapor<?= $jmlterlapor ?>"></span><br>
                                <button style="display: none;" onclick="ceknikpdptkterlapor(<?= $jmlterlapor ?>)" id="tbnikpdptkterlapor<?= $jmlterlapor ?>" class="btn_abu2">Konfirm</button>
                            </td>
                        </tr>
                        <tr id="nikRowterlapor<?= $jmlterlapor ?>" <?= ($statusterlapor == 2 || $statusterlapor == 6) ? '' : 'style="display:none"' ?>>
                            <td>
                                NIK Terlapor *
                            </td>
                            <td>:</td>
                            <td><select <?= ($statusterlapor == 6) ? "style='display:none;'" : "" ?> disabled class="pilortu" id="statusortuterlapor<?= $jmlterlapor ?>">
                                    <option <?= ($terlapor['status_ortu'] == "ayah") ? 'selected' : '' ?> value="ayah">Ayah</option>
                                    <option <?= ($terlapor['status_ortu'] == "ibu") ? 'selected' : '' ?> value="ibu">Ibu</option>
                                    <option <?= ($terlapor['status_ortu'] == "wali") ? 'selected' : '' ?> value="wali">Wali Murid</option>
                                </select>
                                <input disabled type="text" placeholder="" id="nikterlapor<?= $jmlterlapor ?>" name="nikterlapor<?= $jmlterlapor ?>" value="<?= $terlapor['nik'] ?>">
                                <span class="info" id="infonikterlapor<?= $jmlterlapor ?>"></span><br>
                                <button style="display: none;" onclick="ceknikterlapor(<?= $jmlterlapor ?>)" id="tbnikterlapor<?= $jmlterlapor ?>" class="btn_abu2">OK</button>
                            </td>
                        </tr>
                        <tr id="namaortuRowterlapor<?= $jmlterlapor ?>" <?= ($statusterlapor == 2) ? '' : 'style="display:none"' ?>>
                            <td>
                                Nama Terlapor *
                            </td>
                            <td>:</td>
                            <td><textarea disabled id="namaortuterlapor<?= $jmlterlapor ?>" name="namaortuterlapor<?= $jmlterlapor ?>"><?= $terlapor['nama2'] ?></textarea>
                                <span class="info" id="infonamaortuterlapor<?= $jmlterlapor ?>"></span><br>
                                <!-- <button style="display: none;" onclick="konfirmnamaortuterlapor(0)" id="tbnamaortuterlapor" class="btn_abu2">Konfirm</button> -->
                            </td>
                        </tr>
                        <tr id="tgllahirRowterlapor<?= $jmlterlapor ?>" <?= ($statusterlapor == 6) ? '' : 'style="display:none"' ?>>
                            <td>
                                Tanggal Lahir Terlapor
                            </td>
                            <td>:</td>
                            <td><input disabled type="text" id="datepickerterlapor<?= $jmlterlapor ?>" name="datepickerterlapor<?= $jmlterlapor ?>" onblur="validasiTanggalLahir()" placeholder="dd/mm/yyyy" value="<?= $tgllahir ?>">
                                <span id="errorTanggalLahirterlapor<?= $jmlterlapor ?>" style="color: red; display: none;">Format tanggal tidak valid.</span>
                            </td>
                        </tr>
                        <tr id="usiaRowterlapor<?= $jmlterlapor ?>" <?= ($statusterlapor == 6) ? '' : 'style="display:none"' ?>>
                            <td>
                                Usia Terlapor
                            </td>
                            <td>:</td>
                            <td>
                                <input disabled type="text" placeholder="" id="usiaterlapor<?= $jmlterlapor ?>" name="usiaterlapor<?= $jmlterlapor ?>" value="<?= $terlapor['usia'] ?>">
                                <span class="info" id="infousiaterlapor<?= $jmlterlapor ?>"></span>
                            </td><br>
                            <!-- <button onclick="cekusiaterlapor(0)" id="tbusiaterlapor" class="btn_abu2">OK</button> -->
                        </tr>
                        <tr id="jenis_kelaminRowterlapor<?= $jmlterlapor ?>">
                            <td>
                                Jenis Kelamin Terlapor *
                            </td>
                            <td>:</td>
                            <td>
                                <input <?= ($terlapor['jenis_kelamin'] == "L") ? 'checked' : '' ?> disabled type="radio" name="jenis_kelaminterlapor<?= $jmlterlapor ?>" value="L"> Laki-laki<br>
                                <input <?= ($terlapor['jenis_kelamin'] == "P") ? 'checked' : '' ?> disabled type="radio" name="jenis_kelaminterlapor<?= $jmlterlapor ?>" value="P"> Perempuan<br>
                                <span class="info" id="infojenis_kelaminterlapor<?= $jmlterlapor ?>"></span><br>
                                <button style="display: none;" onclick="konfirmjenis_kelaminterlapor(<?= $jmlterlapor ?>)" id="tbjenis_kelaminterlapor<?= $jmlterlapor ?>" class="btn_abu2">Konfirm</button>
                            </td>
                        </tr>
                        <tr id="alamatRowterlapor<?= $jmlterlapor ?>" <?= ($statusterlapor == 6) ? '' : 'style="display:none"' ?>>
                            <td>
                                Alamat Terlapor *
                            </td>
                            <td>:</td>
                            <td><input disabled type="text" placeholder="" id="alamatterlapor<?= $jmlterlapor ?>" name="alamatterlapor<?= $jmlterlapor ?>" value="<?= $terlapor['alamat'] ?>">
                                <span class="info" id="infoalamatterlapor<?= $jmlterlapor ?>"></span>
                            </td><br>
                            <!-- <button onclick="cekusiaterlapor(0)" id="tbusiaterlapor" class="btn_abu2">OK</button> -->
                        </tr>
                        <tr id="provinsiRowterlapor<?= $jmlterlapor ?>" <?= ($statusterlapor == 6) ? '' : 'style="display:none"' ?>>
                            <td>
                                Provinsi *
                            </td>
                            <td>:</td>
                            <td>
                                <select class="pilortu" id="provinsiterlapor<?= $jmlterlapor ?>" onchange="getkota(0, this.value);">
                                    <?php foreach ($daf_provinsi as $provinsi) :
                                        $selected = "";
                                        $pilprov = substr($terlapor['kode_wilayah'], 0, 2) . "0000";
                                        if (trim($provinsi['kode_wilayah']) == $pilprov)
                                            $selected = "selected";
                                    ?>
                                        <option <?= $selected ?> value="<?= $provinsi['kode_wilayah'] ?>"><?= $provinsi['nama'] ?></option>

                                    <?php endforeach; ?>
                                </select>
                            </td>
                        </tr>
                        <tr id="kotaRowterlapor<?= $jmlterlapor ?>" <?= ($statusterlapor == 6) ? '' : 'style="display:none"' ?>>
                            <td>
                                Kab / Kota *
                            </td>
                            <td>:</td>
                            <td>
                                <select disabled class="pilortu" id="kotaterlapor<?= $jmlterlapor ?>" onchange="getkecamatan(0, this.value);">
                                    <option><?= $terlapor['kota'] ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr id="kecamatanRowterlapor<?= $jmlterlapor ?>" <?= ($statusterlapor == 6) ? '' : 'style="display:none"' ?>>
                            <td>
                                Kecamatan *
                            </td>
                            <td>:</td>
                            <td>
                                <select disabled class="pilortu" id="kecamatanterlapor<?= $jmlterlapor ?>" onchange="getdesa(0, this.value);">
                                    <option><?= $terlapor['kecamatan'] ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr id="desaRowterlapor<?= $jmlterlapor ?>" <?= ($statusterlapor == 6) ? '' : 'style="display:none"' ?>>
                            <td>
                                Desa
                            </td>
                            <td>:</td>
                            <td>
                                <select class="pilortu" id="desaterlapor<?= $jmlterlapor ?>">
                                    <option><?= $terlapor['desa'] ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr id="disabilitasRowterlapor<?= $jmlterlapor ?>">
                            <td>
                                Apakah terlapor memiliki disabilitas?
                            </td>
                            <td>:</td>
                            <td>

                                <input disabled type="radio" <?= ($terlapor['disabilitas'] == 1) ? "checked" : "" ?> name="disabilitasterlapor<?= $jmlterlapor ?>" value="1" onclick="toggleInput(' terlapor',this, 1)"> Ya, sebutkan:

                                <input disabled type="text" id="inputdisabilitasterlapor<?= $jmlterlapor ?>" style="display: none;">
                                <br>
                                <div id="opsidisabilitasRowterlapor<?= $jmlterlapor ?>" style="margin-left: 20px; display: <?= ($terlapor['disabilitas'] == 1) ? "block" : "none" ?>">
                                    <?php
                                    $nilai_yang_dicari = explode('-', $terlapor['kebutuhan_khusus']);
                                    $nilai_yang_dicari = explode(',', $nilai_yang_dicari[0]);
                                    $nilai_yang_dicari = array_map('trim', $nilai_yang_dicari);

                                    foreach ($daf_kebutuhan_khusus as $row) {
                                        $kd_kb = $row['kebutuhan_khusus'];
                                        $kodeexp = explode("-", $kd_kb);
                                        $kode = trim($kodeexp[0], " ");
                                        $checked = "";
                                        if (in_array($kode, $nilai_yang_dicari)) {
                                            $checked = " checked ";
                                        }
                                        echo '<input ' . $checked . ' disabled type="checkbox" value="' . $row['kebutuhan_khusus_id'] . '" id="checkbox' . $kode . 'terlapor' . $jmlterlapor . '"> ' . $kd_kb . '<br>';
                                    }
                                    ?>
                                </div>

                                <input disabled type="radio" <?= ($terlapor['disabilitas'] == 0) ? "checked" : "" ?> name="disabilitasterlapor<?= $jmlterlapor ?>" value="0" onclick="toggleInput('terlapor',this, 1)"> Tidak
                                <span class="info" id="infodisabilitasterlapor<?= $jmlterlapor ?>"></span><br>
                                <br>
                                <button <?= ($statusterlapor == 6) ? '' : 'style="display:none"' ?> onclick="konfirmdisabilitasterlapor(<?= $jmlterlapor ?>)" id="tbdisabilitasterlapor<?= $jmlterlapor ?><?= $jmlterlapor ?>" class="btn_abu2">Konfirm</button>
                            </td>
                        </tr>
                    </table>
                    <div style="margin-top: 10px; display:inline">
                        <button id="tbkurangiterlapor" style="margin-top: 10px; display: none;" class="btn_merah" onclick="kurangiTerlapor()">HAPUS PELAKU INI</button>
                        <button id="tbtambahterlapor" style="margin-top: 10px; display: none;" class="btn_ijo" onclick="tambahTerlapor()">INPUT PELAKU BERIKUTNYA</button>
                        <button id="tbkronologi" style="margin-top: 10px; display: none;" class="btn_ijo" onclick="inputkronologiTerlapor()">INPUT KRONOLOGI</button>
                    </div>
                </div>
            <?php } ?>

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
                        <?php
                        $data_bentuk_string_cleaned = preg_replace("/[^0-9,]/", "", $data_pelaporan['bentuk_kekerasan']);
                        $data_bentuk_array = explode(',', $data_bentuk_string_cleaned);
                        $data_bentuk_array = array_filter($data_bentuk_array);
                        foreach ($daf_bentuk_kekerasan as $bentuk) {
                            $isChecked = in_array($bentuk['bentuk_kekerasan_id'], $data_bentuk_array);
                        ?>
                            <div class="checkbox-container">
                                <input disabled type="checkbox" name="k_<?= $bentuk['bentuk_kekerasan_id'] ?>" <?php echo $isChecked ? 'checked' : '' ?>>
                                <?= $bentuk['nama'] ?>
                            </div>
                        <?php } ?>

                    </td>
                </tr>
                <tr>
                    <td>
                        Cakupan Kekerasan
                    </td>
                    <td>:</td>
                    <td>
                        <div class="checkbox-container">
                            <input disabled <?= ($data_pelaporan['cakupan_kekerasan'] == "dalam") ? "checked" : "" ?> type="radio" name="cakupan" value="dalam">
                            Di dalam lokasi satuan pendidikan
                        </div>
                        <div class="checkbox-container">
                            <input disabled <?= ($data_pelaporan['cakupan_kekerasan'] == "luar") ? "checked" : "" ?> type="radio" name="cakupan" value="luar">
                            Di luar lokasi satuan pendidikan (namun masih dalam kegiatan satuan pendidikan)
                        </div>
                        <div class="checkbox-container">
                            <input disabled <?= ($data_pelaporan['cakupan_kekerasan'] == "lebih") ? "checked" : "" ?> type="radio" name="cakupan" value="lebih">
                            Melibatkan lebih dari 1 (satu) satuan pendidikan
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        Kronologi peristiwa
                    </td>
                    <td>:</td>
                    <td><textarea disabled id="ikronologi" rows="5"><?= $data_pelaporan['kronologi'] ?></textarea>
                        <br>
                        <button style="display:none" onclick="submitkronologi(this)" id="tbkronologi" class="btn_abu2">Submit</button>
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
                        Pengisi formulir adalah operator sekolah untuk Dapodik.
                    </li>
                    <li>
                        Formulir diisi paling lambat di akhir semester (Juni dan Desember).
                    </li>
                </ul>

            </div>
        </div>

    </div>
</div>



<?= $this->endSection(); ?>

<?= $this->section('scriptfooter') ?>

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
                for (var b = 1; b <= 6; b++)
                    if (document.getElementById('tb' + b).disabled == false) {
                        document.getElementById('dif' + b).style.display = "block";
                    }
            } else {
                toggle.checked = true;
                document.getElementById('tabs-container').classList.remove('hide');
                document.getElementById('singleViewBtn').classList.remove('aktif');
                document.getElementById('multiViewBtn').classList.add('aktif');
                for (var b = 1; b <= 6; b++) {
                    document.getElementById('dif' + (b)).style.display = "none";
                    if (document.getElementById('tb' + b).classList.contains("active")) {
                        document.getElementById('dif' + (b)).style.display = "block";
                    }
                }
                if (document.getElementById('tb5').classList.contains("active")) {
                    document.getElementById('dif6').style.display = "block";
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
        document.getElementById(divId).style.display = "block";
        // tbs.forEach(tb => tb.classList.remove('active'));
        for (var a = 1; a <= 6; a++) {
            document.getElementById("tb" + a).classList.remove('active');
        }
        document.getElementById("tb" + divId.substring(3, 4)).classList.add('active');
        if (document.getElementById('tb5').classList.contains("active")) {
            document.getElementById('dif6').style.display = "block";
        }
    }

    const sebagai = '<?= $sebagai ?>';
    var btnTidakBersedia = document.querySelector('.btn_merah');
    var btnBersedia = document.querySelector('.btn_ijo');
    var akhirDiv = document.getElementById('akhir');
    var isianDiv = document.getElementById('isian');
    var korbanDiv;
    var pelakuDiv = document.getElementById('pelaku');
    var terlaporDiv = document.getElementById('terlapor');
    var kronologiDiv = document.getElementById('kronologi');
    var tbya = document.getElementById('tbya');
    var tbtidak = document.getElementById('tbtidak');
    var tbstop = document.getElementById('tbstop');
    var pilstatus = {
        korban: [],
        pelaku: [],
        terlapor: []
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
    var nisn = "";
    var nama_sekolah = "";
    var disabilitas = "";
    var pildisabilitas = "";
    var disabilitasortu = "";
    var pildisabilitasortu = "";
    var statusakhir = 0;

    var csrf = '<?= csrf_hash(); ?>';

    let counterkorban = 0;
    let counterpelaku = 0;
    let counterterlapor = 0;

    var dafkodeKB = [];
    <?php
    foreach ($daf_kebutuhan_khusus as $row) {
        $kd_kb = $row['kebutuhan_khusus'];
        $kodeexp = explode("-", $kd_kb);
        $kode = trim($kodeexp[0], " ");
        echo 'dafkodeKB.push("' . $kode . '"); ';
    }
    ?>

    const lokasikorban = document.getElementById('lokasikorban');
    const lokasipelaku = document.getElementById('lokasipelaku');

    function cekstatuskorban(idx) {
        cekstatus("korban", idx);
    }

    function cekstatuspelaku(idx) {
        cekstatus("pelaku", idx);
    }

    function cekstatusterlapor(idx) {
        cekstatus("terlapor", idx);
    }

    function cekpilihjkkorban(idx) {
        cekpilihjk("korban", idx);
    }

    function cekpilihjkpelaku(idx) {
        cekpilihjk("pelaku", idx);
    }

    function cekpilihjkterlapor(idx) {
        cekpilihjk("terlapor", idx);
    }

    function kembali() {
        window.open("<?= base_url('daftar_laporan_kekerasan') ?>", "_self");
    }

    function cekpilihjk(siapa, idx) {
        document.getElementById('infojenis_kelamin' + siapa + idx).innerHTML = "";
    }

    function cekstatus(siapa, idx) {
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
            // if (!btn.classList.contains('clicked')) {
            //     btn.disabled = true;
            // } else {
            //     btn.removeAttribute('disabled');
            // }
        });

        var xsiapa = capitalizeFirstLetter(siapa);
        var xsiapa2 = "";
        if (selectedValuestatus == 2) {
            xsiapa2 = xsiapa + " (Ayah)";
            xsiapa = "Peserta Didik";
        } else if (selectedValuestatus == 6) {
            xsiapa2 = xsiapa;
        }

        var checkboxes = document.querySelectorAll('#container input[type="checkbox"]');

        checkboxes.forEach(function(checkbox) {
            checkbox.disabled = true;
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
        const nisnrow = document.getElementById('nisnRow' + siapa + idx);
        const nisn = document.getElementById('nisn' + siapa + idx);
        const labels = nisnrow.getElementsByTagName('td');
        const nikrow = document.getElementById('nikRow' + siapa + idx);
        const tbnik = document.getElementById('tbnik' + siapa + idx);
        const statusortu = document.getElementById('statusortu' + siapa + idx);
        const labelnik2 = nikrow.getElementsByTagName('td');
        const isinik = document.getElementById('nik' + siapa + idx);
        const nikpdptkrow = document.getElementById('nikpdptkRow' + siapa + idx);
        const labelnikpdptk = nikpdptkrow.getElementsByTagName('td');
        const sekolahrow = document.getElementById('sekolahRow' + siapa + idx);
        const sekolah = document.getElementById('sekolah' + siapa + idx);
        const infosekolah = document.getElementById('infosekolah' + siapa + idx);
        const tbsekolah = document.getElementById('tbsekolah' + siapa + idx);
        const labels2 = sekolahrow.getElementsByTagName('td');
        const namarow = document.getElementById('namaRow' + siapa + idx);
        const nama = document.getElementById('nama' + siapa + idx);
        const labelnama = namarow.getElementsByTagName('td');
        const namaorturow = document.getElementById('namaortuRow' + siapa + idx);
        const labelnama2 = namaorturow.getElementsByTagName('td');
        const usiarow = document.getElementById('usiaRow' + siapa + idx);
        const usia = document.getElementById('usia' + siapa + idx);
        const tglahirrow = document.getElementById('tgllahirRow' + siapa + idx);
        const jenis_kelaminrow = document.getElementById('jenis_kelaminRow' + siapa + idx);
        const alamatrow = document.getElementById('alamatRow' + siapa + idx);
        const alamat = document.getElementById('alamat' + siapa + idx);
        const provinsirow = document.getElementById('provinsiRow' + siapa + idx);
        const kotarow = document.getElementById('kotaRow' + siapa + idx);
        const kecamatanrow = document.getElementById('kecamatanRow' + siapa + idx);
        const desarow = document.getElementById('desaRow' + siapa + idx);
        const disabilitasrow = document.getElementById('disabilitasRow' + siapa + idx);

        labelnpsn[0].innerText = 'NPSN ' + xsiapa;
        labelnama[0].innerText = 'Nama ' + xsiapa;
        labelnikpdptk[0].innerText = 'NIK ' + xsiapa;
        labelnik2[0].innerText = 'NIK ' + xsiapa2;
        labelnama2[0].innerText = 'Nama ' + xsiapa2;

        namaorturow.style.display = "none";

        if (selectedValuestatus >= 1 && selectedValuestatus <= 2) {
            tglahirrow.style.display = 'none';
            alamatrow.style.display = 'none';
            nikrow.style.display = 'none';
            // nikpdptkrow.style.display = 'table-row';
            npsnrow.style.display = 'table-row';
            npsnrow.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
            if (selectedValuestatus == 2)
                statusortu.style.display = 'table-row';
            labels[0].innerText = 'NISN ' + xsiapa;
            labels2[0].innerText = 'Nama Sekolah ' + xsiapa;
            xinfonis = "NISN tidak sesuai";
            tbsekolah.innerText = "Konfirm";
            tbsekolah.style.display = 'table-row';
            // tbnama.innerText = "Konfirm";
            if (tbsekolah.style.display == 'none') {
                nisnrow.style.display = "table-row";
                sekolah.disabled = true;
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
            // if (selectedValuestatus == 2) {
            //     if (namarow.style.display == "table-row")
            //         namaorturow.style.display = "table-row";
            // }
        } else if (selectedValuestatus >= 3 && selectedValuestatus <= 5) {
            nikrow.style.display = 'none';
            tglahirrow.style.display = 'none';
            alamatrow.style.display = 'none';
            // nikpdptkrow.style.display = 'table-row';
            npsnrow.style.display = 'table-row';
            npsnrow.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
            labels[0].innerText = 'NIK / NUPTK ' + xsiapa;
            labels2[0].innerText = 'Nama Sekolah ' + xsiapa;
            xinfonis = "NIK / NUPTK tidak sesuai";
            tbsekolah.innerText = "Konfirm";
            tbsekolah.style.display = 'table-row';
            // tbnama.innerText = "Konfirm";
            if (tbsekolah.style.display == 'none') {
                nisnrow.style.display = "table-row";
                sekolah.disabled = true;
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
            npsnrow.style.display = 'none';
            nikrow.style.display = 'table-row';
            tbnik.style.display = 'none';
            statusortu.style.display = 'none';
            tglahirrow.style.display = 'table-row';
            usiarow.style.display = 'table-row';
            provinsirow.style.display = 'table-row';
            kotarow.style.display = 'table-row';
            kecamatanrow.style.display = 'table-row';
            desarow.style.display = 'table-row';
            disabilitasrow.style.display = 'table-row';
            usia.style.display = 'table-row';
            alamatrow.style.display = 'table-row';
            alamat.style.display = 'table-row';
            jenis_kelaminrow.style.display = 'table-row';
            if (alamat.value != "")
                alamatrow.style.display = 'table-row';
            namarow.style.display = 'table-row';
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
            if (sekolah.value != "")
                nikrow.style.display = 'table-row';
            if (isinik.value != "")
                namarow.style.display = 'table-row';
        }

        if (sebagai == "sekolah") {
            npsn.disabled = true;
            tbcarisekolah.style.display = 'none';
        }

    }

    function capitalizeFirstLetter(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    ////////////// KORBAN ////////////////////////////////////////////////

    function tambahKorban() {
        counterkorban++;

        pilstatus['korban'][counterkorban] = "";
        const clone = document.getElementById('korban').cloneNode(true);
        tbkorban = document.getElementById('tbkorban');
        tbkorban.style.display = 'none';

        updateElementIdskorban(clone);
        updateElementNameskorban(clone);

        clone.id = 'korban' + counterkorban;
        clone.querySelectorAll('th.kelabu').forEach(th => {
            if (counterkorban == 1)
                th.textContent = th.textContent.replace('Bagian 1: Formulir Korban', 'Bagian ' + counterkorban + ': Formulir Korban ' + counterkorban);
            else
                th.textContent = th.textContent.replace('Bagian 1: Formulir Korban', 'Formulir Korban ' + counterkorban);
        });

        clone.querySelectorAll('[name^="datepickerkorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterkorban;
            btn.setAttribute('onblur', `validasiTanggalLahirkorban(${counterkorban})`);
        });

        clone.querySelectorAll('[name^="status_korban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterkorban;
            btn.setAttribute('onchange', `cekstatuskorban(${counterkorban})`);
        });

        clone.querySelectorAll('[name^="disabilitaskorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterkorban;
            btn.setAttribute('onclick', `toggleInput('korban',this, ${counterkorban})`);
        });

        clone.querySelectorAll('[id^="npsnkorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterkorban;
            btn.addEventListener('change', function(event) {
                changenpsn("korban", counterkorban);
            });

            btn.addEventListener('input', function(event) {
                changenpsn("korban", counterkorban);
            });
        });

        clone.querySelectorAll('[id^="tbnpsnkorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterkorban;
            btn.setAttribute('onclick', `submitnpsnkorban(${counterkorban})`);
        });

        clone.querySelectorAll('[id^="sekolahkorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterkorban;
            btn.addEventListener('change', function(event) {
                changesekolah("korban", counterkorban);
            });

            btn.addEventListener('input', function(event) {
                changesekolah("korban", counterkorban);
            });
        });

        clone.querySelectorAll('[id^="tbcarisekolahkorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterkorban;
            btn.setAttribute('onclick', `tampilmodalkorban(${counterkorban})`);
        });

        clone.querySelectorAll('[id^="nisnkorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterkorban;
            btn.addEventListener('change', function(event) {
                changenisn("korban", counterkorban);
            });

            btn.addEventListener('input', function(event) {
                changenisn("korban", counterkorban);
            });
        });

        clone.querySelectorAll('[id^="tbnisnkorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterkorban;
            btn.setAttribute('onclick', `ceknisnkorban(${counterkorban})`);
        });

        clone.querySelectorAll('[id^="tbnikkorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterkorban;
            btn.setAttribute('onclick', `ceknikkorban(${counterkorban})`);
        });

        clone.querySelectorAll('[id^="nikkorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterkorban;
            btn.addEventListener('change', function(event) {
                changenik("korban", counterkorban);
            });

            btn.addEventListener('input', function(event) {
                changenik("korban", counterkorban);
            });
        });

        clone.querySelectorAll('[id^="tbnikpdptkkorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterkorban;
            btn.setAttribute('onclick', `ceknikpdptkkorban(${counterkorban})`);
        });

        clone.querySelectorAll('[id^="tbnamakorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterkorban;
            btn.setAttribute('onclick', `konfirmnamakorban(${counterkorban})`);
        });

        clone.querySelectorAll('[id^="namakorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterkorban;
            btn.addEventListener('change', function(event) {
                changenama("korban", counterkorban);
            });

            btn.addEventListener('input', function(event) {
                changenama("korban", counterkorban);
            });
        });

        clone.querySelectorAll('[id^="statusortukorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterkorban;
            btn.setAttribute('onchange', `changestatusortukorban(${counterkorban})`);
        });

        clone.querySelectorAll('[id^="tbnamaortukorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterkorban;
            btn.setAttribute('onclick', `konfirmnamaortukorban(${counterkorban})`);
        });

        clone.querySelectorAll('[id^="namaortukorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterkorban;
            btn.addEventListener('change', function(event) {
                changenamaortu("korban", counterkorban);
            });

            btn.addEventListener('input', function(event) {
                changenamaortu("korban", counterkorban);
            });
        });

        clone.querySelectorAll('[id^="tbnisnkorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterkorban;
            btn.setAttribute('onclick', `ceknisnkorban(${counterkorban})`);
        });

        clone.querySelectorAll('[id^="tbjenis_kelaminkorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterkorban;
            btn.setAttribute('onclick', `konfirmjenis_kelaminkorban(${counterkorban})`);
        });

        clone.querySelectorAll('[name^="jenis_kelaminkorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterkorban;
            btn.setAttribute('onchange', `cekpilihjkkorban(${counterkorban})`);
        });

        clone.querySelectorAll('[id^="tbsekolahkorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterkorban;
            btn.setAttribute('onclick', `konfirmsekolahkorban(${counterkorban})`);
        });

        clone.querySelectorAll('[id^="tbdisabilitaskorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterkorban;
            btn.setAttribute('onclick', `konfirmdisabilitaskorban(${counterkorban})`);
        });

        clone.querySelectorAll('[id^="tbpelakukorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterkorban;
            if (statuskasus == 1)
                btn.setAttribute('onclick', 'tambahPelaku()');
            else
                btn.setAttribute('onclick', 'tambahTerlapor()');
        });

        clone.querySelectorAll('[id^="provinsikorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterkorban;
            btn.setAttribute('onchange', `getkota("korban", ${counterkorban}, this.value)`);
        });

        clone.querySelectorAll('[id^="kotakorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterkorban;
            btn.setAttribute('onchange', `getkecamatan("korban", ${counterkorban}, this.value)`);
        });

        clone.querySelectorAll('[id^="kecamatankorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterkorban;
            btn.setAttribute('onchange', `getdesa("korban", ${counterkorban}, this.value)`);
        });

        lokasikorban.appendChild(clone);

        const datePickerElement = $(clone).find("#datepickerkorban" + counterkorban);

        datePickerElement.datepicker({
            dateFormat: 'dd/mm/yy'
        });

        korbanDiv = document.getElementById('korban' + counterkorban);
        korbanDiv.classList.add('fade-in');
        korbanDiv.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });

        if (counterkorban > 1) {
            tbkurangikorban = document.getElementById('tbkurangikorban' + counterkorban);
            tbkurangikorban.style.display = 'inline';

            tbtambahkorbanprev = document.getElementById('tbtambahkorban' + (counterkorban - 1));
            tbtambahkorbanprev.style.display = 'none';
            tbkurangikorbanprev = document.getElementById('tbkurangikorban' + (counterkorban - 1));
            tbkurangikorbanprev.style.display = 'none';
            tbpelaku = document.getElementById('tbpelakukorban' + (counterkorban - 1));
            tbpelaku.style.display = 'none';
        }

    }

    function kurangiKorban() {
        if (confirm("Yakin akan menghapus Korban ini?")) {
            const clonedElement = document.getElementById('korban' + counterkorban);
            clonedElement.remove();
            counterkorban--;
            tbtambahkorbanprev = document.getElementById('tbtambahkorban' + counterkorban);
            tbtambahkorbanprev.style.display = 'inline';
            tbpelaku = document.getElementById('tbpelakukorban' + counterkorban);
            tbpelaku.style.display = 'inline';
            if (counterkorban > 1) {
                tbkurangikorbanprev = document.getElementById('tbkurangikorban' + counterkorban);
                tbkurangikorbanprev.style.display = 'inline';
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

    function tambahPelaku() {
        counterpelaku++;

        pilstatus['pelaku'][counterpelaku] = "";
        const clone = document.getElementById('pelaku').cloneNode(true);
        // tbpelaku = document.getElementById('tbpelakukorban' + counterpelaku);
        // tbpelaku.style.display = 'none';

        updateElementIdspelaku(clone);
        updateElementNamespelaku(clone);

        clone.id = 'pelaku' + counterpelaku;
        clone.querySelectorAll('th.kelabu').forEach(th => {
            if (counterpelaku == 1)
                th.textContent = th.textContent.replace('Bagian 2: Formulir Pelaku', 'Bagian 2: Formulir Pelaku ' + counterpelaku);
            else
                th.textContent = th.textContent.replace('Bagian 2: Formulir Pelaku', 'Formulir Pelaku ' + counterpelaku);
        });

        clone.querySelectorAll('[name^="datepickerpelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterpelaku;
            btn.setAttribute('onblur', `validasiTanggalLahirpelaku(${counterpelaku})`);
        });

        clone.querySelectorAll('[name^="status_pelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterpelaku;
            btn.setAttribute('onchange', `cekstatuspelaku(${counterpelaku})`);
        });

        clone.querySelectorAll('[name^="disabilitaspelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterpelaku;
            btn.setAttribute('onclick', `toggleInput('pelaku',this, ${counterpelaku})`);
        });

        clone.querySelectorAll('[id^="npsnpelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterpelaku;
            btn.addEventListener('change', function(event) {
                changenpsn("pelaku", counterpelaku);
            });

            btn.addEventListener('input', function(event) {
                changenpsn("pelaku", counterpelaku);
            });
        });

        clone.querySelectorAll('[id^="tbnpsnpelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterpelaku;
            btn.setAttribute('onclick', `submitnpsnpelaku(${counterpelaku})`);
        });

        clone.querySelectorAll('[id^="sekolahpelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterpelaku;
            btn.addEventListener('change', function(event) {
                changesekolah("pelaku", counterpelaku);
            });

            btn.addEventListener('input', function(event) {
                changesekolah("pelaku", counterpelaku);
            });
        });

        clone.querySelectorAll('[id^="tbcarisekolahpelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterpelaku;
            btn.setAttribute('onclick', `tampilmodalpelaku(${counterpelaku})`);
        });

        clone.querySelectorAll('[id^="nisnpelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterpelaku;
            btn.addEventListener('change', function(event) {
                changenisn("pelaku", counterpelaku);
            });

            btn.addEventListener('input', function(event) {
                changenisn("pelaku", counterpelaku);
            });
        });

        clone.querySelectorAll('[id^="tbnisnpelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterpelaku;
            btn.setAttribute('onclick', `ceknisnpelaku(${counterpelaku})`);
        });

        clone.querySelectorAll('[id^="tbnikpelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterpelaku;
            btn.setAttribute('onclick', `ceknikpelaku(${counterpelaku})`);
        });

        clone.querySelectorAll('[id^="nikpelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterpelaku;
            btn.addEventListener('change', function(event) {
                changenik("pelaku", counterpelaku);
            });

            btn.addEventListener('input', function(event) {
                changenik("pelaku", counterpelaku);
            });
        });

        clone.querySelectorAll('[id^="tbnikpdptkpelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterpelaku;
            btn.setAttribute('onclick', `ceknikpdptkpelaku(${counterpelaku})`);
        });

        clone.querySelectorAll('[id^="tbnamapelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterpelaku;
            btn.setAttribute('onclick', `konfirmnamapelaku(${counterpelaku})`);
        });

        clone.querySelectorAll('[id^="namapelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterpelaku;
            btn.addEventListener('change', function(event) {
                changenama("pelaku", counterpelaku);
            });

            btn.addEventListener('input', function(event) {
                changenama("pelaku", counterpelaku);
            });
        });

        clone.querySelectorAll('[id^="statusortupelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterpelaku;
            btn.setAttribute('onchange', `changestatusortupelaku(${counterpelaku})`);
        });

        clone.querySelectorAll('[id^="tbnamaortupelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterpelaku;
            btn.setAttribute('onclick', `konfirmnamaortupelaku(${counterpelaku})`);
        });

        clone.querySelectorAll('[id^="namaortupelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterpelaku;
            btn.addEventListener('change', function(event) {
                changenamaortu("pelaku", counterpelaku);
            });

            btn.addEventListener('input', function(event) {
                changenamaortu("pelaku", counterpelaku);
            });
        });

        clone.querySelectorAll('[id^="tbnisnpelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterpelaku;
            btn.setAttribute('onclick', `ceknisnpelaku(${counterpelaku})`);
        });

        clone.querySelectorAll('[id^="tbjenis_kelaminpelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterpelaku;
            btn.setAttribute('onclick', `konfirmjenis_kelaminpelaku(${counterpelaku})`);
        });

        clone.querySelectorAll('[name^="jenis_kelaminpelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterpelaku;
            btn.setAttribute('onchange', `cekpilihjkpelaku(${counterpelaku})`);
        });

        clone.querySelectorAll('[id^="tbsekolahpelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterpelaku;
            btn.setAttribute('onclick', `konfirmsekolahpelaku(${counterpelaku})`);
        });

        clone.querySelectorAll('[id^="tbdisabilitaspelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterpelaku;
            btn.setAttribute('onclick', `konfirmdisabilitaspelaku(${counterpelaku})`);
        });

        clone.querySelectorAll('[id^="provinsipelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterpelaku;
            btn.setAttribute('onchange', `getkota("pelaku", ${counterpelaku}, this.value)`);
        });

        clone.querySelectorAll('[id^="kotapelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterpelaku;
            btn.setAttribute('onchange', `getkecamatan("pelaku", ${counterpelaku}, this.value)`);
        });

        clone.querySelectorAll('[id^="kecamatanpelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterpelaku;
            btn.setAttribute('onchange', `getdesa("pelaku", ${counterpelaku}, this.value)`);
        });

        lokasipelaku.appendChild(clone);

        const datePickerElement = $(clone).find("#datepickerpelaku" + counterpelaku);

        datePickerElement.datepicker({
            dateFormat: 'dd/mm/yy'
        });

        pelakuDiv = document.getElementById('pelaku' + counterpelaku);
        pelakuDiv.classList.add('fade-in');
        pelakuDiv.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });

        if (counterpelaku > 1) {
            tbkurangipelaku = document.getElementById('tbkurangipelaku' + counterpelaku);
            tbkurangipelaku.style.display = 'inline';

            tbtambahpelakuprev = document.getElementById('tbtambahpelaku' + (counterpelaku - 1));
            tbtambahpelakuprev.style.display = 'none';
            tbkurangipelakuprev = document.getElementById('tbkurangipelaku' + (counterpelaku - 1));
            tbkurangipelakuprev.style.display = 'none';
            tbkronologi = document.getElementById('tbkronologi' + (counterpelaku - 1));
            tbkronologi.style.display = 'none';
        } else {
            tbkorbanprev = document.getElementById('tbtambahkorban' + counterkorban);
            tbkorbanprev.style.display = 'none';
            tbkurkorbanprev = document.getElementById('tbkurangikorban' + counterkorban);
            tbkurkorbanprev.style.display = 'none';
            tbtambahpelakuprev = document.getElementById('tbpelakukorban' + counterkorban);
            tbtambahpelakuprev.style.display = 'none';
        }

    }

    function kurangiPelaku() {
        if (confirm("Yakin akan menghapus Pelaku ini?")) {
            const clonedElement = document.getElementById('pelaku' + counterpelaku);
            clonedElement.remove();
            counterpelaku--;
            tbtambahpelakuprev = document.getElementById('tbtambahpelaku' + counterpelaku);
            tbtambahpelakuprev.style.display = 'inline';
            tbkronologi = document.getElementById('tbkronologi' + counterpelaku);
            tbkronologi.style.display = 'inline';
            if (counterpelaku > 1) {
                tbkurangipelakuprev = document.getElementById('tbkurangipelaku' + counterpelaku);
                tbkurangipelakuprev.style.display = 'inline';
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
    ///////////////////////////////////////////////////////////////////////////

    ////////////// TERLAPOR ////////////////////////////////////////////////

    function tambahTerlapor() {
        counterterlapor++;

        pilstatus['terlapor'][counterterlapor] = "";
        const clone = document.getElementById('terlapor').cloneNode(true);
        // tbterlapor = document.getElementById('tbpelakukorban' + counterterlapor);
        // tbterlapor.style.display = 'none';

        updateElementIdsterlapor(clone);
        updateElementNamesterlapor(clone);

        clone.id = 'terlapor' + counterterlapor;
        clone.querySelectorAll('th.kelabu').forEach(th => {
            if (counterterlapor == 1)
                th.textContent = th.textContent.replace('Bagian 2: Formulir Terlapor', 'Bagian 2: Formulir Terlapor ' + counterterlapor);
            else
                th.textContent = th.textContent.replace('Bagian 2: Formulir Terlapor', 'Formulir Terlapor ' + counterterlapor);
        });

        clone.querySelectorAll('[name^="datepickerterlapor"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterterlapor;
            btn.setAttribute('onblur', `validasiTanggalLahirterlapor(${counterterlapor})`);
        });

        clone.querySelectorAll('[name^="status_terlapor"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterterlapor;
            btn.setAttribute('onchange', `cekstatusterlapor(${counterterlapor})`);
        });

        clone.querySelectorAll('[name^="disabilitasterlapor"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterterlapor;
            btn.setAttribute('onclick', `toggleInput('terlapor',this, ${counterterlapor})`);
        });

        clone.querySelectorAll('[id^="npsnterlapor"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterterlapor;
            btn.addEventListener('change', function(event) {
                changenpsn("terlapor", counterterlapor);
            });

            btn.addEventListener('input', function(event) {
                changenpsn("terlapor", counterterlapor);
            });
        });

        clone.querySelectorAll('[id^="tbnpsnterlapor"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterterlapor;
            btn.setAttribute('onclick', `submitnpsnterlapor(${counterterlapor})`);
        });

        clone.querySelectorAll('[id^="sekolahterlapor"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterterlapor;
            btn.addEventListener('change', function(event) {
                changesekolah("terlapor", counterterlapor);
            });

            btn.addEventListener('input', function(event) {
                changesekolah("terlapor", counterterlapor);
            });
        });

        clone.querySelectorAll('[id^="tbcarisekolahterlapor"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterterlapor;
            btn.setAttribute('onclick', `tampilmodalterlapor(${counterterlapor})`);
        });

        clone.querySelectorAll('[id^="nisnterlapor"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterterlapor;
            btn.addEventListener('change', function(event) {
                changenisn("terlapor", counterterlapor);
            });

            btn.addEventListener('input', function(event) {
                changenisn("terlapor", counterterlapor);
            });
        });

        clone.querySelectorAll('[id^="tbnisnterlapor"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterterlapor;
            btn.setAttribute('onclick', `ceknisnterlapor(${counterterlapor})`);
        });

        clone.querySelectorAll('[id^="tbnikterlapor"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterterlapor;
            btn.setAttribute('onclick', `ceknikterlapor(${counterterlapor})`);
        });

        clone.querySelectorAll('[id^="nikterlapor"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterterlapor;
            btn.addEventListener('change', function(event) {
                changenik("terlapor", counterterlapor);
            });

            btn.addEventListener('input', function(event) {
                changenik("terlapor", counterterlapor);
            });
        });

        clone.querySelectorAll('[id^="tbnikpdptkterlapor"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterterlapor;
            btn.setAttribute('onclick', `ceknikpdptkterlapor(${counterterlapor})`);
        });

        clone.querySelectorAll('[id^="tbnamaterlapor"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterterlapor;
            btn.setAttribute('onclick', `konfirmnamaterlapor(${counterterlapor})`);
        });

        clone.querySelectorAll('[id^="namaterlapor"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterterlapor;
            btn.addEventListener('change', function(event) {
                changenama("terlapor", counterterlapor);
            });

            btn.addEventListener('input', function(event) {
                changenama("terlapor", counterterlapor);
            });
        });

        clone.querySelectorAll('[id^="statusortuterlapor"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterterlapor;
            btn.setAttribute('onchange', `changestatusortuterlapor(${counterterlapor})`);
        });

        clone.querySelectorAll('[id^="tbnamaortuterlapor"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterterlapor;
            btn.setAttribute('onclick', `konfirmnamaortuterlapor(${counterterlapor})`);
        });

        clone.querySelectorAll('[id^="namaortuterlapor"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterterlapor;
            btn.addEventListener('change', function(event) {
                changenamaortu("terlapor", counterterlapor);
            });

            btn.addEventListener('input', function(event) {
                changenamaortu("terlapor", counterterlapor);
            });
        });

        clone.querySelectorAll('[id^="tbnisnterlapor"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterterlapor;
            btn.setAttribute('onclick', `ceknisnterlapor(${counterterlapor})`);
        });

        clone.querySelectorAll('[id^="tbjenis_kelaminterlapor"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterterlapor;
            btn.setAttribute('onclick', `konfirmjenis_kelaminterlapor(${counterterlapor})`);
        });

        clone.querySelectorAll('[name^="jenis_kelaminterlapor"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterterlapor;
            btn.setAttribute('onchange', `cekpilihjkterlapor(${counterterlapor})`);
        });

        clone.querySelectorAll('[id^="tbsekolahterlapor"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterterlapor;
            btn.setAttribute('onclick', `konfirmsekolahterlapor(${counterterlapor})`);
        });

        clone.querySelectorAll('[id^="tbdisabilitasterlapor"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterterlapor;
            btn.setAttribute('onclick', `konfirmdisabilitasterlapor(${counterterlapor})`);
        });

        clone.querySelectorAll('[id^="provinsiterlapor"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterterlapor;
            btn.setAttribute('onchange', `getkota("terlapor", ${counterterlapor}, this.value)`);
        });

        clone.querySelectorAll('[id^="kotaterlapor"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterterlapor;
            btn.setAttribute('onchange', `getkecamatan("terlapor", ${counterterlapor}, this.value)`);
        });

        clone.querySelectorAll('[id^="kecamatanterlapor"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterterlapor;
            btn.setAttribute('onchange', `getdesa("terlapor", ${counterterlapor}, this.value)`);
        });

        lokasiterlapor.appendChild(clone);

        const datePickerElement = $(clone).find("#datepickerterlapor" + counterterlapor);

        datePickerElement.datepicker({
            dateFormat: 'dd/mm/yy'
        });

        terlaporDiv = document.getElementById('terlapor' + counterterlapor);
        terlaporDiv.classList.add('fade-in');
        terlaporDiv.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });

        if (counterterlapor > 1) {
            tbkurangiterlapor = document.getElementById('tbkurangiterlapor' + counterterlapor);
            tbkurangiterlapor.style.display = 'inline';

            tbtambahterlaporprev = document.getElementById('tbtambahterlapor' + (counterterlapor - 1));
            tbtambahterlaporprev.style.display = 'none';
            tbkurangiterlaporprev = document.getElementById('tbkurangiterlapor' + (counterterlapor - 1));
            tbkurangiterlaporprev.style.display = 'none';
            tbkronologi = document.getElementById('tbkronologi' + (counterterlapor - 1));
            tbkronologi.style.display = 'none';
        } else {
            tbkorbanprev = document.getElementById('tbtambahkorban' + counterkorban);
            tbkorbanprev.style.display = 'none';
            tbkurkorbanprev = document.getElementById('tbkurangikorban' + counterkorban);
            tbkurkorbanprev.style.display = 'none';
            tbtambahterlaporprev = document.getElementById('tbpelakukorban' + counterkorban);
            tbtambahterlaporprev.style.display = 'none';
        }

    }

    function kurangiTerlapor() {
        if (confirm("Yakin akan menghapus Terlapor ini?")) {
            const clonedElement = document.getElementById('terlapor' + counterterlapor);
            clonedElement.remove();
            counterterlapor--;
            tbtambahterlaporprev = document.getElementById('tbtambahterlapor' + counterterlapor);
            tbtambahterlaporprev.style.display = 'inline';
            tbkronologi = document.getElementById('tbkronologi' + counterterlapor);
            tbkronologi.style.display = 'inline';
            if (counterterlapor > 1) {
                tbkurangiterlaporprev = document.getElementById('tbkurangiterlapor' + counterterlapor);
                tbkurangiterlaporprev.style.display = 'inline';
            }
        }
    }

    function updateElementIdsterlapor(element) {
        const inputs = element.querySelectorAll('[id]');
        inputs.forEach(input => {
            const newId = input.id + counterterlapor;
            input.id = newId;
        });
    }

    function updateElementNamesterlapor(element) {
        const inputs = element.querySelectorAll('[name]');
        inputs.forEach(input => {
            const newName = input.name + counterterlapor;
            input.name = newName;
        });
    }
    ///////////////////////////////////////////////////////////////////////////

    function get_data(siapa, jenis, idx) {

        var npsn = document.getElementById('npsn' + siapa + idx).value;
        var nisn = document.getElementById('nisn' + siapa + idx).value;
        var iinfonisn = document.getElementById('infonisn' + siapa + idx);
        const nisnrow = document.getElementById('nisnRow' + siapa + idx);
        const labelnnisn = nisnrow.getElementsByTagName('td');

        alamat = '<?= base_url() . "inputdata/get_data_p" ?>';

        var url = alamat;
        var data = {
            npsn: npsn,
            nisn: nisn,
            jenis: jenis,
            csrf_test_name: csrf,
        };

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            dataType: 'json',
            cache: false,
            success: function(result) {
                // alert("kucil");
                csrf = result.csrf;
                nama = result.nama_siswa;
                if (nama == "")
                    iinfonisn.innerText = xinfonis;
                else {
                    iinfonisn.innerText = "";
                    document.getElementById('tbnisn' + siapa + idx).style.display = 'none';
                }
                valnama = result.valnama_siswa;
                nisn = result.nisn;
                nik_pdptk = result.nik;
                jenis_kelamin = result.jenis_kelamin;
                valjenis_kelamin = result.valjenis_kelamin;
                // nama_sekolah = result.nama_sekolah;
                if (jenis == 1) {
                    if (result.disabilitas_id > 0) {
                        pildisabilitas = "1";
                        disabilitas = result.disabilitas;
                    } else {
                        pildisabilitas = "0";
                    }
                } else {
                    pildisabilitas = "0";
                    labelnnisn[0].innerText = result.nomor + " " + capitalizeFirstLetter(siapa);
                }

                const tbnisn = document.getElementById('tbnisn' + siapa + idx);
                tbnisn.disabled = false;
                tbnisn.style.display = 'none';
                // tbnisn.innerHTML = "cek";

                tampilkannamadll(siapa, idx);

            }
        });

    }

    function tampilkannamadll(siapa, idx) {
        var namarow = document.getElementById('namaRow' + siapa + idx);
        var inama = document.getElementById('nama' + siapa + idx);
        var iinfonama = document.getElementById('infonama' + siapa + idx);

        var selectedValue;
        const radioButtons1 = document.querySelectorAll('input[name="status_' + siapa + idx + '"]');
        radioButtons1.forEach((radio) => {
            if (radio.checked) {
                selectedValue = radio.value;
            }
        });
        // var nikpdptk = document.getElementById('nikpdptk' + siapa + idx).value;

        namarow.style.display = "table-row";
        inama.value = nama;
        if (valnama == null)
            valnama = "Belum Valid";
        iinfonama.innerText = "Dukcapil: " + valnama;

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
        var nik = document.getElementById('nikpdptk' + siapa + idx);

        nikrow.style.display = "table-row";
        nik.value = nik_pdptk;

        tampilkanJK(siapa, idx);
    }

    function tampilkannikpesertadidik(siapa, idx) {
        var nikrow = document.getElementById('nikpdptkRow' + siapa + idx);
        var nik = document.getElementById('nikpdptk' + siapa + idx);
        var tbnik = document.getElementById('tbnikpdptk' + siapa + idx);

        nikrow.style.display = "table-row";
        nik.value = nik_pdptk;
        tbnik.style.display = "table-row";

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
        var nik = document.getElementById('nik' + siapa + idx).value;
        var tbnama = document.getElementById('tbnama' + siapa + idx);
        var iinfonama = document.getElementById('infonama' + siapa + idx);
        var namarow = document.getElementById('namaRow' + siapa + idx);
        var inama = document.getElementById('nama' + siapa + idx).value;
        var iinfonik = document.getElementById('infonik' + siapa + idx);

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
                valnama = result.valnama_siswa;
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

                tbnama.style.display = "none";
                iinfonama.innerText = "Dukcapil: " + valnama;
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
        lokasikorban.appendChild(akhirDiv);
        akhirDiv.classList.add('fade-in');
    });

    btnBersedia.addEventListener('click', function() {
        btnTidakBersedia.style.display = 'none';
        btnBersedia.style.display = 'none';
        isianDiv.classList.add('fade-in');
        isianDiv.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    });

    tbya.addEventListener('click', function() {
        // alasanDihentikan.style.display = 'none';
        // if (counterkorban == 0)
        //     tbkorban.style.display = 'block';
        // statuskasus = 1;
    });

    tbtidak.addEventListener('click', function() {
        // alasanDihentikan.style.display = 'none';
        // if (counterkorban == 0)
        //     tbkorban.style.display = 'block';
        // statuskasus = 2;
    });

    tbstop.addEventListener('click', function() {
        // var alasanDihentikan = document.getElementById('alasanDihentikan');
        // alasanDihentikan.style.display = 'table-row';
        // if (counterkorban == 0)
        //     tbkorban.style.display = 'block';
        // statuskasus = 3;
    });

    tbkorban.addEventListener('click', function() {
        tambahKorban();
    });

    function showtbsubmitkorban(idx) {
        showtbsubmit('korban', idx);
    }

    function showtbsubmitpelaku(idx) {
        showtbsubmit('pelaku', idx);
    }

    function showtbsubmitterlapor(idx) {
        showtbsubmit('terlapor', idx);
    }

    function showtbsubmit(siapa, idx) {
        const tbsubmit = document.getElementById('tbnpsn' + siapa + idx);
        const sekolahrow = document.getElementById('sekolahRow' + siapa + idx);
        const sekolah = document.getElementById('sekolah' + siapa + idx);
        tbsubmit.style.display = 'block';
        sekolahrow.style.display = 'none';
        sekolah.value = "";
        document.getElementById('infonpsn' + siapa + idx).innerHTML = "";
    }

    function submitnpsnkorban(idx) {
        submitnpsn('korban', idx);
    }

    function submitnpsnpelaku(idx) {
        submitnpsn('pelaku', idx);
    }

    function submitnpsnterlapor(idx) {
        submitnpsn('terlapor', idx);
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
            tbnpsn.disabled = true;
            getnamasekolah(document.getElementById('npsn' + siapa + idx).value, siapa, idx);
        }

    };

    function getnamasekolah(npsn, siapa, idx) {
        $.ajax({
            type: 'GET',
            url: '<?= base_url() ?>inputdata/ceknpsnsekolah',
            data: {
                npsn: npsn,
            },
            success: function(response) {
                var sekolahrow = document.getElementById('sekolahRow' + siapa + idx);
                var sekolah = document.getElementById('sekolah' + siapa + idx);
                var tbnpsn = document.getElementById('tbnpsn' + siapa + idx);
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

    function ceknikterlapor(idx) {
        if (statusakhir == 6)
            ceknikmas("terlapor", idx);
        else
            ceknik("terlapor", idx);
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

        if (nikortu.length != 16 && nikortu != "-")
            infonik.innerHTML = "Nomor NIK 16 digit";
        else {
            infonik.innerHTML = "";
            tbnik.innerHTML = 'tunggu...';
            $.ajax({
                url: '<?= base_url() ?>inputdata/ceknikortu',
                type: 'GET',
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

                        labelnikortu[0].innerText = 'NIK ' + capitalizeFirstLetter(siapa) + ' (' + capitalizeFirstLetter(statusortu) + ')';
                        labelnamaortu[0].innerText = 'Nama ' + capitalizeFirstLetter(siapa) + ' (' + capitalizeFirstLetter(statusortu) + ')';
                        namaorturow.style.display = "table-row";
                        namaortu.value = response.nama;
                        infonamaortu.innerHTML = response.valnama;
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
                        infojenis_kelamin.innerHTML = response.valjenis_kelamin;
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
        document.getElementById('nama' + siapa + idx).value = "";
        document.getElementById('infonisn' + siapa + idx).innerHTML = "";
        document.getElementById('infonama' + siapa + idx).innerHTML = "";
        document.getElementById('nikpdptk' + siapa + idx).value = "";
        document.getElementById('jenis_kelaminRow' + siapa + idx).style.display = "none";
        document.getElementById('disabilitasRow' + siapa + idx).style.display = "none";
        document.getElementById('namaRow' + siapa + idx).style.display = "none";
        document.getElementById('nikpdptkRow' + siapa + idx).style.display = "none";
        document.getElementById('tbnisn' + siapa + idx).style.display = "table-row";
        document.getElementById('tbnisn' + siapa + idx).innerText = "Cek";
        document.getElementById('tbnisn' + siapa + idx).disabled = false;
        document.getElementById('nikRow' + siapa + idx).style.display = 'none';
    }

    function changenik(siapa, idx) {
        if (statusakhir < 6) {
            document.getElementById('infonik' + siapa + idx).innerHTML = "";
            document.getElementById('tbnik' + siapa + idx).style.display = "table-row";
            document.getElementById('tbnik' + siapa + idx).innerHTML = "Cek";
            document.getElementById('namaortuRow' + siapa + idx).style.display = "none";
            document.getElementById('jenis_kelaminRow' + siapa + idx).style.display = "none";
            document.getElementById('disabilitasRow' + siapa + idx).style.display = "none";
            var statusortu = capitalizeFirstLetter(document.getElementById('statusortu' + siapa + idx).value);
            var nikrow = document.getElementById('nikRow' + siapa + idx);
            var labelnikstatus = nikrow.getElementsByTagName('td');
            labelnikstatus[0].innerHTML = "NIK " + capitalizeFirstLetter(siapa) + " (" + statusortu + ")";
            var jkrow = document.getElementById('jenis_kelaminRow' + siapa + idx);
            var labeljkstatus = jkrow.getElementsByTagName('td');
            labeljkstatus[0].innerHTML = "Jenis Kelamin " + capitalizeFirstLetter(siapa) + " (" + statusortu + ")";
            var disrow = document.getElementById('disabilitasRow' + siapa + idx);
            var labeldisstatus = disrow.getElementsByTagName('td');
            labeldisstatus[0].innerHTML = "Apakah " + siapa + " (" + statusortu + ") memiliki disabilitas ?";
            piljk = "";
            if (statusortu == "Ibu") {
                piljk = "P";
            } else if (statusortu == "Ayah") {
                piljk = "L";
            }
            var radios = document.getElementsByName('jenis_kelamin' + siapa + idx);
            for (var i = 0; i < radios.length; i++) {
                if (radios[i].value === piljk) {
                    radios[i].checked = true;
                    break;
                }
            }
        }

    }

    function changesekolah(siapa, idx) {
        document.getElementById('infosekolah' + siapa + idx).innerHTML = "";
        const tbcek = document.getElementById('tbsekolah' + siapa + idx);
        var selectedValue;
        const radioButtons1 = document.querySelectorAll('input[name="status_' + siapa + idx + '"]');
        radioButtons1.forEach((radio) => {
            if (radio.checked) {
                selectedValue = radio.value;
            }
        });

        // if (selectedValue == 6) {
        //     tbcek.style.display = 'table-row';
        // }
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

        // if (selectedValue == 6) {
        //     tbcek.style.display = 'table-row';
        // }
    }

    function changestatusortukorban(idx) {
        changenik("korban", idx);
    }

    function changestatusortupelaku(idx) {
        changenik("pelaku", idx);
    }

    function changestatusortuterlapor(idx) {
        changenik("terlapor", idx);
    }


    function changenamaortu(siapa, idx) {
        document.getElementById('infonamaortu' + siapa + idx).innerHTML = "";
    }

    function ceknik_nama(siapa, idx) {
        const nik = document.getElementById('nik' + siapa + idx);
        const nama = document.getElementById('nama' + siapa + idx);
        const infonama = document.getElementById('infonama' + siapa + idx);

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

    function konfirmnamaterlapor(idx) {
        konfirmnama("terlapor", idx);
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
            document.getElementById('nisn' + siapa + idx).disabled = true;
            document.getElementById('nama' + siapa + idx).disabled = true;

            var radioButtons = document.querySelectorAll('input[name="status_' + siapa + idx + '"]');
            radioButtons.forEach(function(radioButton) {
                radioButton.disabled = true;
            });

            tampilkannikpdptk(siapa, idx);
        } else {
            // alert("DISINI");
            var radioButtons = document.querySelectorAll('input[name="status_' + siapa + idx + '"]');
            radioButtons.forEach(function(radioButton) {
                radioButton.disabled = true;
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

    function konfirmnamaortuterlapor(idx) {
        konfirmnamaortu("terlapor", idx);
    }

    function konfirmnamaortu(siapa, idx) {

        if (statusakhir < 6) {
            document.getElementById('tbnamaortu' + siapa + idx).style.display = 'none';
            document.getElementById('namaortu' + siapa + idx).disabled = true;
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

    function ceknikpdptkterlapor(idx) {
        ceknikpdptk("terlapor", idx);
    }

    function ceknikpdptk(siapa, idx) {
        // document.getElementById('nikpdptk' + siapa + idx).disabled = true;
        // document.getElementById('tbnikpdptk' + siapa + idx).style.display = 'none';
        // var selectedValue;
        // const radioButtons1 = document.querySelectorAll('input[name="status_' + siapa + idx + '"]');
        // radioButtons1.forEach((radio) => {
        //     if (radio.checked) {
        //         selectedValue = radio.value;
        //     }
        // });
        // if (selectedValue == 2) {
        //     var namaorturow = document.getElementById('namaortuRow' + siapa + idx);
        //     namaorturow.style.display = "table-row";
        //     namaorturow.scrollIntoView({
        //         behavior: 'smooth',
        //         block: 'start'
        //     });
        // } else {
        //     tampilkanJK(siapa, idx);
        // }
        document.getElementById('nisn' + siapa + idx).disabled = true;
        document.getElementById('nama' + siapa + idx).disabled = true;
        document.getElementById('infonama' + siapa + idx).style.display = 'none';
        document.getElementById('nikpdptk' + siapa + idx).disabled = true;
        document.getElementById('tbnikpdptk' + siapa + idx).style.display = 'none';
        tampilkaninputortumasy(siapa, idx);
    }

    function tampilkanJK(siapa, idx) {
        var JKrow = document.getElementById('jenis_kelaminRow' + siapa + idx);
        var radios = document.getElementsByName('jenis_kelamin' + siapa + idx);
        for (var i = 0; i < radios.length; i++) {
            if (radios[i].value === jenis_kelamin) {
                radios[i].checked = true;
                break;
            }
        }

        JKl = "-";
        if (jenis_kelamin == "L")
            JKl = "Laki-laki";
        else if (jenis_kelamin == "P")
            JKl = "Perempuan";
        document.getElementById('infojenis_kelamin' + siapa + idx).innerText = "Dukcapil: " + JKl;

        JKrow.style.display = "table-row";

        tampilkandisabilitas(siapa, idx);
    }

    function ambilSukuKata(data) {
        var posisiStrip = data.indexOf('-');
        var sukuKataArray = posisiStrip !== -1 ? data.substring(0, posisiStrip).split(',') : data.split(',');
        sukuKataArray = sukuKataArray.map(function(sukuKata) {
            return sukuKata.trim();
        });
    }

    function tampilkandisabilitas(siapa, idx) {
        // document.getElementById('infonama' + siapa + idx).style.display = 'none';
        var radios = document.getElementsByName('disabilitas' + siapa + idx);
        for (var i = 0; i < radios.length; i++) {
            if (radios[i].value === pildisabilitas) {
                radios[i].checked = true;
                toggleInput(siapa, radios[i], idx);
                // var inputdisabilitas = document.getElementById('inputdisabilitas' + siapa + idx);
                // inputdisabilitas.value = 
                // alert(disabilitas);
                break;
            }
        }
        // disabilitas = 'A, B';

        // var dataArray = ambilSukuKata(disabilitas).split(', ');

        // alert(dataArray);

        // // Mengatur checkbox yang sesuai
        // $(document).ready(function() {
        //     $.each(dataArray, function(index, value) {
        //         $('#checkbox' + value + siapa + idx).prop('checked', true);
        //     });
        // });

        var selectedValue;
        const radioButtons1 = document.querySelectorAll('input[name="status_' + siapa + idx + '"]');
        radioButtons1.forEach((radio) => {
            if (radio.checked) {
                selectedValue = radio.value;
            }
        });

        if (selectedValue == 6) {
            document.getElementById('sekolah' + siapa + idx).disabled = true;
            document.getElementById('nama' + siapa + idx).disabled = true;
            document.getElementById('nik' + siapa + idx).disabled = true;
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

    function ceknisnkorban(idx) {
        ceknisn("korban", idx);
    }

    function ceknisnpelaku(idx) {
        ceknisn("pelaku", idx);
    }

    function ceknisnterlapor(idx) {
        ceknisn("terlapor", idx);
    }

    function ceknisn(siapa, idx) {
        var selectedValue;
        const radioButtons1 = document.querySelectorAll('input[name="status_' + siapa + idx + '"]');
        radioButtons1.forEach((radio) => {
            if (radio.checked) {
                selectedValue = radio.value;
            }
            radio.disabled = true;
        });

        valid = true;

        if (selectedValue <= 2 && document.getElementById('nisn' + siapa + idx).value == "") {
            document.getElementById('infonisn' + siapa + idx).innerHTML = "NISN harus diisi atau '-'";
            valid = false;
        }
        if (selectedValue > 2 && document.getElementById('nisn' + siapa + idx).value == "") {
            document.getElementById('infonisn' + siapa + idx).innerHTML = "NIK/NUPTK harus diisi";
            valid = false;
        }
        if (selectedValue == 6 && document.getElementById('nisn' + siapa + idx).value == "") {
            document.getElementById('infonisn' + siapa + idx).innerHTML = "NIK harus diisi";
            valid = false;
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
            const tbnisn = document.getElementById('tbnisn' + siapa + idx);
            tbnisn.disabled = true;
            tbnisn.innerHTML = "tunggu...";

            if (selectedValue == 1 || selectedValue == 2) {
                return get_data(siapa, 1, idx);
            } else if (selectedValue >= 3 && selectedValue <= 5) {
                return get_data(siapa, 2, idx);
            }
        }
    }

    function konfirmjenis_kelaminkorban(idx) {
        konfirmjenis_kelamin("korban", idx);
    }

    function konfirmjenis_kelaminpelaku(idx) {
        konfirmjenis_kelamin("pelaku", idx);
    }

    function konfirmjenis_kelaminterlapor(idx) {
        konfirmjenis_kelamin("terlapor", idx);
    }

    function konfirmjenis_kelamin(siapa, idx) {
        if (statusakhir < 6) {
            document.getElementById('infonama' + siapa + idx).style.display = 'none';
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
                radioButton.disabled = true;
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
        const nik_masy = document.getElementById('nik' + siapa + idx).value;
        const nama_masy = document.getElementById('nama' + siapa + idx).value;
        const jk_masy = document.getElementById('jenis_kelamin' + siapa + idx).value;
        const tgllahir = document.getElementById('tgl_lahir' + siapa + idx).value;
        $.ajax({
            url: '<?= base_url() ?>inputdata/ceknikmasy',
            type: 'POST',
            data: {
                nik_masy: nik_masy,
                nama_masy: nama_masy,
                jk_masy: jk_masy,
                tgllahir: tgllahir,
            },
            success: function(response) {
                tbnik.style.display = 'none';
                // var sekolahrow = document.getElementById('sekolahRow' + siapa + idx);

                if (response != null) {

                    if (response.ortu == "-") {
                        document.getElementById('infonik' + siapa + idx).innerHTML = "NIK tidak sesuai Dukcapil!<br>";
                    }
                    // kec = response.kecamatan.substring(5);

                    labelnikortu[0].innerText = 'NIK ' + capitalizeFirstLetter(siapa) + ' (' + capitalizeFirstLetter(statusortu) + ')';
                    labelnamaortu[0].innerText = 'Nama ' + capitalizeFirstLetter(siapa) + ' (' + capitalizeFirstLetter(statusortu) + ')';
                    namaorturow.style.display = "table-row";
                    namaortu.value = response.nama;
                    infonamaortu.innerHTML = response.valnama;
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
                    infojenis_kelamin.innerHTML = response.valjenis_kelamin;
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

    function konfirmsekolahterlapor(idx) {
        if (statusakhir == 6)
            konfirmsekolahmas("terlapor", idx);
        else
            konfirmsekolah("terlapor", idx);
    }

    function konfirmsekolah(siapa, idx) {

        valid = true;
        if (document.getElementById('sekolah' + siapa + idx).value == "") {
            document.getElementById('infosekolah' + siapa + idx).innerHTML = "Nama sekolah harus diisi";
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
                var nisn = document.getElementById('nisnRow' + siapa + idx);
                document.getElementById('tbsekolah' + siapa + idx).style.display = 'none';
                document.getElementById('npsn' + siapa + idx).disabled = true;
                document.getElementById('sekolah' + siapa + idx).disabled = true;
                document.getElementById('tbcarisekolah' + siapa + idx).style.display = 'none';
                nisn.style.display = 'table-row';

                nisn.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
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

    function konfirmdisabilitaskorban(idx) {
        konfirmdisabilitas("korban", idx);
    }

    function konfirmdisabilitaspelaku(idx) {
        konfirmdisabilitas("pelaku", idx);
    }

    function konfirmdisabilitasterlapor(idx) {
        konfirmdisabilitas("terlapor", idx);
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

        valid = true;


        if (document.getElementById('namaortu' + siapa + idx).value == "" && selectedValuestatus == 2) {
            document.getElementById('infonamaortu' + siapa + idx).innerHTML = "Nama " + siapa + " harus diisi";
            valid = false;
        }

        if (document.getElementById('nama' + siapa + idx).value == "") {
            document.getElementById('infonama' + siapa + idx).innerHTML = "Nama " + siapa + " harus diisi";
            valid = false;
        }


        // if (document.getElementById('nikpdptk' + siapa + idx).value.length != 16) {
        //     document.getElementById('infonikpdptk' + siapa + idx).innerHTML = "NIK " + siapa + " harus diisi";
        //     valid = false;
        // }

        // if (document.getElementById('nikpdptk' + siapa + idx).value == "") {
        //     document.getElementById('infonikpdptk' + siapa + idx).innerHTML = "NIK " + siapa + " harus diisi";
        //     valid = false;
        // }

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
        }



        if (valid) {
            document.getElementById('statusortu' + siapa + idx).disabled = true;
            document.getElementById('tbdisabilitas' + siapa + idx).style.display = 'none';
            document.getElementById('infodisabilitas' + siapa + idx).innerHTML = "";
            document.getElementById('infonik' + siapa + idx).innerHTML = "";
            dafkodeKB.forEach(function(element) {
                document.getElementById('checkbox' + element + siapa + idx).disabled = true;
            });

            var radioButtons = document.querySelectorAll('input[name="disabilitas' + siapa + idx + '"]');
            radioButtons.forEach(function(radioButton) {
                radioButton.disabled = true;
            });
            // document.getElementById('inputdisabilitas' + siapa + idx).disabled = true;
            document.getElementById('nama' + siapa + idx).disabled = true;
            document.getElementById('namaortu' + siapa + idx).disabled = true;
            document.getElementById('nikpdptk' + siapa + idx).disabled = true;
            document.getElementById('nik' + siapa + idx).disabled = true;
            document.getElementById('nisn' + siapa + idx).disabled = true;

            radioButtonsjk.forEach(function(radioButton) {
                radioButton.disabled = true;
            });
            var radioButtons = document.querySelectorAll('input[id^="disabilitas' + siapa + idx + '"]');
            radioButtons.forEach(function(radioButton) {
                radioButton.disabled = true;
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
                tbpelaku = document.getElementById('tbpelaku' + siapa + counterkorban);
                tbpelaku.innerText = "INPUT" + pelakuterlapor;
                tbpelaku.style.display = 'inline';

                if (counterkorban > 1) {
                    tbkurangikorban = document.getElementById('tbkurangi' + siapa + counterkorban);
                    tbkurangikorban.style.display = 'inline';

                    tbtambahkorbanprev = document.getElementById('tbtambah' + siapa + (counterkorban - 1));
                    tbtambahkorbanprev.style.display = 'none';
                    tbkurangikorbanprev = document.getElementById('tbkurangi' + siapa + (counterkorban - 1));
                    tbkurangikorbanprev.style.display = 'none';
                    tbpelaku = document.getElementById('tbpelakukorban' + (counterkorban - 1));
                    tbpelaku.style.display = 'none';
                }
            } else if (siapa == 'pelaku') {
                tbtambahpelaku = document.getElementById('tbtambah' + siapa + counterpelaku);
                tbtambahpelaku.innerHTML = "INPUT PELAKU KE-" + (counterpelaku + 1);
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

            } else if (siapa == 'terlapor') {
                tbtambahterlapor = document.getElementById('tbtambah' + siapa + counterterlapor);
                tbtambahterlapor.innerHTML = "INPUT TERLAPOR KE-" + (counterterlapor + 1);
                tbtambahterlapor.style.display = 'inline';
                tbkronologi = document.getElementById('tbkronologi' + counterterlapor);
                tbkronologi.style.display = 'inline';

                if (counterterlapor > 1) {
                    tbkurangiterlapor = document.getElementById('tbkurangi' + siapa + counterterlapor);
                    tbkurangiterlapor.style.display = 'inline';

                    tbtambahterlaporprev = document.getElementById('tbtambah' + siapa + (counterterlapor - 1));
                    tbtambahterlaporprev.style.display = 'none';
                    tbkurangiterlaporprev = document.getElementById('tbkurangi' + siapa + (counterterlapor - 1));
                    tbkurangiterlaporprev.style.display = 'none';
                    tbkronologiprev = document.getElementById('tbkronologi' + (counterterlapor - 1));
                    tbkronologiprev.style.display = 'none';
                }
            }
        }

    };

    function inputkronologiPelaku() {
        inputkronologi("pelaku");
    }

    function inputkronologiTerlapor() {
        inputkronologi("terlapor");
    }

    function inputkronologi(siapa) {
        if (siapa == "pelaku")
            counter = counterpelaku;
        else
            counter = counterterlapor;

        tbkurangipelakuterlapor = document.getElementById('tbkurangi' + siapa + counter);
        tbkurangipelakuterlapor.style.display = 'none';

        tbtambahpelakuterlapor = document.getElementById('tbtambah' + siapa + counter);
        tbtambahpelakuterlapor.style.display = 'none';

        tbkronologi = document.getElementById('tbkronologi' + counter);
        tbkronologi.style.display = 'none';

        const kronologiDiv = document.getElementById('kronologi');

        kronologiDiv.classList.add('fade-in');
        kronologiDiv.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }

    function submitkronologi() {
        if (confirm("Apakah data sudah lengkap?")) {
            document.getElementById('tbkronologi').style.display = 'none';
            event.preventDefault();

            var xnoreg = "<?= $data_kasus['nomor_register'] ?>";
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

            var cakupan_kekerasan = "";
            const rbCakupan = document.querySelectorAll('input[name="cakupan"]');
            rbCakupan.forEach((radio) => {
                if (radio.checked) {
                    cakupan_kekerasan = radio.value;
                }
            });

            /////////////////// data korban dan pelaku ////////////
            let dataKorban = []; // Array untuk menampung data korban

            for (let i = 1; i <= counterkorban; i++) {
                let status = pilstatus['korban'][i];
                let nik = $(`#nikkorban${i}`).val();
                let nikpdptk = $(`#nikpdptkkorban${i}`).val();
                let npsn = $(`#npsnkorban${i}`).val();
                let nisn = $(`#nisnkorban${i}`).val();
                if (status == 2)
                    var nama = $(`#namaortukorban${i}`).val()
                else
                    var nama = $(`#namakorban${i}`).val()
                let jenis_kelamin = $(`input[name='jenis_kelaminkorban${i}']:checked`).val();
                let nama_sekolah = $(`#sekolahkorban${i}`).val();
                let disabilitas = $(`input[name='disabilitaskorban${i}']:checked`).val();
                // let inputdisabilitas = $(`#inputdisabilitaskorban${i}`).val();
                var tgl_lahir_masy = $(`#datepickerkorban${i}`).val();
                var usia = $(`#usiakorban${i}`).val();
                var kodewilayah = $(`#desakorban${i}`).val();
                if (status < 6)
                    kodewilayah = $(`#kecamatankorban${i}`).val();

                var jumlahKB = 0;
                dafkodeKB.forEach(function(element) {
                    if ($('#checkbox' + element + "korban" + i).prop('checked')) {
                        // selectedCheckboxes.push($('#checkbox' + element + siapa + idx).val());
                        jumlahKB += parseInt($('#checkbox' + element + "korban" + i).val());
                    }
                });

                // Buat objek untuk setiap data korban
                let korbanData = {
                    status: status,
                    nikpdptk: nikpdptk,
                    nik: nik,
                    npsn: npsn,
                    nisn: nisn,
                    nama: nama,
                    jenis_kelamin: jenis_kelamin,
                    nama_sekolah: nama_sekolah,
                    disabilitas: disabilitas,
                    inputdisabilitas: jumlahKB
                };

                dataKorban.push(korbanData);
            }

            let dataPelaku = [];

            for (let i = 1; i <= counterpelaku; i++) {
                let status = pilstatus['pelaku'][i];
                let nik = $(`#nikpelaku${i}`).val();
                let nikpdptk = $(`#nikpdptkpelaku${i}`).val();
                let npsn = $(`#npsnpelaku${i}`).val();
                let nisn = $(`#nisnpelaku${i}`).val();
                if (status == 2)
                    var nama = $(`#namaortupelaku${i}`).val()
                else
                    var nama = $(`#namapelaku${i}`).val()
                let jenis_kelamin = $(`input[name='jenis_kelaminpelaku${i}']:checked`).val();
                let nama_sekolah = $(`#sekolahpelaku${i}`).val();
                let disabilitas = $(`input[name='disabilitaspelaku${i}']:checked`).val();
                // let inputdisabilitas = $(`#inputdisabilitaspelaku${i}`).val();
                var tgl_lahir_masy = $(`#datepickerpelaku${i}`).val();
                var usia = $(`#usiapelaku${i}`).val();
                var kodewilayah = $(`#desapelaku${i}`).val();
                if (status < 6)
                    kodewilayah = $(`#kecamatanpelaku${i}`).val();

                var jumlahKB = 0;
                dafkodeKB.forEach(function(element) {
                    if ($('#checkbox' + element + "pelaku" + i).prop('checked')) {
                        // selectedCheckboxes.push($('#checkbox' + element + siapa + idx).val());
                        jumlahKB += parseInt($('#checkbox' + element + "pelaku" + i).val());
                    }
                });

                let pelakuData = {
                    status: status,
                    nikpdptk: nikpdptk,
                    nik: nik,
                    npsn: npsn,
                    nisn: nisn,
                    nama: nama,
                    jenis_kelamin: jenis_kelamin,
                    nama_sekolah: nama_sekolah,
                    disabilitas: disabilitas,
                    inputdisabilitas: jumlahKB
                };

                dataPelaku.push(pelakuData);
            }

            let dataTerlapor = [];

            for (let i = 1; i <= counterterlapor; i++) {
                let status = pilstatus['terlapor'][i];
                let nik = $(`#nikterlapor${i}`).val();
                let nikpdptk = $(`#nikpdptkterlapor${i}`).val();
                let npsn = $(`#npsnterlapor${i}`).val();
                let nisn = $(`#nisnterlapor${i}`).val();
                if (status == 2)
                    var nama = $(`#namaortuterlapor${i}`).val()
                else
                    var nama = $(`#namaterlapor${i}`).val()
                let jenis_kelamin = $(`input[name='jenis_kelaminterlapor${i}']:checked`).val();
                let nama_sekolah = $(`#sekolahterlapor${i}`).val();
                let disabilitas = $(`input[name='disabilitasterlapor${i}']:checked`).val();
                // let inputdisabilitas = $(`#inputdisabilitasterlapor${i}`).val();
                var tgl_lahir_masy = $(`#datepickerterlapor${i}`).val();
                var usia = $(`#usiaterlapor${i}`).val();
                var kodewilayah = $(`#desaterlapor${i}`).val();
                if (status < 6)
                    kodewilayah = $(`#kecamatanterlapor${i}`).val();

                var jumlahKB = 0;
                dafkodeKB.forEach(function(element) {
                    if ($('#checkbox' + element + "terlapor" + i).prop('checked')) {
                        // selectedCheckboxes.push($('#checkbox' + element + siapa + idx).val());
                        jumlahKB += parseInt($('#checkbox' + element + "terlapor" + i).val());
                    }
                });

                let terlaporData = {
                    status: status,
                    nikpdptk: nikpdptk,
                    nik: nik,
                    npsn: npsn,
                    nisn: nisn,
                    nama: nama,
                    jenis_kelamin: jenis_kelamin,
                    nama_sekolah: nama_sekolah,
                    disabilitas: disabilitas,
                    inputdisabilitas: jumlahKB
                };

                dataTerlapor.push(terlaporData);
            }

            var kronologi = $('#ikronologi').val();

            // var jenis_kelamin = $('input[name="jenis_kelamin"]:checked').val();

            // var csrfToken = $('meta[name="csrf-token"]').attr('content');
            alamat = '<?= base_url() . "inputdata/simpan_kasus" ?>';

            $.ajax({
                type: 'POST',
                url: alamat,
                data: {
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
                    dataterlapor: dataTerlapor,
                    csrf_test_name: '<?= $csrfToken ?>', // Sertakan token CSRF di sini
                },
                success: function(response) {
                    akhirDiv.classList.add('fade-in');
                    akhirDiv.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                },
                error: function() {
                    alert('Terjadi kesalahan saat mengirim data.');
                }
            });


        }
    };

    function validasiTanggal(idx) {
        var input = document.getElementById('datepicker' + idx).value;
        var regex = /^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[0-2])\/\d{4}$/;

        if (regex.test(input)) {
            document.getElementById('errorTanggal').style.display = 'none';
            // Lakukan tindakan selanjutnya sesuai dengan tanggal yang diinput
        } else {
            document.getElementById('errorTanggal').style.display = 'block';
        }
    }

    function validasiTanggalLahirkorban(idx) {
        validasiTanggalLahir("korban", idx);
    }

    function validasiTanggalLahirpelaku(idx) {
        validasiTanggalLahir("pelaku", idx);
    }

    function validasiTanggalLahirterlapor(idx) {
        validasiTanggalLahir("terlapor", idx);
    }

    function validasiTanggalLahir(siapa, idx) {
        var input = document.getElementById('datepicker' + siapa + idx).value;
        var regex = /^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[0-2])\/\d{4}$/;

        if (regex.test(input)) {
            document.getElementById('errorTanggalLahir' + siapa + idx).style.display = 'none';
            // Lakukan tindakan selanjutnya sesuai dengan tanggal yang diinput
        } else {
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

        // if (statuskasus == 1) {
        //     pelakuDiv.classList.add('fade-in');
        // } else {
        //     terlaporDiv.classList.add('fade-in');
        // }

    }

    // const buttons = document.querySelectorAll('.btn_abu');

    // buttons.forEach(button => {
    //     button.addEventListener('click', function() {
    //         buttons.forEach(btn => btn.classList.remove('clicked'));
    //         this.classList.add('clicked');
    //     });
    // });
</script>
<script>
    $(function() {
        $("#datepicker1").datepicker({
            dateFormat: 'dd/mm/yy'
        });

        $("#datepicker2").datepicker({
            dateFormat: 'dd/mm/yy'
        });

        $("#datepicker").datepicker({
            dateFormat: 'dd/mm/yy'
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

    function tampilmodalterlapor(idx) {
        tampilmodal("terlapor", idx);
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
        alert(npsn);
        // document.getElementById('npsnkorban').value = npsn;

        // var sekolahRow = document.getElementById('sekolahRowkorban');
        // sekolahRow.style.display = 'table-row';
        // sekolahRow.innerHTML = '<td>Nama Sekolah</td><td>:</td><td>' + namaSekolah + '</td>';
    }

    function getkota(siapa, id, selectedProvinsi) {
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
</script>


<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<?= $this->endSection(); ?>