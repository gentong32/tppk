<?= $this->extend('layout/default') ?>
<?= $this->section('header') ?>

<style>
    .tbijo {
        color: #000000;
        background-color: #82e383;
        font-size: 14px;
        border: 1px solid #49e969;
        border-radius: 3px;
        padding: 5px 8px;
        cursor: pointer
    }

    .tbijo:hover {
        color: #49e969;
        background-color: #ffffff;
    }

    .tbmerah {
        color: #000000;
        background-color: #d0535f;
        font-size: 14px;
        border: 1px solid #c14e4e;
        border-radius: 3px;
        padding: 5px 8px;
        cursor: pointer
    }

    .tbmerah:hover {
        color: #c14e4e;
        background-color: #ffffff;
    }
</style>

<?= $this->endSection(); ?>

<?= $this->section('konten') ?>
<div class="content-wrap">

    <div style="float:right"><button onclick="history.back()">Kembali</button>
    </div>
    <div class="judulkiri">
        <b>Data Operator Satgas <?= $dataoperator->nama_wilayah ?></b>
    </div>
    <table class="tabelinfo">
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td><?= $dataoperator->nama ?></td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>:</td>
            <td><?= $dataoperator->nik ?></td>
        </tr>
        <tr>
            <td>Tempat, Tanggal Lahir</td>
            <td>:</td>
            <td><?= $dataoperator->tempat_lahir . ", " . date('d-m-Y', strtotime($dataoperator->tanggal_lahir)) ?></td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td><?= ($dataoperator->jenis_kelamin == "L") ? "Laki-laki" : "Perempuan" ?></td>
        </tr>
        <tr>
            <td>Alamat Rumah</td>
            <td>:</td>
            <td><?= $dataoperator->alamat ?></td>
        </tr>
        <tr>
            <td>No. HP</td>
            <td>:</td>
            <td><?= $dataoperator->telepon ?></td>
        </tr>
        <tr>
            <td>Email</td>
            <td>:</td>
            <td><?= $dataoperator->email ?></td>
        </tr>

    </table>
    <br>
    <iframe src="<?= base_url() . 'public/sk_op_satgas/sk' . strtolower($dataoperator->pengguna_id) . '.pdf' ?>" width="100%" height="500"></iframe>
    <div style="float:left;margin-bottom: 15px;">
        <button id="tbsesuai" class="tbmerah" onclick="return sksesuai(1);">Ditolak</button>
        <button id="tbtaksesuai" class="tbijo" onclick="return sksesuai(2);">Diterima</button>
        <div id="dinputcatatan" style="display: none;">
            <br>
            <span style="color:red; font-size:14px">Ditolak karena: </span><br>
            <textarea style="font-size: 14px;" name="catatansk" id="catatansk" cols="60" rows="4"></textarea>
            <br>
            <button class="tbmerah" onclick="return batalin();">Batal</button>
            <button class="tbijo" onclick="return tolak();">Submit</button>
        </div>
    </div>

</div>

<?= $this->endSection(); ?>

<?= $this->section('scriptfooter') ?>
<script src="<?= base_url() ?>js/jquery-3.5.1.js"></script>
<script>
    var w = window.innerWidth;
    var h = window.innerHeight;

    if (w < h) {
        teru = true;
    } else {
        teru = false;
    }

    var konfirmtolak = 0;

    function batalin() {
        $('#tbsesuai').show();
        $('#tbtaksesuai').show();
        $('#dinputcatatan').hide();
    }

    function tolak() {
        var catatan = $('#catatansk').val();
        $.ajax({
            type: 'GET',
            data: {
                pengguna_id: '<?= $dataoperator->pengguna_id ?>',
                opsi: 1,
                catatan: catatan,
            },
            dataType: 'text',
            cache: false,
            url: '<?php echo base_url() ?>inputdata/operatorsesuai',
            success: function(result) {
                window.open("<?= base_url() ?>inputdata/daftar_skbaru/<?= $op_wil ?>", "_self");
                return false;
            }
        });
    }

    function sksesuai(opsinya) {
        konfirmtolak = 0;
        if (opsinya == 1) {
            $('#tbsesuai').hide();
            $('#tbtaksesuai').hide();
            $('#dinputcatatan').show();
            $('html, body').animate({
                scrollTop: $('#dinputcatatan').offset().top + $('#dinputcatatan').height()
            }, 'slow');
            return false;
        } else {
            $.ajax({
                type: 'GET',
                data: {
                    pengguna_id: '<?= $dataoperator->pengguna_id ?>',
                    opsi: opsinya,
                    catatan: '',
                },
                dataType: 'text',
                cache: false,
                url: '<?php echo base_url() ?>inputdata/operatorsesuai',
                success: function(result) {
                    window.open("<?= base_url() ?>inputdata/daftar_skbaru/<?= $op_wil ?>", "_self");
                    return false;
                }
            });
        }
    }
</script>
<?= $this->endSection(); ?>