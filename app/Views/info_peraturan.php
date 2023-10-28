<?= $this->extend('layout/default') ?>

<?= $this->section('header') ?>

<?= $this->endSection() ?>


<?= $this->section('konten') ?>
<div class="content-wrap">
    <section class="informasi">
        <div class="judul">PERATURAN MENTERI</div>
        <p>Pada Peraturan Menteri Pendidikan Kebudayaan Riset Dan Teknologi Republik Indonesia No XX Tahun 2023 tentang Pencegahan dan Penanganan Kekerasan di Lingkungan Satuan Pendidikan (PPKSP) telah mengatur satuan pendidikan untuk membentuk tim pencegahan dan penanganan kekerasan yang selanjutnya disebut sebagai TPPK. TPPK bertanggungjawab kepada kepala satuan pendidikan.</p>
        <p>Pemerintah daerah provinsi dan kabupaten atau kota membentuk Satuan Tugas Pencegahan dan Penanganan Kekerasan melalui usulan Dinas Pendidikan. Satuan Tugas bertanggung jawab kepada kepala daerah melalui kepala Dinas Pendidikan. TPPK dan Satuan Tugas hadir untuk memastikan kasus-kasus kekerasan yang terjadi di satuan pendidikan dapat segera ditangani dan korban mendapatkan pemulihan.</p>
        <div class="judulgambar">
            <h1>Keanggotaan dan target waktu pembentukan TPPK dan Satuan Tugas<br>
                dibedakan untuk menyesuaikan konteks dimana tim dibentuk<br>
            </h1>
            <h2>Pasal 24 s.d. Pasal 35 dan Pasal 76</h2>
            <img src="<?= base_url() ?>gambar/info1.jpg" alt="">
        </div>
    </section>
</div>

<script>
    function toggleInfo(event, idx) {
        event.preventDefault(); // Mencegah aksi default hyperlink

        var info = document.getElementById("info" + idx);
        info.classList.toggle("show");
    }
</script>
<?= $this->endSection(); ?>