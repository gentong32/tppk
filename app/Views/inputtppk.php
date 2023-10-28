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

            <center>
                <div class="tengah">
                    <input onclick="return cekinput();" type="submit" value="Input">
                </div>
            </center>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scriptfooter') ?>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.single').select2();
    });

    $('#ipropinsi').change(function() {
        getkota();
    });

    $('body').on("change", "#ikota", function() {
        getkecamatan();
    });

    $('body').on("change", "#ikecamatan", function() {
        getsekolah();
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
                    isihtml2 = isihtml2 + "<option value='" + result.kode_instansi + "'>[" + result.kode_instansi + "] " + result.nama + "</option>";
                });
                isihtml3 = '</select>';
                $('#dsekolah').html(isihtml1 + isihtml2 + isihtml3);
                // $('#inpsn').val("");
                $('.single').select2();
            }
        });
    }

    function cekinput() {
        var oke = true;
        var valnpsn = document.getElementById("iinstansi").value;

        if (valnpsn != "00") {
            window.open('<?= base_url() . "inputdata/npsn/" ?>' + valnpsn);
        }
        return true;
    }
</script>
<?= $this->endSection(); ?>