<div class="container-fluid">

    <!-- Page Heading -->
   

    <div class="row">
        <!-- Total -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Pengajuan</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total; ?></div>
                </div>
            </div>
        </div>

        <!-- Diproses -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Diproses</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $proses; ?></div>
                </div>
            </div>
        </div>

        <!-- Disetujui -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Disetujui</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $setuju; ?></div>
                </div>
            </div>
        </div>

        <!-- Ditolak -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Ditolak</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $tolak; ?></div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="container-fluid">
    <a href="<?= base_url('pengajuan/add'); ?>" class="btn btn-info mb-4 mt-4">Buat Pengajuan</a>

    <h5>Pengajuan</h5>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
    <thead class="thead-light">
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">Nama</th>
            <th class="text-center">Jabatan</th>
            <th class="text-center">Tempat Tujuan</th>
            <th class="text-center" >Tanggal Berangkat</th>
            <th class="text-center">Tanggal Pulang</th>
            <th class="text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($pengajuan)): ?>
            <?php foreach ($pengajuan as $i => $p): ?>
            <tr class="text-center">
                <td><?= $i + 1; ?></td>
                <td><?= htmlspecialchars($p['nama'] ?? ''); ?></td>
                <td><?= htmlspecialchars($p['jabatan'] ?? ''); ?></td>
                <td><?= htmlspecialchars($p['tempat_tujuan'] ?? ''); ?></td>
                <td>
                <?= !empty($p['tgl_berangkat']) ? date('d-m-Y', strtotime($p['tgl_berangkat'])) : '-'; ?></td>
                <td>
                <?= !empty($p['tgl_pulang']) ? date('d-m-Y', strtotime($p['tgl_pulang'])) : '-'; ?></td>
                
                <td class="text-center">
                    <a href="<?= base_url('user/detail/' . $p['id']); ?>"title="Detail" class="mx-1">
                    <i class="fas fa-info-circle" style="color: #1853e8ff; font-size: 18px;"></i></a>
        
                    <a href="javascript:void(0);" class="btn-hapus mx-1" data-id="<?= $p['id']; ?>" title="Hapus">
                    <i class="fas fa-trash" style="color: #b80f0f; font-size: 18px;"></i></a>

               </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" class="text-center">Belum ada pengajuan</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
$(document).ready(function() {
    $('.btn-hapus').on('click', function() {
        var id = $(this).data('id');
        var url = $(this).data('url');

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect ke controller hapus
                window.location.href = "<?= base_url('user/hapus/'); ?>" + id;
            }
        });
    });
});
</script>


    
