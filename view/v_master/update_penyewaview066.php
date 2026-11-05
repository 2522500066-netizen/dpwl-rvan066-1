<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Data Penyewa</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('?url=c_master/Penyewa_C066/index') ?>">Master Data</a>
                        </li>
                        <li class="breadcrumb-item active">Edit Penyewa</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">Form Ubah Data Penyewa (066)</h3>
                        </div>

                        <!-- Form Edit -->
                        <form action="<?= base_url('?url=c_master/Penyewa_C066/update'); ?>" method="POST" enctype="multipart/form-data">
                            <div class="card-body">
                                
                                <!-- Username (Primary Key - Readonly) -->
                                <div class="form-group">
                                    <label for="user_plg066">Username / User Pelanggan</label>
                                    <input type="text" name="user_plg066" id="user_plg066" class="form-control" value="<?= htmlspecialchars($penyewa['user_plg066'] ?? ''); ?>" readonly>
                                    <small class="text-muted">Username tidak dapat diubah (Primary Key).</small>
                                </div>

                                <!-- Password / Sandi -->
                                <div class="form-group">
                                    <label for="sandi066">Password / Sandi</label>
                                    <input type="text" name="sandi066" id="sandi066" class="form-control" value="<?= htmlspecialchars($penyewa['sandi066'] ?? ''); ?>" required>
                                </div>

                                <!-- NIK -->
                                <div class="form-group">
                                    <label for="nik066">NIK (Nomor Induk Kependudukan)</label>
                                    <input type="text" name="nik066" id="nik066" class="form-control" value="<?= htmlspecialchars($penyewa['nik066'] ?? ''); ?>" required>
                                </div>

                                <!-- Nama Lengkap -->
                                <div class="form-group">
                                    <label for="nm_lngkp066">Nama Lengkap</label>
                                    <input type="text" name="nm_lngkp066" id="nm_lngkp066" class="form-control" value="<?= htmlspecialchars($penyewa['nm_lngkp066'] ?? ''); ?>" required>
                                </div>

                                <!-- Nomor HP -->
                                <div class="form-group">
                                    <label for="no_hp066">No. Telepon / HP</label>
                                    <input type="text" name="no_hp066" id="no_hp066" class="form-control" value="<?= htmlspecialchars($penyewa['no_hp066'] ?? ''); ?>" required>
                                </div>

                                <!-- Alamat Lengkap -->
                                <div class="form-group">
                                    <label for="almt_lngkp066">Alamat Lengkap</label>
                                    <textarea name="almt_lngkp066" id="almt_lngkp066" class="form-control" rows="3" required><?= htmlspecialchars($penyewa['almt_lngkp066'] ?? ''); ?></textarea>
                                </div>

                                <!-- Upload Foto KTP -->
                                <div class="form-group">
                                    <label for="ft_ktp066">Foto KTP <small class="text-info">(Biarkan kosong jika tidak ingin mengganti foto)</small></label>
                                    <input type="file" name="ft_ktp066" id="ft_ktp066" class="form-control-file">
                                    <?php if (!empty($penyewa['ft_ktp066'])) : ?>
                                        <div class="mt-2">
                                            <small class="text-muted d-block">Foto KTP Saat Ini:</small>
                                            <img src="<?= base_url('img/' . $penyewa['ft_ktp066']); ?>" width="120" class="img-thumbnail mt-1" alt="Foto KTP">
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Upload Foto SIM A -->
                                <div class="form-group">
                                    <label for="ft_sim_a066">Foto SIM A <small class="text-info">(Biarkan kosong jika tidak ingin mengganti foto)</small></label>
                                    <input type="file" name="ft_sim_a066" id="ft_sim_a066" class="form-control-file">
                                    <?php if (!empty($penyewa['ft_sim_a066'])) : ?>
                                        <div class="mt-2">
                                            <small class="text-muted d-block">Foto SIM A Saat Ini:</small>
                                            <img src="<?= base_url('img/' . $penyewa['ft_sim_a066']); ?>" width="120" class="img-thumbnail mt-1" alt="Foto SIM A">
                                        </div>
                                    <?php endif; ?>
                                </div>

                            </div>

                            <!-- Tombol Aksi -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save"></i> Update Data
                                </button>
                                <a href="<?= base_url('?url=c_master/Penyewa_C066/index'); ?>" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>