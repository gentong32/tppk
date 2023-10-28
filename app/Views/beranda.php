<?= $this->extend('layout/default') ?>

<?= $this->section('konten') ?>
<div class="content-wrap0">
    <section class="onebanner">
        <img id="gb" src="<?= base_url() ?>gambar/landing_image.jpg" alt="">
    </section>
</div>
<footer id="footer" class="footer bg-overlay">
    <div class="copyright">
        <span>Pusdatin &copy; Kemendikbudristek <script>
                document.write(new Date().getFullYear())
            </script></span>
    </div>
</footer>
<?= $this->endSection(); ?>

<?= $this->section('scriptfooter'); ?>
<script>
    function cekLebarLayar() {
        var lebarLayar = window.innerWidth;
        var tinggiLayar = window.innerHeight;
        var tinggiMenuAtas = document.querySelector('.navbar').offsetHeight;
        var tinggiLogoAtas = document.querySelector('.logoatas').offsetHeight;

        if (lebarLayar - tinggilayar >= 100) {
            // Layar lebar (desktop)
            document.getElementById('gb').style.height = (tinggiLayar - tinggiMenuAtas - tinggiLogoAtas - 10) + 'px';
            document.getElementById('gb').style.width = 'auto';
            document.getElementById('gb').style.textAlign = 'center';
        } else {
            // Layar kecil (tablet/ponsel)
            document.getElementById('gb').style.width = (lebarLayar - 200) + 'px';
            document.getElementById('gb').style.height = 'auto';
        }
    }

    // Panggil fungsi cekLebarLayar saat halaman dimuat dan saat jendela diubah ukurannya
    window.onload = cekLebarLayar;
    window.onresize = cekLebarLayar;
</script>
<?= $this->endSection(); ?>