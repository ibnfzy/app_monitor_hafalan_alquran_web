<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>REKAP NILAI</title>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js' integrity='sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==' crossorigin='anonymous'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js' integrity='sha512-qZvrmS2ekKPF2mSznTQsxqPgnpkI4DNTlrdUmTzrDgektczlKNRRhy5X5AAOnx5S09ydFYWWNSfcEqDTTHgtNA==' crossorigin='anonymous'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.min.js' integrity='sha512-2/YdOMV+YNpanLCF5MdQwaoFRVbTmrJ4u4EpqS/USXAQNUDgI5uwYi6J98WVtJKcfe1AbgerygzDFToxAlOGEQ==' crossorigin='anonymous'></script>
</head>

<body>
  <table id="informasi">
    <tr>
      <td>Nama</td>
      <td>: IBNU</td>
      <td>Musyrifah</td>
      <td>: Siti Raoda, S.Pd</td>
    </tr>
    <tr>
      <td>Kelas</td>
      <td>: 3</td>
      <td>Semester</td>
      <td>: 1</td>
    </tr>
    <tr>
      <td>Halaqoh</td>
      <td>: 6 (Zaid Bin Tsabit)</td>
      <td>Tahun Ajaran</td>
      <td>: 2023/2024</td>
    </tr>
  </table>

  <table id="table-1">
    <thead>
      <tr>
        <th>No</th>
        <th>Aspek</th>
        <th>Prestasi</th>
        <th>Keterangan</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>1</td>
        <td>Adab dalam Halaqoh</td>
        <td>A</td>
        <td>Sangat Baik</td>
      </tr>
      <tr>
        <td>2</td>
        <td>Tahsin (Perbaikan Bacaan)</td>
        <td>A</td>
        <td>Sangat Baik</td>
      </tr>
      <tr>
        <td>3</td>
        <td>Tahfidz (Hafalan)</td>
        <td>A</td>
        <td>Sangat Baik</td>
      </tr>
      <tr>
        <td>4</td>
        <td>Murajaah (Mengulang Hafalan)</td>
        <td>A</td>
        <td>Sangat Baik</td>
      </tr>
    </tbody>
  </table>

  <table id="table-2">
    <thead>
      <tr>
        <th>No</th>
        <th>Ujian</th>
        <th>Angka</th>
        <th>Keterangan</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>1</td>
        <td>Ujian Tengah Semester (UTS)</td>
        <td>82</td>
        <td>Memuaskan </td>
      </tr>
      <tr>
        <td>2</td>
        <td>Tahsin (Perbaikan Bacaan)</td>
        <td>83</td>
        <td>Memuaskan </td>
      </tr>
    </tbody>
  </table>

  <table id="absensi">
    <thead>
      <tr>
        <th>Absensi</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Sakit : 0</td>
      </tr>
      <tr>
        <td>Izin : 0</td>
      </tr>
      <tr>
        <td>Alpa : 0</td>
      </tr>
    </tbody>
  </table>

  <script>
    var doc = new jspdf.jsPDF();
    let suratdate = '<?= date('d F Y') ?>';
    const d = new Date()
    const months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September",
      "Oktober",
      "November", "Desember"
    ];
    let month = months[d.getMonth()];
    let fulldate = d.getDate() + ' ' + month + ' ' + d.getFullYear();

    doc.setProperties({
      title: 'Rekap Nilai',
      subject: 'Rekap Nilai',
      author: 'SDIT BOMBANG TALLUNA BIRA',
      keywords: 'Rekap Nilai',
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
    doc.text('Jln. Salodong No. 46 RT.F/RW.01 No. Telp : 0852–4273–4766/0821–9040–0050', 100, 35, 'center');

    doc.line(25, 39, 180, 39)
    doc.setFontSize(12)

    let lastFinalY = 0

    doc.autoTable({
      html: '#informasi',
      margin: {
        top: 45
      },
      autoPaging: 'text',
      theme: 'plain'
    })

    lastFinalY += doc.lastAutoTable.finalY

    doc.autoTable({
      html: '#table-1',
      margin: {
        top: lastFinalY + 15
      },
      autoPaging: 'text',
      theme: 'grid',
      styles: {
        lineColor: [0, 0, 0],
      },
      headStyles: {
        fillColor: [0, 0, 0],
        textColor: [255, 225, 225],
        lineColor: [0, 0, 0],
      }
    })

    lastFinalY += doc.lastAutoTable.finalY

    doc.autoTable({
      html: '#table-2',
      margin: {
        top: lastFinalY + 15
      },
      autoPaging: 'text',
      theme: 'grid',
      styles: {
        lineColor: [0, 0, 0],
      },
      headStyles: {
        fillColor: [0, 0, 0],
        textColor: [255, 225, 225],
        lineColor: [0, 0, 0],
      }
    });

    doc.autoTable({
      head: [
        ['Keterangan Tambahan']
      ],
      body: [
        [
          'Alhamdulillah ananda Yusuf  Telah malaksanakan ujian akhir semester 1 dengan predikat Memuaskan. Kehadiran dalam halaqah mohon diperhatikan kembali dan mohon hafalan yang sudah dihafalkan ditingkatkan murajaahnya dirumah  agar hafalan  tetap terjaga. Barakallahu Fiikum.',
        ]
      ],
      styles: {
        cellWidth: 70,
        lineColor: [0, 0, 0],
      },
      theme: 'grid',
      headStyles: {
        fillColor: [0, 0, 0],
        textColor: [255, 225, 225],
        lineColor: [0, 0, 0],
      },
      startY: 150,
      margin: {
        right: 107
      },
    })

    doc.autoTable({
      html: '#absensi',
      styles: {
        cellWidth: 70,
        lineColor: [0, 0, 0],
      },
      theme: 'grid',
      headStyles: {
        fillColor: [0, 0, 0],
        textColor: [255, 225, 225],
        lineColor: [0, 0, 0],
      },
      startY: 150,
      margin: {
        left: 127
      },
    })

    doc.setFont('helvetica', 'normal')
    doc.text(`Diberikan di: Makassar, ${fulldate}`, 125, doc.lastAutoTable.finalY + 10, 'left');

    doc.text('Mengetahui', 85, doc.lastAutoTable.finalY + 23, 'left');

    doc.setFont('helvetica', 'normal')
    doc.text('Musyrifah Tahfidz', 28, doc.lastAutoTable.finalY + 40, 'left');
    doc.setFont('helvetica', 'bold')
    doc.text('Siti Raoda, S.Pd', 27, doc.lastAutoTable.finalY + 55, 'left');
    let textWidth = doc.getTextWidth('Siti Raoda, S.Pd');
    doc.line(27, doc.lastAutoTable.finalY + 57, 27 + textWidth, doc.lastAutoTable.finalY + 57);

    doc.setFont('helvetica', 'normal')
    doc.text('Orang Tua/Wali Siswa', 80, doc.lastAutoTable.finalY + 40, 'left');
    doc.setFont('helvetica', 'bold')
    doc.text('.....................................', 80, doc.lastAutoTable.finalY + 55, 'left');
    textWidth = doc.getTextWidth('.....................................');
    doc.line(80, doc.lastAutoTable.finalY + 57, 80 + textWidth, doc.lastAutoTable.finalY + 57);

    doc.setFont('helvetica', 'normal')
    doc.text('Kepala Sekolah', 140, doc.lastAutoTable.finalY + 40, 'left');
    doc.setFont('helvetica', 'bold')
    doc.text('Juminah, S.Pd.I M.Pd', 140, doc.lastAutoTable.finalY + 55, 'left');
    textWidth = doc.getTextWidth('Juminah, S.Pd.I M.Pd');
    doc.line(140, doc.lastAutoTable.finalY + 57, 140 + textWidth, doc.lastAutoTable.finalY + 57);

    var string = doc.output('bloburi');
    var iframe =
      "<iframe style='position: fixed; top: 0; left: 0; width: 100%; height: 100%; border: none;' src='" +
      string + "'></iframe>";
    document.body.innerHTML = iframe;
  </script>
</body>

</html>