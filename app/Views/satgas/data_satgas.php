<?php

$adafilter = "";
$filter = "";

if ($adafilter != "") {
    $parameter = substr($text, 0, $panjang - 1);
} else {
    $parameter = "";
}

$totalsemua = 0;
$total1 = 0;

$link1 = site_url('satgas/wilayah') . "/" . substr($kode, 0, 2) . "0000" . "/1/" . $parameter;
$link2 = site_url('satgas/wilayah') . "/" . substr($kode, 0, 4) . "00" . "/2/" . $parameter;
$link3 = site_url('satgas/wilayah') . "/" . substr($kode, 0, 6) . "/3/" . $parameter;
$breadcrump1 = "";
$breadcrump2 = "";
$breadcrump3 = "";
$judulnama = "Nama Provinsi";

if ($level == 1) {
    $breadcrump1 = ">> " . $namalevel1;
    if (substr($kode, 0, 2) != '35')
        $judulnama = "Nama Kota/Kabupaten";
    else
        $judulnama = "Nama Negara";
} else if ($level > 1) {
    $breadcrump1 = '>> <a href="' . $link1 . '">' . $namalevel1 . '</a>';
}

if ($level == 2) {
    $breadcrump2 = ">> " . $namalevel2;
    if (substr($kode, 0, 2) != '35')
        $judulnama = "Nama Kecamatan";
    else
        $judulnama = "Nama Kota";
} else if ($level == 3) {
    $judulnama = "Nama Sekolah";
    $breadcrump2 = '>> <a href="' . $link2 . '">' . $namalevel2 . '</a>';
} else if ($level == 4) {
    $judulnama = "Nama Sekolah";
    $breadcrump3 = '>> <a href="' . $link2 . '>' . $namalevel2 . '>' . $link3 . '">' . $namalevel3 . '</a>';
}

$styletabel = "max-width:900px;";
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
        <div class="breadcrumps"><a href="<?= site_url('satgas/wilayah' . $parameter) ?>">Indonesia</a>
            <?= $breadcrump1; ?>
            <?= $breadcrump2; ?>
            <?= $breadcrump3; ?>
        </div>
    <?php } ?>
    <div class="judul">Jumlah Satuan Tugas tiap <?= $namapilihan ?></div>



    <div class="informasi">
        <table class="table table-striped" id="tabel2">
            <thead>
                <th width="10px">No</th>
                <th><?= $judulnama ?></th>
                <th>Satgas Provinsi</th>
                <th>Jumlah Kota/Kab</th>
                <th>Jumlah Satgas Kota/Kab</th>
            </thead>

            <tbody align="right">
                <?php foreach ($datanas as $key => $value) : ?>
                    <tr>
                        <td><?= $key + 1 ?></td>
                        <td align="left" class="link1">
                            <?php if ($level <= 3) {

                            ?>
                                <a href="<?= site_url('satgas/wilayah/' .
                                                trim($value['kode_wilayah']) . '/' . ($level + 1) . $parameter) ?>"><?php
                                                                                                                    if ($level == 0 && $value['wilayah'] != "Luar Negeri") {
                                                                                                                        echo substr($value['wilayah'], 5);
                                                                                                                    } else if ($level == 2 && substr($kode, 0, 2) != '35') {
                                                                                                                        echo substr($value['wilayah'], 4);
                                                                                                                    } else {
                                                                                                                        echo $value['wilayah'];
                                                                                                                    } ?></a>
                            <?php
                            } else {

                                if ($level == 0 && $value['wilayah'] != "Luar Negeri") {
                                    echo substr($value['wilayah'], 5);
                                } else if ($level == 2 && substr($kode, 0, 2) != '35') {
                                    echo substr($value['wilayah'], 4);
                                } else {
                                    echo $value['wilayah'];
                                }
                            } ?>
                        </td>
                        <td>1</td>
                        <td>0</td>
                        <td>0</td>


                    </tr>

                <?php endforeach; ?>
            </tbody>

            <tfoot align="right">
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
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

    var kolom_angka = 2;

    $('#tabel2').DataTable({
        scrollX: teru,
        columnDefs: [{
                targets: kolom_angka,
                render: $.fn.dataTable.render.number('.', ',', 0, '')
            },

            {
                className: 'text-right',
                targets: [(kolom_angka), (kolom_angka + 1), (kolom_angka + 2)]
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

            var total2 = api
                .column((kolom_angka + 1))
                .data()
                .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            var total3 = api
                .column((kolom_angka + 2))
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
            $(api.column((kolom_angka + 1)).footer()).html(numFormat(total2));
            $(api.column((kolom_angka + 1)).footer()).css({
                'text-align': 'right',
                'padding-right': '15px'
            });
            $(api.column((kolom_angka + 2)).footer()).html(numFormat(total3));
            $(api.column((kolom_angka + 2)).footer()).css({
                'text-align': 'right',
                'padding-right': '15px'
            });

        },
        "processing": true,
    });

    $(document).on('change', '#jenjang', function() {
        // alert ($('#jenjang').val());
        getdaftarbentuk();
    });

    function getdaftarbentuk() {

        isihtml1 = '<select class="combobox1" id="bentuk_pendidikan" name="bentuk_pendidikan">';
        isihtml3 = '</select>';
        $('#dbentukpendidikan').html(isihtml1 + isihtml3);
        $.ajax({
            type: 'GET',
            data: {},
            dataType: 'json',
            cache: false,
            url: '<?php echo base_url(); ?>/satgas/getBentukKementerian/' + $('#jenjang').val(),
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
        var jenjang = document.getElementById('jenjang').value;
        var bentuk = document.getElementById('bentuk_pendidikan').value;
        var status = document.getElementById('istatus').value;

        if (bentuk == '-Semua Bentuk-')
            bentuk = "all";

        if (jenjang != "all" || bentuk != "all" || status != "all") {
            adafilter = "?";
        }

        if (jenjang != "all") {
            filter = filter + "jenjang=" + jenjang + "&";
        }
        if (bentuk != "all") {
            filter = filter + "bentuk=" + bentuk + "&";
        }
        if (status != "all") {
            filter = filter + "status=" + status + "&";
        }

        let text = adafilter + filter;
        let panjang = text.length;
        let result = text.substr(0, panjang - 1);

        if (adafilter != "") {
            window.open("<?= base_url() ?>satgas/wilayah" + kodlevel + result, "_self");
        } else {
            window.open("<?= base_url() ?>satgas/wilayah" + kodlevel, "_self");
        }

    }
</script>
<?= $this->endSection(); ?>