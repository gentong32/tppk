<?php
$txtstatus = array("Belum di Approval", "<span style='color:red'>Tidak Sesuai</span>", "<span style='color:green'>Sesuai</span>");
?>

<?= $this->extend('layout/default') ?>
<?= $this->section('header') ?>
<link rel="stylesheet" href="<?= base_url() ?>css/my_tables.css" />
<link rel="stylesheet" href="<?= base_url() ?>css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="<?= base_url() ?>css/responsive.dataTables.min.css" />
<link rel="stylesheet" href="<?= base_url() ?>css/flatpickr.min.css" />
<script src="<?= base_url() ?>js/jquery-3.5.1.js"></script>
<script src="<?= base_url() ?>js/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>js/dataTables.responsive.min.js"></script>
<script src="<?= base_url() ?>js/flatpickr.js"></script>

<style>
    .my-custom-table {
        border-collapse: collapse;
        background-color: #f8f8f8;
        border: 1px solid #ddd;
        font-size: 12px;
    }

    .my-custom-table td {
        text-align: left !important;
        border-bottom: 1px solid #ddd;
        vertical-align: top;
    }

    .my-custom-table tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    .my-custom-table th {
        background-color: #5a96c7;
        color: white;
    }

    .tabel_container {
        margin-top: 10px;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        position: relative;
    }

    .judultengah {
        text-align: center;
        font-size: 14px;
        margin-bottom: 25px;
    }

    .submenu {
        display: flex;
        justify-content: space-between;
    }

    .datepicker {
        margin-bottom: 3px;
    }

    #datepicker {
        padding-left: 5px;
        padding-right: 5px;
        font-size: 14px;
        width: 75px;
        height: 30px;
        margin-right: 3px;
    }

    .content-wrap {
        max-width: 97%;
    }

    .tbatas {
        backface-visibility: hidden;
        position: relative;
        cursor: pointer;
        display: inline-block;
        white-space: nowrap;
        background: #B2D4F9;
        border-radius: 8px;
        margin-bottom: 4px;
        border: 0px solid #246;
        padding: 8px;
        color: black;
        font-size: initial;
        font-family: Helvetica Neue;
        font-style: normal
    }

    .filteraktif {
        background: #C5D7C1 !important;
    }

    .tbatas2 {
        backface-visibility: hidden;
        position: relative;
        cursor: pointer;
        display: inline-block;
        white-space: nowrap;
        background: #F1F5EE;
        border-radius: 8px;
        margin-top: 1px;
        border: 0.5px solid #246;
        padding: 8px;
        color: black;
        font-size: initial;
        font-family: Helvetica Neue;
        font-style: normal
    }

    .tbatas>div {
        color: #999;
        font-size: 10px;
        font-family: Helvetica Neue;
        font-weight: initial;
        font-style: normal;
        text-align: center;
        margin: 0px 0px 0px 0px
    }

    .dropdowns {
        display: flex;
        flex-direction: column;
        gap: 3px;
    }

    .dropdowns select {
        padding: 5px;
        height: 34px;
    }

    .inputs-container {
        border: 1px solid #000;
        padding: 10px;
        display: none;
        position: absolute;
        background: white;
        z-index: 1000;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        gap: 20px;
    }
</style>

<?= $this->endSection(); ?>

<?= $this->section('konten') ?>
<div class="content-wrap">

    <div class="judultengah">
        <h3>Statistik Login User</h3>
        (per <?= ($formattedtanggal != "0") ? $formattedtanggal : " Wilayah" ?>)
    </div>

    <div class="submenu">
        <div class="button_container">
            <button class="tbatas <?= ($asal == 1) ? 'aktif' : '' ?>" onclick="userdinas(1)">Operator Sekolah/Dinas</button>
            <button class="tbatas <?= ($asal == 2) ? 'aktif' : '' ?>" onclick="userdinas(2)">Anggota TPPK</button>
            <button class="tbatas <?= ($asal == 3) ? 'aktif' : '' ?>" onclick="userdinas(3)">Admin Satgas</button>
        </div>
        <div class="dfilter">
            <button class="tbatas2 <?= $filteraktif ?>" style="width: 80px;" id="filterButton">Filter</button>
        </div>
    </div>
    <div id="inputsContainer" class="inputs-container">
        <div class="datepicker">
            <label>
                <input <?= ($tanggal != "") ? "checked" : "" ?> type="checkbox" id="includeDate">
                Per tanggal:
            </label>
            <input type="text" id="datepicker" placeholder="Pilih tanggal">
        </div>
        <div class="dropdowns">
            Provinsi: <select id="provinsi">
                <option value="">Pilih Provinsi</option>
                <?php foreach ($dafprovinsi as $data) {
                    $selected = "";
                    if (substr($wilayah, 0, 2) == substr($data['kode_wilayah'], 0, 2))
                        $selected = "selected";
                    echo "<option " . $selected . " value='" . $data['kode_wilayah'] . "'>" . $data['nama'] . "</option>";
                }
                ?>
            </select>
            Kota/Kab: <select id="kota">
                <option value="">---</option>
            </select>
        </div>
        <div class="school">
            <button style="margin-top: 5px;" class="tbatas2 filteraktif" id="openButton">Terapkan</button>
        </div>
    </div>


    <div class="tabel_container">
        <table class="table table-striped my-custom-table" id="example">
            <thead>
                <tr>
                    <th>No</th>
                    <?php if ($tanggal == "") : ?>
                        <th>Tanggal</th>
                    <?php else : ?>
                        <th>Jam</th>
                    <?php endif ?>
                    <th>Nama</th>
                    <th>Instansi</th>
                    <th>Wilayah</th>
                    <th>Provinsi</th>
                    <?php if ($asal > 1) : ?>
                        <th>Jabatan</th>
                        <th>Email</th>
                        <th>No. HP</th>
                    <?php endif ?>
                </tr>
            </thead>

            <tfoot>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <?php if ($asal > 1) : ?>
                        <th></th>
                        <th></th>
                        <th></th>
                    <?php endif ?>
                </tr>

        </table>
    </div>

</div>

<?= $this->endSection(); ?>

<?= $this->section('scriptfooter') ?>
<script>
    var w = window.innerWidth;
    var h = window.innerHeight;
    var provinsiId;
    var kotanya = "<?= $kota ?>";

    if (w < h) {
        teru = true;
    } else {
        teru = false;
    }

    var asal = <?= $asal ?>;
    var tanggal = "<?= $tanggal ?>";

    $(document).ready(function() {
        var data = [];
        provinsiId = document.getElementById('provinsi').value;
        if (provinsiId != "") {
            fetchKota(provinsiId);
        }
        <?php
        $nomor = 0;
        foreach ($rekap as $value) {
            $nomor++;
            if ($tanggal == "")
                $jamlogin = substr($value['login_time'], 8, 2) . "-" . substr($value['login_time'], 5, 2) . "-" . substr($value['login_time'], 0, 4) . " " . substr($value['login_time'], 11, 8);
            else
                $jamlogin = substr($value['login_time'], 11, 8);
            $instansiid = $value['jenis_instansi_id'];
            $instansi = "";
            if ($instansiid == 1)
                $instansi = "Pusat";
            else if ($instansiid == 2)
                $instansi = "Op. Dinas Provinsi";
            else if ($instansiid == 3)
                $instansi = "Op. Dinas Kab/Kota";
            else if ($instansiid == 5 || $instansiid == 99)
                $instansi = $value['sekolah'];
            $jabatannya = $value['jabatan'];
            $jabatan = "";
            if ($jabatannya == "ketua")
                $jabatan = "Ketua";
            else if ($jabatannya == "anggota")
                $jabatan = "Anggota";
            else if ($jabatannya == "anggotalain")
                $jabatan = "Anggota Lain";
        ?>
            <?php if ($asal > 1) : ?>
                data.push([<?= $nomor ?>, '<?= $jamlogin ?>', '<?= $value['nama'] ?>', '<?= $instansi ?>', '<?= $value['wilayah'] ?>', '<?= $value['provinsi'] ?>', '<?= $jabatan ?>', '<?= $value['username'] ?>', '<?= $value['telp'] ?>']);
            <?php else : ?>
                data.push([<?= $nomor ?>, '<?= $jamlogin ?>', '<?= $value['nama'] ?>', '<?= $instansi ?>', '<?= $value['wilayah'] ?>', '<?= $value['provinsi'] ?>']);
            <?php endif ?>
        <?php }
        ?>

        $('#example').DataTable({
            data: data,
            deferRender: true,
            scrollX: teru,
            processing: true,
            responsive: false,
        });

        function fetchKota(provinsiId) {
            $.ajax({
                url: '<?= base_url('get_daf_kota') ?>',
                type: 'GET',
                data: {
                    kodeprov: provinsiId
                },
                dataType: 'json',
                success: function(response) {
                    var kotaDropdown = $('#kota');
                    kotaDropdown.empty();
                    kotaDropdown.append('<option value="">---</option>');
                    response.forEach(function(kota) {
                        var option = document.createElement('option');
                        option.value = kota.kode_wilayah;
                        option.text = kota.nama;

                        if (kota.kode_wilayah.trim() == kotanya.trim()) {
                            option.selected = true;
                        }

                        if (kota.nama !== "") {
                            document.getElementById('kota').appendChild(option);
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Gagal mengambil data kota/kabupaten:', error);
                }
            });
        }

        $('#provinsi').on('change', function() {
            provinsiId = $(this).val();
            if (provinsiId) {
                fetchKota(provinsiId);
            } else {
                $('#kota').empty();
                $('#kota').append('<option value="">---</option>');
            }
        });
    });

    var datepicker = flatpickr('#datepicker', {
        dateFormat: 'Y-m-d',
        defaultDate: tanggal || new Date(),
        onChange: function(selectedDates, dateStr, instance) {
            console.log('Date changed to: ', dateStr);
            $('#includeDate').prop('checked', true);
        }
    });

    if (tanggal != "") {
        datepicker.setDate(tanggal);
    } else {
        datepicker.setDate(new Date());
    }

    document.getElementById('openButton').addEventListener('click', function() {
        var includeDate = $('#includeDate').is(':checked');
        var selectedDate = includeDate ? $('#datepicker').val() : '';
        var selectedProvinsi = $('#provinsi').val();
        var selectedKota = $('#kota').val();

        var params = {
            asal: asal,
            tanggal: selectedDate,
            provinsi: selectedProvinsi.trim(),
            kota: selectedKota.trim(),
        };

        window.open('<?= base_url('statistik_user') ?>?' + $.param(params), '_self');

    });

    function userdinas(idx) {
        var includeDate = $('#includeDate').is(':checked');
        var selectedDate = includeDate ? $('#datepicker').val() : '';
        var selectedProvinsi = $('#provinsi').val();
        var selectedKota = $('#kota').val();

        var params = {
            asal: idx,
            tanggal: selectedDate,
            provinsi: selectedProvinsi.trim(),
            kota: selectedKota.trim(),
        };

        window.open('<?= base_url('statistik_user') ?>?' + $.param(params), '_self');
    }

    document.getElementById('filterButton').addEventListener('click', function() {
        var filterButton = document.getElementById('filterButton');
        var inputsContainer = document.getElementById('inputsContainer');
        var rect = filterButton.getBoundingClientRect();

        inputsContainer.style.display = (inputsContainer.style.display === 'none' || inputsContainer.style.display === '') ? 'block' : 'none';

        inputsContainer.style.top = (rect.bottom + window.scrollY + 5) + 'px';
        // inputsContainer.style.left = (rect.left + window.scrollX) + 'px';
        inputsContainer.style.right = '20px';
    });
</script>
<?= $this->endSection(); ?>