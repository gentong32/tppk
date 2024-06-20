<?= $this->extend('layout/default') ?>

<?= $this->section('header') ?>
<style>
    .statuskontainer {
        height: 200px;
        margin-top: 50px;
    }

    .statususer {
        text-align: center;
        margin: auto;
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 30px;
    }

    .keterangan {
        text-align: center;
        margin: auto;
        margin-top: 30px;
        font-size: 16px;
        color: red;
    }
</style>
<link rel="stylesheet" href="<?= base_url() ?>css/myregister.css?v1.1">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<?= $this->endSection() ?>


<?= $this->section('konten') ?>
<div class="register-container">
    <h2>Status Approval Calon Operator Satgas</h2>
    <div class="statuskontainer">
        <div class="statususer">
            <?= $txtstatus ?>
        </div>
        <div class="keterangan">
            <?= $keterangan ?>
        </div>
    </div>
</div>



<?= $this->endSection(); ?>