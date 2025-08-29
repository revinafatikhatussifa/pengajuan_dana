<!DOCTYPE html>
<html>
<head>
    <title>Cetak Data Pengajuan</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid #000;
            padding: 6px;
        }
        th {
            background: #f5f5f5;
        }
    </style>
</head>
<body onload="window.print()">

<h2 style="text-align:center;">Laporan Daftar Pengajuan</h2>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Jabatan</th>
            <th>Tempat Tujuan</th>
            <th>Tgl Berangkat</th>
            <th>Tgl Pulang</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($pengajuan)) : ?>
            <?php foreach ($pengajuan as $i => $row) : ?>
                <tr>
                    <td><?= $i+1 ?></td>
                    <td><?= htmlspecialchars($row['nama']); ?></td>
                    <td><?= htmlspecialchars($row['jabatan']); ?></td>
                    <td><?= htmlspecialchars($row['tempat_tujuan']); ?></td>
                    <td><?= !empty($row['tgl_berangkat']) ? date('d-m-Y', strtotime($row['tgl_berangkat'])) : '-'; ?></td>
                    <td><?= !empty($row['tgl_pulang']) ? date('d-m-Y', strtotime($row['tgl_pulang'])) : '-'; ?></td>
                    <td><?= ucfirst($row['status'] ?? '-'); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="7" style="text-align:center;">Tidak ada data pengajuan</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>
