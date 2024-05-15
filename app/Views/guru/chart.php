<?= $this->extend('guru/base'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid px-4">
  <h1 class="mt-4 text-white">Grafik Hafalan Siswa</h1>
  <ol class="breadcrumb mb-4">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#pilih">Pilih Siswa</button>
  </ol>
  <div class="card mb-4" style="width: 70rem; margin: 0 auto;">
    <div class="card-body" id="chartParent">
      <canvas id="chart"></canvas>
    </div>
  </div>
</div>

<div class="modal fade" id="pilih" tabindex="-1" aria-labelledby="pilihLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-success">
        <h5 class="modal-title text-white" id="pilihLabel">Pilih Siswa</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3 " id="surahParent">
          <label for="siswa" class="form-label">Pilih Siswa</label>
          <select class="select2-chart form-control col-12" style="width: 100%;" id="siswa">
            <?php foreach ($data as $siswa) : ?>
              <option value="<?= $siswa['id_siswa']; ?>"><?= $siswa['nama_siswa'] . ' : NISN ' . $siswa['nisn']; ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" data-bs-dismiss="modal" onclick="getSelectData()">Tampilkan</button>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>

<script>
  const ctx = document.getElementById('chart');

  let chart;
  let chartStatus = Chart.getChart('chart');

  let labels = [];
  let dataSets = [];
  let namaSiswa = '';

  document.addEventListener('DOMContentLoaded', function() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/GuruPanel/Chart/Random', true);
    xhr.onload = function() {
      if (xhr.status >= 200 && xhr.status < 400) {
        console.log(JSON.parse(xhr.responseText));
        const data = JSON.parse(xhr.responseText);

        generateChart(data['label'], data['datasets'], data['nama_siswa']);
      } else {
        console.log('Request failed. Returned status of ' + xhr.status);
      }
    };
    xhr.onerror = function() {
      console.log('Request failed');
    };
    xhr.send();
  });

  function getSelectData() {
    let siswa = document.getElementById('siswa');
    let selectedSiswa = siswa.options[siswa.selectedIndex].value;
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/GuruPanel/Chart/Select/' + selectedSiswa, true);
    xhr.onload = function() {
      if (xhr.status >= 200 && xhr.status < 400) {
        console.log(JSON.parse(xhr.responseText));
        const data = JSON.parse(xhr.responseText);

        chart.destroy();

        generateChart(data['label'], data['datasets'], data['nama_siswa']);
      } else {
        console.log('Request failed. Returned status of ' + xhr.status);
      }
    };
    xhr.onerror = function() {
      console.log('Request failed');
    }
    xhr.send();
  }

  function generateChart(labels = [], dataSets = [], namaSiswa = '') {
    const randomColor = '#' + Math.floor(Math.random() * 16777215).toString(16);
    let colors = [];

    console.log(dataSets);

    labels.forEach(element => {
      colors.push(randomColor);
    });

    const data = {
      labels: labels,
      datasets: dataSets
    };

    const config = {
      type: 'line',
      data: data,
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'top',
          },
          title: {
            display: true,
            text: `Grafik Hafalan ${namaSiswa}`,
            font: {
              size: 20
            }
          }
        }
      },
    };

    chart = new Chart(ctx, config);
  }
</script>

<?= $this->endSection(); ?>