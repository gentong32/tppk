<div class="judul">Jumlah Satuan Tugas tiap <?= $namapilihan2 ?></div>

<div class="informasi">
    <table class="table table-striped" id="tabel2">
        <thead>
            <th width="10px">No</th>
            <th>Nama Kota/Kabupaten</th>
            <th>Satgas Kota/Kab</th>
            <th>Satgas Kota/Kab Valid</th>
            <th>Jumlah Anggota Satgas Kota/Kab</th>
        </thead>

        <tbody align="right">
            <?php
            $jml_satgas = 0;
            $jml_satgas_valid = 0;
            foreach ($datanas2 as $key => $value) :
                if ($value['jml_anggota_satgas'] > 0) {
                    $jml_satgas++;
                }
                if ($value['jml_kab_kota_valid'] != null) {
                    $jml_satgas_valid++;
                }
            ?>
                <tr>
                    <td><?= $key + 1 ?></td>
                    <td align="left" class="link1">
                        <?php if ($level <= 3) {
                            if ($sebagai == "viewersk") { ?>
                                <a href="<?= site_url('inputdata/lihatanggota2/' .
                                                trim($value['kode_wilayah'])) ?>"><?php
                                                                                    if ($level == 0 && $value['wilayah'] != "Luar Negeri") {
                                                                                        echo substr($value['wilayah'], 5);
                                                                                    } else if ($level == 2 && substr($kode, 0, 2) != '35') {
                                                                                        echo substr($value['wilayah'], 4);
                                                                                    } else {
                                                                                        echo $value['wilayah'];
                                                                                    } ?></a>
                            <?php } else { ?>
                                <a href="<?= site_url('tppk/anggota2/' .
                                                trim($value['kode_wilayah'])) ?>"><?php
                                                                                    if ($level == 0 && $value['wilayah'] != "Luar Negeri") {
                                                                                        echo substr($value['wilayah'], 5);
                                                                                    } else if ($level == 2 && substr($kode, 0, 2) != '35') {
                                                                                        echo substr($value['wilayah'], 4);
                                                                                    } else {
                                                                                        echo $value['wilayah'];
                                                                                    } ?></a>
                        <?php }
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
                    <td><?= ($value['jml_anggota_satgas'] == 0) ? '-' : '&check;' ?></td>
                    <td align="center">
                        <div class="residu <?= ($value['jml_kab_kota_valid'] == null) ? 'merah' : 'hijau' ?>"><?= ($value['jml_kab_kota_valid'] == null) ? ' ' : '' ?></div>
                    </td>
                    <td><?= ($value['jml_anggota_satgas'] > 0) ? $value['jml_anggota_satgas'] : 0 ?></td>


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
            </tr>
        </tfoot>

    </table>
</div>