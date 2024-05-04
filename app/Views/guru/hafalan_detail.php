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
        <th>No</th>
        <th>Tanggal</th>
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
            <?= $item['nama_surah']; ?>
          </td>
          <td>
            <?= $item['ayat']; ?>
          </td>
          <td>
            <?= ucwords($item['keterangan']); ?>
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
      doc.setFontSize(17)
      doc.text('HAFALAN SISWA', 110, 10, 'center');
      doc.text('SDIT BOMBANG TALLUNA BIRA', 110, 17, 'center');

      doc.line(30, 20, 180, 20);

      doc.rect(30, 25, 80, 20);

      doc.setFontSize(8)
      doc.text("Nama Siswa : <?= $dataSiswa['nama_siswa']; ?>", 32, 33)
      doc.text("NIS      : <?= $dataSiswa['nis']; ?>", 32, 36)
      doc.text("Kelas   : <?= $dataSiswa['kelas']; ?>",
        32, 39)

      doc.autoTable({
        html: '#datatable',
        margin: {
          top: 50
        },
        autoPaging: 'text',
        cellWidth: 'auto'
      })

      var finalY = doc.lastAutoTable.finalY

      doc.setFontSize(12)
      doc.text('Makassar, ' + fulldate, 140, finalY + 20)
      doc.text('<?= $dataGuru['nama_guru']; ?>', 140, finalY + 35)

      var string = doc.output('datauristring', 'laporan.pdf');
      var iframe = "<iframe width='100%' height='100%' src='" + string + "'></iframe>"
      window.document.open();
      window.document.write(iframe);
      window.document.close();
    });
  </script>

</body>

</html>