<!DOCTYPE html>
<html>
<head>
    <title>Formulir Pengajuan Dana</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
            margin: 40px 60px;
            color: #000;
            position: relative;
        }

        /* Watermark ringan */
        body::before {
            content: "";
            position: fixed;
            top: 40%;
            left: 25%;
            width: 50%;
            height: 50%;
            background: url('logo.png') no-repeat center;
            background-size: contain;
            opacity: 0.05;
            z-index: -1;
        }

        /* Kop surat */
        .kop {
            text-align: center;
            margin-bottom: 10px;
        }

        .kop img {
            height: 80px;
            float: left;
            margin-right: 20px;
        }

        .kop h2, .kop h3 {
            margin: 0;
            line-height: 1.2;
        }

        .kop p {
            margin: 0;
            font-size: 10pt;
        }

        .line {
            border-top: 3px double #000;
            margin-bottom: 20px;
        }

        h3.title {
            text-align: center;
            text-transform: uppercase;
            margin-bottom: 5px;
            font-size: 14pt;
        }

        h4.subtitle {
            text-align: center;
            margin-bottom: 20px;
            font-size: 12pt;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #000;
        }

        th, td {
            padding: 8px 10px;
        }

        th {
            background-color: #f0f0f0;
            text-align: center;
        }

        td.center { text-align: center; }
        td.right { text-align: right; }

        .no-border td { border: none; padding: 4px 8px; }

        .signature td { vertical-align: top; padding-top: 50px; }

        @media print {
            body { margin: 0; }
            .btn, .navbar, .sidebar, footer { display: none !important; }
        }
    </style>
</head>
<body onload="window.print()">

<!-- Kop surat -->
<div class="kop">
   <img src="<?= base_url('assets/img/profile/logo.pt.png'); ?>" alt="Logo Instansi">
    <h2>PT. INDO TECHNO MEDIC</h2>
    <h3>Dapertemen Operasional</h3>
    <p>Alamat: Jl. Menayu Lor, Menayu Lor, Tirtonirmolo, Kec. Kasihan, Bantul, Daerah Istimewa Yogyakarta 55184, Telp: +62 856 4158 4013, Email: info@technomedic.id</p>
</div>
<div class="line"></div>

<h3 class="title">Formulir Pengajuan Dana Operasional</h3>
<h4 class="subtitle">Tugas Luar Kota</h4>

<!-- Informasi Pengajuan -->
<table class="no-border">
    <tr>
        <td><b>Nama</b></td>
        <td>: <?= $pengajuan['nama'] ?? '-' ?></td>
        <td><b>Jabatan</b></td>
        <td>: <?= $pengajuan['jabatan'] ?? '-' ?></td>
    </tr>
    <tr>
        <td><b>Tempat Tujuan</b></td>
        <td>: <?= $pengajuan['tempat_tujuan'] ?? '-' ?></td>
        <td><b>Tgl Berangkat</b></td>
        <td>: <?= $pengajuan['tgl_berangkat'] ?? '-' ?></td>
    </tr>
    <tr>
        <td><b>Tgl Pulang</b></td>
        <td>: <?= $pengajuan['tgl_pulang'] ?? '-' ?></td>
        <td></td>
        <td></td>
    </tr>
</table>

<!-- Rincian Biaya -->
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Keterangan</th>
            <th>Banyak</th>
            <th>Satuan</th>
            <th>Nominal (Rp)</th>
            <th>Jumlah (Rp)</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $no = 1; 
        $total = 0;
        foreach($rincian as $r): 
            $total += $r['jumlah'];
        ?>
        <tr>
            <td class="center"><?= $no++; ?></td>
            <td><?= $r['keterangan']; ?></td>
            <td class="center"><?= $r['banyak']; ?></td>
            <td class="center"><?= $r['satuan']; ?></td>
            <td class="right"><?= number_format($r['nominal'],0,',','.'); ?></td>
            <td class="right"><?= number_format($r['jumlah'],0,',','.'); ?></td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="5" class="right"><b>Total Pengajuan Dana</b></td>
            <td class="right"><b><?= number_format($total,0,',','.'); ?></b></td>
        </tr>
    </tbody>
</table>

<!-- Tanda Tangan -->
<style>
.signature {
    width: 100%;
    margin-top: 50px;
    border-collapse: collapse;
    font-family: Arial, sans-serif;
}

.signature td {
    width: 50%;
    vertical-align: top;
    padding: 10px;
}

.signature .sign-box {
    height: 80px; /* tinggi kotak tanda tangan */
    border-bottom: 1px dotted #000; /* garis titik-titik */
    width: 70%; /* lebar kotak tanda tangan */
    margin-top: 30px;
}

.signature p {
    margin: 0;
    font-size: 12px;
}
</style>

<table class="signature">
    <tr>
        <td style="text-align:left;">
            <p>Tanggal pengajuan: <?= date('d F Y'); ?></p>
            <p>Yang Membuat,</p>
            <div class="sign-box"></div>
            <b><?= $this->session->userdata('nama'); ?></b><br>
            Admin
        </td>
        <td style="text-align:left;">
            <p>Disetujui,</p>
            <div class="sign-box"></div>
            <b><?= $this->session->userdata('nama'); ?></b><br>
            <b>Direktur Utama</b>
        </td>
    </tr>
</table>


</body>
</html>
