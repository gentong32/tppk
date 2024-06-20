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

    .kadaluwarsa {
        color: red;
    }

    .kadaluwarsa a {
        color: red;
    }
</style>

<?= $this->endSection(); ?>

<?= $this->section('konten') ?>
<div class="content-wrap">

    <div class="judulkiri">
        <b>Satuan Tugas (Satgas)</b>
        <h3><?= $namaprovinsi ?></h3>
        <?php if ($level == 2) : ?>
            <h3><?= (substr($namakota, 0, 3) == "Kab") ? "Kabupaten" : "Kota" ?> <?= substr($namakota, 4) ?></h3>
        <?php endif ?>
    </div>

    <?php if ($daftaranggota && $sudah_upload == false) { ?>
        <br>
        <div style='color: red'>
            <div style="border: #d0535f solid; border-radius: 5px; padding: 5px;max-width:480px;">
                <h3>Tidak valid:</h3>
                <table class="tabelinfo">
                    <tr>
                        <td>File SK belum berhasil diunggah.</td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>
    <?php } ?>


    <div style="margin:20px auto 10px;font-size:16px;">ANGGOTA</div>

    <table class="table table-striped my-custom-table" id="example">
        <thead>
            <th>No</th>
            <th>Nama</th>
            <th>Status Keanggotaan</th>
            <th>Asal Instansi</th>
            <th>Telp</th>
            <th>Pilih Admin</th>
        </thead>

        <tbody>
            <?php
            $nomor = 1;
            $ketua_email = null;
            $sk_id = null;
            $kode_wilayah = null;

            foreach ($daftaranggota as $row) {
                if ($row['anggotake'] == 0) {
                    $ketua_email = $row['email'];
                    $sk_id = $row['sk_id'];
                    $kode_wilayah = $row['kode_wilayah'];
                    break;
                }
            }
            foreach ($daftaranggota as $row) : ?>
                <tr>
                    <td><?= $nomor++ ?></td>
                    <td><?= $row['namaanggota'] ?></td>
                    <td><?= ($row['anggotake'] == 0) ? "Ketua" : "Anggota " . $row['anggotake'] ?></td>
                    <td><?= $row['instansi'] ?></td>
                    <td><?= $row['telepon'] ?></td>
                    <td style="text-align: center;">
                        <?php if ($row['instansi'] == "Dinas Pendidikan" && $row['email'] != $ketua_email) : ?>
                            <input type="radio" name="operator_satgas" value="<?= $row['email'] ?>" data-id="<?= $row['satgas_id'] ?>" <?= ($row['operator_satgas'] == 1) ? 'checked' : '' ?>>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div style="float: right; margin-top:10px;">
        <button id="updateButton" style="display:none;">Update</button>
    </div>
    <br>
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
                <td class="<?= ($kadaluwarsa) ? 'kadaluwarsa' : '' ?>"><?= ($nomor > 1) ?
                                                                            $tanggal_tambah = date("d-m-Y", strtotime($datask['tanggal_sk'] . " +4 years")) : "-" ?></td>
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
                <td><?= ($nomor > 1) ? $datask['nama_operator'] : "" ?></td>
                <!-- <td><a target="_blank" href="https://sdm.data.kemdikbud.go.id/instansi/view?id='0'">-</a></td> -->
            </tr>
        </table>

    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scriptfooter') ?>
<script>
    var w = window.innerWidth;
    var h = window.innerHeight;
    var csrf = "<?= csrf_hash() ?>";

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

    const radioButtons = document.querySelectorAll('input[name="operator_satgas"]');
    const updateButton = document.getElementById('updateButton');

    radioButtons.forEach(radio => {
        radio.addEventListener('change', function() {
            updateButton.style.display = 'block';
        });
    });

    updateButton.addEventListener('click', function() {
        const selectedRadio = document.querySelector('input[name="operator_satgas"]:checked');
        if (selectedRadio) {
            const selectedEmail = selectedRadio.value;
            const selectedId = selectedRadio.getAttribute('data-id');

            fetch('<?= base_url('update_operator_satgas') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrf,
                    },
                    body: JSON.stringify({
                        email_ketua: '<?= $ketua_email ?>',
                        email: selectedEmail,
                        id: selectedId,
                        sk_id: "<?= $sk_id ?>",
                        kode_wilayah: "<?= $kode_wilayah ?>",
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    } else {
                        alert('Terjadi kesalahan');
                    }
                    csrf = data.csrf;
                })
                .catch(error => console.error('Error:', error));
        }
    });
</script>
<?= $this->endSection(); ?>