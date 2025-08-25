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
<!-- Rincian -->
<style>
    .table-custom {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    }
    .table-custom thead {
        background: linear-gradient(90deg, #3ddec8, #2C3E50);
        color: #fff;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .table-custom tbody tr:hover {
        background: #f5f9ff;
        transition: 0.3s;
    }
    .btn-sm {
        border-radius: 20px;
        padding: 4px 12px;
    }
</style>

<div class="table-responsive">
    <table class="table table-striped table-hover table-custom">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Tanggal</th>
                <th>Jumlah</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($rincian)) : ?>
                <?php $no = 1; foreach($rincian as $r) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $r['nama_user'] ?? '-' ?></td>
                    <td><?= !empty($r['created_at']) ? date('d-m-Y', strtotime($r['created_at'])) : '-' ?></td>
                    <td><?= isset($r['jumlah']) ? number_format($r['jumlah'],0,',','.') : '0' ?></td>
                    <td>
                        <a href="<?= base_url('admin/detrinci/'.($r['nama_user'] ?? '')) ?>" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i> Lihat
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center text-muted">Data tidak tersedia</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

