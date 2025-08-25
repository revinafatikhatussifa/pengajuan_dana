<style>
    /* Styling khusus tabel */
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
        border-radius: 50px;
        padding: 4px 10px;
    }
</style>

<div class="container-fluid">
        <div class="table-responsive">
            <table class="table table-striped table-hover table-custom">
                <thead>
                    <tr>
                        <th style="width:5%;">No</th>
                        <th style="width:20%;">Nama</th>
                        <th style="width:25%;">Dokumen</th>
                        <th style="width:20%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!empty($dokumen)) : ?>
                    <?php $no = 1; foreach ($dokumen as $row) : ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $row['name']; ?></td>
                        <td>
                            <a href="<?= base_url('uploads/'.$row['file_url']); ?>" target="_blank" class="text-decoration-none">
                                <i class="fas fa-paperclip me-1 text-secondary"></i> <?= $row['file_url']; ?>
                            </a>
                        </td>
                        <td class="text-center">
                            <div class="btn-group d-flex justify-content-center" role="group" style="gap:6px;">
                                <a href="<?= base_url($row['file_url']); ?>" target="_blank" 
                                   class="btn btn-sm btn-info" title="Lihat">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?= base_url($row['file_url']); ?>" download 
                                   class="btn btn-sm btn-success" title="Download">
                                    <i class="fas fa-download"></i>
                                </a>
                                <a href="<?= base_url('admin/delete_dokumen/'.$row['id']); ?>" 
                                   class="btn btn-sm btn-danger btn-delete" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="4" class="text-center text-muted">Belum ada dokumen yang diupload</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
