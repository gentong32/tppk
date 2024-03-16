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
    #tabelakhir {
        margin-top: 10px;
        line-height: 20px;
        font-size: 14px;
        width: 100%;
    }

    #tabelakhir tr th {
        text-align: left !important;
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

    #pelaku {
        display: none;
        transition: opacity 0.5s ease-in-out;
        padding: 20px;
    }

    #terlapor {
        display: none;
        transition: opacity 0.5s ease-in-out;
        padding: 20px;
    }

    #kronologi {
        display: none;
        transition: opacity 0.5s ease-in-out;
        padding: 20px;
    }

    #inputkronologi {
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
</style>

<?= $this->endSection(); ?>

<?= $this->section('konten') ?>
<div id="content_wrap" class="content-wrap">

    <div class="judul">
        <br>
        <b>FORMULIR REKAPITULASI LAPORAN KEKERASAN</b>
    </div>
    <div class="atas">
        <table class="tabelinfo">
            <tr>
                <th class="merah">RAHASIA</th>
            </tr>
            <tr>
                <td><b>Pernyataan yang perlu diisi oleh TPPK:</b><br><br>
                    Saya, yang mengisi formulir ini, menyatakan bahwa informasi yang saya sampaikan adalah benar adanya. Saya bersedia menjamin bahwa saya tidak menyebarluaskan informasi yang saya isi di formulir kepada publik. Saya siap diproses secara hukum jika terbukti menyebarluaskan informasi yang saya catat.
                    <br><br>
                    <button class="btn_merah">Saya tidak bersedia</button> <button class="btn_ijo">Saya bersedia</button>
                </td>
            </tr>
        </table>
    </div>

    <div id="isian">
        <table class="tabelisian">
            <tr>
                <th style="width:40%"></th>
                <th style="width:10px;"></th>
                <th></th>
            </tr>
            <tr>
                <td>
                    Nomor register laporan *
                </td>
                <td>:</td>
                <td><input id="noreg" type="text" disabled value="<?= $nomor_register ?>"></td>
            </tr>
            <tr>
                <td>
                    Tanggal penerimaan laporan *
                </td>
                <td>:</td>
                <td><input type="text" id="datepicker1" name="datepicker1" onblur="validasiTanggal(1)" value="<?= $tgl_sekarang ?>">
                    <span id="errorTanggal" style="color: red; display: none;">Format tanggal tidak valid.</span>
                </td>
            </tr>
            <tr>
                <td>
                    Tanggal kejadian *
                </td>
                <td>:</td>
                <td><input type="text" id="datepicker2" name="datepicker2" onblur="validasiTanggal(2)" value="<?= $tgl_sekarang ?>">
                    <span id="errorTanggal" style="color: red; display: none;">Format tanggal tidak valid.</span>
                </td>
            </tr>
            <tr>
                <td>
                    Apakah kasus kekerasan sudah terbukti?
                </td>
                <td>:</td>
                <td>
                    <button class="btn_abu" id="tbya">Ya</button><br>
                    <button class="btn_abu" id="tbtidak">Tidak</button><br>
                    <button class="btn_abu" id="tbstop">Kasus Dihentikan</button>
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
                        Status Korban
                    </td>
                    <td>:</td>
                    <td>
                        <div class="checkbox-container">
                            <input type="radio" name="status_korban" value="pd">
                            Peserta Didik
                        </div>
                        <div class="checkbox-container">
                            <input type="radio" name="status_korban" value="ot">
                            Orang tua / wali peserta didik
                        </div>
                        <div class="checkbox-container">
                            <input type="radio" name="status_korban" value="p">
                            Pendidik
                        </div>
                        <div class="checkbox-container">
                            <input type="radio" name="status_korban" value="tk">
                            Tenaga Kependidikan
                        </div>
                        <div class="checkbox-container">
                            <input type="radio" name="status_korban" value="ksp">
                            Kepala Satuan Pendidikan
                        </div>
                        <div class="checkbox-container">
                            <input type="radio" name="status_korban" value="mu">
                            Masyarakat Umum
                        </div>
                    </td>
                </tr>
                <tr id="npsnRowkorban">
                    <td>
                        NPSN Korban
                    </td>
                    <td>:</td>
                    <td><input type="text" placeholder="" id="npsnkorban" name="npsnkorban" value="<?= $npsn ?>">
                        <span class="info" id="infonpsnkorban"></span>
                        <button id="tbnpsnkorban" class="btn_abu2" onclick="submitnpsnkorban(0)">Submit</button>
                    </td>
                </tr>
                <tr id="nikRowkorban" style="display: none;">
                    <td>
                        NIK Korban
                    </td>
                    <td>:</td>
                    <td><input type="text" placeholder="" id="nikkorban" name="nikkorban">
                        <span class="info" id="infonikkorban"></span><br>
                        <button onclick="ceknikkorban(0)" id="tbnikkorban" class="btn_abu2">Cek</button>
                    </td>
                </tr>
                <tr id="namaRowkorban" style="display: none;">
                    <td>
                        Nama Korban
                    </td>
                    <td>:</td>
                    <td><input type="text" placeholder="" id="namakorban" name="namakorban">
                        <span class="info" id="infonamakorban"></span><br>
                        <button onclick="konfirmnamakorban(0)" id="tbnamakorban" class="btn_abu2">Konfirm</button>
                    </td>
                </tr>
                <tr id="nisnRowkorban" style="display: none;">
                    <td>
                        NISN / NUPTK Korban
                    </td>
                    <td>:</td>
                    <td><input type="text" placeholder="" id="nisnkorban" name="nisnkorban">
                        <button onclick="konfirmnisnkorban(0)" id="tbnisnkorban" class="btn_abu2">Konfirm</button>
                    </td>
                </tr>
                <tr id="jenis_kelaminRowkorban" style="display: none;">
                    <td>
                        Jenis Kelamin Korban
                    </td>
                    <td>:</td>
                    <td>
                        <input type="radio" name="jenis_kelaminkorban" value="L"> Laki-laki<br>
                        <input type="radio" name="jenis_kelaminkorban" value="P"> Perempuan<br>
                        <span class="info" id="infojenis_kelaminkorban"></span><br>
                        <button onclick="konfirmjenis_kelaminkorban(0)" id="tbjenis_kelaminkorban" class="btn_abu2">Konfirm</button>
                    </td>
                </tr>
                <tr id="sekolahRowkorban" style="display: none;">
                    <td>
                        Nama Sekolah / Instansi Korban
                    </td>
                    <td>:</td>
                    <td><input type="text" placeholder="" id="sekolahkorban" name="sekolahkorban">
                        <span class="info" id="infosekolahkorban"></span>
                        <button onclick="konfirmsekolahkorban(0)" id="tbsekolahkorban" class="btn_abu2">Konfirm</button>
                    </td>
                </tr>
                <tr id="disabilitasRowkorban" style="display: none;">
                    <td>
                        Apakah korban memiliki disabilitas?
                    </td>
                    <td>:</td>
                    <td>

                        <input type="radio" name="disabilitaskorban" value="ya" onclick="toggleInput('korban',this, 1)"> Ya, sebutkan:

                        <input type="text" id="inputdisabilitaskorban" style="display: none;">
                        <br>

                        <input type="radio" name="disabilitaskorban" value="tidak" onclick="toggleInput('korban',this, 1)"> Tidak

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

    </div>

    <div id="lokasipelaku">
        <div id="pelaku" class="korban">
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
                        <div class="checkbox-container">
                            <input type="radio" name="status_pelaku" value="pd">
                            Peserta Didik
                        </div>
                        <div class="checkbox-container">
                            <input type="radio" name="status_pelaku" value="ot">
                            Orang tua / wali peserta didik
                        </div>
                        <div class="checkbox-container">
                            <input type="radio" name="status_pelaku" value="p">
                            Pendidik
                        </div>
                        <div class="checkbox-container">
                            <input type="radio" name="status_pelaku" value="tk">
                            Tenaga Kependidikan
                        </div>
                        <div class="checkbox-container">
                            <input type="radio" name="status_pelaku" value="ksp">
                            Kepala Satuan Pendidikan
                        </div>
                        <div class="checkbox-container">
                            <input type="radio" name="status_pelaku" value="mu">
                            Masyarakat Umum
                        </div>
                    </td>
                </tr>
                <tr id="npsnRowpelaku">
                    <td>
                        NPSN Pelaku
                    </td>
                    <td>:</td>
                    <td><input type="text" placeholder="" id="npsnpelaku" name="npsnpelaku" value="<?= $npsn ?>">
                        <span class="info" id="infonpsnpelaku"></span>
                        <button id="tbnpsnpelaku" class="btn_abu2" onclick="submitnpsnpelaku(0)">Submit</button>
                    </td>
                </tr>
                <tr id="nikRowpelaku" style="display: none;">
                    <td>
                        NIK Pelaku
                    </td>
                    <td>:</td>
                    <td><input type="text" placeholder="" id="nikpelaku" name="nikpelaku">
                        <span class="info" id="infonikpelaku"></span><br>
                        <button onclick="ceknikpelaku(0)" id="tbnikpelaku" class="btn_abu2">Cek</button>
                    </td>
                </tr>
                <tr id="namaRowpelaku" style="display: none;">
                    <td>
                        Nama Pelaku
                    </td>
                    <td>:</td>
                    <td><input type="text" placeholder="" id="namapelaku" name="namapelaku">
                        <span class="info" id="infonamapelaku"></span><br>
                        <button onclick="konfirmnamapelaku(0)" id="tbnamapelaku" class="btn_abu2">Konfirm</button>
                    </td>
                </tr>
                <tr id="nisnRowpelaku" style="display: none;">
                    <td>
                        NISN / NUPTK Pelaku
                    </td>
                    <td>:</td>
                    <td><input type="text" placeholder="" id="nisnpelaku" name="nisnpelaku">
                        <button onclick="konfirmnisnpelaku(0)" id="tbnisnpelaku" class="btn_abu2">Konfirm</button>
                    </td>
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
                        <button onclick="konfirmjenis_kelaminpelaku(0)" id="tbjenis_kelaminpelaku" class="btn_abu2">Konfirm</button>
                    </td>
                </tr>
                <tr id="sekolahRowpelaku" style="display: none;">
                    <td>
                        Nama Sekolah / Instansi Korban
                    </td>
                    <td>:</td>
                    <td><input type="text" placeholder="" id="sekolahpelaku" name="sekolahpelaku">
                        <span class="info" id="infosekolahpelaku"></span>
                        <button onclick="konfirmsekolahpelaku(0)" id="tbsekolahpelaku" class="btn_abu2">Konfirm</button>
                    </td>
                </tr>
                <tr id="disabilitasRowpelaku" style="display: none;">
                    <td>
                        Apakah pelaku memiliki disabilitas?
                    </td>
                    <td>:</td>
                    <td>

                        <input type="radio" name="disabilitaspelaku" value="ya" onclick="toggleInput('pelaku',this, 1)"> Ya, sebutkan:

                        <input type="text" id="inputdisabilitaspelaku" style="display: none;">
                        <br>

                        <input type="radio" name="disabilitaspelaku" value="tidak" onclick="toggleInput('pelaku',this, 1)"> Tidak

                        <br>
                        <button onclick="konfirmdisabilitaspelaku(0)" id="tbdisabilitaspelaku" class="btn_abu2">Konfirm</button>
                    </td>
                </tr>
            </table>
            <div style="margin-top: 10px; display:inline">
                <button id="tbkurangipelaku" style="margin-top: 10px; display: none;" class="btn_merah" onclick="kurangiPelaku()">HAPUS PELAKU INI</button>
                <button id="tbtambahpelaku" style="margin-top: 10px; display: none;" class="btn_ijo" onclick="tambahPelaku()">INPUT PELAKU BERIKUTNYA</button>
                <button id="tbpelakupelaku" style="margin-top: 10px; display: none;" class="btn_ijo" onclick="inputkronologi()">INPUT KRONOLOGI</button>
            </div>
        </div>

        <div id="terlapor">
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
                        <div class="checkbox-container">
                            <input type="radio" name="status_terlapor" value="pd">
                            Peserta Didik
                        </div>
                        <div class="checkbox-container">
                            <input type="radio" name="status_terlapor" value="ot">
                            Orang tua / wali peserta didik
                        </div>
                        <div class="checkbox-container">
                            <input type="radio" name="status_terlapor" value="p">
                            Pendidik
                        </div>
                        <div class="checkbox-container">
                            <input type="radio" name="status_terlapor" value="tk">
                            Tenaga Kependidikan
                        </div>
                        <div class="checkbox-container">
                            <input type="radio" name="status_terlapor" value="ksp">
                            Kepala Satuan Pendidikan
                        </div>
                        <div class="checkbox-container">
                            <input type="radio" name="status_terlapor" value="mu">
                            Masyarakat Umum
                        </div>
                    </td>
                </tr>
                <tr id="npsnRow3">
                    <td>
                        NPSN Terlapor
                    </td>
                    <td>:</td>
                    <td><input type="text" placeholder="" id="npsn3" name="npsn3" value="<?= $npsn ?>">
                        <span class="info" id="infonpsn3"></span>
                        <button id="tbnpsn3" class="btn_abu2" onclick="submitnpsn(3)">Submit</button>
                    </td>
                </tr>
                <tr id="nikRow3" style="display: none;">
                    <td>
                        NIK Terlapor
                    </td>
                    <td>:</td>
                    <td><input type="text" placeholder="" id="nik3" name="nik3">
                        <span class="info" id="infonik3"></span><br>
                        <button onclick="ceknik(3)" id="tbnik3" class="btn_abu2">Cek</button>
                    </td>
                </tr>
                <tr id="namaRow3" style="display: none;">
                    <td>
                        Nama Terlapor
                    </td>
                    <td>:</td>
                    <td><input type="text" placeholder="" id="nama3" name="nama3">
                        <span class="info" id="infonama3"></span><br>
                        <button onclick="konfirmnama(3)" id="tbnama3" class="btn_abu2">Konfirm</button>
                    </td>
                </tr>

                <tr id="nisnRow3" style="display: none;">
                    <td>
                        NISN / NUPTK Terlapor
                    </td>
                    <td>:</td>
                    <td><input type="text" placeholder="" id="nisn3" name="nisn3">
                        <button onclick="konfirmnisn(3)" id="tbnisn3" class="btn_abu2">Konfirm</button>
                    </td>
                </tr>
                <tr id="jenis_kelaminRow3" style="display: none;">
                    <td>
                        Jenis Kelamin Terlapor
                    </td>
                    <td>:</td>
                    <td>
                        <input type="radio" name="jenis_kelamin3" value="L"> Laki-laki<br>
                        <input type="radio" name="jenis_kelamin3" value="P"> Perempuan<br>
                        <span class="info" id="infojenis_kelamin3"></span><br>
                        <button onclick="konfirmjenis_kelamin(3)" id="tbjenis_kelamin3" class="btn_abu2">Konfirm</button>
                    </td>
                </tr>
                <tr id="sekolahRow3" style="display: none;">
                    <td>
                        Nama Sekolah / Instansi Terlapor
                    </td>
                    <td>:</td>
                    <td><input type="text" placeholder="" id="sekolah3" name="sekolah3">
                        <span class="info" id="infosekolah3"></span>
                        <button onclick="konfirmsekolah(3)" id="tbsekolah3" class="btn_abu2">Konfirm</button>
                    </td>
                </tr>
                <tr id="disabilitasRow3" style="display: none;">
                    <td>
                        Apakah terlapor memiliki disabilitas?
                    </td>
                    <td>:</td>
                    <td>

                        <input type="radio" name="disabilitas3" value="ya" onclick="toggleInput(this, 3)"> Ya, sebutkan:

                        <input type="text" id="inputdisabilitas3" style="display: none;">
                        <br>

                        <input type="radio" name="disabilitas3" value="tidak" onclick="toggleInput(this, 3)"> Tidak

                        <br>
                        <button onclick="konfirmdisabilitas(3)" id="tbdisabilitas3" class="btn_abu2">Konfirm</button>
                    </td>
                </tr>
            </table>
        </div>
    </div>

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
                    <div class="checkbox-container">
                        <input type="checkbox" name="k_fisik">
                        Fisik
                    </div>
                    <div class="checkbox-container">
                        <input type="checkbox" name="k_psikis">
                        Psikis
                    </div>
                    <div class="checkbox-container">
                        <input type="checkbox" name="k_perundungan">
                        Perundungan
                    </div>
                    <div class="checkbox-container">
                        <input type="checkbox" name="k_seksual">
                        Seksual
                    </div>
                    <div class="checkbox-container">
                        <input type="checkbox" name="k_diskriminasi">
                        Diskriminasi dan intoleransi
                    </div>
                    <div class="checkbox-container">
                        <input type="checkbox" name="k_kebijakan">
                        Kebijakan yang mengandung Kekerasan
                    </div>
                    <div class="checkbox-container">
                        <input type="checkbox" name="k_lain">
                        Lainnya
                    </div>
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
                </td>
            </tr>
            <tr>
                <td>
                    Kronologi peristiwa
                </td>
                <td>:</td>
                <td><textarea id="inputkronologi" rows="5"></textarea>
                    <br>
                    <button onclick="submitkronologi()" id="tbkronologi" class="btn_abu2">Submit</button>
                </td>
            </tr>
        </table>
    </div>

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



<?= $this->endSection(); ?>

<?= $this->section('scriptfooter') ?>

<script>
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
    var pilstatus_korban = "";
    var pilstatus_pelaku = "";
    var pilstatus_terlapor = "";

    var statuskasus = "";

    var nama = "";
    var valnama = "-";
    var tgl_lahir = "";
    var valtgl_lahir = "-";
    var jenis_kelamin = "";
    var valjenis_kelamin = "-";
    var nisn = "";
    var nama_sekolah = "";
    var disabilitas = "";
    var pildisabilitas = "";

    let counterkorban = 0;
    let counterpelaku = 0;

    const lokasikorban = document.getElementById('lokasikorban');
    const lokasipelaku = document.getElementById('lokasipelaku');

    ////////////// KORBAN ////////////////////////////////////////////////

    function tambahKorban() {
        counterkorban++;

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

        clone.querySelectorAll('[id^="tbnpsnkorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterkorban;
            btn.setAttribute('onclick', `submitnpsnkorban(${counterkorban})`);
        });

        clone.querySelectorAll('[id^="tbnikkorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterkorban;
            btn.setAttribute('onclick', `ceknikkorban(${counterkorban})`);
        });

        clone.querySelectorAll('[id^="tbnamakorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterkorban;
            btn.setAttribute('onclick', `konfirmnamakorban(${counterkorban})`);
        });

        clone.querySelectorAll('[id^="tbnisnkorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterkorban;
            btn.setAttribute('onclick', `konfirmnisnkorban(${counterkorban})`);
        });

        clone.querySelectorAll('[id^="tbjenis_kelaminkorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterkorban;
            btn.setAttribute('onclick', `konfirmjenis_kelaminkorban(${counterkorban})`);
        });

        clone.querySelectorAll('[id^="tbsekolahkorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterkorban;
            btn.setAttribute('onclick', `konfirmsekolahkorban(${counterkorban})`);
        });

        clone.querySelectorAll('[id^="tbdisabilitaskorban"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterkorban;
            btn.setAttribute('onclick', `konfirmdisabilitaskorban(${counterkorban})`);
        });

        lokasikorban.appendChild(clone);

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

        clone.querySelectorAll('[id^="tbnpsnpelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterpelaku;
            btn.setAttribute('onclick', `submitnpsnpelaku(${counterpelaku})`);
        });

        clone.querySelectorAll('[id^="tbnikpelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterpelaku;
            btn.setAttribute('onclick', `ceknikpelaku(${counterpelaku})`);
        });

        clone.querySelectorAll('[id^="tbnamapelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterpelaku;
            btn.setAttribute('onclick', `konfirmnamapelaku(${counterpelaku})`);
        });

        clone.querySelectorAll('[id^="tbnisnpelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterpelaku;
            btn.setAttribute('onclick', `konfirmnisnpelaku(${counterpelaku})`);
        });

        clone.querySelectorAll('[id^="tbjenis_kelaminpelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterpelaku;
            btn.setAttribute('onclick', `konfirmjenis_kelaminpelaku(${counterpelaku})`);
        });

        clone.querySelectorAll('[id^="tbsekolahpelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterpelaku;
            btn.setAttribute('onclick', `konfirmsekolahpelaku(${counterpelaku})`);
        });

        clone.querySelectorAll('[id^="tbdisabilitaspelaku"]').forEach((btn) => {
            // btn.id = btn.id.slice(0, -1) + counterpelaku;
            btn.setAttribute('onclick', `konfirmdisabilitaspelaku(${counterpelaku})`);
        });

        lokasipelaku.appendChild(clone);

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
            tbpelaku = document.getElementById('tbpelakupelaku' + (counterpelaku - 1));
            tbpelaku.style.display = 'none';
        } else {
            tbkorbanprev = document.getElementById('tbtambahkorban' + counterkorban);
            tbkorbanprev.style.display = 'none';
        }

    }

    function kurangiPelaku() {
        const clonedElement = document.getElementById('pelaku' + counterpelaku);
        clonedElement.remove();
        counterpelaku--;
        tbtambahpelakuprev = document.getElementById('tbtambahpelaku' + counterpelaku);
        tbtambahpelakuprev.style.display = 'inline';
        tbpelaku = document.getElementById('tbpelakupelaku' + counterpelaku);
        tbpelaku.style.display = 'inline';
        if (counterpelaku > 1) {
            tbkurangipelakuprev = document.getElementById('tbkurangipelaku' + counterpelaku);
            tbkurangipelakuprev.style.display = 'inline';
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

    function get_data(siapa, jenis, idx) {
        var npsn = document.getElementById('npsn' + siapa + idx).value;
        var nik = document.getElementById('nik' + siapa + idx).value;
        var namarow = document.getElementById('namaRow' + siapa + idx);
        var inama = document.getElementById('nama' + siapa + idx);
        var iinfonama = document.getElementById('infonama' + siapa + idx);
        var iinfonik = document.getElementById('infonik' + siapa + idx);

        // alert('infonik' + siapa + idx);

        alamat = '<?= base_url() . "inputdata/get_data_p" ?>';

        var url = alamat;
        var data = {
            npsn: npsn,
            nik: nik,
            jenis: jenis
        };

        $.ajax({
            url: url,
            type: 'GET',
            data: data,
            dataType: 'json',
            cache: false,
            success: function(result) {
                // alert("kucil");
                nama = result.nama_siswa;
                if (nama == "")
                    iinfonik.innerText = "NIK tidak sesuai"
                else {
                    iinfonik.innerText = "";
                    document.getElementById('tbnik' + siapa + idx).style.display = 'none';
                }
                valnama = result.valnama_siswa;
                nisn = result.nisn;
                jenis_kelamin = result.jenis_kelamin;
                valjenis_kelamin = result.valjenis_kelamin;
                nama_sekolah = result.nama_sekolah;
                tgl_lahir = result.tgl_lahir;
                valtgl_lahir = result.valtgl_lahir;
                if (jenis == 1) {
                    if (result.kebutuhan_khusus_id > 0) {
                        pildisabilitas = "ya";
                        disabilitas = result.kebutuhan_khusus;
                    } else {
                        pildisabilitas = "tidak";
                    }
                } else {
                    pildisabilitas = "tidak";
                }

                namarow.style.display = "table-row";
                inama.value = nama;
                iinfonama.innerText = "Dukcapil: " + valnama;

                namarow.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });



        // alert(nik);
    }

    btnTidakBersedia.addEventListener('click', function() {
        btnTidakBersedia.style.display = 'none';
        btnBersedia.style.display = 'none';
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
        // tbya.disabled = true;
        // tbtidak.disabled = false;
        // tbstop.disabled = false;
        alasanDihentikan.style.display = 'none';
        tbkorban.style.display = 'block';
        statuskasus = 1;
    });

    tbtidak.addEventListener('click', function() {
        // tbtidak.disabled = true;
        // tbtidak.disabled = false;
        // tbstop.disabled = false;
        alasanDihentikan.style.display = 'none';
        tbkorban.style.display = 'block';
        statuskasus = 2;
    });

    tbstop.addEventListener('click', function() {
        var alasanDihentikan = document.getElementById('alasanDihentikan');
        // tbtidak.disabled = false;
        // tbtidak.disabled = false;
        // tbstop.disabled = true;
        alasanDihentikan.style.display = 'table-row';
        statuskasus = 3;
    });

    tbkorban.addEventListener('click', function() {
        tambahKorban();
    });

    function submitnpsnkorban(idx) {
        submitnpsn('korban', idx);
    }

    function submitnpsnpelaku(idx) {
        submitnpsn('pelaku', idx);
    }

    function submitnpsn(siapa, idx) {
        var radios = document.getElementsByName('status_' + siapa + idx);
        var nikrow = document.getElementById('nikRow' + siapa + idx);
        pilstatus_korban = "";
        for (var i = 0; i < radios.length; i++) {
            radios[i].addEventListener('change', function() {
                document.getElementById('infonpsn' + siapa + idx).innerHTML = "";
            });

            if (radios[i].checked) {
                pilstatus_korban = radios[i].value;
                break;
            }
        }

        if (pilstatus_korban == "") {
            document.getElementById('infonpsn' + siapa + idx).innerHTML = "Silakan pilih status " + siapa + "!<br>";
        } else {
            document.getElementById('tbnpsn' + siapa + idx).style.display = 'none';
            nikrow.style.display = 'table-row';
        }

        nikrow.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });

    };

    function ceknikkorban(idx) {
        ceknik("korban", idx);
    }

    function ceknikpelaku(idx) {
        ceknik("pelaku", idx);
    }

    function ceknik(siapa, idx) {
        var selectedValue;
        const radioButtons1 = document.querySelectorAll('input[name="status_' + siapa + idx + '"]');
        radioButtons1.forEach((radio) => {
            if (radio.checked) {
                selectedValue = radio.value;
            }
        });

        // alert(idx + "-" + selectedValue);

        if (selectedValue == "pd" || selectedValue == "ot") {
            return get_data(siapa, 1, idx);
        } else if (selectedValue == "p" || selectedValue == "tk" || selectedValue == "ksp") {
            return get_data(siapa, 2, idx);
        } else {
            return get_data(siapa, 3, idx);
        }
    };

    function konfirmnamakorban(idx) {
        konfirmnama("korban", idx);
    }

    function konfirmnamapelaku(idx) {
        konfirmnama("pelaku", idx);
    }

    function konfirmnama(siapa, idx) {
        var nisnrow = document.getElementById('nisnRow' + siapa + idx);
        document.getElementById('tbnama' + siapa + idx).style.display = 'none';
        document.getElementById('infonama' + siapa + idx).style.display = 'none';
        nisnrow.style.display = 'table-row';
        document.getElementById('nisn' + siapa + idx).value = nisn;

        nisnrow.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });

    };

    function konfirmnisnkorban(idx) {
        konfirmnisn("korban", idx);
    }

    function konfirmnisnpelaku(idx) {
        konfirmnisn("pelaku", idx);
    }

    function konfirmnisn(siapa, idx) {
        var jkrow = document.getElementById('jenis_kelaminRow' + siapa + idx);
        document.getElementById('tbnisn' + siapa + idx).style.display = 'none';
        jkrow.style.display = 'table-row';
        var radios = document.getElementsByName('jenis_kelamin' + siapa + idx);
        for (var i = 0; i < radios.length; i++) {
            if (radios[i].value === jenis_kelamin) {
                radios[i].checked = true;
                break;
            }
        }
        document.getElementById('infojenis_kelamin' + siapa + idx).innerText = "Dukcapil: " + valjenis_kelamin;

        jkrow.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    };

    function konfirmjenis_kelaminkorban(idx) {
        konfirmjenis_kelamin("korban", idx);
    }

    function konfirmjenis_kelaminpelaku(idx) {
        konfirmjenis_kelamin("pelaku", idx);
    }

    function konfirmjenis_kelamin(siapa, idx) {
        var sekolahrow = document.getElementById('sekolahRow' + siapa + idx);
        document.getElementById('tbjenis_kelamin' + siapa + idx).style.display = 'none';
        document.getElementById('infojenis_kelamin' + siapa + idx).style.display = 'none';
        sekolahrow.style.display = 'table-row';
        document.getElementById('sekolah' + siapa + idx).value = nama_sekolah;

        sekolahrow.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    };

    function konfirmsekolahkorban(idx) {
        konfirmsekolah("korban", idx);
    }

    function konfirmsekolahpelaku(idx) {
        konfirmsekolah("pelaku", idx);
    }

    function konfirmsekolah(siapa, idx) {
        var disabilitasrow = document.getElementById('disabilitasRow' + siapa + idx);
        document.getElementById('tbsekolah' + siapa + idx).style.display = 'none';
        disabilitasrow.style.display = 'table-row';

        var radios = document.getElementsByName('disabilitas' + siapa + idx);
        for (var i = 0; i < radios.length; i++) {
            if (radios[i].value === pildisabilitas) {
                radios[i].checked = true;
                toggleInput(siapa, radios[i], idx);
                var inputdisabilitas = document.getElementById('inputdisabilitas' + siapa + idx);
                inputdisabilitas.value = disabilitas;
                break;
            }
        }

        disabilitasrow.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    };

    function konfirmdisabilitaskorban(idx) {
        konfirmdisabilitas("korban", idx);
    }

    function konfirmdisabilitaspelaku(idx) {
        konfirmdisabilitas("pelaku", idx);
    }

    function konfirmdisabilitas(siapa, idx) {
        document.getElementById('tbdisabilitas' + siapa + idx).style.display = 'none';
        tbya.disabled = true;
        tbtidak.disabled = true;
        tbstop.disabled = true;
        if (siapa == 'korban') {
            tbtambahkorban = document.getElementById('tbtambah' + siapa + counterkorban);
            tbtambahkorban.innerHTML = "INPUT KORBAN KE-" + (counterkorban + 1);
            tbtambahkorban.style.display = 'inline';
            tbpelaku = document.getElementById('tbpelaku' + siapa + counterkorban);
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
            tbpelaku = document.getElementById('tbpelaku' + siapa + counterpelaku);
            tbpelaku.style.display = 'inline';

            if (counterpelaku > 1) {
                tbkurangipelaku = document.getElementById('tbkurangi' + siapa + counterpelaku);
                tbkurangipelaku.style.display = 'inline';

                tbtambahpelakuprev = document.getElementById('tbtambah' + siapa + (counterpelaku - 1));
                tbtambahpelakuprev.style.display = 'none';
                tbkurangipelakuprev = document.getElementById('tbkurangi' + siapa + (counterpelaku - 1));
                tbkurangipelakuprev.style.display = 'none';
                tbpelaku = document.getElementById('tbpelakupelaku' + (counterpelaku - 1));
                tbpelaku.style.display = 'none';
            }
        }

    };

    function inputkronologi() {
        const kronologiDiv = document.getElementById('kronologi');

        kronologiDiv.classList.add('fade-in');
        kronologiDiv.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }

    function submitkronologi() {
        if (confirm("Apakah data sudah lengkap?")) {
            // document.getElementById('tbkronologi').style.display = 'none';

            event.preventDefault();
            var xnoreg = "<?= $nomor_register ?>";
            var xtgl_lapor = $('#datepicker1').val();
            var xtgl_kasus = $('#datepicker2').val();
            var xsts_kasus = statuskasus;
            var terlapor_meninggal = $('input[name="terlapor_meninggal"]:checked').length > 0 ? "tm," : "";
            var korban_tidak_ditemukan = $('input[name="korban_tidak_ditemukan"]:checked').length > 0 ? "ktd," : "";
            var pembuktian_belum_cukup = $('input[name="pembuktian_belum_cukup"]:checked').length > 0 ? "pbc," : "";
            var alasan_dihentikan = terlapor_meninggal + korban_tidak_ditemukan + pembuktian_belum_cukup;

            var k_fisik = $('input[name="k_fisik"]:checked').length > 0 ? "fsk," : "";
            var k_psikis = $('input[name="k_psikis"]:checked').length > 0 ? "psi," : "";
            var k_perundungan = $('input[name="k_perundungan"]:checked').length > 0 ? "prd," : "";
            var k_seksual = $('input[name="k_seksual"]:checked').length > 0 ? "sks," : "";
            var k_diskriminasi = $('input[name="k_diskriminasi"]:checked').length > 0 ? "dis," : "";
            var k_kebijakan = $('input[name="k_kebijakan"]:checked').length > 0 ? "kbj," : "";
            var k_lain = $('input[name="k_lain"]:checked').length > 0 ? "lin," : "";
            var bentuk_kekerasan = k_fisik + k_psikis + k_perundungan + k_seksual + k_diskriminasi + k_kebijakan + k_lain;

            var cakupan_kekerasan = "";
            const rbCakupan = document.querySelectorAll('input[name="cakupan"]');
            rbCakupan.forEach((radio) => {
                if (radio.checked) {
                    cakupan_kekerasan = radio.value;
                }
            });

            var kronologi = $('#inputkronologi').val();

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
                    // jenis_kelamin: jenis_kelamin,
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

    function toggleInput(siapa, radio, idx) {
        var input = document.getElementById('inputdisabilitas' + siapa + idx);
        if (radio.value === 'ya') {
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
            dateFormat: 'dd/mm/yy'
        });

        $("#datepicker2").datepicker({
            dateFormat: 'dd/mm/yy'
        });
    });
</script>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<?= $this->endSection(); ?>