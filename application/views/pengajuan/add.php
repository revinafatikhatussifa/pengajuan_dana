<div class="container mt-4">
    <h3>Form Pengajuan Dana Operasional Luar Kota</h3>

    <?= form_open('pengajuan/add'); ?>

    <div class="form-group">
        <label for="nama">Nama</label>
        <input type="text" class="form-control" name="nama" value="<?= set_value('nama'); ?>">
        <?= form_error('nama', '<small class="text-danger">', '</small>'); ?>
    </div>

    <div class="form-group">
        <label for="jabatan">Jabatan</label>
        <input type="text" class="form-control" name="jabatan" value="<?= set_value('jabatan'); ?>">
        <?= form_error('jabatan', '<small class="text-danger">', '</small>'); ?>
    </div>

    <div class="form-group">
        <label for="tujuan">Tempat Tujuan</label>
        <input type="text" class="form-control" name="tujuan" value="<?= set_value('tujuan'); ?>">
        <?= form_error('tujuan', '<small class="text-danger">', '</small>'); ?>
    </div>

    <div class="form-group">
        <label for="tgl_berangkat">Tanggal Berangkat</label>
        <input type="date" class="form-control" name="tgl_berangkat" value="<?= set_value('tgl_berangkat'); ?>">
        <?= form_error('tgl_berangkat', '<small class="text-danger">', '</small>'); ?>
    </div>

    <div class="form-group">
        <label for="tgl_pulang">Tanggal Pulang</label>
        <input type="date" class="form-control" name="tgl_pulang" value="<?= set_value('tgl_pulang'); ?>">
        <?= form_error('tgl_pulang', '<small class="text-danger">', '</small>'); ?>
    </div>

    <div class="mt-4">
        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
        <a href="<?= base_url('user'); ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>

    </form>
</div>
