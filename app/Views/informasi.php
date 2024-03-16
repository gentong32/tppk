<?= $this->extend('layout/default') ?>

<?= $this->section('header') ?>
<style>
    .infoul {
        padding: 5px;
        margin-top: 25px;
        list-style-type: none;
        font-size: 13px;
    }

    .infoul li {
        line-height: 25px;
    }

    /* .infoul li:nth-child(even) {
        margin-top: 5px;
        background-color: white;
        padding: 10px;
    }

    .infoul li:nth-child(odd) {
        margin-top: 5px;
        background-color: rgba(40, 170, 205, 0.1);
        background-color: white;
        padding: 10px;
    } */

    .info-container {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.5s ease;
    }

    .info-container.show {
        max-height: 1700px;
        /* margin-top: 25px; */
        /* Atur tinggi maksimum sesuai kebutuhan */
    }

    /* CSS untuk section informasi */
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

    /* CSS untuk tombol unduh panduan */
    button {
        background-color: #3498db;
        color: #fff;
        padding: 10px 15px;
        font-size: 16px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .infotuna {
        margin: 20px;
    }

    /* CSS untuk video iframe */
</style>
<?= $this->endSection() ?>


<?= $this->section('konten') ?>
<div class="content-wrap">
    <br>
    <section class="informasi">
        <div class="judul">INFORMASI</div>
        Panduan Pengguna Aplikasi Dasbor TPPK dan Satgas, Kabupaten, Kota, dan Provinsi<br>
        <button onclick="return download_panduan();">Unduh Panduan</button>
        <br><br>
        Mekanisme Pelaporan Pembentukan Tim Pencegahan dan Penanganan Kekerasan (TPPK)
        <br>
        <button id="tombolVideo">Tonton Video</button>
        <div id="videoContainer" class="video-container" style="display:none">
            <iframe id="youtubeVideo" width="560" height="315" src="https://www.youtube.com/embed/7lw5qclI_Zs?si=k9kfjS85zXdLdzJv" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
        </div>
        <br><br>
        Informasi Mengenai Jenis Ketunaan<br>
        <button onclick="tampilkanketunaan()">Tampilkan</button>
        <br><br>
        Solusi Penguatan Pencegahan Kekerasan bagi TPPK dan Satgas PPKSP
        <br>
        <button id="tombolVideo2">Live Streaming</button>
        <div id="videoContainer2" class="video-container" style="display:none">
            <iframe id="youtubeVideo2" width="560" height="315" src="https://www.youtube.com/embed/ljs0oHoazr4?si=s4R6U4ziOFKYmHCn" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
        </div>
    </section>
</div>

<script>
    document.getElementById('tombolVideo').addEventListener('click', function() {
        var videoContainer = document.getElementById('videoContainer');
        if (videoContainer.style.display === 'none') {
            videoContainer.style.display = 'block';

            var youtubeVideo = document.getElementById('youtubeVideo');
            youtubeVideo.src = youtubeVideo.src + '&autoplay=1';
        }
        document.getElementById('tombolVideo').style.display = 'none';
    });

    document.getElementById('tombolVideo2').addEventListener('click', function() {
        var videoContainer = document.getElementById('videoContainer2');
        if (videoContainer.style.display === 'none') {
            videoContainer.style.display = 'block';

            var youtubeVideo = document.getElementById('youtubeVideo2');
            youtubeVideo.src = youtubeVideo.src + '&autoplay=1';

            videoContainer.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
        document.getElementById('tombolVideo2').style.display = 'none';
    });

    function toggleInfo(event, idx) {
        event.preventDefault(); // Mencegah aksi default hyperlink

        var info = document.getElementById("info" + idx);
        info.classList.toggle("show");
    }

    function download_panduan() {
        window.open("<?= base_url() ?>inputdata/download_panduan");
    }

    function tampilkanketunaan() {
        window.open("<?= base_url() ?>informasi/ketunaan", "_blank");
    }
</script>
<?= $this->endSection(); ?>