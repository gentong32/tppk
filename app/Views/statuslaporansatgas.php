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
        <?php if ($level > 0 && ($sebagai == "dinasprov" || $sebagai == "dinaskota" || $sebagai == "operatorsatgas")) : ?>
            <button class="btn_ijo" onclick="laporan();">LAPORAN DINAS <?= ($sebagai == "dinasprov" || ($sebagai == "operatorsatgas" && $indeks == 2)) ? "PROVINSI" : "KAB/KOTA" ?></button>
        <?php endif ?>
        <div class=" informasi" style="margin-top: 15px;">
            <table class="table table-striped" id="example">
                <thead>
                    <?php if ($level <= 1) { ?>
                        <tr>
                            <th rowspan="2" width="10px">No</th>
                            <th rowspan="2"><?= $judulkolom ?></th>
                            <?php if ($sebagai == "irjen") {
                                echo '<th rowspan="2">Lihat</th>';
                            } ?>
                            <th colspan="<?= ($level == 0) ? 3 : 2 ?>">Total Laporan</th>
                            <th rowspan="2">Terbukti</th>
                            <th rowspan="2">Tidak terbukti</th>
                            <th rowspan="2">Dihentikan</th>
                        </tr>
                        <tr>
                            <?php if ($level == 0) { ?>
                                <th>Prov</th>
                            <?php } ?>
                            <?php if ($level <= 1) { ?>
                                <th>Kota/Kab</th>
                            <?php } ?>
                            <th>TPPK</th>
                        </tr>
                    <?php } else { ?>
                        <th width="10px">No</th>
                        <th><?= $judulkolom ?></th>
                        <th>Total Laporan</th>
                        <th>Terbukti</th>
                        <th>Tidak terbukti</th>
                        <th>Dihentikan</th>
                    <?php } ?>
                </thead>
                <tfoot>
                    <tr>
                        <th></th>
                        <?php if ($sebagai == "irjen" || $level >= 2) { ?>
                            <th></th>
                        <?php } ?>
                        <?php if ($level <= 1) { ?>
                            <th></th>
                        <?php } ?>
                        <?php if ($level == 0) { ?>
                            <th>Prov</th>
                        <?php } ?>
                        <?php if ($level <= 1) { ?>
                            <th>Kota/Kab</th>
                        <?php } ?>
                        <th>TPPK</th>
                        <th>Terbukti</th>
                        <th>Tidak terbukti</th>
                        <th>Dihentikan</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div>
<?= $this->endSection(); ?>

<?= $this->section('scriptfooter') ?>
<script>
    var w = window.innerWidth;
    var h = window.innerHeight;
    var kode_wilayah = '<?= $kode_wilayah ?>';
    var jenjang = '<?= $jenjang ?>';

    if (w < h) {
        teru = true;
    } else {
        teru = false;
    }

    $(document).ready(function() {
        var data = [];
        <?php
        $nomor = 0;
        foreach ($rekap_laporan as $value) {
            $nomor++;
            if ($kode_wilayah == "000000") {
                $namawilayah = '<a href = ' . base_url() . 'status_laporan_kekerasan?kode_wilayah=' . $value['kode_wilayah'] . ' target = \'_self\'>' . $value['nama'] . '</a>';
            } else {
                if ($level < 3) {
                    $namawilayah = '<a href = ' . base_url() . 'status_laporan_kekerasan?kode_wilayah=' . $value['kode_wilayah'] . ' target = \'_self\'>' . $value['nama'] . '</a>';
                    if ($level == 2 && $level != "irjen") {
                        $namawilayah = $value['nama'];
                    }
                } else {
                    if ($sebagai == "irjen") {
                        $namawilayah = '<a href = ' . base_url() . 'status_laporan_kekerasan?kode_wilayah=' . $value['kode_wilayah'] . '&npsn=' . $value['npsn'] . ' target = \'_self\'>' . $value['nama'] . '</a>';
                    } else {
                        $namawilayah = $value['nama'];
                    }
                }

                if (($sebagai == "dinaskota") || ($sebagai == "dinasprov" && $level == 2))
                    $namawilayah = $value['nama'];
            }
            $mata = '<i class=\'far fa-eye\'></i>';

        ?>
            data.push([<?= $nomor ?>, "<?= $namawilayah ?>", <?= ($level <= 1 && $sebagai == "irjen") ? '"' . $mata . '",' : "" ?> <?= ($level == 0) ? '"' . $value['prov'] . '",' : "" ?> <?= ($level <= 1) ? '"' . $value['kota'] . '",' : "" ?> <?= ($level <= 3) ? '"' . $value['tppk'] . '",' : "" ?> "<?= $value['Terbukti'] ?>",
                "<?= $value['TidakTerbukti'] ?> ", "<?= $value['Dihentikan'] ?> "
            ]);
        <?php }
        ?>

        <?php if ($level <= 1) { ?>
            var kolom = 1;
            var kolom2 = 1;
            <?php } else {
            if ($sebagai == "irjen") { ?>
                var kolom = 0;
                var kolom2 = 0;
            <?php } else { ?>
                var kolom = 1;
                var kolom2 = 1;
            <?php } ?>

        <?php } ?>
        <?php if ($sebagai == "irjen") { ?>
            kolom++;
            kolom2++;
        <?php } ?>

        $('#example').DataTable({
            data: data,
            scrollX: teru,
            processing: true,
            responsive: true,
            footerCallback: function(row, data, start, end, display) {
                var api = this.api();

                $(api.column(1).footer()).html('Total');
                // Menghitung total untuk setiap kolom
                <?php if ($level == 0) { ?>
                    kolom++;
                    var total_prov = api.column(kolom).data().reduce(function(a, b) {
                        return parseInt(a) + parseInt(b);
                    }, 0);
                <?php } ?>

                <?php if ($level <= 1) { ?>
                    kolom++;
                    var total_kota = api.column(kolom).data().reduce(function(a, b) {
                        return parseInt(a) + parseInt(b);
                    }, 0);
                <?php } ?>

                kolom++;
                var total_tppk = api.column(kolom).data().reduce(function(a, b) {
                    return parseInt(a) + parseInt(b);
                }, 0);

                kolom++;
                var total_terbukti = api.column(kolom).data().reduce(function(a, b) {
                    return parseInt(a) + parseInt(b);
                }, 0);

                kolom++;
                var total_tidak_terbukti = api.column(kolom).data().reduce(function(a, b) {
                    return parseInt(a) + parseInt(b);
                }, 0);

                kolom++;
                var total_dihentikan = api.column(kolom).data().reduce(function(a, b) {
                    return parseInt(a) + parseInt(b);
                }, 0);

                // Menambahkan footer ke tabel

                <?php if ($level == 0) { ?>
                    kolom2++;
                    $(api.column(kolom2).footer()).html(total_prov);
                <?php } ?>

                <?php if ($level <= 1) { ?>
                    kolom2++;
                    $(api.column(kolom2).footer()).html(total_kota);
                <?php } ?>

                kolom2++;
                $(api.column(kolom2).footer()).html(total_tppk);
                kolom2++;
                $(api.column(kolom2).footer()).html(total_terbukti);
                kolom2++;
                $(api.column(kolom2).footer()).html(total_tidak_terbukti);
                kolom2++;
                $(api.column(kolom2).footer()).html(total_dihentikan);
            }
        });
    });

    function gantijenjang(e) {
        linkkodewilayah = "";
        if (kode_wilayah != "000000")
            linkkodewilayah = "?kode_wilayah=" + kode_wilayah;
        linkjenjang = "";
        if (e.value != "semua") {
            if (linkkodewilayah == "") {
                linkjenjang = "?jenjang=" + e.value;
            } else {
                linkjenjang = "&jenjang=" + e.value;
            }
        } else
            linkjenjang = "";
        window.open('<?= base_url('status_laporan_kekerasan') ?>' + linkkodewilayah + linkjenjang, '_self');
    }

    function laporan() {
        window.open("<?= base_url('status_laporan_kekerasan?laporan=dinas') ?>", "_self");
    }
</script>
<?= $this->endSection(); ?>