<?= $this->extend('layout/default') ?>

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

    td:nth-child(n+3):nth-child(-n+6) {
        text-align: right;
        padding-right: 20px;
    }
</style>
<script src="<?= base_url() ?>js/jquery-3.5.1.js"></script>
<script src="<?= base_url() ?>js/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>js/dataTables.responsive.min.js"></script>
<?= $this->endSection() ?>

<?= $this->section('konten') ?>

<div class="content-wrap">
    <div class="judul">STATUS LAPORAN KEKERASAN <?= ($wilayah2 == "") ? strtoupper($wilayah1) : strtoupper($wilayah2) ?></div>
    <?php if ($kode_wilayah != '000000') : ?>
        <a href="<?= base_url('status_laporan_kekerasan') ?>">Indonesia</a> >> <?= substr($wilayah1, 5) ?>
    <?php endif ?>

    <div class="informasi" style="margin-top: 15px;">
        <table class="table table-striped" id="example">
            <thead>
                <th width="10px">No</th>
                <th><?= ($kode_wilayah == '000000') ? 'Provinsi' : 'Kota/Kabupaten' ?></th>
                <th>Total Laporan</th>
                <th>Terbukti</th>
                <th>Tidak terbukti</th>
                <th>Dihentikan</th>
            </thead>
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
        var data = [];
        <?php
        $nomor = 0;
        foreach ($rekap_laporan as $value) {
            $nomor++;
            if ($kode_wilayah == "000000") {
                $namawilayah = '<a href = ' . base_url() . 'status_laporan_kekerasan?kode_wilayah=' . $value['kode_wilayah'] . ' target = \'_self\'>' . $value['nama'] . '</a>';
            } else {
                // $namawilayah = $value['nama'];
                $namawilayah = '<a href = ' . base_url() . 'status_laporan_kekerasan?kode_wilayah=' . $value['kode_wilayah'] . ' target = \'_self\'>' . $value['nama'] . '</a>';
            }
        ?>
            data.push([<?= $nomor ?>, "<?= $namawilayah ?>", "<?= $value['Terbukti'] + $value['TidakTerbukti'] + $value['Dihentikan'] ?>", "<?= $value['Terbukti'] ?>", "<?= $value['TidakTerbukti'] ?>", "<?= $value['Dihentikan'] ?>"]);
        <?php }
        ?>

        $('#example').DataTable({
            data: data,
            scrollX: teru,
            processing: true,
            responsive: true,
        });
    });

    function inputform() {
        window.open("<?= base_url('inputdata/pelaporan') ?>", "_self");
    }
</script>
<?= $this->endSection(); ?>