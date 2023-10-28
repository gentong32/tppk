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
    <h5>TPPK dan Satuan Tugas</h5>
    <h6><?= $tglsekarang ?><h6>
  </div>

  <div class="row">
    <div class="chartbox">
      <h5>Persentase TPPK</h5>
      <div id="chart1"></div>
    </div>
  </div>
  <div class="row">
    <div class="chartbox">
      <h5>Persentase Satuan Tugas</h5>
      <div id="chart2"></div>
    </div>
  </div>

</div>
<?= $this->endSection() ?>

<?= $this->section('scriptfooter') ?>
<script>
  var options = {};
  var options2 = {};
  var data = {};
  data[1] = [<?= $persen_tppk ?>, <?= $persen_sp ?>];
  data[2] = [<?= 0.00 ?>, <?= 100 ?>];

  options = {
    series: data[1],
    chart: {
      width: 300,
      type: 'donut',
    },
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
    labels: ['Jumlah TPPK', 'Satuan Pendidikan'],
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


  options2 = {
    series: data[2],
    chart: {
      width: 300,
      type: 'donut',
    },
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
    labels: ['Jumlah Satgas', 'Kab/Kota'],
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

  var chart2 = new ApexCharts(document.querySelector("#chart2"), options2);
  chart2.render();
</script>
<?= $this->endSection() ?>