<?php

$adafilter = "";
$filter = "";

if ($jenjang != "semua" || $bentuk != "semua" || $status != "semua") {
    $adafilter = "?";
}

if ($jenjang != "semua") {
    $filter = $filter . "jenjang=" . $jenjang . "&";
}
if ($bentuk != "semua") {
    $filter = $filter . "bentuk=" . $bentuk . "&";
}
if ($status != "semua") {
    $filter = $filter . "status=" . $status . "&";
}

$text = $adafilter . $filter;
$panjang = strlen($text);


if ($adafilter != "") {
    $parameter = substr($text, 0, $panjang - 1);
} else {
    $parameter = "";
}


$totalsemua = 0;
$total1 = 0;

$link1 = site_url('tppk/wilayah') . "/" . substr($kode, 0, 2) . "0000" . "/1/" . $parameter;
$link2 = site_url('tppk/wilayah') . "/" . substr($kode, 0, 4) . "00" . "/2/" . $parameter;
$link3 = site_url('tppk/wilayah') . "/" . substr($kode, 0, 6) . "/3/" . $parameter;
$breadcrump1 = "";

$judulnama = "Nama Sekolah";
$breadcrump1 = ">> <a href='" . $link1 . "'>$namalevel1</a> >> <a href='" . $link2 . "'>$namalevel2</a> >> $namalevel3";
$styletabel = "max-width:900px;";

for ($a = 1; $a <= 5; $a++) {
    $selectj[$a] = "";
}
if ($jenjang == "paud")
    $selectj[1] = "selected";
else if ($jenjang == "dikdas")
    $selectj[2] = "selected";
else if ($jenjang == "dikmen")
    $selectj[3] = "selected";
else if ($jenjang == "dikmas")
    $selectj[4] = "selected";

for ($a = 1; $a <= 2; $a++) {
    $selects[$a] = "";
}
if ($status == "negeri")
    $selects[1] = "selected";
else
    $selects[2] = "selected";
?>

<?= $this->extend('layout/default') ?>

<?= $this->section('header') ?>
<link rel="stylesheet" href="<?= base_url() ?>css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="<?= base_url() ?>css/responsive.dataTables.min.css" />
<script src="<?= base_url() ?>js/jquery-3.5.1.js"></script>
<script src="<?= base_url() ?>js/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>js/dataTables.responsive.min.js"></script>
<?= $this->endSection() ?>

<?= $this->section('konten') ?>
<div class="content-wrap">
    <?php if ($level > 0) { ?>
        <div class="breadcrumps"><a href="<?= site_url('tppk/wilayah' . $parameter) ?>">Indonesia</a>
            <?= $breadcrump1; ?>
        </div>
    <?php } ?>
    <div class="judul">TPPK SEKOLAH DI <?= $namapilihan ?></div>

    <center>
        <div class="dfilter">
            <div id="djenjang" style="display:inline-block;">
                <select class="combobox1" id="jenjang" name="jenjang">
                    <option value="all">-Semua Jenjang-</option>
                    <option <?= $selectj[1] ?> value="paud">Paud</option>
                    <option <?= $selectj[2] ?> value="dikdas">Dikdas</option>
                    <option <?= $selectj[3] ?> value="dikmen">Dikmen</option>
                    <option <?= $selectj[4] ?> value="dikmas">Dikmas</option>
                </select>
            </div>
            <div id="dbentukpendidikan" style="display:inline-block;">
                <select class="combobox1" id="bentuk_pendidikan" name="bentuk_pendidikan">
                    <option value="all">-Semua Bentuk-</option>
                    <?php
                    foreach ($dafbentuk as $value) {
                        $seleksi = "";
                        if ($value == $bentuk) {
                            $seleksi = "selected";
                        }
                        echo "<option " . $seleksi . " value='" . $value . "'>" . $value . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div id="dbentukpendidikan" style="display:inline-block;">
                <select class="combobox1" id="istatus" name="istatus">
                    <option value="all">-Semua Status-</option>
                    <option <?= $selects[1] ?> value="negeri">Negeri</option>
                    <option <?= $selects[2] ?> value="swasta">Swasta</option>
                </select>
            </div>
            <button onclick="filterdata()" class="tb_utama" type="button">
                Terapkan
            </button>
        </div>
    </center>

    <div class="informasi">
        <table class="table table-striped" id="example">
            <thead>
                <th width="10px">No</th>
                <th><?= $judulnama ?></th>
                <?php if ($level == 3) { ?>
                    <th>NPSN</th>
                <?php } ?>
                <th>TPPK</th>
            </thead>

            <tbody align="right">
                <?php foreach ($datanas as $key => $value) : ?>
                    <tr>
                        <td><?= $key + 1 ?></td>
                        <td align="left" class="link1">
                            <a href="<?= site_url('tppk/anggota/' .
                                            trim($value['instansi_id'])) ?>"><?= $value['namasekolah'] ?></a>
                        </td>
                        <?php if ($level == 3) { ?>
                            <td><?= $value['kode_instansi'] ?></td>
                        <?php } ?>
                        <td><?= $value['total_anggota'] ?></td>


                    </tr>

                <?php endforeach; ?>
            </tbody>

            <tfoot align="right">
                <tr>
                    <th></th>
                    <th></th>
                    <?php if ($level == 3) { ?>
                        <th>NPSN</th>
                    <?php } ?>
                    <th></th>


                </tr>
            </tfoot>

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

    <?php if ($level == 3) { ?>
        var kolom_angka = 3;
    <?php } else { ?>
        var kolom_angka = 2;
    <?php } ?>

    $('#example').DataTable({
        scrollX: teru,
        columnDefs: [{
                targets: kolom_angka,
                render: $.fn.dataTable.render.number('.', ',', 0, '')
            },

            {
                className: 'text-right',
                targets: [(kolom_angka)]
            },
        ],
        "footerCallback": function(row, data, start, end, display) {
            var api = this.api(),
                data;

            // converting to interger to find total
            var intVal = function(i) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ?
                    i : 0;
            };

            var total1 = api
                .column((kolom_angka))
                .data()
                .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);



            // Update footer by showing the total with the reference of the column index 
            var numFormat = $.fn.dataTable.render.number('.', ',', 0, '').display;

            $(api.column(0).footer()).html('');
            $(api.column(1).footer()).html('TOTAL SEMUA');
            $(api.column(2).footer()).html('');
            $(api.column((kolom_angka)).footer()).html(numFormat(total1));
            $(api.column((kolom_angka)).footer()).css({
                'text-align': 'right',
                'padding-right': '15px'
            });


        },
        "processing": true,
    });

    $(document).on('change', '#kementerian', function() {
        getdaftarjenjang();
    });

    $(document).on('change', '#jenjang', function() {
        // alert ($('#jenjang').val());
        getdaftarbentuk();
    });

    function getdaftarjenjang() {
        // alert ($('#kementerian').val());
        isihtml1 = '<select class="combobox1" id="jenjang" name="jenjang">';
        isihtml3 = '</select>';
        $('#djenjang').html(isihtml1 + isihtml3);
        $.ajax({
            type: 'GET',
            data: {},
            dataType: 'json',
            cache: false,
            url: '<?php echo base_url(); ?>/tppk/getJenjangKementerian/' + $('#kementerian').val(),
            success: function(result) {
                isihtml1 = '<select class="combobox1" id="jenjang" name="jenjang">' +
                    '<option value="all">-Semua Jenjang-</option>';
                isihtml2 = "";
                total = 0;
                $.each(result, function(i, result) {
                    total++;
                    isihtml2 = isihtml2 + "<option value='" + result + "'>" + result + "</option>";
                });
                if (total == 1) {
                    isihtml1 = '<select class="combobox1" id="jenjang" name="jenjang">';
                }
                $('#djenjang').html(isihtml1 + isihtml2 + isihtml3);
                getdaftarbentuk();
            }
        });
    }

    function getdaftarbentuk() {

        isihtml1 = '<select class="combobox1" id="bentuk_pendidikan" name="bentuk_pendidikan">';
        isihtml3 = '</select>';
        $('#dbentukpendidikan').html(isihtml1 + isihtml3);
        $.ajax({
            type: 'GET',
            data: {},
            dataType: 'json',
            cache: false,
            url: '<?php echo base_url(); ?>/tppk/getBentukKementerian/' + $('#kementerian').val() + '/' + $('#jenjang').val(),
            success: function(result) {
                // alert ($('#jalur_pendidikan').val());
                isihtml1 = '<select class="combobox1" id="bentuk_pendidikan" name="bentuk_pendidikan">' +
                    '<option value="all">-Semua Bentuk-</option>';
                isihtml2 = "";
                var total = 0;
                $.each(result, function(i, result) {
                    total++;
                    // if (result=='-Semua Bentuk-')
                    // result = "all";
                    isihtml2 = isihtml2 + "<option value='" + result + "'>" + result + "</option>";
                });
                if (total == 1) {
                    isihtml1 = '<select class="combobox1" id="bentuk_pendidikan" name="bentuk_pendidikan">';
                }
                $('#dbentukpendidikan').html(isihtml1 + isihtml2 + isihtml3);
            }
        });
    }

    function filterdata() {
        //    alert ($('#bentuk_pendidikan').val());
        var adafilter = "";
        var filter = "";

        var kode = "<?= $kode ?>";
        var level = "<?= $level ?>";
        var kodlevel = "";
        if (kode != "000000") {
            kodlevel = "/" + kode + "/" + level;
        }
        var mentri = document.getElementById('kementerian').value;
        var jenjang = document.getElementById('jenjang').value;
        var bentuk = document.getElementById('bentuk_pendidikan').value;
        var residu = document.getElementById('iresidu').value;

        if (bentuk == '-Semua Bentuk-')
            bentuk = "all";

        if (mentri != "all" || jenjang != "all" || bentuk != "all" || residu != "all") {
            adafilter = "?";
        }

        if (mentri != "all") {
            filter = filter + "lembaga=" + mentri + "&";
        }
        if (jenjang != "all") {
            filter = filter + "jenjang=" + jenjang + "&";
        }
        if (bentuk != "all") {
            filter = filter + "bentuk=" + bentuk + "&";
        }
        if (residu != "all") {
            filter = filter + "residu=" + residu + "&";
        }

        let text = adafilter + filter;
        let panjang = text.length;
        let result = text.substr(0, panjang - 1);

        if (adafilter != "") {
            window.open("<?= base_url() ?>tppk/wilayah" + kodlevel + result, "_self");
        } else {
            window.open("<?= base_url() ?>tppk/wilayah" + kodlevel, "_self");
        }

    }
</script>
<?= $this->endSection(); ?>