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
        max-height: 200px;
        /* Atur tinggi maksimum sesuai kebutuhan */
    }
</style>
<?= $this->endSection() ?>


<?= $this->section('konten') ?>
<div class="content-wrap">
    <div class="landing-page">
        <div class="form-container">
            <h2 class="form-title">Satuan Tugas Kabupaten/Kota</h2>
            <form action="<?= base_url() ?>inputdata/simpansatgas" method="post" enctype="multipart/form-data">
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
                    <label for="file_sk">FIle SK</label>
                    <input type="file" id="file_sk" name="file_sk" accept=".jpg,.jpeg,.png,.pdf">
                </div>
                <div class="form-group">
                    <label for="tanggal_sk">Tanggal SK</label>
                    <input type="text" id="tanggal_sk" name="tanggal_sk" value="">
                </div>

                <h2 class="form-title">Keanggotaan</h2>

                <label>
                    <h3 style="margin-bottom:15px;">KETUA:</h3>
                </label>
                <div class="fanggota" style="margin-bottom:10px">
                    <div class="form-group ctim">
                        <label for="djenis0">Instansi</label>
                        <div id="djenis0">
                            <select class=" single" id="idinas0" name="idinas0">
                                <option value="00">- Pilih Instansi -</option>
                                <option value="01">Dinas Pendidikan</option>
                                <option value="02">Dinas Sosial</option>
                                <option value="03">Dinas PPPA</option>
                                <option value="04">Dinas Kesehatan</option>
                                <option value="05">UPTD PPA</option>
                                <option value="06">Kepolisian</option>
                                <option value="07">Balai Pemasyarakatan</option>
                                <option value="08">Fasilitas Kesehatan</option>
                                <option value="09">Fasilitas Rehab Sosial</option>
                                <option value="10">Tokoh Adat / Masyarakat</option>
                                <option value="11">Lembaga Swadaya Masyarakat</option>
                                <option value="99">Lainnya</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group ctim">
                        <label for="inama0">Nama</label>
                        <input type="text" id="inama0" name="inama0" value="">
                    </div>
                    <div class="form-group ctim">
                        <label for="inik0">NIK</label>
                        <input type="text" id="inik0" name="inik0" value="">
                    </div>
                    <div class="form-group ctim">
                        <label for="isex0">Jenis Kelamin</label>
                        <select class="single" id="isex0" name="isex0">
                            <option value="0">- Pilih Jenis Kelamin -</option>
                            <option value="1">Laki-laki</option>
                            <option value="2">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group ctim">
                        <label for="ihp0">Nomor HP</label>
                        <input type="text" id="ihp0" name="ihp0" value="">
                    </div>
                    <div class="form-group ctim">
                        <label for="iemail0">Email</label>
                        <input type="text" id="iemail0" name="iemail0" value="">
                    </div>
                </div>
                <hr class="hrtim">

                <ul class="infoul">
                    <li>
                        <a href="#" onclick="toggleInfo(event,1)">
                            <h3 style="margin-bottom:15px;">ANGGOTA 1: DINAS PENDIDIKAN &#9660;</h3>
                        </a>
                        <div id="info1" class="fanggota info-container" style="margin-bottom:10px">
                            <div class="form-group ctim">
                                <label for="inama1">Nama</label>
                                <input type="text" id="inama1" name="inama1" value="">
                            </div>
                            <div class="form-group ctim">
                                <label for="inik1">NIK</label>
                                <input type="text" id="inik1" name="inik1" value="">
                            </div>
                            <div class="form-group ctim">
                                <label for="isex1">Jenis Kelamin</label>
                                <select class="single" id="isex1" name="isex1">
                                    <option value="0">- Pilih Jenis Kelamin -</option>
                                    <option value="1">Laki-laki</option>
                                    <option value="2">Perempuan</option>
                                </select>
                            </div>
                            <div class="form-group ctim">
                                <label for="ihp1">Nomor HP</label>
                                <input type="text" id="ihp1" name="ihp1" value="">
                            </div>
                            <div class="form-group ctim">
                                <label for="iemail1">Email</label>
                                <input type="text" id="iemail1" name="iemail1" value="">
                            </div>
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
                                <input type="text" id="inama2" name="inama2" value="">
                            </div>
                            <div class="form-group ctim">
                                <label for="inik2">NIK</label>
                                <input type="text" id="inik2" name="inik2" value="">
                            </div>
                            <div class="form-group ctim">
                                <label for="isex2">Jenis Kelamin</label>
                                <select class="single" id="isex2" name="isex2">
                                    <option value="0">- Pilih Jenis Kelamin -</option>
                                    <option value="1">Laki-laki</option>
                                    <option value="2">Perempuan</option>
                                </select>
                            </div>
                            <div class="form-group ctim">
                                <label for="ihp2">Nomor HP</label>
                                <input type="text" id="ihp2" name="ihp2" value="">
                            </div>
                            <div class="form-group ctim">
                                <label for="iemail2">Email</label>
                                <input type="text" id="iemail2" name="iemail2" value="">
                            </div>
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
                                <input type="text" id="inama3" name="inama3" value="">
                            </div>
                            <div class="form-group ctim">
                                <label for="inik3">NIK</label>
                                <input type="text" id="inik3" name="inik3" value="">
                            </div>
                            <div class="form-group ctim">
                                <label for="isex3">Jenis Kelamin</label>
                                <select class="single" id="isex3" name="isex3">
                                    <option value="0">- Pilih Jenis Kelamin -</option>
                                    <option value="1">Laki-laki</option>
                                    <option value="2">Perempuan</option>
                                </select>
                            </div>
                            <div class="form-group ctim">
                                <label for="ihp3">Nomor HP</label>
                                <input type="text" id="ihp3" name="ihp3" value="">
                            </div>
                            <div class="form-group ctim">
                                <label for="iemail3">Email</label>
                                <input type="text" id="iemail3" name="iemail3" value="">
                            </div>
                        </div>
                        <hr class="hrtim">
                    </li>
                </ul>

                <!-- ANGGOTA 4-8 -->
                <?php for ($a = 4; $a <= 8; $a++) { ?>
                    <div id="danggota<?= $a ?>" style="display:none;">
                        <label>
                            <h3 style="margin-bottom:15px;">ANGGOTA <?= $a ?>:</h3>
                        </label>
                        <div class="fanggota" style="margin-bottom:10px">
                            <div class="form-group ctim">
                                <label for="djenis<?= $a ?>">Instansi</label>
                                <div id="djenis<?= $a ?>">
                                    <select class=" single" id="idinas<?= $a ?>" name="idinas<?= $a ?>">
                                        <option value="00">- Pilih Instansi -</option>
                                        <option value="01">Dinas Pendidikan</option>
                                        <option value="02">Dinas Sosial</option>
                                        <option value="03">Dinas PPPA</option>
                                        <option value="04">Dinas Kesehatan</option>
                                        <option value="05">UPTD PPA</option>
                                        <option value="06">Kepolisian</option>
                                        <option value="07">Balai Pemasyarakatan</option>
                                        <option value="08">Fasilitas Kesehatan</option>
                                        <option value="09">Fasilitas Rehab Sosial</option>
                                        <option value="10">Tokoh Adat / Masyarakat</option>
                                        <option value="11">Lembaga Swadaya Masyarakat</option>
                                        <option value="99">Lainnya</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group ctim">
                                <label for="inama<?= $a ?>">Nama</label>
                                <input type="text" id="inama<?= $a ?>" name="inama<?= $a ?>" value="">
                            </div>
                            <div class="form-group ctim">
                                <label for="inik<?= $a ?>">NIK</label>
                                <input type="text" id="inik<?= $a ?>" name="inik<?= $a ?>" value="">
                            </div>
                            <div class="form-group ctim">
                                <label for="isex<?= $a ?>">Jenis Kelamin</label>
                                <select class="single" id="isex<?= $a ?>" name="isex<?= $a ?>">
                                    <option value="0">- Pilih Jenis Kelamin -</option>
                                    <option value="1">Laki-laki</option>
                                    <option value="2">Perempuan</option>
                                </select>
                            </div>
                            <div class="form-group ctim">
                                <label for="ihp<?= $a ?>">Nomor HP</label>
                                <input type="text" id="ihp<?= $a ?>" name="ihp<?= $a ?>" value="">
                            </div>
                            <div class="form-group ctim">
                                <label for="iemail<?= $a ?>">Email</label>
                                <input type="text" id="iemail<?= $a ?>" name="iemail<?= $a ?>" value="">
                            </div>
                        </div>
                        <hr class="hrtim">
                    </div> <?php } ?>

                <div class="form-group ctim" style="margin-top:20px;">
                    <button id="tbtambah" onclick="return tambahInput()">Tambah Anggota</button>&nbsp;
                    <button id="tbkurang" onclick="return kurangiInput()">Kurangi Anggota</button>
                </div>

                <input type="hidden" id="jmlpengguna" name="jmlpengguna" value="4">
                <input type="hidden" id="idinas1" name="idinas1" value="01">
                <input type="hidden" id="idinas2" name="idinas2" value="02">
                <input type="hidden" id="idinas3" name="idinas3" value="03">

                <center>
                    <div class="tengah">
                        <input onclick="return cekinput();" type="submit" value="Kirim">
                    </div>
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

    $("#tbkurang").hide();

    $(document).ready(function() {

        $("#tanggal_sk").datepicker({
            dateFormat: "dd-mm-yy",
        });
        $.datepicker.setDefaults($.datepicker.regional['id']);

        $('.single').select2();

    });

    var counter = 4;

    function tambahInput() {
        $("#tbkurang").show();
        $("#danggota" + counter).show();
        if (counter <= 8)
            counter++;
        if (counter == 9)
            $("#tbtambah").hide();
        return false;
    }

    function kurangiInput() {
        $("#tbtambah").show();
        if (counter > 2)
            counter--;
        if (counter == 4)
            $("#tbkurang").hide();
        $("#danggota" + counter).hide();
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


    // $('body').on("change", "#inamaketua", function() {
    //     getjabatan();
    // });


    // function getsatgas() {
    //     var kode = $('#idinas').val();
    //     $.ajax({
    //         type: 'GET',
    //         data: {
    //             kode: kode
    //         },
    //         dataType: 'json',
    //         cache: false,
    //         url: '<?php //echo base_url(); 
                        ?>inputdata/getPTK',
    //         success: function(result) {
    //             isihtml1 = '<select onchange="getjabatan(0)" class="single" id="inama1" name="inama1">';
    //             isihtml2 = '<option value="00">- Pilih Nama -</option>';
    //             $.each(result, function(i, result) {
    //                 // jabatan.push([result.ptk_id, result.jenis_ptk_id + "," + result.jenis_ptk]);
    //                 jabatan.push([result.ptk_id, result.jenis_ptk]);
    //                 isihtml2 = isihtml2 + "<option value='" + result.ptk_id + "'>" + result.nama + "</option>";
    //             });
    //             isihtml3 = '</select>';
    //             $('#dnama').html(isihtml1 + isihtml2 + isihtml3);

    //             for (var i = 1; i <= 8; i++) {
    //                 isihtml1 = '<select class="single" id="inamaanggota' + i + '" name="inamaanggota' + i + '">';
    //                 isihtml2 = '<option value="00">- Pilih Nama -</option>';
    //                 $.each(result, function(i, result) {
    //                     isihtml2 = isihtml2 + "<option value='" + result.ptk_id + "'>" + result.nama + "</option>";
    //                 });
    //                 isihtml3 = '</select>';
    //                 $('#dnama' + i).html(isihtml1 + isihtml2 + isihtml3);
    //             }

    //             $('.single').select2();
    //         }
    //     });
    // }

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

        valsk = document.getElementById("file_sk").value;
        fileExt = valsk.split('.').pop();
        valtgl = document.getElementById("tanggal_sk").value;

        // arrayinputnya.push(inamaketua);
        // arrayinputnya.push(inamaanggota1);

        if (valsk == "") {
            oke = false;
        }

        for (var a = 0; a < counter; a++) {
            if (document.getElementById("idinas" + a).value == "00" || document.getElementById("inama" + a).value == "" || document.getElementById("inik" + a).value == "" || document.getElementById("isex" + a).value == "0" || document.getElementById("ihp" + a).value == "") {
                oke = false;
            }


            if (cekemailvalid(a) == false && document.getElementById("iemail" + a).value != "") {
                emailvalid = false;
            }
            arrayinputnya.push(document.getElementById("inama" + a).value);
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

        if (checkUnique(arrayinputnya) == false && document.getElementById("inama" + a).value != "") {
            alert("Ada nama yang sama");
            oke = false;
        }

        if (emailvalid == false) {
            alert("Alamat email tidak valid");
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

    function toggleInfo(event, idx) {
        event.preventDefault();

        var info = document.getElementById("info" + idx);
        info.classList.toggle("show");
    }
</script>
<?= $this->endSection(); ?>