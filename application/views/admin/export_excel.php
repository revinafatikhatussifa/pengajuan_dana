<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=laporan_pengajuan.xls");
?>

<table border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Nama</th>
            <th>Keterangan</th>
            <th>Jumlah (Rp)</th>
        </tr>
    </thead>
    <tbody>
        <?php $no=1; foreach($laporan as $row): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= date('d-m-Y', strtotime($row->created_at)) ?></td>
            <td><?= $row->nama_user ?></td>
            <td><?= $row->keterangan ?></td>
            <td><?= number_format($row->jumlah,0,',','.') ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
