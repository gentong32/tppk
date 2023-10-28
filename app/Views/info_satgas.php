<?= $this->extend('layout/default') ?>

<?= $this->section('header') ?>

<?= $this->endSection() ?>


<?= $this->section('konten') ?>
<div class="content-wrap">
    <section class="informasi">
        <div class="judul">Satuan Tugas</div>
        <p>Hal penting lainnya dalam pelaksanaan pencegahan dan penanganan kekerasan yaitu perlunya Satuan Tugas di tingkat pemerintah daerah provinsi dan kabupaten atau kota. Pemerintah daerah provinsi membentuk Satuan Tugas untuk kewenangan satuan pendidikan tingkat SMA, SMK dan pendidikan khusus. Pemerintah kabupaten atau kota membentuk Satuan Tugas untuk kewenangan satuan pendidikan tingkat paud SD, SMP dan pendidikan nonformal. Kedua jenis Satuan Tugas ini bertugas untuk melaksanakan pembinaan pemantauan dan pengawasan pencegahan serta penanganan kekerasan pada satuan pendidikan di wilayah kewenangannya.</p>
        <p>Dalam melaksanakan tugasnya Satuan Tugas berfungsi untuk:
        <ol>
            <li>
                Melakukan pencegahan dan penanganan kasus kekerasan pada satuan pendidikan di wilayah sesuai kewenangannya;
            </li>
            <li>
                Membina mendampingi dan mengawasi TPPK;
            </li>
            <li>
                Memfasilitasi TPPK untuk berkoordinasi dengan dinas terkait lembaga layanan ahli atau pihak terkait yang dibutuhkan dalam pencegahan dan penanganan kekerasan di lingkungan satuan pendidikan;
            </li>
            <li>
                Memastikan pemenuhan hak pendidikan atas peserta didik yang terlibat kekerasan dalam wilayah kerja Satuan Tugas berupa pemberian jaminan layanan pendidikan bagi peserta didik dan koordinasi dengan pihak terkait dalam penyediaan akses layanan pendidikan;
            </li>
            <li>
                Memfasilitasi pemenuhan hak pendidikan atas anak yang berhadapan dengan hukum berupa:
                <ol>
                    <li>
                        Pemberian rekomendasi layanan pendidikan anak terhadap anak yang berhadapan dengan hukum kepada aparat penegak hukum
                    </li>
                    <li>
                        Pemetaan sumber daya untuk mendukung pendidikan anak selama menjalani proses peradilan atau selama menjalani putusan atau penetapan pengadilan dan
                    </li>
                    <li>
                        Koordinasi dengan pihak terkait dalam penyediaan akses layanan pendidikan.
                    </li>
                </ol>
            </li>
            <li>
                Melakukan pemantauan dan evaluasi pelaksanaan pencegahan dan penanganan kekerasan di lingkungan satuan pendidikan paling sedikit 1 (satu) kali dalam 1 (satu) tahun dan

            </li>
            <li>
                Melaporkan hasil pemantauan dan evaluasi kepada dinas pendidikan setiap satu kali dalam satu tahun atau sewaktu-waktu apabila diperlukan.
            </li>
        </ol>
        <p></p>
        <p>
            Kita memahami bahwa mewujudkan lingkungan belajar yang bebas dari kekerasan menjadi tanggungjawab bersama sehingga diperlukan kolaborasi dengan berbagai pemangku kepentingan dalam mencegah dan menangani kekerasan. Dalam pelaksanaan tugas Satuan Tugas dapat berkoordinasi dengan pihak lain seperti dinas kesehatan atau dinas terkait lainnya psikolog dokter atau tenaga kesehatan lainnya pekerja sosial unit pelaksana teknis kementerian pada daerah setempat perwakilan organisasi masyarakat sipil atau praktisi yang berfokus pada bidang pendidikan dan atau bidang penanganan kekerasan; dan atau pihak lain yang diperlukan dalam penanganan kekerasan.
        </p>
        <p>
            Sedikit berbeda dengan anggota TPPK keanggotaan Satuan Tugas berjumlah ganjil dengan minimal lima orang. Di dalamnya terdiri atas unsur perwakilan dinas yang menyelenggarakan fungsi pendidikan perwakilan dinas yang menyelenggarakan fungsi bidang perlindungan anak perwakilan dinas yang menyelenggarakan fungsi bidang sosial dan organisasi atau bidang profesi yang terkait dengan anak.
        </p>

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