<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Harian</title>
    <style>
        table {width: 100%; border-collapse: collapse; margin-top:20px;}
        table, th, td {border:1px solid black; padding:5px;}
    </style>
</head>
<body>
    <h3>Laporan Pengajuan Dana Tanggal <?= $tanggal ?></h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama User</th>
                <th>Uraian</th>
                <th>Satuan</th>
                <th>Nominal</th>
                <th>Jumlah</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
        <?php 
        $no=1; $total=0;
        foreach($rincian as $r): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $r['nama'] ?></td>
                <td><?= $r['uraian'] ?></td>
                <td><?= $r['satuan'] ?></td>
                <td><?= number_format($r['nominal'],0,',','.') ?></td>
                <td><?= number_format($r['jumlah'],0,',','.') ?></td>
                <td><?= $r['created_at'] ?></td>
            </tr>
        <?php $total += $r['jumlah']; endforeach; ?>
            <tr>
                <td colspan="5" align="right"><strong>Total</strong></td>
                <td colspan="2"><strong>Rp <?= number_format($total,0,',','.') ?></strong></td>
            </tr>
        </tbody>
    </table>
</body>
</html>
