<?= $this->extend('layout/default') ?>

<?= $this->section('konten') ?>
<style>
    .dot {
        height: 10px;
        width: 10px;
        margin: 0 5px;
        background-color: #bbb;
        border-radius: 50%;
        display: inline-block;
        transition: background-color 0.3s ease;
        cursor: pointer;
    }

    .active,
    .dot:hover {
        background-color: #717171;
    }

    #single {
        max-width: calc(100% - 20px);
        max-height: calc(100vh - 130px);
        width: auto;
        height: auto;
        margin: 1px auto;
        padding: 5px;
        display: block;
        box-sizing: border-box;
    }
</style>

<div class="content-wrap0">
    <section class="onebanner">
        <?php
        $adaevent = false;
        if ($adaevent) { ?>
            <div id="slideshow-container" style="position: relative;">
                <a id="imageLink" href="#">
                    <img id="slideshow" src="<?= base_url() ?>gambar/landing_image2.jpg" alt="">
                </a>
                <!-- <div id="slider-dots" style="position: absolute; bottom: 10px; left: 50%; transform: translateX(-50%);"></div> -->

                <button id="prevBtn" onclick="prevImage()" style="display:none; position: absolute; top: 50%; transform: translateY(-50%); left: 10px;">&#10094;</button>
                <button id="nextBtn" onclick="nextImage()" style="display:none; position: absolute; top: 50%; transform: translateY(-50%); right: 10px;">&#10095;</button>
            </div>
            <div id="slider-dots" style="text-align: center;"></div>
        <?php } else { ?>
            <img id="single" src="<?= base_url() ?>gambar/landing_image2.jpg" alt="">
        <?php } ?>
    </section>
</div>
<footer id="footer" class="footer bg-overlay">
    <div class="copyright">
        <span>Pusdatin &copy; Kemendikbudristek <?= date("Y") ?></span>
    </div>
</footer>
<?= $this->endSection(); ?>

<?= $this->section('scriptfooter'); ?>
<script>
    function cekLebarLayar() {
        var lebarLayar = window.innerWidth;
        var tinggilayar = window.innerHeight;
        var tinggiMenuAtas = document.querySelector('.navbar').offsetHeight;
        var tinggiLogoAtas = document.querySelector('.logoatas').offsetHeight;

        if (lebarLayar - tinggilayar >= 100) {
            // Layar lebar (desktop)
            //     document.getElementById('gb').style.height = (tinggiLayar - tinggiMenuAtas - tinggiLogoAtas - 10) + 'px';
            //     document.getElementById('gb').style.width = 'auto';
            //     document.getElementById('gb').style.textAlign = 'center';
            // } else {
            // Layar kecil (tablet/ponsel)
            // document.getElementById('gb').style.width = (lebarLayar - 200) + 'px';
            // document.getElementById('gb').style.height = 'auto';
        }
    }

    // Panggil fungsi cekLebarLayar saat halaman dimuat dan saat jendela diubah ukurannya
    window.onload = cekLebarLayar;
    window.onresize = cekLebarLayar;

    <?php if ($adaevent) { ?>
        var images = ['<?= base_url() ?>gambar/landing_image2.jpg', '<?= base_url() ?>gambar/webinar1.jpg'];
        var currentImageIndex = 0;
        var slideshowInterval = setInterval(nextImage, 3000); // Berganti gambar setiap 5 detik

        // Inisialisasi indikator bulatan
        var dots = document.getElementById("slider-dots");
        for (var i = 0; i < images.length; i++) {
            var dot = document.createElement("span");
            dot.classList.add("dot");
            dot.setAttribute("onclick", "currentImage(" + i + ")");
            dots.appendChild(dot);
        }

        // Fungsi untuk menampilkan gambar berdasarkan indeks
        function showImage(index) {
            document.getElementById('slideshow').src = images[index];
            currentImageIndex = index;
            updateDots();
            updateCursor();
        }

        // Fungsi untuk menampilkan gambar berikutnya
        function nextImage() {
            currentImageIndex = (currentImageIndex + 1) % images.length;
            showImage(currentImageIndex);
        }

        // Fungsi untuk menampilkan gambar sebelumnya
        function prevImage() {
            currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
            showImage(currentImageIndex);
        }

        // Fungsi untuk menampilkan gambar sesuai dengan indeks dot yang diklik
        function currentImage(index) {
            showImage(index);
        }

        // Fungsi untuk memperbarui indikator bulatan
        function updateDots() {
            var dots = document.getElementsByClassName("dot");
            for (var i = 0; i < dots.length; i++) {
                dots[i].classList.remove("active");
            }
            dots[currentImageIndex].classList.add("active");
        }

        // Fungsi untuk memperbarui kursor
        function updateCursor() {
            var imageLink = document.getElementById("imageLink");
            if (currentImageIndex === 1) {
                imageLink.style.cursor = "pointer";
                imageLink.setAttribute("onclick", "redirectToPage()");
            } else {
                imageLink.style.cursor = "default";
                imageLink.removeAttribute("onclick");
            }
        }

        // Fungsi untuk mengarahkan pengguna ke halaman tertentu saat gambar kedua diklik
        function redirectToPage() {
            // Menentukan halaman yang ingin Anda arahkan ketika gambar kedua diklik
            window.location.href = "<?= base_url() ?>webinar";
        }
    <?php } ?>
</script>
<?= $this->endSection(); ?>