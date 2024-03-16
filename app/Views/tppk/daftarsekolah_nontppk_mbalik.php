<?= $this->extend('layout/default') ?>
<?php $csrfToken = csrf_hash(); ?>
<?= $this->section('header') ?>
<link rel="stylesheet" href="<?= base_url() ?>css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="<?= base_url() ?>css/responsive.dataTables.min.css" />
<style>
    table td {
        vertical-align: top;
    }

    .dwilayah {
        margin-bottom: 10px;
    }
</style>
<script src="<?= base_url() ?>js/jquery-3.5.1.js"></script>
<script src="<?= base_url() ?>js/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>js/dataTables.responsive.min.js"></script>
<?= $this->endSection() ?>

<?= $this->section('konten') ?>

<div class="content-wrap">
    <div class="judul">DAFTAR SEKOLAH BELUM MEMILIKI TPPK [<?= $namawilayah ?>]</div>

    <center>
        <?php if ($instansiid == 1) : ?>
            <div class="dwilayah">
                <div id="dprovinsi" style="display:inline-block;">
                    <select class="combobox1" id="provinsi" name="provinsi" onchange="pilprov(this)">
                        <?php
                        foreach ($daftar_provinsi as $item) { ?>
                            <option <?php echo (substr($provinsi, 0, 6) == substr($item['kode_wilayah'], 0, 6)) ? 'selected' : ''; ?> value="<?= $item['kode_wilayah'] ?>"><?= substr($item['nama'], 5) ?></option>";
                        <?php }
                        ?>

                    </select>
                </div>
                <div id="dkota" style="display:inline-block;">
                    <select class="combobox1" id="kota" name="kota">
                        <?php
                        $sudahoke = false;
                        if ($sudahoke == true) { ?>
                            <option value="<?= $provinsi ?>">Semua Kota/Kab</option>
                        <?php } ?>
                        <?php
                        foreach ($daftar_kota as $item2) { ?>
                            <option <?php echo (substr($kode_wilayah, 0, 6) == substr($item2['kode_wilayah'], 0, 6)) ? 'selected' : ''; ?> value="<?= $item2['kode_wilayah'] ?>"><?= substr($item2['nama'], 5) ?></option>";
                        <?php }
                        ?>
                    </select>
                </div>
            </div>
        <?php endif ?>
        <div class="dfilter">
            <div id="djenjang" style="display:inline-block;">
                <select class="combobox1" id="jenjang" name="jenjang" onchange="handleChange(this)">
                    <option <?php echo ($jenjang == 'PAUD') ? 'selected' : ''; ?> value="PAUD">PAUD</option>
                    <option <?php echo ($jenjang == 'SD') ? 'selected' : ''; ?> value="SD">SD</option>
                    <option <?php echo ($jenjang == 'SMP') ? 'selected' : ''; ?> value="SMP">SMP</option>
                    <option <?php echo ($jenjang == 'SMA') ? 'selected' : ''; ?> value="SMA">SMA</option>
                    <option <?php echo ($jenjang == 'SMK') ? 'selected' : ''; ?> value="SMK">SMK</option>
                    <option <?php echo ($jenjang == 'SLB') ? 'selected' : ''; ?> value="SLB">SLB</option>
                    <option <?php echo ($jenjang == 'KESETARAAN') ? 'selected' : ''; ?> value="KESETARAAN">KESETARAAN</option>
                </select>
            </div>
            <button onclick="filterdata()" class="tb_utama" type="button">
                Terapkan
            </button>

            <button onclick="unduhdata(1)" id="tbunduh1" class="tb_utama" type="button" style="margin-top: 5px;">
                Unduh Provinsi
            </button>
            <button onclick="unduhdata(2)" id="tbunduh2" class="tb_utama" type="button" style="margin-top: 5px;">
                Unduh Kab/Kota
            </button>
        </div>
    </center>

    <div class="informasi">
        <table class="table table-striped" id="example">
            <thead>
                <th width="10px">No</th>
                <th>Kabupaten</th>
                <th>Kecamatan</th>
                <th>Nama Sekolah</th>
                <th>NPSN</th>
                <th>Bentuk Pendidikan</th>
                <th>Status Sekolah</th>
            </thead>

            <!-- <tbody align="left">
                
            </tbody> -->

        </table>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('scriptfooter') ?>
<script>
    var w = window.innerWidth;
    var h = window.innerHeight;

    if (w < h) {
        teru = true;
    } else {
        teru = false;
    }

    $(document).ready(function() {
        $('#example').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            "ajax": {
                "url": "<?php echo base_url('inputdata/ajaxGetDaftarNonTPPK/' . $jenjang . '/' . $kode_wilayah); ?>",
                "type": "GET"
            },
            "columns": [{
                    data: null,
                    className: 'text-center',
                    orderable: false,
                    searchable: false
                },
                {
                    "data": "kota_kab"
                },
                {
                    "data": "kecamatan"
                },
                {
                    "data": "Sekolah"
                },
                {
                    "data": "NPSN"
                },
                {
                    "data": "bentuk_pendidikan"
                },
                {
                    "data": "status_sekolah"
                }
            ],
            rowCallback: function(row, data, index) {
                var table = $('#example').DataTable();
                $('td:eq(0)', row).html(table.page.info().start + index + 1);
            }
        });
    });



    function handleChange(selectElement) {
        document.getElementById('tbunduh1').style.display = "none";
        document.getElementById('tbunduh2').style.display = "none";
    }

    function pilprov(selectElement) {
        var kodeprov = selectElement.value;
        $.ajax({
            url: '<?= base_url() ?>inputdata/get_daf_kota',
            type: 'GET',
            data: {
                kodeprov: kodeprov,
            },
            dataType: 'json',
            cache: false,
            success: function(result) {
                // alert ($('#jalur_pendidikan').val());
                //<option value = "' + kodeprov + '">Semua Kota/Kab </option>
                isihtml1 = '<select class="combobox1" id="kota" name="kota">';
                isihtml2 = "";
                var total = 0;
                $.each(result, function(i, result) {
                    total++;
                    isihtml2 = isihtml2 + "<option value='" + result.kode_wilayah + "'>" + result.nama + "</option>";
                });
                isihtml3 = "</select>";
                // $('.tb_utama').prop('disabled', false);

                $('#dkota').html(isihtml1 + isihtml2 + isihtml3);
            }
        });
    }

    function filterdata() {
        var jenjang = document.getElementById('jenjang').value;
        <?php if ($instansiid == 1) { ?>
            var kota = document.getElementById('kota').value;
            window.open("<?= base_url() ?>residu?jenjang=" + jenjang + "&kode_wilayah=" + kota, "_self");
        <?php } else { ?>
            window.open("<?= base_url() ?>residu?jenjang=" + jenjang, "_self");
        <?php } ?>

    }

    function unduhdata(pilihan) {
        var jenjang = document.getElementById('jenjang').value;
        var tombol = document.getElementById('tbunduh' + pilihan);
        tombol.disabled = true;
        tombol.innerText = "mengunduh...";
        <?php if ($instansiid == 1) { ?>
            var kota = document.getElementById('kota').value;
            if (pilihan == 1) {
                kota = kota.substring(0, 2) + '0000';
            }
            window.open("<?= base_url() ?>inputdata/ekspor?jenjang=" + jenjang + "&kode_wilayah=" + kota, "_self");
        <?php } else { ?>
            window.open("<?= base_url() ?>inputdata/ekspor?jenjang=" + jenjang, "_self");
        <?php } ?>
    }
</script>
<?= $this->endSection(); ?>