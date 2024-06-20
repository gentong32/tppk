<?= $this->extend('layout/default') ?>

<?= $this->section('header') ?>
<style>
    .container {
        max-width: 800px;
        background-color: #E1F4DD;
        border: 1px solid black;
        border-radius: 3px;
        padding: 20px;
        font-size: 14px;
        line-height: 28px;
    }

    .error-message {
        color: red;
        margin-bottom: 10px;
    }
</style>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<?= $this->endSection() ?>


<?= $this->section('konten') ?>
<div class="container">
    <h2>Unggah File SK</h2>

    <?php if (session()->getFlashdata('message')) : ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('message') ?>
        </div>
    <?php endif; ?>

    Halo, <?= session()->get("nama") ?>.<br>
    Silakan unggah file SK penugasan terlebih dahulu. Setelah itu akan dilakukan approval oleh Puspeka.

    <form id="uploadForm" action="<?= base_url('unggah_sk_op_satgas') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <label for="file">Pilih File:</label>
        <input type="file" id="file" name="file" accept=".pdf" required>
        <div class="error-message" id="error-message">&nbsp;<?= session('error') ?: ''; ?></div>
        <!-- <button type="submit">Unggah</button> -->
    </form>

</div>

<script>
    document.getElementById('uploadForm').addEventListener('submit', function(event) {
        var fileInput = document.getElementById('file');
        var file = fileInput.files[0];
        var errorMessage = document.getElementById('error-message');

        if (file) {
            var fileType = file.type;
            var fileSize = file.size;

            errorMessage.innerHTML = '&nbsp;';

            if (fileType !== 'application/pdf') {
                errorMessage.innerHTML = 'Hanya file PDF saja.';
                event.preventDefault();
                return false;
            }

            if (fileSize > 700 * 1024) {
                errorMessage.innerHTML = 'Ukuran file maksimal 700KB.';
                event.preventDefault();
                return false;
            }
        }
    });

    document.getElementById('file').addEventListener('change', function() {
        var errorMessage = document.getElementById('error-message');
        errorMessage.innerHTML = '&nbsp;';
    });
</script>

<?= $this->endSection(); ?>