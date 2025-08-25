<div class="container">
    <div class="row mt-3">
        <div class="col-md-8 offset-md-2">

            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-primary text-white text-center">
                    <h3 class="mb-0">Detail Rincian</h3>
                </div>
                <div class="card-body">

                    <?php $no=1; foreach($rincian as $r): ?>
                    <div class="card mb-3 border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-primary mb-3">
                                <?= $no++ . ". " . htmlspecialchars($r['nama_user']); ?>
                            </h5>

                            <div class="row mb-2">
                                <div class="col-4 fw-bold">Keterangan</div>
                                <div class="col-8"><?= htmlspecialchars($r['keterangan']); ?></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4 fw-bold">Satuan</div>
                                <div class="col-8"><?= htmlspecialchars($r['satuan']); ?></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4 fw-bold">Nominal</div>
                                <div class="col-8 text-end"><?= number_format($r['nominal'],0,',','.'); ?></div>
                            </div>
                            <div class="row">
                                <div class="col-4 fw-bold">Jumlah</div>
                                <div class="col-8 text-end text-success fw-bold">
                                    <?= number_format($r['jumlah'],0,',','.'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>

                    <div class="text-end mt-3">
                        <a href="<?= base_url('admin/rincian/'); ?>mahasiswa" class="btn btn-primary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

