


<!-- Bisa ditambah daftar pengajuan terbaru di bawahnya -->
 <div class="container-fluid">
<style>
    /* Tombol */
    .btn-custom {
        background-color: #4a4a4a; 
        color: white;
        border: none;
    }
    .btn-custom:hover {
        background-color: #333;
        color: white;
    }

    /* Header tabel */
    .table thead {
        background-color: #f5f5f5;
        color: #333;
    }

    /* Border tabel */
    .table-bordered th, .table-bordered td {
        border-color: #ddd;
    }

    /* Aksi tombol download */
    .btn-download {
        background-color: #4a4a4a;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 14px;
    }
    .btn-download:hover {
        background-color: #333;
        color: white;
    }
</style>
<!-- Daftar Dokumen Terbaru -->
<div class="container mt-4">
    <div class="card shadow-sm mb-3">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <span>Daftar Pengajuan</span>       
        <div class="btn-group d-flex justify-content-center" role="group" style="gap:6px;">
        <a href="<?= base_url('admin/download_pdf'); ?>" class="btn btn-danger btn-sm me-2">
                            <i class="bi bi-file-earmark-pdf-fill"></i> PDF </a> 
        <a href="<?= base_url('admin/download_excel'); ?>" class="btn btn-success btn-sm me-2">
                             <i class="bi bi-file-earmark-excel-fill"></i> Excel
                        </a>
        <a href="<?= base_url('admin/cetak'); ?>" class="btn btn-custom btn-sm ">
            <i class="fas fa-print"></i> Cetak
        </a></div>
</div>
       <table class="table table-bordered">
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
            <td><?= $i + 1; ?></td>
            <td><?= htmlspecialchars($row['nama']); ?></td>
            <td><?= htmlspecialchars($row['jabatan']); ?></td>
            <td><?= htmlspecialchars($row['tempat_tujuan']); ?></td>
            <td><?= !empty($row['tgl_berangkat']) ? date('d-m-Y', strtotime($row['tgl_berangkat'])) : '-'; ?></td>
            <td><?= !empty($row['tgl_pulang']) ? date('d-m-Y', strtotime($row['tgl_pulang'])) : '-'; ?></td>
            <td><?= ucfirst($row['status'] ?? '-'); ?>
                <form action="<?= base_url('admin/updateStatus/'.$row['id']); ?>" method="post" class="d-flex">
                    <select name="status" class="form-control form-control-sm">
                        <option value="">-- Pilih Status --</option>
                        <option value="diproses">Diproses</option>
                        <option value="disetujui">Disetujui</option>
                        <option value="ditolak">Ditolak</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-primary ml-2">Update</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
<?php else : ?>
    <tr>
        <td colspan="8" class="text-center">Tidak ada pengajuan</td>
    </tr>
<?php endif; ?>
</tbody>

</table>
