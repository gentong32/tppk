<?= $this->extend('layout/default') ?>

<?= $this->section('header') ?>

<?= $this->endSection() ?>


<?= $this->section('konten') ?>
<div class="content-wrap">
    <section class="informasi">
        <div class="judul">Persyaratan Menjadi TPPK dan Satuan Tugas</div>
        <p>Persyaratan untuk bergabung menjadi anggota TPPK maupun satgas antara lain: tidak pernah terbukti melakukan kekerasan tidak pernah terbukti dijatuhi hukuman pidana dengan ancaman lima tahun atau lebih yang telah berkekuatan hukum tetap dan atau tidak pernah dan atau tidak sedang menjalani hukuman disiplin pegawai tingkat sedang maupun berat.</p>
        <p>Baik anggota TPPK maupun satgas akan berakhir masa keanggotaannya apabila: masa tugas anggota TPPK atau satgas berakhir yaitu dua tahun bagi TPPK dan empat tahun bagi satgas meninggal dunia mengundurkan diri tidak lagi memenuhi syarat keanggotaan seperti yang telah disebutkan sebelumnya terbukti melakukan kekerasan berdasarkan pemeriksaan kasus kekerasan yang dilakukan Satuan Tugas menjadi tersangka tindak pidana kecuali tindak pidana ringan berhalangan tetap yang mengakibatkan tidak dapat melaksanakan tugas atau pindah tugas atau mutasi.</p>
        <p>TPPK dan Satuan Tugas berperan sangat penting dalam pelaksanaan pencegahan dan penanganan kekerasan di satuan pendidikan. Oleh karena itu komitmen aktif dari satuan pendidikan pemerintah daerah anggota TPPK Satuan Tugas serta seluruh lapisan masyarakat akan memberikan dukungan yang kuat untuk menciptakan lingkungan pendidikan yang bebas dari kekerasan. Sudah seharusnya satuan pendidikan menjadi tempat yang aman</p>

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