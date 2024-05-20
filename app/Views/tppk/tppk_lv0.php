<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<div class="judul">Jumlah Satuan Tugas tiap <?= $namapilihan2 ?></div>

<div class="informasi">
    <table class="table table-striped" id="tabel2">
        <thead>
            <th width="10px">No</th>
            <th><?= $judulnama ?></th>
            <th>Lihat Satgas</i></th>
            <th>Satgas Provinsi</th>
            <th>Jumlah Kota/Kab</th>
            <th>Jumlah Satgas Kota/Kab</th>
            <th>Persentase Satgas Kota/Kab</th>
        </thead>

        <tbody align="right">
            <?php foreach ($datanas2 as $key => $value) : ?>
                <tr>
                    <td><?= $key + 1 ?></td>
                    <td align="left" class="link1">
                        <?php if ($level <= 3) {

                        ?>
                            <a href="<?= site_url('tppk/wilayah/' .
                                            trim($value['kode_wilayah']) . '/' . ($level + 1) . $parameter) ?>"><?php
                                                                                                                if ($level == 0 && $value['wilayah'] != "Luar Negeri") {
                                                                                                                    echo substr($value['wilayah'], 5);
                                                                                                                } else if ($level == 2 && substr($kode, 0, 2) != '35') {
                                                                                                                    echo substr($value['wilayah'], 4);
                                                                                                                } else {
                                                                                                                    echo $value['wilayah'];
                                                                                                                } ?></a>
                        <?php
                        } else {

                            if ($level == 0 && $value['wilayah'] != "Luar Negeri") {
                                echo substr($value['wilayah'], 5);
                            } else if ($level == 2 && substr($kode, 0, 2) != '35') {
                                echo substr($value['wilayah'], 4);
                            } else {
                                echo $value['wilayah'];
                            }
                        } ?>
                    </td>
                    <!-- <i class="far fa-eye"></i> -->
                    <td><?php if ($value['jml_satgas_provinsi'] == 1) {
                            if ($sebagai == "viewersk") { ?>
                                <a href="<?= base_url() . 'inputdata/lihatanggota2/' . trim($value['kode_wilayah']) ?>"><i class="far fa-eye"></i></a>
                            <?php } else { ?>
                                <a href="<?= base_url() . 'tppk/anggota2/' . trim($value['kode_wilayah']) ?>"><i class="far fa-eye"></i></a>
                        <?php }
                        } else {
                            echo '<i class="far fa-eye-slash"></i>';
                        } ?>
                    </td>
                    <td><?= $value['jml_satgas_provinsi'] ?></td>
                    <td><?= $value['jml_kab_kota'] ?></td>
                    <td><?= $value['jml_satgas_kab_kota'] ?></td>
                    <td><?= number_format($value['jml_satgas_kab_kota'] * 100 / $value['jml_kab_kota'], 2, '.', '') ?>%</td>


                </tr>

            <?php endforeach; ?>
        </tbody>

        <tfoot align="right">
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </tfoot>

    </table>
</div>