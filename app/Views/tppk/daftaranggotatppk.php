<?php
$csrfToken = csrf_hash();
?>

<?= $this->extend('layout/default') ?>
<?= $this->section('header') ?>
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

    #updateButton {
        display: none;
        margin-top: 10px;
        float: right;
        margin-bottom: 10px;
    }
</style>

<?= $this->endSection(); ?>

<?= $this->section('konten') ?>
<div class="content-wrap">

    <div class="judulkiri">
        <b>Tim Pencegahan dan Penanganan Kekerasan (TPPK)</b>
        <h3><?= $namasekolah['nama'] ?></h3>
    </div>
    <div style="margin:20px auto 10px;font-size:16px;">Silakan pilih satu anggota yang bisa input Pelaporan (khusus untuk PTK)</div>
    <table class="table table-striped my-custom-table" id="example">
        <thead>
            <th>No</th>
            <th>Nama</th>
            <th>Status Keanggotaan</th>
            <th>Unsur Keanggotaan</th>
            <th>Status</th>
        </thead>

        <tbody>
            <?php
            $nomor = 1;
            $udahketua = 0;
            foreach ($daftaranggota as $row) :
                $cekstatus = "";
                if ($row['peran_ang'] == "Ketua" && $udahketua == 0) {
                    $cekstatus = "*";
                    $udahketua = 1;
                } else if ($row['peran_ang'] == "Koordinator" && $udahketua == 0) {
                    $cekstatus = "*";
                    $udahketua = 1;
                } else if ($row['ptk_id'] != null) {
                    $selected = "";
                    if ($row['ptk_id'] == $row['ptk_id_anggota_1'])
                        $selected = "checked";
                    $cekstatus = "<input " . $selected . " type='radio' name='selected_member' value='" . $row['ptk_id'] . "'>";
                }
            ?>
                <tr>
                    <td><?= $nomor++ ?></td>
                    <td><?= $row['nm_ang'] ?></td>
                    <td><?= $row['peran_ang'] ?></td>
                    <td><?= ($row['jenis_ptk'] == NULL) ? $row['nama_unsur2'] : $row['jenis_ptk'] ?></td>
                    <td><?= $cekstatus ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <button class="btn_ijo" id="updateButton" style="display: none;">Update</button>

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
        columnDefs: [{
                responsivePriority: 1,
                targets: 0
            },
            {
                responsivePriority: 2,
                targets: -1
            }
        ],
    });

    document.addEventListener("DOMContentLoaded", function() {
        const radioButtons = document.querySelectorAll('input[name="selected_member"]');
        const updateButton = document.getElementById('updateButton');

        // Fungsi untuk menampilkan atau menyembunyikan tombol "Update"
        function toggleUpdateButton() {
            let isSelected = false;
            radioButtons.forEach(function(radioButton) {
                if (radioButton.checked) {
                    isSelected = true;
                }
            });
            updateButton.style.display = isSelected ? 'block' : 'none';
            updateButton.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }

        // Mendeteksi perubahan pada radio button
        radioButtons.forEach(function(radioButton) {
            radioButton.addEventListener('change', toggleUpdateButton);
        });
    });

    $(document).ready(function() {
        $('#updateButton').click(function() {
            var selectedValue = $('input[name="selected_member"]:checked').val();
            $.ajax({
                url: '<?= base_url() ?>inputdata/simpan_login_anggota',
                method: 'POST',
                data: {
                    selectedValue: selectedValue,
                    sktugas: '<?= $daftaranggota[0]['sk_tugas'] ?>',
                    csrf_test_name: '<?= $csrfToken ?>',
                },
                success: function(response) {
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error('Terjadi kesalahan:', error);
                }
            });
        });
    });
</script>
<?= $this->endSection(); ?>