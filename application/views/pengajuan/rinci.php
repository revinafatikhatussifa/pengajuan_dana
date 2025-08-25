<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php if($this->session->flashdata('success')): ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil',
    text: '<?= $this->session->flashdata('success'); ?>',
    confirmButtonText: 'OK'
});
</script>
<?php endif; ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    table {
        table-layout: fixed;
        min-width: 900px; /* supaya di layar kecil bisa scroll */
    }
    th, td {
        vertical-align: middle !important;
        text-align: center;
    }
    input {
        width: 100%;
        box-sizing: border-box;
        text-align: center;
    }
    td:nth-child(2),
    td:nth-child(3) {
        text-align: left;
    }
</style>
<div class="container mt-4">
    <form action="<?= base_url('user/simpanRincian'); ?>" method="post">
        <input type="hidden" name="user_id" value="<?= $user_id; ?>">

        <div class="card shadow-lg border-0 mb-3 rounded-3">
            <div class="card-header bg-secondary text-white text-center">
                <h5 class="mb-0">Rincian Pengajuan</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    
                    <!-- Nama -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Nama lengkap</label>
                        <input type="text" name="nama_user" class="form-control" required>
                    </div>

                    <!-- Keterangan -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Keterangan</label>
                        <textarea name="keterangan[]" class="form-control" rows="2" 
                            placeholder="Tulis keterangan detail..."></textarea>
                    </div>

                    <!-- Banyak -->
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Banyak</label>
                        <input type="number" name="banyak[]" class="form-control banyak" min="1" placeholder="0">
                    </div>

                    <!-- Satuan -->
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Satuan</label>
                        <input type="text" name="satuan[]" class="form-control" placeholder="hari/unit">
                    </div>

                    <!-- Nominal -->
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Nominal</label>
                        <input type="number" name="nominal[]" class="form-control nominal" placeholder="Rp">
                    </div>

                    <!-- Jumlah -->
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Jumlah</label>
                        <input type="number" name="jumlah[]" class="form-control jumlah fw-bold text-success" readonly>
                    </div>

                </div>
            </div>
            <div class="card-footer text-end">
                <a href="<?= base_url('user/rincian'); ?>" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button type="button" class="btn btn-success" id="btnKirim">
                <i class="fas fa-paper-plane"></i> Kirim
            </button>
            </div>
        </div>
    </form>
</div>



<script>
// Hitung otomatis jumlah = banyak × nominal
document.addEventListener("input", function(e) {
    if (e.target.classList.contains("banyak") || e.target.classList.contains("nominal")) {
        let row = e.target.closest("tr");
        let banyak = parseFloat(row.querySelector(".banyak").value) || 0;
        let nominal = parseFloat(row.querySelector(".nominal").value) || 0;
        row.querySelector(".jumlah").value = banyak * nominal;
    }
});
</script>
<script>
document.getElementById('btnKirim').addEventListener('click', function(e) {
    e.preventDefault();

    Swal.fire({
        title: 'Kirim Data?',
        text: "Pastikan semua data sudah benar sebelum dikirim!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Kirim',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // submit form
            document.querySelector("form").submit();
        }
    });
});
</script>
