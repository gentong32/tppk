<?= $this->extend('layout/default') ?>

<?= $this->section('header') ?>

<?= $this->endSection() ?>


<?= $this->section('konten') ?>
<div class="content-wrap">
    <section class="informasi">
        <div class="judul">TPPK</div>
        <p>Satuan pendidikan membentuk TPPK dengan tugas dan fungsi untuk pencegahan dan penanganan. Tiga belas fungsi TPPK sebagai berikut:</p>
        <ol>
            <li>
                Menyampaikan usulan atau rekomendasi program pencegahan kekerasan kepada kepala satuan pendidikan;
            </li>
            <li>
                Memberikan masukan atau saran kepada kepala satuan pendidikan mengenai fasilitas yang aman dan nyaman di satuan pendidikan;
            </li>
            <li>
                Melaksanakan sosialisasi kebijakan dan program terkait pencegahan dan penanganan kekerasan bersama dengan satuan pendidikan;
            </li>
            <li>
                Menerima dan menindaklanjuti laporan dugaan kekerasan;
            </li>
            <li>
                Melakukan penanganan terhadap temuan adanya dugaan kekerasan di lingkungan satuan pendidikan;
            </li>
            <li>
                Menyampaikan pemberitahuan kepada orang tuawali dari peserta didik yang terlibat kekerasan;
            </li>
            <li>
                Memeriksa laporan dugaan kekerasan;
            </li>
            <li>
                Memberikan rekomendasi sanksi kepada kepala satuan pendidikan berdasarkan hasil pemeriksaan;
            </li>
            <li>
                Mendampingi korban dan atau pelapor kekerasan di lingkungan satuan pendidikan;
            </li>
            <li>
                Memfasilitasi pendampingan oleh ahli atau layanan lainnya yang dibutuhkan korban, pelapor, dan atau saksi;
            </li>
            <li>
                Memberikan rujukan bagi korban ke layanan sesuai dengan kebutuhan korban kekerasan;
            </li>
            <li>
                Memberikan rekomendasi pendidikan anak dalam hal peserta didik yang terlibat kekerasan merupakan anak yang berhadapan dengan hukum; dan
            </li>
            <li>
                Melaporkan pelaksanaan tugas kepada kepala dinas pendidikan melalui kepala satuan pendidikan paling sedikit 1 (satu) kali dalam 1 (satu) tahun.
            </li>
        </ol>
        <p></p>
        <p>TPPK juga memiliki kewenangan untuk:</p>
        <ol>
            <li>
                Memanggil dan meminta keterangan pelapor korban saksi terlapor orang tua atau wali pendamping dan atau ahli
            </li>
            <li>
                Berkoordinasi dengan satuan pendidikan lain yang melibatkan korban saksi pelapor dan atau terlapor dari satuan pendidikan yang bersangkutan jika kekerasan yang terjadi melibatkan satuan pendidikan lain dan
            </li>
            <li>
                Berkoordinasi dengan pihak lain untuk pemulihan dan identifikasi dampak kekerasan seperti psikolog tenaga medis tenaga kesehatan pekerja sosial rohaniawan dan atau profesi lainnya sesuai kebutuhan.
            </li>
        </ol>
        <p></p>
        <p>Anggota TPPK dibentuk dengan jumlah ganjil atau paling sedikit tiga orang dengan perwakilan dari pendidik dan komite sekolah atau perwakilan orang tua atau wali. Jika diperlukan perwakilan tenaga kependidikan juga dapat menjadi anggota TPPK sebagai tenaga administrasi. Namun bagi satuan Pendidikan Anak Usia Dini (PAUD) yang tidak dapat membentuk TPPK karena sumber daya manusianya tidak mencukupi tugas dan wewenang TPPK dilaksanakan oleh beberapa satuan PAUD yang ditetapkan oleh Dinas Pendidikan. Sehingga pelaksanaan tugas dan fungsinya sebagai TPPK akan bertanggungjawab kepada kepala Dinas Pendidikan.
        </p>
        <p>Sedangkan untuk satuan pendidikan nonformal seperti pendidikan kesetaraan yang tidak memiliki komite sekolah maka TPPK cukup beranggotakan dari unsur pendidik.</p>










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