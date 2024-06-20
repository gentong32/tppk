<?php
$penugasan = array("", "Ketua", "Anggota");
$jabatan = array("", "Wakil Kepala Bidang Kesiswaan", "Guru", "Guru Bimbingan Konseling", "Komite Sekolah");
$txtstatus = array("Belum di Approval", "<span style='color:red'>Tidak Sesuai</span>", "<span style='color:green'>Sesuai</span>");

$userlogin = session()->get('loggedIn');
$jenisinstansiid = session()->get('jenis_instansi_id');
$npsnuser = session()->get('npsn_user');

?>

<?= $this->extend('layout/default') ?>
<?= $this->section('header') ?>
<!-- <link rel="stylesheet" href="<?= base_url() ?>css/my_tables.css" /> -->
<link rel="stylesheet" href="<?= base_url() ?>css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="<?= base_url() ?>css/responsive.dataTables.min.css" />
<script src="<?= base_url() ?>js/jquery-3.5.1.js"></script>
<script src="<?= base_url() ?>js/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>js/dataTables.responsive.min.js"></script>

<style>
    /* Gaya Tabel */
    .my-custom-table {
        border-collapse: collapse;
        width: 100%;
        background-color: #f8f8f8;
        border: 1px solid #ddd;
    }

    .my-custom-table th,
    .my-custom-table td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .my-custom-table tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    /* Gaya Header Tabel */
    .my-custom-table th {
        background-color: #5a96c7;
        color: white;
    }

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
        <b>Tim Pencegahan dan Penanganan Kekerasan (TPPK)</b>
        <h3><?= $namasekolah['nama'] ?></h3>
    </div>
    <table class="tabelinfo">
        <tr>
            <td>NPSN</td>
            <td>:</td>
            <td><?= $namasekolah['npsn'] ?></td>
        </tr>
        <tr>
            <td>Provinsi</td>
            <td>:</td>
            <td><?= substr($provinsi, 5) ?></td>
        </tr>
        <tr>
            <td><?= (substr($kota, 0, 3) == "Kab") ? "Kabupaten" : "Kota" ?></td>
            <td>:</td>
            <td><?= substr($kota, 4) ?></td>
        </tr>
        <tr>
            <td>Kecamatan</td>
            <td>:</td>
            <td><?= substr($kecamatan, 4) ?></td>
        </tr>
    </table>
    <br>
    <table class="tabelinfo">
        <tr>
            <td>Nama Kepala Sekolah</td>
            <td>:</td>
            <td><?= $kepalasekolah ?></td>
        </tr>
        <tr>
            <td>Jumlah PTK</td>
            <td>:</td>
            <td><?= $jumlah_ptk ?></td>
        </tr>
        <tr>
            <td>Jumlah Peserta Didik</td>
            <td>:</td>
            <td><?= $jumlah_pd ?></td>
        </tr>
    </table>


    <div style="margin:20px auto 10px;font-size:16px;">ANGGOTA</div>

    <table class="table table-striped my-custom-table" id="example">
        <thead>
            <th>No</th>
            <th>Nama</th>
            <th>Status Keanggotaan</th>
            <th>Unsur Keanggotaan</th>
            <th>Asal Lembaga</th>
        </thead>

        <tbody>
            <?php
            $nomor = 1;
            foreach ($daftaranggota as $row) : ?>
                <tr>
                    <td><?= $nomor++ ?></td>
                    <td><?= $row['nm_ang'] ?></td>
                    <td><?= $row['peran_ang'] ?></td>
                    <td><?= ($row['jenis_ptk'] == NULL) ? $row['nama_unsur2'] : $row['jenis_ptk'] ?></td>
                    <td><?= $row['nama_sekolah'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div style="max-width:1000px;margin:auto;margin-top:20px;line-height:16px;">
        <table class="tabelinfo">
            <tr>
                <td>Nomor SK</td>
                <td>:</td>
                <td><?= $linknomorsk ?></td>
            </tr>
            <tr>
                <td>Tanggal SK</td>
                <td>:</td>
                <td><?= ($nomor > 1) ? substr($row['tmt_sk_tugas'], 8, 2) . "-" . substr($row['tmt_sk_tugas'], 5, 2) . "-" . substr($row['tmt_sk_tugas'], 0, 4) : "-" ?></td>
            </tr>
            <tr>
                <td>Tanggal Berakhir SK</td>
                <td>:</td>
                <td><?= ($nomor > 1) ? substr($row['tst_sk_tugas'], 8, 2) . "-" . substr($row['tst_sk_tugas'], 5, 2) . "-" . substr($row['tst_sk_tugas'], 0, 4) : "-" ?></td>
            </tr>
            <tr>
                <td>Status SK</td>
                <td>:</td>
                <td><?= ($nomor > 1) ?
                        $txtstatus[intval($datask['status_sk'])] : "-" ?></td>
            </tr>

        </table>
        <br>
        <?php if ($userlogin && $jenisinstansiid == 5 && $npsnuser == $npsn && $sk_tugas != "-" && $tgl_sk != "-") { ?>
            <form action="<?= base_url() ?>inputdata/upload_sk" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="npsn" value="<?= $npsn ?>">
                <input type="hidden" name="sk_tugas" value="<?= $sk_tugas ?>">
                <input type="hidden" name="tanggal_sk" value="<?= $tgl_sk ?>">
                <div style="border:1px solid green;padding:10px;max-width:400px;background-color:honeydew;">
                    <label for="inputfilesk">
                        <h3>INPUT FILE SK:</h3>
                    </label>
                    <div id="inputfilesk" class="form-group">
                        <input type="file" id="file_sk" name="file_sk" accept=".jpg,.jpeg,.png,.pdf">
                    </div>
                </div>
                <div style="margin-top: 5px;">
                    <!-- <input class="btn_ijo" onclick="return cekinput();" type="submit" value="Unggah File SK"> -->
                    <button class="btn_ijo">Unggah</button>
                    <br>Mohon maaf. Karena sedang ada kendala teknis, untuk sementara waktu fungsi Upload dinonaktifkan.
                </div>

            </form>
            <br>
        <?php } ?>
        <table class="tabelinfo">
            <tr>
                <td>Operator Sekolah</td>
                <td>:</td>
                <td><a target="_blank" href="https://sdm.data.kemdikbud.go.id/instansi/view?id=<?= $instansiid ?>"><?= $operator[0]->nama_operator ?></a></td>
            </tr>
        </table>

        <?php if ($nomor > 1 && ($jenisinstansiid == 2 || $jenisinstansiid == 3)) : ?>
            <div style="float:right;margin-bottom: 15px;">
                <button class="tbmerah" onclick="return sksesuai(1);">SK Tidak Sesuai</button>
                <button class="tbijo" onclick="return sksesuai(2);">SK Sesuai</button>
            </div>
        <?php endif ?>
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

    $('#example').DataTable({
        scrollX: teru,
        searching: false,
        paging: false,
        info: false,
        processing: true,
    });

    function cekinput() {
        var valsk = document.getElementById("file_sk").value;
        fileExt = valsk.split('.').pop();

        if (valsk == "") {
            alert("Pilih file dahulu!");
            return false;
        } else {
            return true;
        }
    }

    function sksesuai(opsinya) {
        $.ajax({
            type: 'GET',
            data: {
                npsn: '<?= $namasekolah['npsn'] ?>',
                opsi: opsinya,
            },
            dataType: 'text',
            cache: false,
            url: '<?php echo base_url() ?>inputdata/sktppksesuai',
            success: function(result) {
                window.open("<?= base_url() ?>inputdata/daftar_skbaru", "_self");
                return false;
            }
        });
    }
</script>
<?= $this->endSection(); ?>