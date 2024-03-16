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

    td:nth-child(n+1):nth-child(-n+7) {
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
    <div class="judul">DAFTAR LAPORAN KEKERASAN <?= strtoupper($wilayah2) ?></div>
    <?php if ($kode_wilayah != '000000' && $area) {
        if ($wilayah2 == "") { ?>
            <a href="<?= base_url('status_laporan_kekerasan') ?>">Indonesia</a> >> <?= substr($wilayah1, 5) ?>
        <?php } else { ?>
            <a href="<?= base_url('status_laporan_kekerasan') ?>">Indonesia</a> >> <a href="<?= base_url('status_laporan_kekerasan?kode_wilayah=') . substr($kode_wilayah, 0, 2) . '0000' ?>"><?= substr($wilayah1, 5) ?></a> >> <?= substr($wilayah2, 5) ?>
        <?php }
        ?>
    <?php } ?>

    <div class="informasi" style="margin-top: 15px;">
        <button class="btn_ijo" onclick="inputform();">INPUT LAPORAN</button>
        <div class="informasi">
            <table class="table table-striped" id="example">
                <thead>
                    <th width="10px">No</th>
                    <th width="190px">Nomor Register</th>
                    <th>Tanggal Kejadian</th>
                    <th>Tanggal Penerimaan Laporan</th>
                    <!-- <th>Tanggal Input/Entry</th> -->
                    <th>Jumlah Korban</th>
                    <th>Jumlah Pelaku/Terlapor</th>
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
            var data = [];
            <?php
            $nomor = 0;
            foreach ($rekap_laporan as $value) {
                $nomor++;
            ?>
                data.push([<?= $nomor ?>, "<a href = \"<?= base_url() . 'inputdata/view/' . $value['kasus_id'] ?>\" target = \"_blank\"> <?= $value['nomor_register'] ?> </a>", "<?= namabulan_panjang($value['tanggal_kejadian']) ?>", "<?= namabulan_panjang($value['tanggal_pelaporan']) ?>", "<?= $value['jumlah_korban'] ?>", "<?= $value['jumlah_pelaku'] ?>"]);
            <?php }


            ?>



            $('#example').DataTable({
                data: data,
                deferRender: true,
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