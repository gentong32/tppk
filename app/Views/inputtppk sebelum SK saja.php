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
        background: linear-gradient(to bottom, #DDDDE1, #F9F9FC);
    }

    .landing-page {
        /* min-height: 100vh; */
        /* display: flex; */
        justify-content: center;
        align-items: center;
    }
</style>
<?= $this->endSection() ?>


<?= $this->section('konten') ?>
<div class="content-wrap">
    <div class="landing-page">
        <div class="form-container">
            <h2 class="form-title">TPPK Satuan Pendidikan</h2>
            <form action="<?= base_url() ?>inputdata/simpan" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label for="ipropinsi">Provinsi</label>
                    <div id="dpropinsi">
                        <select class="single" id="ipropinsi" name="ipropinsi">
                            <option value="00">- Pilih Provinsi -</option>
                            <?php foreach ($namaPropinsi as $row) :
                                echo "<option value='" . $row->kode_wilayah . "'>" . (substr($row->nama, 0, 4) == "Prov" ? substr($row->nama, 5) : $row->nama) . "</option>";
                            endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="ikota">Kota/Kabupaten</label>
                    <div id="dkota">
                        <select class="single" id="ikota" name="ikota">
                            <option value="00">- Pilih Kota/Kabupaten -</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="ikecamatan">Kecamatan</label>
                    <div id="dkecamatan">
                        <select class="single" id="ikecamatan" name="ikecamatan">
                            <option value="00">- Pilih Kecamatan -</option>

                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="iinstansi">Sekolah</label>
                    <div id="dsekolah">
                        <select class="single" id="iinstansi" name="iinstansi">
                            <option value="00">- Pilih Sekolah -</option>
                        </select>
                    </div>
                </div>

                <!-- <div class="form-group">
                    <label for="inpsn">NPSN</label>
                    <input readonly type="text" id="inpsn" name="inpsn">
                </div> -->
                <div class="form-group">
                    <label for="file_sk">FIle SK</label>
                    <input type="file" id="file_sk" name="file_sk" accept=".jpg,.jpeg,.png,.pdf">
                </div>
                <div class="form-group">
                    <label for="tanggal_sk">Tanggal SK</label>
                    <input type="text" id="tanggal_sk" name="tanggal_sk" value="">
                </div>

                <h2 class="form-title">Keanggotaan</h2>


                <div class="form-group ctim">
                    <label for="inamaketua">Ketua</label>
                    <div id="dnama">
                        <select class="single" id="inamaketua" name="inamaketua">
                            <option value="00">- Pilih Nama -</option>
                        </select>
                    </div>
                </div>
                <div class="form-group ctim2">
                    <label for="ijabatan">Jabatan</label>
                    <input readonly type="text" id="ijabatan" name="ijabatan" value="">
                </div>

                <hr style="margin-bottom: 10px;">

                <!-- ANGGOTA 1 -->
                <div class="fanggota" style="margin-bottom:10px">
                    <div class="form-group ctim">
                        <label for="ijabatan1">Anggota 1</label>
                        <div id="djenis1">
                            <select onchange="jenisanggota(1)" class="single" id="ijenis1" name="ijenis1">
                                <option value="01">PTK</option>
                                <option value="02">Komite Sekolah</option>
                            </select>
                        </div>
                    </div>
                    <!-- PTK -->
                    <div id="ptk1" class="form-group ctim">
                        <div class="form-group ctim">
                            <label for="inamaanggota1">Nama</label>
                            <div id="dnama1">
                                <select class="single" id="inamaanggota1" name="inamaanggota1">
                                    <option value="00">- Pilih Nama -</option>
                                </select>
                            </div>
                        </div>
                        <label for="ijabatan1">Jabatan</label>
                        <input readonly type="text" id="ijabatan1" name="ijabatan1" value="">
                    </div>

                    <!-- KOMITE -->
                    <div id="komite1" style="display: none;">
                        <div class="form-group ctim3">
                            <label for="ikomitenama1">Nama</label>
                            <input type="text" id="ikomitenama1" name="ikomitenama1" value="">
                        </div>
                        <div class="form-group ctim3">
                            <label for="ikomitenik1">NIK</label>
                            <input type="text" id="ikomitenik1" name="ikomitenik1" value="">
                        </div>
                        <div class="form-group ctim3">
                            <label for="ikomitesex1">Jenis Kelamin</label>
                            <select class="single" id="ikomitesex1" name="ikomitesex1">
                                <option value="1">Laki-laki</option>
                                <option value="1">Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group ctim3">
                            <label for="inamaanggota1">Nomor HP</label>
                            <input type="text" id="ikomitehp1" name="ikomitehp1" value="">
                        </div>
                    </div>
                    <hr style="margin-bottom: 10px;">
                </div>

                <!-- ANGGOTA 2-8 -->
                <?php for ($a = 2; $a <= 8; $a++) { ?>
                    <div id="danggota<?= $a ?>" style="display:none">
                        <div class="form-group ctim">
                            <label for="ijabatan1">Anggota <?= $a ?></label>
                            <div id="djenis<?= $a ?>">
                                <select onchange="jenisanggota(<?= $a ?>)" class="single" id="ijenis<?= $a ?>" name="ijenis<?= $a ?>">
                                    <option value="01">PTK</option>
                                    <option value="02">Komite Sekolah</option>
                                </select>
                            </div>
                        </div>
                        <!-- PTK -->
                        <div id="ptk<?= $a ?>" class="form-group ctim">
                            <div class="form-group ctim">
                                <label for="inamaanggota<?= $a ?>">Nama</label>
                                <div style="margin-bottom:2px;" id="dnama<?= $a ?>">
                                    <select class="single" id="inamaanggota<?= $a ?>" name="inamaanggota<?= $a ?>">
                                        <option value="00">- Pilih Nama -</option>
                                    </select>
                                </div>

                                <label for="ijabatan<?= $a ?>">Jabatan</label>
                                <input readonly type="text" id="ijabatan<?= $a ?>" name="ijabatan<?= $a ?>" value="">
                            </div>
                        </div>
                        <!-- KOMITE -->
                        <div id="komite<?= $a ?>" style="display: none;">
                            <div class="form-group ctim3">
                                <label for="ikomitenama<?= $a ?>">Nama</label>
                                <input type="text" id="ikomitenama<?= $a ?>" name="ikomitenama<?= $a ?>" value="">
                            </div>
                            <div class="form-group ctim3">
                                <label for="ikomitenik<?= $a ?>">NIK</label>
                                <input type="text" id="ikomitenik<?= $a ?>" name="ikomitenik<?= $a ?>" value="">
                            </div>
                            <div class="form-group ctim3">
                                <label for="ikomitesex<?= $a ?>">Jenis Kelamin</label>
                                <select class="single" id="ikomitesex<?= $a ?>" name="ikomitesex<?= $a ?>">
                                    <option value="1">Laki-laki</option>
                                    <option value="1">Perempuan</option>
                                </select>
                            </div>
                            <div class="form-group ctim3">
                                <label for="inamaanggota<?= $a ?>">Nomor HP</label>
                                <input type="text" id="ikomitehp<?= $a ?>" name="ikomitehp<?= $a ?>" value="">
                            </div>
                        </div>
                        <hr style="margin-bottom: 10px;">
                    </div>
                <?php } ?>


                <div class="form-group" style="margin-top:20px;">
                    <button onclick="return tambahInput()">Tambah Anggota</button>&nbsp;
                    <button onclick="return kurangiInput()">Kurangi Anggota</button>
                </div>

                <input type="hidden" id="idsekolah" name="idsekolah" value="">
                <input type="hidden" id="jmlpengguna" name="jmlpengguna" value="2">
                <input type="hidden" id="idjabatanketua" name="idjabatanketua" value="">
                <input type="hidden" id="idjabatananggota1" name="idjabatananggota1" value="">
                <input type="hidden" id="idjabatananggota2" name="idjabatananggota2" value="">
                <input type="hidden" id="idjabatananggota3" name="idjabatananggota3" value="">
                <input type="hidden" id="idjabatananggota4" name="idjabatananggota4" value="">
                <input type="hidden" id="idjabatananggota5" name="idjabatananggota5" value="">
                <input type="hidden" id="idjabatananggota6" name="idjabatananggota6" value="">
                <input type="hidden" id="idjabatananggota7" name="idjabatananggota7" value="">
                <input type="hidden" id="idjabatananggota8" name="idjabatananggota8" value="">

                <center>
                    <div class="tengah">
                        <input onclick="return cekinput();" type="submit" value="Kirim">
                    </div>
                </center>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scriptfooter') ?>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    var sekolahid;
    var jabatan = [];


    $(document).ready(function() {
        $("#tanggal_sk").datepicker({
            dateFormat: "dd-mm-yy",
        });
        $.datepicker.setDefaults($.datepicker.regional['id']);

        $('.single').select2();

    });

    var counter = 2;

    function tambahInput() {
        $("#danggota" + counter).show();
        if (counter <= 8)
            counter++;
        return false;
    }

    function kurangiInput() {
        if (counter > 2)
            counter--;
        $("#danggota" + counter).hide();
        return false;
    }

    $('#ipropinsi').change(function() {
        getkota();
        resetptk()
    });

    $('body').on("change", "#ikota", function() {
        getkecamatan();
        resetptk()
    });

    $('body').on("change", "#ikecamatan", function() {
        getsekolah();
        resetptk()
    });

    $('body').on("change", "#iinstansi", function() {
        // getnpsn();
        getptk();
    });

    // $('body').on("change", "#inamaketua", function() {
    //     getjabatan();
    // });

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

                isihtmlb1 = '<select class="single" id="ikecamatan" name="ikecamatan">';
                isihtmlb2 = '<option value="00">- Pilih Kecamatan -</option>';
                $('#dkecamatan').html(isihtmlb1 + isihtmlb2 + isihtml3);
                isihtmlb1 = '<select class="single" id="iinstansi" name="iinstansi">';
                isihtmlb2 = '<option value="00">- Pilih Sekolah -</option>';
                $('#dsekolah').html(isihtmlb1 + isihtmlb2 + isihtml3);
                // $('#inpsn').val("");
                $('.single').select2();
            }
        });
    }

    function getkecamatan() {
        var kode = $('#ikota').val();
        $.ajax({
            type: 'GET',
            data: {
                kode: kode,
                level: 3
            },
            dataType: 'json',
            cache: false,
            url: '<?php echo base_url(); ?>inputdata/getNamaWilayah',
            success: function(result) {
                isihtml1 = '<select class="single" id="ikecamatan" name="ikecamatan">';
                isihtml2 = '<option value="00">- Pilih Kecamatan -</option>';
                $.each(result, function(i, result) {
                    isihtml2 = isihtml2 + "<option value='" + result.kode_wilayah + "'>" + result.nama + "</option>";
                });
                isihtml3 = '</select>';
                $('#dkecamatan').html(isihtml1 + isihtml2 + isihtml3);
                isihtmlb1 = '<select class="single" id="iinstansi" name="iinstansi">';
                isihtmlb2 = '<option value="00">- Pilih Sekolah -</option>';
                $('#dsekolah').html(isihtmlb1 + isihtmlb2 + isihtml3);
                // $('#inpsn').val("");
                $('.single').select2();
            }
        });
    }

    function getsekolah() {
        var kode = $('#ikecamatan').val();
        $.ajax({
            type: 'GET',
            data: {
                kode: kode
            },
            dataType: 'json',
            cache: false,
            url: '<?php echo base_url(); ?>inputdata/getNamaInstansi/5',
            success: function(result) {
                isihtml1 = '<select class="single" id="iinstansi" name="iinstansi">';
                isihtml2 = '<option value="00">- Pilih Sekolah -</option>';
                $.each(result, function(i, result) {
                    isihtml2 = isihtml2 + "<option value='" + result.instansi_id + "'>[" + result.kode_instansi + "] " + result.nama + "</option>";
                });
                isihtml3 = '</select>';
                $('#dsekolah').html(isihtml1 + isihtml2 + isihtml3);
                // $('#inpsn').val("");
                $('.single').select2();
            }
        });
    }

    // function getnpsn() {
    //     var kode = $('#iinstansi').val();
    //     $.ajax({
    //         type: 'GET',
    //         data: {
    //             kode: kode
    //         },
    //         dataType: 'json',
    //         cache: false,
    //         url: '<?php //echo base_url(); 
                        ?>inputdata/getNPSN',
    //         success: function(result) {
    //             $('#inpsn').val(result);
    //         }
    //     });
    // }

    function getptk() {
        var kode = $('#iinstansi').val();
        $.ajax({
            type: 'GET',
            data: {
                kode: kode
            },
            dataType: 'json',
            cache: false,
            url: '<?php echo base_url(); ?>inputdata/getPTK',
            success: function(result) {
                isihtml1 = '<select onchange="getjabatan(0)" class="single" id="inamaketua" name="inamaketua">';
                isihtml2 = '<option value="00">- Pilih Nama -</option>';
                $.each(result, function(i, result) {
                    // jabatan.push([result.ptk_id, result.jenis_ptk_id + "," + result.jenis_ptk]);
                    jabatan.push([result.ptk_id, result.jenis_ptk]);
                    isihtml2 = isihtml2 + "<option value='" + result.ptk_id + "'>" + result.nama + "</option>";
                });
                isihtml3 = '</select>';
                $('#dnama').html(isihtml1 + isihtml2 + isihtml3);

                for (var i = 1; i <= 8; i++) {
                    isihtml1 = '<select onchange="getjabatan(' + i + ')" class="single" id="inamaanggota' + i + '" name="inamaanggota' + i + '">';
                    isihtml2 = '<option value="00">- Pilih Nama -</option>';
                    $.each(result, function(i, result) {
                        isihtml2 = isihtml2 + "<option value='" + result.ptk_id + "'>" + result.nama + "</option>";
                    });
                    isihtml3 = '</select>';
                    $('#dnama' + i).html(isihtml1 + isihtml2 + isihtml3);
                }

                $('.single').select2();
            }
        });
    }

    function getjabatan(idx) {
        var kodeYangDicari = "";
        var nama = "";
        var alamat = "";

        if (idx == 0) {
            kodeYangDicari = $('#inamaketua').val();
            alamat = "ijabatan";
        } else {
            kodeYangDicari = $('#inamaanggota' + idx).val();
            alamat = "ijabatan" + idx;
        }

        for (var i = 0; i < jabatan.length; i++) {
            if (jabatan[i][0] === kodeYangDicari) {
                nama = jabatan[i][1];
                $('#' + alamat).val(nama);
                break;
            }
        }
    }

    function jenisanggota(idx) {
        if ($('#ijenis' + idx).val() == "01") {
            $('#ptk' + idx).show();
            $('#komite' + idx).hide();
        } else {
            $('#ptk' + idx).hide();
            $('#komite' + idx).show();
        }

    }

    function resetptk() {
        isihtml1 = '<select class="single" id="inamaketua" name="inamaketua">';
        isihtml2 = '<option value="00">- Pilih Nama -</option>';
        isihtml3 = '</select>';
        $('#dnama').html(isihtml1 + isihtml2 + isihtml3);

        for (var i = 1; i <= 8; i++) {
            isihtml1 = '<select class="single" id="inamaanggota' + i + '" name="inamaanggota' + i + '">';
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

        valsk = document.getElementById("file_sk").value;
        fileExt = valsk.split('.').pop();
        valtgl = document.getElementById("tanggal_sk").value;
        ijabatan = document.getElementById("ijabatan").value;
        inamaketua = document.getElementById("inamaketua").value;
        ijabatan1 = document.getElementById("ijabatan1").value;
        inamaanggota1 = document.getElementById("inamaanggota1").value;

        arrayinputnya.push(inamaketua);
        arrayinputnya.push(inamaanggota1);

        if (valnpsn == "" || valsk == "" || ijabatan == "00" || ijabatan1 == "00" || inamaketua == "00" || inamaanggota1 == "00") {
            oke = false;
        }

        for (var a = 2; a < counter; a++) {
            if (document.getElementById("ijabatan" + a).value == "00" || document.getElementById("inamaanggota" + a).value == "00") {
                oke = false;
            }
            arrayinputnya.push(document.getElementById("inamaanggota" + a).value);
        }

        if (fileExt != "jpg" && fileExt != "jpeg" && fileExt != "png" && fileExt != "pdf") {
            oke = false;
        }

        if (valtgl == "") {
            oke = false;
        } else if (!isValidDate(valtgl)) {
            alert("Tanggal tidak sesuai format");
            oke = false;
        }

        if (checkUnique(arrayinputnya) == false && inamaketua != 00) {
            alert("Ada nama yang sama");
            oke = false;
        }

        if (oke) {
            // alert("Berhasil.... Hanya Uji Coba Dahulu");
            document.getElementById("jmlpengguna").value = counter;
            return true;
        } else {
            alert("Silakan periksa kembali ...");
            return false;
        }
    }
</script>
<?= $this->endSection(); ?>