<?= $this->extend('layout/default') ?>

<?= $this->section('header') ?>
<style>
    .informasi {
        padding: 20px;
        background-color: #f5f5f5;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    /* CSS untuk judul */
    .judul {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    /* CSS untuk teks informasi */
    .informasi p {
        font-size: 16px;
        line-height: 1.5;
        margin-bottom: 15px;
    }

    .video-container {
        text-align: center;
    }

    .video-container iframe {
        max-width: 800px;
        width: 100%;
        padding-right: 10px;
        height: calc(100vw * 0.5625);
        max-height: calc(800px * 9 / 16);
    }

    /* CSS untuk video iframe */
</style>
<?= $this->endSection() ?>


<?= $this->section('konten') ?>
<div class="content-wrap">
    <br>
    <section class="informasi">
        <div class="judul">WEBINAR</div>

        <div class="video-container">
            <iframe width="560" height="315" src="https://www.youtube.com/embed/ljs0oHoazr4?si=s4R6U4ziOFKYmHCn" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
        </div>
    </section>
</div>

<script>

</script>
<?= $this->endSection(); ?>