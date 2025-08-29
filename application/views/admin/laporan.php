
<div class="container my-4">
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-file-alt me-2"></i> Laporan Harian Total Pengajuan</h4>
            <div>
                <div class="card shadow-sm border-0 p-2 mb-3">
    <form action="<?= base_url('admin/cetak_by_nama'); ?>" method="get" target="_blank" class="d-flex align-items-center gap-2">
        <label for="nama" class="fw-bold mb-0 me-2">Nama:</label>
        <input type="text" id="nama" name="nama" class="form-control form-control-sm w-auto" placeholder="Masukkan Nama" required>
        
        <button type="submit" class="btn btn-dark btn-sm shadow-sm">
            <i class="fa fa-print me-1"></i> Cetak
        </button>
    </form>
</div>


            </div>
        </div>

        <div class="card-body">
            <!-- Filter Form -->
            <form method="get" class="row g-3 mb-4">
                <div class="col-md-3">
                    <label class="form-label fw-bold">Tanggal Awal</label>
                    <input type="date" name="tanggal_awal" class="form-control" value="<?= $tanggal_awal ?? '' ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Tanggal Akhir</label>
                    <input type="date" name="tanggal_akhir" class="form-control" value="<?= $tanggal_akhir ?? '' ?>">
                </div>
                <div class="col-md-3 align-self-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                    </button>
                    <button id="btnExportExcelFilter" type="button" class="btn btn-success me-2">
                    <i class="fas fa-file-excel"></i>
                </button>
                <button id="btnExportPDF" class="btn btn-danger">
                    <i class="fas fa-file-pdf"></i>
                </button>
                </div>
            </div>
        </div>
            </form>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-dark">
                        <tr class="text-center">
                            <th style="width:5%;">No</th>
                            <th style="width:15%;">Tanggal</th>
                            <th style="width:20%;">Nama</th>
                            <th>Keterangan</th>
                            <th style="width:20%;">Jumlah (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php if(!empty($laporan)): ?>
        <?php $no=1; foreach($laporan as $row): ?>
        <tr>
            <td class="text-center"><?= $no++ ?></td>
            <td><?= !empty($row->created_at) ? date('d-m-Y', strtotime($row->created_at)) : '-' ?></td>
            <td><?= $row->nama_user ?? '-' ?></td>
            <td><?= $row->keterangan ?></td>
            <td class="text-end"><?= number_format($row->jumlah,0,',','.') ?></td>
        </tr>
        <?php endforeach; ?>
        <tr class="fw-bold bg-light">
            <td colspan="4" class="text-end">TOTAL</td>
            <td class="text-end"><?= number_format($total,0,',','.') ?></td>
        </tr>
    <?php else: ?>
        <tr>
            <td colspan="5" class="text-center text-muted">Tidak ada data pada rentang tanggal ini</td>
        </tr>
    <?php endif; ?>
</tbody>

                </table>
            </div>
        </div>
    </div>
</div>
<script>
document.getElementById('btnExportExcelFilter').addEventListener('click', function() {
    // ambil nilai input date filter
    let tglAwal = document.querySelector('input[name="tanggal_awal"]').value;
    let tglAkhir = document.querySelector('input[name="tanggal_akhir"]').value;

    if (!tglAwal || !tglAkhir) {
        alert("Silakan pilih tanggal awal dan tanggal akhir terlebih dahulu!");
        return;
    }

    // arahkan ke controller dengan query string
    window.location.href = "<?= base_url('laporan/export_excel') ?>?tanggal_awal=" + tglAwal + "&tanggal_akhir=" + tglAkhir;
});
</script>

<script>
document.getElementById('btnExportPDFFilter').addEventListener('click', function() {
    let tglAwal = document.querySelector('input[name="tanggal_awal"]').value;
    let tglAkhir = document.querySelector('input[name="tanggal_akhir"]').value;

    if(!tglAwal || !tglAkhir){
        alert("Silakan pilih tanggal awal dan tanggal akhir terlebih dahulu!");
        return;
    }

    window.location.href = "<?= base_url('laporan/export_pdf') ?>?tanggal_awal=" + tglAwal + "&tanggal_akhir=" + tglAkhir;
});
</script>




