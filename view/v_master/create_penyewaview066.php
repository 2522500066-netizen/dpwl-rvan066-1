<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Entri Data Penyewa</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('?url=c_master/Penyewa_C066/index') ?>">Master Penyewa</a>
                        </li>
                        <li class="breadcrumb-item active">Entri Penyewa</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user-plus"></i> Form Entri Data Penyewa
                    </h3>
                </div>

                <!-- ACTION KE ROUTE SIMPAN -->
                <form action="<?= base_url('?url=c_master/Penyewa_C066/simpan') ?>"
                      method="POST"
                      enctype="multipart/form-data">

                    <div class="card-body">
                        <div class="row">

                            <!-- Kolom Kiri -->
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label>Username (User Pelanggan)</label>
                                    <input type="text"
                                           name="user_plg066"
                                           class="form-control"
                                           placeholder="Contoh: Revandisastra066"
                                           maxlength="50"
                                           required>
                                </div>

                                <div class="form-group">
                                    <label>NIK</label>
                                    <input type="text"
                                           name="nik066"
                                           class="form-control"
                                           placeholder="Nomor Induk Kependudukan"
                                           maxlength="20"
                                           required>
                                </div>

                                <div class="form-group">
                                    <label>Nama Lengkap</label>
                                    <input type="text"
                                           name="nm_lngkp066"
                                           class="form-control"
                                           placeholder="Contoh: Budi Santoso"
                                           maxlength="100"
                                           required>
                                </div>

                                <div class="form-group">
                                    <label>Alamat Lengkap</label>
                                    <textarea name="almt_lngkp066"
                                              class="form-control"
                                              rows="3"
                                              placeholder="Masukkan alamat lengkap penyewa"
                                              required></textarea>
                                </div>

                                <div class="form-group">
                                    <label>
                                        <i class="fas fa-id-card"></i> Foto KTP (ft_ktp066) <span class="text-danger">*</span>
                                    </label>
                                    <input type="file"
                                           name="ft_ktp066"
                                           class="form-control"
                                           accept=".jpg,.jpeg,.png"
                                           required>
                                    <small class="text-muted">Format JPG, JPEG atau PNG.</small>
                                </div>

                            </div>

                            <!-- Kolom Kanan -->
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label>Kata Sandi (Password)</label>
                                    <input type="password"
                                           name="sandi066"
                                           class="form-control"
                                           placeholder="Masukkan kata sandi"
                                           maxlength="225"
                                           required>
                                </div>

                                <div class="form-group">
                                    <label>No. Handphone</label>
                                    <input type="text"
                                           name="no_hp066"
                                           class="form-control"
                                           placeholder="Contoh: 081234567890"
                                           maxlength="20"
                                           required>
                                </div>

                                <div class="form-group">
                                    <label>
                                        <i class="fas fa-id-card"></i> Foto SIM A (ft_sim_a066)
                                    </label>
                                    <input type="file"
                                           name="ft_sim_a066"
                                           class="form-control"
                                           accept=".jpg,.jpeg,.png">
                                    <small class="text-muted">Format JPG, JPEG atau PNG (Opsional).</small>
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <a href="<?= base_url('?url=c_master/Penyewa_C066/index') ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>

                </form>

            </div>

        </div>
    </section>

</div>