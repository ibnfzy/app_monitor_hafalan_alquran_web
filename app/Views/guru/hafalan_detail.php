<!DOCTYPE html>
<html lang="ar">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PDF</title>
  <script src="/node_modules/jquery/dist/jquery.min.js"></script>
  <script src="/jspdf/examples/libs/jspdf.umd.js"></script>
  <script src="/jspdf/dist/jspdf.plugin.autotable.js"></script>
</head>

<body>

  <table id="datatable" lang="ar">
    <thead>
      <tr>
        <th rowspan="2">No</th>
        <th colspan="3">Tahsin</th>
        <th>Muroja'ah</th>
        <th colspan="3">Hafalan Baru</th>
      </tr>
      <tr>
        <th>Tanggal</th>
        <th>Halaman</th>
        <th>Jilid</th>
        <th>Surah</th>
        <th>Surah</th>
        <th>Ayat</th>
        <th>Keterangan</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($data as $key => $item) : ?>
      <tr>
        <td>
          <?= $key + 1 ?>
        </td>
        <td>
          <?= $item['tanggal_input']; ?>
        </td>
        <td>
          <?= $item['ayat']; ?>
        </td>
        <td>
          <?= $item['jilid']; ?>
        </td>
        <td>
          <?php if ($item['murojaah'] == 1) : ?>
          <?= $item['nama_surah']; ?>
          <?php endif ?>
        </td>
        <td>
          <?= $item['nama_surah']; ?>
        </td>
        <td>
          <?= $item['ayat']; ?>
        </td>
        <td>
          <?= $item['keterangan']; ?>
        </td>
      </tr>
      <?php endforeach ?>
    </tbody>
  </table>

  <script>
  $(document).ready(function() {
    const d = new Date()
    const months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September",
      "Oktober",
      "November", "December"
    ];
    let month = months[d.getMonth()];
    let fulldate = d.getDate() + ' ' + month + ' ' + d.getFullYear();
    var doc = new jspdf.jsPDF();

    doc.setProperties({
      title: 'Hafalan Siswa',
      subject: 'Hafalan Siswa',
      author: 'SDIT BOMBANG TALLUNA BIRA',
      keywords: 'Hafalan Siswa',
      creator: 'SDIT BOMBANG TALLUNA BIRA',
    });
    var imgData2 = new Image();
    var imgData1 = new Image();
    imgData2.src = '<?= base_url('Gambar2.png'); ?>';
    imgData1.src = '<?= base_url('Gambar1.png'); ?>';
    imgData1.onload = function() {
      callback(imgData1)
    }
    imgData2.onload = function() {
      callback(imgData2)
    }

    doc.addImage(imgData1, 'PNG', 18, 10, 20, 20);
    doc.addImage(imgData2, 'PNG', 168, 10, 20, 20);

    doc.setFontSize(12)
    doc.text('YAYASAN BOMBANG TALLUNA BIRA', 100, 15, 'center');
    doc.setFontSize(20)
    doc.text('SDIT BOMBANG TALLUNA BIRA', 100, 23, 'center');
    doc.setFontSize(12)
    doc.text('KELURAHAN BULUROKENG KECAMATAN BIRINGKANAYA', 100, 30, 'center');
    doc.setFontSize(10)
    doc.text('Jln. Salodong No. 46 RT.F/RW.01 No. Telp : 0852-4273-4766/0821-9040-0050', 100, 35, 'center');

    doc.line(25, 39, 180, 39)
    doc.setFontSize(12)

    doc.rect(30, 25 + 18, 80, 20);

    doc.setFontSize(8)
    doc.text("Nama Siswa     : <?= $dataSiswa['nama_siswa']; ?>", 32, 33 + 18)
    doc.text("NISN                : <?= $dataSiswa['nisn']; ?>", 32, 36 + 18)
    doc.text("Kelas                : <?= $dataSiswa['kelas']; ?>",
      32, 39 + 18)

    doc.autoTable({
      html: '#datatable',
      margin: {
        top: 66
      },
      autoPaging: 'text',
      cellWidth: 'auto',
      theme: 'grid',
      styles: {
        lineColor: [0, 0, 0],
      },
      headStyles: {
        fillColor: [220, 220, 220],
        textColor: [0, 0, 0],
        lineColor: [0, 0, 0],
        lineWidth: 0.25
      }
    })

    var finalY = doc.lastAutoTable.finalY

    doc.setFontSize(12)
    doc.text('Makassar, ' + fulldate, 140, finalY + 20)
    doc.text('<?= $dataGuru['nama_guru']; ?>', 140, finalY + 35)

    var string = doc.output('bloburi');

    var iframe =
      "<iframe style='position: fixed; top: 0; left: 0; width: 100%; height: 100%; border: none;' src='" +
      string + "'></iframe>";
    document.body.innerHTML = iframe;
  });
  </script>

</body>

</html>