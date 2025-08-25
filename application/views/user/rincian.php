    <div class="container-fluid">
    <form action="<?= base_url('user/rincian'); ?>" method="post" enctype="multipart/form-data">
    <a href="<?= base_url('pengajuan/rinci'); ?>" class="btn btn-outline-primary mb-3">
        <i class="bi bi-plus-circle"></i> Add Rincian
    </a>
    </form>


    <form action="<?= base_url('user/upload'); ?>" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="uploadDokumen" class="form-label fw-bold">Upload Dokumen</label>
        <input class="form-control" type="file" id="uploadDokumen" name="dokumen" required>
    </div>

    <button type="submit" class="btn btn-success w-100">
        <i class="bi bi-send-fill"></i> Kirim
    </button>
</form>
<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if ($this->session->flashdata('success')): ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil',
    text: '<?= $this->session->flashdata('success'); ?>',
    timer: 2500,
    showConfirmButton: false
})
</script>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
<script>
Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: '<?= $this->session->flashdata('error'); ?>'
})
</script>
<?php endif; ?>



<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">


