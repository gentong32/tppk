<?= $this->extend('layout/default') ?>

<?= $this->section('header') ?>
<link rel="stylesheet" href="<?= base_url() ?>css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="<?= base_url() ?>css/responsive.dataTables.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    table td {
        vertical-align: top;
    }

    .dwilayah {
        margin-bottom: 10px;
    }

    td:nth-child(n+3):nth-child(-n+9) {
        text-align: right;
        padding-right: 20px;
    }

    .dfilter {
        text-align: center;
    }

    .table.dataTable tfoot th {
        text-align: right !important;
        padding-right: 20px;
    }
</style>
<script src="<?= base_url() ?>js/jquery-3.5.1.js"></script>
<script src="<?= base_url() ?>js/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>js/dataTables.responsive.min.js"></script>
<?= $this->endSection() ?>

<?= $this->section('konten') ?>

<div class="content-wrap">
    <div class="judul">STATUS LAPORAN KEKERASAN <?= ($level >= 2) ? "[SATUAN PENDIDIKAN]" : "" ?> <?= $judul ?></div>

    <?php if ($level == 1) : ?>
        <?= $linkindonesia ?> >> <?= substr($wilayah1, 5) ?>
    <?php elseif ($level == 2) : ?>
        <?= $linkindonesia ?> >> <?= $linkprovinsi ?> >> <?= $wilayah2 ?>
    <?php elseif ($level == 3) : ?>
        <?= $linkindonesia ?> >> <?= $linkprovinsi ?> >> <?= $linkkota ?> >> <?= $wilayah3 ?>
    <?php endif ?>

    <div class="dfilter">
        Jenjang:
        <div id="djenjang" style="display:inline-block;">
            <select class="combobox1" id="jenjang" name="jenjang" onchange="gantijenjang(this)">
                <option <?php echo ($jenjang == $jenjangall) ? 'selected' : ''; ?> value="<?= $jenjangall ?>">- <?= $jenjangall ?> -</option>
                <?php foreach ($opsijenjang as $opsi) {
                    echo "<option " . (($jenjang == $opsi) ? 'selected' : '') . " value='" . $opsi . "'>" . $opsi . "</option>\n";
                }
                ?>
            </select>
        </div>
    </div>

    <div style="margin-top: 0px;">
        <?php if ($sebagai == "operatorsatgas") { ?>
            <button class="btn_ijo" onclick="inputform();">INPUT LAPORAN</button>
        <?php } ?>
        <?php if ($level > 0 && ($sebagai == "pusat" || $sebagai == "dinasprovinsi" || $sebagai == "dinaskota" || $sebagai == "operatorsatgas")) : ?>
            <button class="btn_ijo" onclick="laporan();">LAPORAN DINAS <?= (($sebagai == "pusat" && $level == 1) || ($sebagai == "dinasprovinsi" && $level == 1) || ($sebagai == "operatorsatgas" && $level == 1)) ? "PROVINSI" : "KAB/KOTA" ?></button>
        <?php endif ?>
        <div class="informasi" style="margin-top: 15px;">
            <table class="table table-striped" id="example">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Satuan Pendidikan</th>
                        <th>Total Kasus</th>
                        <th>Terbukti</th>
                        <th>Tidak terbukti</th>
                        <th>Dihentikan</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th></th>
                        <th>Total</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div>
<?= $this->endSection(); ?>

<?= $this->section('scriptfooter') ?>
<script>
    var kode_wilayah = "<?= $kode_wilayah ?>";

    $(document).ready(function() {

        var data = [];
        <?php
        $nomor = 0;
        foreach ($rekap_laporan as $value) {
            $nomor++;
            $namawilayah = '<a href="' . base_url() . 'status_laporan_kekerasan?kode_wilayah=' . $kode_wilayah . '&npsn=' . $value['npsn'] . '" target="_self">' . $value['nama'] . '</a>';
            echo "data.push([" . $nomor . ", '" . $namawilayah . "', '" . $value['tppk'] . "', '" . $value['Terbukti'] . "', '" . $value['TidakTerbukti'] . "', '" . $value['Dihentikan'] . "']);\n";
        }
        ?>

        $('#example').DataTable({
            data: data,
            scrollX: window.innerWidth < window.innerHeight,
            processing: true,
            responsive: true,
            columns: [{
                    title: "No"
                },
                {
                    title: "Satuan Pendidikan"
                },
                {
                    title: "Total Kasus"
                },
                {
                    title: "Terbukti"
                },
                {
                    title: "Tidak terbukti"
                },
                {
                    title: "Dihentikan"
                }
            ],
            footerCallback: function(row, data, start, end, display) {
                var api = this.api();

                // Remove formatting to get integer data for summation
                var intVal = function(i) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '') * 1 :
                        typeof i === 'number' ?
                        i : 0;
                };

                // Total over all pages
                totalTppk = api
                    .column(2)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                totalTerbukti = api
                    .column(3)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                totalTidakTerbukti = api
                    .column(4)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                totalDihentikan = api
                    .column(5)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Update footer
                $(api.column(2).footer()).html(totalTppk);
                $(api.column(3).footer()).html(totalTerbukti);
                $(api.column(4).footer()).html(totalTidakTerbukti);
                $(api.column(5).footer()).html(totalDihentikan);
            }
        });
    });

    function gantijenjang(e) {
        var linkkodewilayah = kode_wilayah != "000000" ? "?kode_wilayah=" + kode_wilayah : "";
        var linkjenjang = e.value != "semua" ? (linkkodewilayah ? "&jenjang=" + e.value : "?jenjang=" + e.value) : "";
        window.open('<?= base_url('status_laporan_kekerasan') ?>' + linkkodewilayah + linkjenjang, '_self');
    }

    function laporan() {
        window.open("<?= base_url('status_laporan_kekerasan') ?>?kode_wilayah=" + kode_wilayah + "&laporan=dinas", "_self");
    }

    function inputform() {
        window.open("<?= base_url('inputdata/pelaporan') ?>", "_self");
    }
</script>
<?= $this->endSection(); ?>