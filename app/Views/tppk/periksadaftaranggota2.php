<?php
$penugasan = array("", "Ketua", "Anggota");
$jabatan = array("Ketua", "Anggota 1", "Anggota 2", "Anggota 3", "Anggota 4", "Anggota 5", "Anggota 6", "Anggota 7", "Anggota 8");
$instansiid = session()->get('jenis_instansi_id');
$txtstatus = array("Belum di Approval", "<span style='color:red'>Tidak Sesuai</span>", "<span style='color:green'>Sesuai</span>");
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

    @media screen and (min-width: 768px) {
        .kontenaproval {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }

        .kontenkiri,
        .kontenkanan {
            width: 50%;
            padding: 5px;
        }
    }

    @media screen and (max-width: 767px) {
        .kontenaproval {
            display: flex;
            flex-direction: column;
        }

        .kontenkiri,
        .kontenkanan {
            width: 100%;
        }
    }
</style>

<?= $this->endSection(); ?>

<?= $this->section('konten') ?>
<div class="content-wrap">

    <div style="float:right"><button onclick="return kembali();">Kembali</button>
    </div>
    <div class="judulkiri">
        <b>Satuan Tugas (Satgas)</b>
        <h3><?= $namaprovinsi ?></h3>
        <?php if ($level == 2) : ?>
            <h3><?= (substr($namakota, 0, 3) == "Kab") ? "Kabupaten" : "Kota" ?> <?= substr($namakota, 4) ?></h3>
        <?php endif ?>
    </div>

    <!-- <br>
    <table class="tabelinfo">
        <tr>
            <td>Jumlah Kab/Kota</td>
            <td>:</td>
            <td><?php //echo $jumlah_kab 
                ?></td>
        </tr>
    </table> -->

    <div class="kontenaproval">
        <div class="kontenkiri">
            <div style="margin:20px auto 10px;font-size:16px;">ANGGOTA</div>

            <table class="table table-striped my-custom-table" id="example">
                <thead>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Status Keanggotaan</th>
                    <th>Asal Instansi</th>
                    <?php if ($instansiid == 1) : ?>
                        <th class='none'>Nomor Telepon</th>
                    <?php endif ?>
                </thead>

                <tbody>
                    <?php
                    $nomor = 1;
                    foreach ($daftaranggota as $row) : ?>
                        <tr>
                            <td><?= $nomor++ ?></td>
                            <td><?= $row['namaanggota'] ?></td>
                            <td><?= ($row['anggotake'] == 0) ? "Ketua" : "Anggota " . $row['anggotake'] ?></td>
                            <td><?= $row['instansi'] ?></td>
                            <?php if ($instansiid == 1) : ?>
                                <td><?= $row['telepon'] ?></td>
                            <?php endif ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="kontenkanan">
            <div style="margin:20px auto 10px;font-size:16px;">SK</div>
            <?php if ($filepdf == "-") { ?>
                File tidak ditemukan
            <?php } else { ?>
                <iframe src="<?= base_url() . 'public/uploads/' . $filepdf ?>" width="100%" height="500"></iframe>
            <?php } ?>

        </div>
    </div>
    <div style="max-width:1000px;margin:auto;margin-top:20px;line-height:16px;">
        <table class="tabelinfo">
            <tr>
                <td>Nomor SK</td>
                <td>:</td>
                <td><?= $linknomorsk ?></< /td>
            </tr>
            <tr>
                <td>Tanggal SK</td>
                <td>:</td>
                <td><?= ($nomor > 1) ? substr($datask['tanggal_sk'], 8, 2) . "-" . substr($datask['tanggal_sk'], 5, 2) . "-" . substr($datask['tanggal_sk'], 0, 4) : "-" ?></td>
            </tr>
            <tr>
                <td>Tanggal Berakhir SK</td>
                <td>:</td>
                <td><?= ($nomor > 1) ?
                        $tanggal_tambah = date("d-m-Y", strtotime($datask['tanggal_sk'] . " +6 months")) : "-" ?></td>
            </tr>
            <tr>
                <td>Status SK</td>
                <td>:</td>
                <td><?= ($nomor > 1) ?
                        $txtstatus[intval($datask['status_sk'])] : "-" ?></td>
            </tr>
        </table>
        <br>
        <table class="tabelinfo">
            <tr>
                <td>Operator Dinas</td>
                <td>:</td>
                <td><?= $datask['nama_operator'] ?></td>
                <!-- <td><a target="_blank" href="https://sdm.data.kemdikbud.go.id/instansi/view?id='0'">-</a></td> -->
            </tr>
        </table>

        <div style="color: gray;font-size:10px;"><i>[Update
                <?= ($nomor > 1) ? date("d-m-Y H:i:s", strtotime($datask['modified_date'])) : "-" ?>]</i>
            <?php if ($instansiid == 1) : ?>
                <div style="float:right">
                    <button id="tbsesuai" class="tbmerah" onclick="return sksesuai(1);">SK Tidak Sesuai</button>
                    <button id="tbtaksesuai" class="tbijo" onclick="return sksesuai(2);">SK Sesuai</button>
                    <div id="dinputcatatan" style="display: none;">
                        <br>
                        <span style="color:red; font-size:14px">Tidak sesuai karena: </span><br>
                        <textarea style="font-size: 14px;" name="catatansk" id="catatansk" cols="30" rows="10"></textarea>
                        <br>
                        <button class="tbmerah" onclick="return batalin();">Batal</button>
                        <button class="tbijo" onclick="return tolak();">Submit</button>
                    </div>
                </div>
            <?php endif ?>
        </div>

    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scriptfooter') ?>
<script>
    var w = window.innerWidth;
    var h = window.innerHeight;
    var konfirmtolak = 0;

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
        responsive: true,
    });

    function editanggota() {
        window.open("<?= base_url() ?>inputdata/edit", "_self");
    }

    function batalin() {
        $('#tbsesuai').show();
        $('#tbtaksesuai').show();
        $('#dinputcatatan').hide();
    }

    function tolak() {
        $.ajax({
            type: 'GET',
            data: {
                kodewilayah: '<?= $kodewilayah ?>',
                opsi: 1,
            },
            dataType: 'text',
            cache: false,
            url: '<?php echo base_url() ?>inputdata/sksesuai',
            success: function(result) {
                window.open("<?= base_url() ?>inputdata/daftar_skbaru", "_self");
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
                    kodewilayah: '<?= $kodewilayah ?>',
                    opsi: opsinya,
                },
                dataType: 'text',
                cache: false,
                url: '<?php echo base_url() ?>inputdata/sksesuai',
                success: function(result) {
                    window.open("<?= base_url() ?>inputdata/daftar_skbaru", "_self");
                    return false;
                }
            });
        }
    }

    function kembali() {
        var previousPageURL = document.referrer;
        cekback = previousPageURL;
        if (cekback.slice(-14) == "inputdata/edit")
            window.open("<?= base_url() ?>home", "_self");
        else
            history.back()
    }
</script>
<?= $this->endSection(); ?>