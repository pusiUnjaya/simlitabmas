<?php
function indo_date($date)
{
    $date = date('Y-m-d', strtotime($date));
    $ms = [
        1 => 'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    ];
    $d = +substr($date, 8, 2);
    $m = $ms[+substr($date, 5, 2)];
    $y = +substr($date, 0, 4);
    return "$d $m $y";
}
$jenis = $jenis == 'lit' ? 'Penelitian' : 'Pengabdian kepada Masyarakat';
?>
<html>

<head>
    <title>Surat Izin Penelitian atau Pengambdian kepada Masyarakat</title>
    <style>
        body {
            font-family: "Times New Roman";
            font-size: 12pt;
            text-align: justify;
            text-justify: inter-word;
        }

        .main {
            margin-top: 10px;
            margin-left: 1.24cm;
            margin-right: 1.24cm;
        }

        .no-break {
            break-inside: avoid;
            page-break-inside: avoid;
        }

        .no-break-after {
            break-after: avoid;
            page-break-after: avoid;
        }
    </style>
</head>

<body>
    <img style="margin-top:-20px" width="100%" src="<?php FCPATH . 'assets/img/kop.png' ?>">
    <div class="main">
        <table width="100%">
            <tr>
                <td>Nomor</td>
                <td> : </td>
                <td><?php echo $nomor ?></td>
                <td></td>
                <td align="right">Yogyakarta, <?php echo indo_date($tanggal) ?></td>
            </tr>
            <tr>
                <td>Lampiran</td>
                <td> : </td>
                <td> - </td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Perihal</td>
                <td> : </td>
                <td>Izin <?php echo $jenis ?></td>
                <td></td>
                <td>Kepada</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td align="right" valign="top">Yth. </td>
                <td><?php echo nl2br($tertuju) ?><br>di<br><?php echo $tempat ?></td>
            </tr>
        </table>
        <p>Dengan hormat,</p>
        <p>Melalui surat ini kami memberitahukan bahwa dosen Program Studi <?php echo $prodi ?>
            Universitas Jenderal Achmad Yani Yogyakarta, akan melakukan <?php echo strtolower($jenis) ?>
            dalam rangka memenuhi tugas Tridharma Perguruan Tinggi. Sehubungan dengan hal tersebut
            kami mengajukan permohonan izin <?php echo strtolower($jenis) ?> di <?php echo $lokasi ?>.
            Dosen kami yang akan mengambil data tersebut adalah:
        </p>
        <table>
            <tr>
                <td valign="top" width="20%">Nama</td>
                <td valign="top"> : </td>
                <td align="justify" width="80%"><?php echo $dosen ?></td>
            </tr>
            <tr>
                <td valign="top">NIDN/NPP</td>
                <td valign="top"> : </td>
                <td align="justify"><?php echo $nidn ?></td>
            </tr>
            <tr>
                <td valign="top">Judul <?php echo $jenis ?></td>
                <td valign="top"> : </td>
                <td align="justify"><?php echo $judul ?></td>
            </tr>
        </table>
        <p>Atas ijin dan kerjasamanya kami ucapkan terima kasih.</p>
        <div class="no-break" style="text-align: center; margin-left: 50%; margin-top: 2cm;">
            <p>Kepala LPPM</p>
            <img style="margin-top:-10;margin-left:-60;z-index:99" width="130" src="<?php echo base_url('assets/img/stempel.png') ?>">
            <img style="position:absolute;margin-left:40;z-index:-1" width="110" src="<?php echo base_url('assets/img/ttd.png') ?>">
            <p style="margin-top:-40;">Dr. Bdn. Tri Sunarsih, SST., M.Kes. </p>
        </div>
    </div>
</body>

</html>