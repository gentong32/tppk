<?= $this->extend('layout/default') ?>

<?= $this->section('header') ?>
<!-- Custom stylesheet -->
<link rel="stylesheet" href="<?= base_url() ?>css/select2.min.css">

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
        max-height: 410px;
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

    .info {
        color: red;
        font-style: italic;
        font-size: 12px;
        display: none;
        margin-top: -10px;
        margin-left: 0px;
    }

    .alert {
        color: red;
        font-size: 16px;
        padding: 5px;
    }
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
            <form action="<?= base_url() ?>inputdata/simpanfilesatgas" method="post" enctype="multipart/form-data">
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
                    <label for="nomor_sk">Nomor SK <sup>*</sup></label>
                    <input type="text" id="nomor_sk" name="nomor_sk" value="<?= ($opsi == 'ubahfile') ? $nomor_sk : '' ?>">
                </div>
                <div class="info" id="infonomor_sk">Nomor SK wajib diisi</div>
                <div class="form-group">
                    <label for="tanggal_sk">Tanggal SK <sup>*</sup></label>
                    <input type="text" id="tanggal_sk" name="tanggal_sk" value="<?= ($opsi == 'ubahfile') ? date('d-m-Y', strtotime($tanggal_sk)) : '' ?>">
                </div>
                <div class="info" id="infotanggal_sk">Tanggal SK wajib diisi</div>
                <div class="form-group">
                    <label for="file_sk">FIle SK <br><span style='color:red; font-weight:normal;'>(max. 2MB)</span><sup>*</sup></label>
                    <input type="file" id="file_sk" name="file_sk" accept=".pdf">
                </div>
                <?php
                if (session('error')) :
                ?>
                    <div id="gagalunggah" class="alert">
                        <?= session('error') ?>
                    </div>
                <?php
                endif ?>
                <div class="info" id="infofile_sk">FIle SK wajib diunggah</div>

                <?php
                if ($opsi == "edit") {
                    $namafileoke = preg_replace("/[^a-zA-Z0-9]/", "", $nomor_sk);
                    $namafilebaru = "sk_" . trim($wilayahkotasaya) . "_" . $namafileoke;
                    echo "<span style='color:grey;margin-left:130px;'><i>" . $namafilebaru . "</i></span>";
                }
                ?>
                <div style="margin-bottom: 25px;"></div>

                <input type="hidden" id="addedit" name="addedit" value="<?= $opsi ?>">
                <input type="hidden" id="skid" name="skid" value="<?= ($opsi == "ubahfile") ? $skid : "" ?>">
                <input type="hidden" id="ipropinsion" name="ipropinsion" value="">
                <input type="hidden" id="ikotaon" name="ikotaon" value="">

                <center>
                    <?php if ($opsi == "edit") : ?>
                        <div class="tengah2">
                            <input onclick="return batal();" type="button" value="Batal">
                            <input onclick="return cekinput();" type="submit" value="Lanjutkan ke Pengisian Anggota">
                        </div>
                    <?php else : ?>
                        <div class="tengah">
                            <input onclick="return cekinput();" type="submit" value="Lanjutkan ke Pengisian Anggota">
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
<script>
    var csrfToken;
    $(document).ready(function() {

        $("#tanggal_sk").datepicker({
            dateFormat: "dd-mm-yy",
            changeMonth: true,
            changeYear: true,
            yearRange: "c-100:c+10",
        });

        for (var n = 0; n <= 28; n++)
            $("#itglahir" + n).datepicker({
                dateFormat: "dd-mm-yy",
                changeMonth: true,
                changeYear: true,
                yearRange: "c-100:c+10",
            });

        $.datepicker.setDefaults($.datepicker.regional['id']);

    });

    function batal() {
        history.back();
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


    function cekinput() {
        var oke = true;
        var arrayinputnya = [];
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

        if (document.getElementById("nomor_sk").value == "") {
            document.getElementById("infonomor_sk").style.display = "block";
        }
        if (document.getElementById("tanggal_sk").value == "") {
            document.getElementById("infotanggal_sk").style.display = "block";
        }
        if (document.getElementById("file_sk").value == "") {
            document.getElementById("infofile_sk").style.display = "block";
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

        if (oke) {
            // alert("Berhasil.... Hanya Uji Coba Dahulu");
            document.getElementById("ipropinsion").value = document.getElementById("ipropinsi").value;
            document.getElementById("ikotaon").value = document.getElementById("ikota").value;

            return true;
        } else {
            // alert("Silakan periksa kembali ...");
            return false;
        }
    }

    function ceknama(idx) {
        var datanik = document.getElementById('inik' + idx).value;
        var datanama = document.getElementById('inama' + idx).value;
        var datatglahir = document.getElementById('itglahir' + idx).value;
        var datasex = document.getElementById('isex' + idx).value;
        var sexnya = "Laki-Laki";
        csrfToken = <?= csrf_hash() ?>;
        if (datasex == 2)
            sexnya = "Perempuan";

        if (datanik.length != 16) {
            alert("Jumlah karakter NIK harus 16 digit");
            return false;
        }

        $.ajax({
            type: 'POST',
            data: {
                nik: datanik,
                nama: datanama,
                tglahir: datatglahir,
                sex: sexnya,
                csrf_test_name: csrfToken,
            },
            dataType: 'json',
            cache: false,
            url: '<?php echo base_url() ?>inputdata/padankandata',
            success: function(result) {
                // var jsonData = JSON.parse(result);
                var jsonData = result;

                // Mengambil nilai NIK
                var nikValue = jsonData.NIK;
                var namaValue = jsonData.NAMA_LGKP;
                var tglahirValue = jsonData.TGL_LHR;
                var sexValue = jsonData.JENIS_KLMIN;

                csrfToken = jsonData.csrf;
                // alert("NIK:" + nikValue + ", NAMA:" + namaValue + ", TGL_LAHIR:" + tglahirValue + ", JNS KELAMIN:" + sexValue);
                document.getElementById('idukcapil' + idx).value = "NIK:" + nikValue + ", NAMA:" + namaValue + ", TGL_LAHIR:" + tglahirValue + ", JNS_KELAMIN:" + sexValue;
                return false;
            }
        });
        return false;
    }
</script>
<?= $this->endSection(); ?>