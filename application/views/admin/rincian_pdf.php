<h3>Detail Rincian</h3>
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama User</th>
            <th>Keterangan</th>
            <th>Satuan</th>
            <th>Nominal</th>
            <th>Jumlah</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; foreach($rincian as $r): ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($r['nama_user']); ?></td>
            <td><?= htmlspecialchars($r['keterangan']); ?></td>
            <td><?= htmlspecialchars($r['satuan']); ?></td>
            <td><?= number_format($r['nominal'],0,',','.'); ?></td>
            <td><?= number_format($r['jumlah'],0,',','.'); ?></td>
            <td><?= $r['created_at']; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
