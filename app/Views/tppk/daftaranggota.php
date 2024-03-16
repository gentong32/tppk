<?php
$penugasan = array("", "Ketua", "Anggota");
$jabatan = array("", "Wakil Kepala Bidang Kesiswaan", "Guru", "Guru Bimbingan Konseling", "Komite Sekolah");
$txtstatus = array("SK dalam proses persetujuan", "<span style='color:red'>Tidak Sesuai</span>", "<span style='color:green'>Sesuai</span>");

$userlogin = session()->get('loggedIn');
$jenisinstansiid = session()->get('jenis_instansi_id');
$npsnuser = session()->get('npsn_user');

?>

<?= $this->extend('layout/default') ?>
<?= $this->section('header') ?>
<!-- <link rel="stylesheet" href="<?= base_url() ?>css/my_tables.css" /> -->
<link rel="stylesheet" href="<?= base_url() ?>css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="<?= base_url() ?>css/responsive2.dataTables.min.css" />
<script src="<?= base_url() ?>js/jquery-3.5.1.js"></script>
<script src="<?= base_url() ?>js/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>js/dataTables.responsive.min.js"></script>

<style>
    /* Gaya Tabel */
    .my-custom-table {
        border-collapse: collapse;
        width: 100% !important;
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

    .alert {
        color: red;
        font-size: 16px;
        padding: 5px;
    }

    .kadaluwarsa {
        color: red;
    }

    .kadaluwarsa a {
        color: red;
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

    .content-wrap {
        max-width: 100% !important;
        padding-left: 30px;
        padding-right: 30px;
    }

    .table {
        max-width: 100% !important;
    }
</style>

<?= $this->endSection(); ?>

<?= $this->section('konten') ?>
<div class="content-wrap">
    <?php if ($tombolback == 1) { ?>
        <div style="float:right"><button onclick="history.back()">Kembali</button>
        </div>
    <?php } ?>
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

    <?php
    if (intval($datask['status_sk']) == 10) { ?>
        <br>
        <div style='color: orange'>
            <h3>SK dalam proses persetujuan</h3>
        </div>
    <?php } else if (intval($datask['status_sk']) == 11) { ?>
        <br>
        <div style='color: red'>
            <h3>SK belum sesuai</h3>
        </div>
    <?php } ?>


    <?php if ($daftaranggota && ($daftar_residu['residu'] == 1)) { ?>
        <br>
        <div style='color: red'>
            <div style="border: #d0535f solid; border-radius: 5px; padding: 5px;max-width:480px;">
                <h3>Tidak valid:</h3>
                <table class="tabelinfo">
                    <?php if ($daftar_residu['residu_kepsek'] == 1) { ?>
                        <tr>
                            <td>- Kepala Sekolah sebagai anggota</td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php } ?>
                    <?php if ($daftar_residu['residu_ketua_non_ptk'] == 1) { ?>
                        <tr>
                            <td>"Ketua" atau "Koordinator" TPPK tidak mengisi kolom "Guru Bila Guru" di Aplikasi Dapodik </td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php } ?>
                    <?php if ($daftar_residu['residu_guru'] == 1) { ?>
                        <tr>
                            <td>- Tidak ada anggota dari Guru</td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php } ?>
                    <?php if ($daftar_residu['residu_komite'] == 1) { ?>
                        <tr>
                            <td>- Tidak ada anggota dari Komite</td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php } ?>
                    <?php if ($daftar_residu['residu_siswa'] == 1) { ?>
                        <tr>
                            <td>- Siswa sebagai anggota</td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php } ?>
                    <?php if ($daftar_residu['residu_ganjil'] == 1) { ?>
                        <tr>
                            <td>- Jumlah anggota tidak ganjil</td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php } ?>
                    <?php if ($daftar_residu['residu_upload_sk'] == 1) { ?>
                        <tr>
                            <td>- Belum unggah SK Kepanitiaan</td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php } ?>
                    <?php if ($daftar_residu['residu_sk_kadaluarsa'] == 1) { ?>
                        <tr>
                            <td>- SK sudah kadaluwarsa</td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php } ?>
                    <?php if ($daftar_residu['residu_sk_lebih_dari_2_tahun'] == 1) { ?>
                        <tr>
                            <td>- SK lebih dari 2 tahun</td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php } ?>
                    <?php if (intval($datask['status_sk']) == 0 && $daftar_residu['residu_upload_sk'] == 0) { ?>
                        <!-- <tr>
                        <td>- SK dalam proses persetujuan</td>
                        <td></td>
                        <td></td>
                    </tr> -->
                    <?php } ?>
                    <?php if (intval($datask['status_sk']) == 1 && $daftar_residu['residu_upload_sk'] == 0) { ?>
                        <tr>
                            <td>- SK belum sesuai</td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
            <div style="margin-left:20px;margin-top:5px;max-width:480px;">
                <ul>
                    <li><i>Jika sudah melakukan pemutakhiran pada Dapodik, mohon ditunggu 1x24 jam untuk melihat perubahan pada halaman ini.</i></li>
                </ul>
            </div>
        </div>
    <?php } else if (!$daftaranggota) { ?>
        <br>
        <div style='color: red'>
            <div style="border: #d0535f solid; border-radius: 5px; padding: 5px;max-width:650px;">
                <h3>Tidak valid:</h3>
                <table class="tabelinfo">
                    <tr>
                        <td>Silakan input data anggota kepanitiaan TPPK terlebih dahulu melalui aplikasi Dapodik. <br>Setelah itu silakan unggah SK disini.</td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>

    <?php } else if ($daftaranggota && $daftar_residu['residu'] == 0 && intval($datask['status_sk']) == 2) { ?>
        <br>
        <div style='color: green'>
            <h3>Status: valid</h3>
        </div>
    <?php } ?>

    <?php if ($approver) {
        echo '<div class="kontenaproval">
        <div class="kontenkiri">';
    } ?>

    <div style="margin:20px auto 10px;font-size:16px;">ANGGOTA</div>
    <table class="table table-striped my-custom-table" id="example">
        <thead>
            <th>No</th>
            <th>Nama</th>
            <th>Status Keanggotaan</th>
            <th>Unsur Keanggotaan</th>
            <th>Asal Lembaga</th>
            <?php if ($jenisinstansiid == 1) : ?>
                <th>Telp</th>
            <?php endif ?>
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
                    <?php if ($jenisinstansiid == 1) : ?>
                        <td><?= $row['no_kontak'] ?></td>
                    <?php endif ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php if ($approver) {
        echo '</div>';
    } ?>

    <?php if ($approver) { ?>
        <div class="kontenkanan">
            <div style="margin:20px auto 10px;font-size:16px;">SK</div>
            <?php if ($filepdf == "-") { ?>
                File tidak ditemukan
            <?php } else { ?>
                <iframe src="<?= base_url() . 'public/uploads/' . $filepdf ?>" width="100%" height="500"></iframe>
            <?php } ?>
        </div>
</div>
<?php } ?>

<div class="table" style="line-height:16px;">
    <table class="tabelinfo">
        <tr>
            <td>Nomor SK</td>
            <td>:</td>
            <td class="<?= ($kadaluwarsa || $lebih2tahun) ? 'kadaluwarsa' : '' ?>"><?= $linknomorsk ?></td>
        </tr>
        <tr>
            <td>Tanggal SK</td>
            <td>:</td>
            <td><?= ($nomor > 1) ? substr($row['tmt_sk_tugas'], 8, 2) . "-" . substr($row['tmt_sk_tugas'], 5, 2) . "-" . substr($row['tmt_sk_tugas'], 0, 4) : "-" ?></td>
        </tr>
        <tr>
            <td>Tanggal Berakhir SK</td>
            <td>:</td>
            <td class="<?= ($kadaluwarsa || $lebih2tahun) ? 'kadaluwarsa' : '' ?>"><?= ($nomor > 1) ? substr($tanggalberakhir, 8, 2) . "-" . substr($tanggalberakhir, 5, 2) . "-" . substr($tanggalberakhir, 0, 4) : "-" ?></td>
        </tr>


    </table>
    <br>
    <?php if ($userlogin && $jenisinstansiid == 5 && $npsnuser == $npsn && $sk_tugas != "-" && $tgl_sk != "-") {
        $tampil = "none";
        if ($kadaluwarsa) {
            $tampil = "block";
        } else { ?>
            <button id="tb_update" class="btn_ijo" onclick="tampilkan_inputan()">Update File SK</button><br>
        <?php }
        ?>
        <form id="f_input_sk" style="display:<?= $tampil ?>" action="<?= base_url() ?>inputdata/upload_sk" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <input type="hidden" name="npsn" value="<?= $npsn ?>">
            <input type="hidden" name="sk_tugas" value="<?= $sk_tugas ?>">
            <input type="hidden" name="tanggal_sk" value="<?= $tgl_sk ?>">
            <div style="border:1px solid green;padding:10px;max-width:400px;background-color:honeydew;">
                <label for="inputfilesk">
                    <h3>INPUT FILE SK (file pdf max. 750KB):</h3>
                </label>
                <div id="inputfilesk" class="form-group">
                    <input type="file" id="file_sk" name="file_sk" accept=".pdf" maxFileSize="768000">
                </div>
            </div>
            <div style="margin-top: 5px;">
                <input class="btn_ijo" onclick="return cekinput();" type="submit" value="Unggah File SK">
            </div>

        </form>
        <br>
    <?php } ?>
    <?php
    if (session('error')) :
    ?>
        <div id="gagalunggah" class="alert">
            <?= session('error') ?>
        </div>
    <?php
    endif ?>
    <table class="tabelinfo">
        <tr>
            <td>Operator Sekolah</td>
            <td>:</td>
            <td><a target="_blank" href="https://sdm.data.kemdikbud.go.id/instansi/view?id=<?= $instansiid ?>"><?php
                                                                                                                if ($operator[0]->nama_operator == "Hardianto,M.Kom")
                                                                                                                    echo $operator[1]->nama_operator;
                                                                                                                else
                                                                                                                    echo $operator[0]->nama_operator ?></a></td>
        </tr>
    </table>

    <?php if ($approver) { ?>
        <?php if ($nomor > 1 && ($jenisinstansiid == 2 || $jenisinstansiid == 3)) : ?>
            <div style="float:right;margin-bottom: 15px;">
                <button class="tbmerah" onclick="return sksesuai(1);">SK Tidak Sesuai</button>
                <button class="tbijo" onclick="return sksesuai(2);">SK Sesuai</button>
            </div>
        <?php endif ?>
    <?php } ?>
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
        responsive: true,
        // "columnDefs": [{
        //     "visible": false,
        //     "targets": 4
        // }],
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

    function tampilkan_inputan() {
        document.getElementById("f_input_sk").style.display = "block"
        document.getElementById("tb_update").style.display = "none";
        <?php
        if (session('error')) { ?>
            document.getElementById("gagalunggah").style.display = "none";
        <?php } ?>
    }

    <?php if ($approver) { ?>

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
    <?php } ?>
</script>
<?= $this->endSection(); ?>