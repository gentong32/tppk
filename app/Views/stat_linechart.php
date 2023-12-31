<?php

$adafilter = "";
$filter = "";

if ($jenjang != "semua" || $bentuk != "semua" || $status != "semua") {
  $adafilter = "?";
}

if ($jenjang != "semua") {
  $filter = $filter . "jenjang=" . $jenjang . "&";
}
if ($bentuk != "semua") {
  $filter = $filter . "bentuk=" . $bentuk . "&";
}
if ($status != "semua") {
  $filter = $filter . "status=" . $status . "&";
}

$text = $adafilter . $filter;
$panjang = strlen($text);


if ($adafilter != "") {
  $parameter = substr($text, 0, $panjang - 1);
} else {
  $parameter = "";
}


$totalsemua = 0;
$total1 = 0;

for ($a = 1; $a <= 5; $a++) {
  $selectj[$a] = "";
}
if ($jenjang == "paud")
  $selectj[1] = "selected";
else if ($jenjang == "dikdas")
  $selectj[2] = "selected";
else if ($jenjang == "dikmen")
  $selectj[3] = "selected";
else if ($jenjang == "dikmas")
  $selectj[4] = "selected";

for ($a = 1; $a <= 2; $a++) {
  $selects[$a] = "";
}
if ($status == "negeri")
  $selects[1] = "selected";
else if ($status == "swasta")
  $selects[2] = "selected";

?>

<?= $this->extend('layout/default_grafik') ?>

<?= $this->section('header') ?>
<style>
  .apexcharts-legend-text tspan:nth-child(1) {
    font-weight: lighter;
    fill: #999;
  }

  .apexcharts-legend-text tspan:nth-child(3) {
    font-weight: bold;
  }

  .apexcharts-xaxis-label {
    font-weight: lighter;
  }
</style>
<script src="<?= base_url() ?>js/jquery-3.5.1.js"></script>
<script>
  window.Promise ||
    document.write(
      '<script src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.min.js"><\/script>'
    )
  window.Promise ||
    document.write(
      '<script src="https://cdn.jsdelivr.net/npm/eligrey-classlist-js-polyfill@1.2.20171210/classList.min.js"><\/script>'
    )
  window.Promise ||
    document.write(
      '<script src="https://cdn.jsdelivr.net/npm/findindex_polyfill_mdn"><\/script>'
    )
</script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<?= $this->endSection() ?>

<?= $this->section('konten') ?>

<?php

// $persenresidupd = intval($residupd->tot_residu_nisn / $residupd->tot_pd * 10000) / 100;
// $persentotalpd = 100 - $persenresidupd;


$tglawal = strtotime(date("Y-m-01 07:00:00")) * 1000;
$tglmax = strtotime(date("Y-m-d 07:00:00")) * 1000;

?>

<div class="content-wrap">

  <!-- /===================== GRAFIK PD ==========================-->
  <div class="subjudul">
    <h4>TPPK</h4>
    <h6><?= $tglsekarang ?><h6>
  </div>

  <center>
    <div class="dfilter">
      <div id="djenjang" style="display:inline-block;">
        <select class="combobox1" id="jenjang" name="jenjang">
          <option value="all">-Semua Jenjang-</option>
          <option <?= $selectj[1] ?> value="paud">Paud</option>
          <option <?= $selectj[2] ?> value="dikdas">Dikdas</option>
          <option <?= $selectj[3] ?> value="dikmen">Dikmen</option>
          <option <?= $selectj[4] ?> value="dikmas">Dikmas</option>
        </select>
      </div>
      <div id="dbentukpendidikan" style="display:inline-block;">
        <select class="combobox1" id="bentuk_pendidikan" name="bentuk_pendidikan">
          <option value="all">-Semua Bentuk-</option>
          <?php
          foreach ($dafbentuk as $value) {
            $seleksi = "";
            if ($value == $bentuk) {
              $seleksi = "selected";
            }
            echo "<option " . $seleksi . " value='" . $value . "'>" . $value . "</option>";
          }
          ?>
        </select>
      </div>
      <div id="dbentukpendidikan" style="display:inline-block;">
        <select class="combobox1" id="istatus" name="istatus">
          <option value="all">-Semua Status-</option>
          <option <?= $selects[1] ?> value="negeri">Negeri</option>
          <option <?= $selects[2] ?> value="swasta">Swasta</option>
        </select>
      </div>
      <button onclick="filterdata()" class="tb_utama" type="button">
        Terapkan
      </button>
    </div>
  </center>

  <div class="row">
    <div class="chartbox">
      <h5>Jumlah Satuan Pendidikan</h5>
      <div class="totalgraph"><?= number_format($totalsp, 0, ',', '.') ?></div>
    </div>
    <div class="chartbox">
      <h5>Jumlah TPPK</h5>
      <div class="totalgraph"><?= number_format($totaltppk, 0, ',', '.') ?></div>
    </div>
    <div class="chartbox">
      <h5>Persentase TPPK</h5>
      <div id="chart1"></div>
    </div>
  </div>

  <div style="margin-top:35px"></div>
  <div class="subjudul">
    <h4>Satuan Tugas</h4>
    <h6><?= $tglsekarang ?><h6>
  </div>

  <div class="row">
    <div class="chartbox">
      <h5>Jumlah Provinsi</h5>
      <div class="totalgraph"><?= number_format($totalprovinsi, 0, ',', '.') ?></div>
    </div>
    <div class="chartbox">
      <h5>Jumlah Satgas Provinsi</h5>
      <div class="totalgraph"><?= number_format($totalsatgasprovinsi, 0, ',', '.') ?></div>
    </div>
    <div class="chartbox">
      <h5>Persentase Satgas Provinsi</h5>
      <div id="chart2"></div>
    </div>
  </div>

  <div class="row">
    <div class="chartbox">
      <h5>Jumlah Kabupaten/Kota</h5>
      <div class="totalgraph"><?= number_format($totalkota, 0, ',', '.') ?></div>
    </div>
    <div class="chartbox">
      <h5>Jumlah Satgas Kab/Kota</h5>
      <div class="totalgraph"><?= number_format($totalsatgaskota, 0, ',', '.') ?></div>
    </div>
    <div class="chartbox">
      <h5>Persentase Satgas Kab/Kota</h5>
      <div id="chart3"></div>
    </div>
  </div>

</div>
<?= $this->endSection() ?>

<?= $this->section('scriptfooter') ?>
<script>
  var options = {};
  var options2 = {};
  var options3 = {};
  var data = {};
  <?php if ($totalsp > 0) { ?>
    data[1] = [<?= (intval($totaltppk * 10000 / $totalsp) / 100) ?>, <?= (100 - (intval($totaltppk * 10000 / $totalsp) / 100)) ?>];
  <?php } else { ?>
    data[1] = [0, 0];
  <?php } ?>

  data[2] = [<?= $persen_satgasprovinsi ?>, <?= $persen_provinsi ?>];
  data[3] = [<?= $persen_satgaskota ?>, <?= $persen_kota ?>];

  options = {
    series: data[1],
    chart: {
      width: 200,
      type: 'donut',
    },
    colors: ['#00cc00', '#ff6666'],
    grid: {
      padding: {
        left: 0,
        right: 0
      }
    },
    plotOptions: {
      pie: {
        startAngle: 0,
        endAngle: 360,
        donut: {
          size: '45%'
        }
      },
    },
    labels: ['TPPK', 'Belum memiliki TPPK'],
    dataLabels: {
      enabled: true,
      formatter: function(val, opts) {
        return [opts.w.globals.labels[opts.seriesIndex], val + "%"]
      },
    },
    fill: {
      type: 'gradient',
    },
    legend: {
      show: false,
      formatter: function(val, opts) {
        return val + " - " + opts.w.globals.series[opts.seriesIndex] + "%"
      }
    },
  };

  var chart = new ApexCharts(document.querySelector("#chart1"), options);
  chart.render();

  options2 = {
    series: data[2],
    chart: {
      width: 200,
      type: 'donut',
    },
    colors: ['#00cc00', '#ff6666'],
    grid: {
      padding: {
        left: 0,
        right: 0
      }
    },
    plotOptions: {
      pie: {
        startAngle: 0,
        endAngle: 360,
        donut: {
          size: '45%'
        }
      },
    },
    labels: ['Satgas Provinsi', 'Belum memiliki Satgas'],
    dataLabels: {
      enabled: true,
      formatter: function(val, opts) {
        return [opts.w.globals.labels[opts.seriesIndex], val + "%"]
      },
    },
    fill: {
      type: 'gradient',
    },
    legend: {
      show: false,
      formatter: function(val, opts) {
        return val + " - " + opts.w.globals.series[opts.seriesIndex] + "%"
      }
    },
  };

  var chart2 = new ApexCharts(document.querySelector("#chart2"), options2);
  chart2.render();

  options3 = {
    series: data[3],
    chart: {
      width: 200,
      type: 'donut',
    },
    colors: ['#00cc00', '#ff6666'],
    grid: {
      padding: {
        left: 0,
        right: 0
      }
    },
    plotOptions: {
      pie: {
        startAngle: 0,
        endAngle: 360,
        donut: {
          size: '45%'
        }
      },
    },
    labels: ['Satgas Kab/Kota', 'Belum memiliki Satgas'],
    dataLabels: {
      enabled: true,
      formatter: function(val, opts) {
        return [opts.w.globals.labels[opts.seriesIndex], val + "%"]
      },
    },
    fill: {
      type: 'gradient',
    },
    legend: {
      show: false,
      formatter: function(val, opts) {
        return val + " - " + opts.w.globals.series[opts.seriesIndex] + "%"
      }
    },
  };

  var chart3 = new ApexCharts(document.querySelector("#chart3"), options3);
  chart3.render();
</script>

<script>
  function filterdata() {
    //    alert ($('#bentuk_pendidikan').val());
    var adafilter = "";
    var filter = "";

    var jenjang = document.getElementById('jenjang').value;
    var bentuk = document.getElementById('bentuk_pendidikan').value;
    var status = document.getElementById('istatus').value;

    if (bentuk == '-Semua Bentuk-')
      bentuk = "all";

    if (jenjang != "all" || bentuk != "all" || status != "all") {
      adafilter = "?";
    }


    if (jenjang != "all") {
      filter = filter + "jenjang=" + jenjang + "&";
    }
    if (bentuk != "all") {
      filter = filter + "bentuk=" + bentuk + "&";
    }
    if (status != "all") {
      filter = filter + "status=" + status + "&";
    }


    let text = adafilter + filter;
    let panjang = text.length;
    let result = text.substr(0, panjang - 1);

    if (adafilter != "") {
      window.open("<?= base_url() ?>dashboard" + result, "_self");
    } else {
      window.open("<?= base_url() ?>dashboard", "_self");
    }

  }

  $(document).on('change', '#jenjang', function() {
    // alert ($('#jenjang').val());
    getdaftarbentuk();
  });

  function getdaftarbentuk() {

    isihtml1 = '<select class="combobox1" id="bentuk_pendidikan" name="bentuk_pendidikan">';
    isihtml3 = '</select>';
    $('#dbentukpendidikan').html(isihtml1 + isihtml3);
    $.ajax({
      type: 'GET',
      data: {},
      dataType: 'json',
      cache: false,
      url: '<?php echo base_url(); ?>dashboard/getBentukKementerian/' + $('#jenjang').val(),
      success: function(result) {
        // alert ($('#jalur_pendidikan').val());
        isihtml1 = '<select class="combobox1" id="bentuk_pendidikan" name="bentuk_pendidikan">' +
          '<option value="all">-Semua Bentuk-</option>';
        isihtml2 = "";
        var total = 0;
        $.each(result, function(i, result) {
          total++;
          // if (result=='-Semua Bentuk-')
          // result = "all";
          isihtml2 = isihtml2 + "<option value='" + result + "'>" + result + "</option>";
        });
        if (total == 1) {
          isihtml1 = '<select class="combobox1" id="bentuk_pendidikan" name="bentuk_pendidikan">';
        }
        $('#dbentukpendidikan').html(isihtml1 + isihtml2 + isihtml3);
      }
    });
  }
</script>
<?= $this->endSection() ?>