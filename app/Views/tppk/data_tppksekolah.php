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
else if ($status == "swasta")
    $selects[2] = "selected";
?>

<?= $this->extend('layout/default_tppk') ?>

<?= $this->section('header') ?>
<link rel="stylesheet" href="<?= base_url() ?>css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="<?= base_url() ?>css/responsive.dataTables.min.css" />
<script src="<?= base_url() ?>js/jquery-3.5.1.js"></script>
<script src="<?= base_url() ?>js/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>js/dataTables.responsive.min.js"></script>
<style>
    .residu {
        width: 15px;
        height: 15px;
        border-radius: 8px;
    }

    .residu2 {
        width: 10px;
        height: 10px;
        border-radius: 5px;
    }

    .merah {
        background-color: red;
    }

    .hijau {
        background-color: green;
    }

    .orange {
        background-color: green;
    }

    .text-left {
        text-align: left !important;
        /* padding-right: 25px !important; */
    }

    .merahin {
        color: red;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('konten') ?>
<div class="content-wrap">

    <div class="menutab">
        <button onclick="openTab('tab1')" id="btntab1">TPPK</button>
        <button onclick="openTab('tab2')" id="btntab2">Satuan Tugas</button>
    </div>

    <div id="tab1" class="tab">

        <?php if ($level > 0) { ?>
            <div class="breadcrumps"><a href="<?= site_url('tppk/wilayah' . $parameter) ?>">Indonesia</a>
                <?= $breadcrump1; ?>
                <?= $breadcrump2; ?>
                <?= $breadcrump3; ?>
            </div>
        <?php } ?>
        <div class="judul">Jumlah TPPK tiap <?= $namapilihan ?></div>

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
            <table class="table table-striped" id="tabel">
                <thead>
                    <th width="10px">No</th>
                    <th>NPSN *)</th>
                    <th><?= $judulnama ?></th>
                    <th>Validitas **)</th>
                    <th>TPPK ***)</th>
                    <th>Jumlah Anggota TPPK</th>
                </thead>

                <tbody align="right">
                    <?php
                    $totaladatppk = 0;
                    $totalvalid = 0;
                    foreach ($datanas as $key => $value) :
                        if ($value['tot_jml_tppk'] > 0) {
                            $totaladatppk++;
                        }
                        if ($value['tot_residu'] != 1) {
                            $totalvalid++;
                        }
                    ?>
                        <tr>
                            <td><?= $key + 1 ?></td>
                            <td <?= ($value['tot_sekolah_sudah_sync'] == 0) ? 'class="merahin"' : '' ?>><?= trim($value['kode_wilayah']); ?></td>
                            <td align="left" class="link1">
                                <?php if ($level < 3) {
                                ?>
                                    <a href="<?= site_url('tppk/wilayah/' .
                                                    trim($value['kode_wilayah']) . '/' . ($level + 1) . $parameter) ?>"><?php
                                                                                                                        if ($level == 0 && $value['wilayah'] != "Luar Negeri") {
                                                                                                                            echo substr($value['wilayah'], 5);
                                                                                                                        } else if ($level == 2 && substr($kode, 0, 2) != '35') {
                                                                                                                            echo substr($value['wilayah'], 4);
                                                                                                                        } else {
                                                                                                                            echo $value['wilayah'];
                                                                                                                        } ?></a>
                                <?php
                                } else { ?>
                                    <a href="<?= site_url('tppk/anggota/' .
                                                    trim($value['kode_wilayah'])) ?>"><?php

                                                                                        if ($level == 0 && $value['wilayah'] != "Luar Negeri") {
                                                                                            echo substr($value['wilayah'], 5);
                                                                                        } else if ($level == 2 && substr($kode, 0, 2) != '35') {
                                                                                            echo substr($value['wilayah'], 4);
                                                                                        } else {
                                                                                            echo $value['wilayah'];
                                                                                        }
                                                                                    } ?></a>
                            </td>
                            <td align="center">
                                <div class="residu <?= ($value['tot_residu'] == 1) ? 'merah' : (($value['status_sk'] == 0) ? 'orange' : 'hijau') ?>"><?= ($value['tot_residu'] == 1) ? ' ' : '' ?></div>
                            </td>
                            <td><?= ($value['tot_jml_tppk'] > 0) ? '&check;' : '-' ?></td>
                            <td><?= $value['tot_jml_tppk'] ?></td>

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
                        <th></th>
                    </tr>
                </tfoot>

            </table>
            <span class="link1" style="padding-bottom:25px;"><i> &nbsp;&nbsp;&nbsp;&nbsp;*) NPSN <span style="color:red">merah</span>: sekolah tidak update / siswa 0</i></span><br>
            <span class="link1" style="padding-bottom:25px;"><i> &nbsp;&nbsp;**) <div class="residu2 hijau" style="display: inline-block;"></div>:valid &nbsp;&nbsp;<div class="residu2 merah" style="display: inline-block;"></div>:residu </i></span><br>
            <!-- &nbsp;&nbsp;<div class="residu2 orange" style="display: inline-block;"></div>:menunggu persetujuan SK -->
            <span class="link1" style="padding-bottom:25px;"><i>***) Sumber: Dapodik</i></span><br><br>
        </div>
    </div>

    <div id="tab2" class="tab">
        <?php if ($level > 0) { ?>
            <div class="breadcrumps"><a href="<?= site_url('tppk/wilayah' . $parameter) ?>">Indonesia</a>
                <?= $breadcrump1; ?>
            </div>
        <?php }
        if ($level == 0)
            include(APPPATH . 'Views/tppk/tppk_lv0.php');
        else
            include(APPPATH . 'Views/tppk/tppk_lv1.php');
        ?>


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

    var kolom_angka = 4;

    $('#tabel').DataTable({
        scrollX: teru,
        columnDefs: [{
                targets: kolom_angka,
                render: $.fn.dataTable.render.number('.', ',', 0, '')
            },
            {
                className: 'text-left',
                targets: [1]
            },
            {
                className: 'text-right',
                targets: [(kolom_angka), (kolom_angka + 1)]
            },
        ],

        "footerCallback": function(row, data, start, end, display) {
            var api = this.api(),
                data;


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

            var numFormat = $.fn.dataTable.render.number('.', ',', 0, '').display;

            $(api.column(0).footer()).html('');
            $(api.column(1).footer()).html('TOTAL SEMUA');
            $(api.column(2).footer()).html('');
            $(api.column((kolom_angka - 1)).footer()).html(<?= $totalvalid ?>);
            $(api.column((kolom_angka - 1)).footer()).css({
                'text-align': 'right',
                'padding-right': '15px'
            });
            $(api.column((kolom_angka)).footer()).html(<?= $totaladatppk ?>);
            $(api.column((kolom_angka)).footer()).css({
                'text-align': 'right',
                'padding-right': '15px'
            });
            $(api.column((kolom_angka + 1)).footer()).html(numFormat(total2));
            $(api.column((kolom_angka + 1)).footer()).css({
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
            url: '<?php echo base_url(); ?>/tppk/getBentukKementerian/' + $('#jenjang').val(),
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
            window.open("<?= base_url() ?>tppk/wilayah" + kodlevel + result, "_self");
        } else {
            window.open("<?= base_url() ?>tppk/wilayah" + kodlevel, "_self");
        }

    }
</script>

<?php
if ($level == 0)
    include(APPPATH . 'Views/tppk/script_lv0.php');
else
    include(APPPATH . 'Views/tppk/script_lv1.php');
?>

<script>
    function openTab(tabName) {
        var i, tabContent;

        tabContent = document.getElementsByClassName("tab");
        for (i = 0; i < tabContent.length; i++) {
            tabContent[i].style.display = "none";
        }

        var buttons = document.getElementsByTagName("button");
        for (i = 0; i < buttons.length; i++) {
            buttons[i].classList.remove("aktif");
        }

        document.getElementById(tabName).style.display = "block";

        document.getElementById("btn" + tabName).classList.add("aktif");

        if (tabName == "tab1") {
            setSession(1);
        } else {
            setSession(2);
        }

    }

    function setSession(pilih) {
        $.ajax({
            url: '<?php echo base_url(); ?>Home/set_pilihan/' + pilih,
            method: 'GET',
            data: {},
            success: function(response) {},
            error: function(xhr, status, error) {

            }
        });
    }
</script>

<?= $this->endSection(); ?>