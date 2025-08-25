<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-info text-white">
            <h4 class="mb-0">Detail Pengajuan</h4>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Nama Pengaju:</div>
                <div class="col-md-8"><?= htmlspecialchars($pengajuan['nama'] ?? '-'); ?></div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Tempat Tujuan:</div>
                <div class="col-md-8"><?= htmlspecialchars($pengajuan['tempat_tujuan'] ?? '-'); ?></div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Tanggal Berangkat:</div>
                <div class="col-md-8">
                    <?= !empty($pengajuan['tgl_berangkat']) ? date('d-m-Y', strtotime($pengajuan['tgl_berangkat'])) : '-'; ?>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Tanggal Pulang:</div>
                <div class="col-md-8">
                    <?= !empty($pengajuan['tgl_pulang']) ? date('d-m-Y', strtotime($pengajuan['tgl_pulang'])) : '-'; ?>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Status:</div>
                <div class="col-md-8">
                    <?php 
                        $status = $pengajuan['status'] ?? '-';
                        $badge = 'secondary';
                        if ($status == 'Terkirim') $badge = 'warning';
                        if ($status == 'approved') $badge = 'success';
                        if ($status == 'rejected') $badge = 'danger';
                    ?>
                    <span class="badge bg-<?= $badge; ?>"><?= ucfirst($status); ?></span>
                </div>
            </div>
            <?php if(!empty($pengajuan['dokumen'])): ?>
            <div class="row">
                <div class="col-md-4 fw-bold">Dokumen:</div>
                <div class="col-md-8">
                    <a href="<?= base_url($pengajuan['dokumen']); ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-file-alt me-1"></i>Lihat Dokumen
                    </a>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <div class="card-footer text-end">
            <a href="<?= base_url('user'); ?>" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>
</div>
