<div class="content-wrapper">

    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Penyewa</h1>
                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('?url=c_master/Penyewa_C066/index') ?>">
                                Master Data
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            Data Penyewa
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">

                        <div class="card-header">
                            <h3 class="card-title">DATA PENYEWA (066)</h3>
                        </div>

                        <div class="card-body">

                            <!-- Tombol Tambah -->
                            <a href="<?= base_url('?url=c_master/Penyewa_C066/create_penyewa') ?>"
                               class="btn btn-primary mb-3">
                                <i class="fas fa-user-plus"></i>
                                Tambah Data Penyewa
                            </a>

                            <!-- Tabel Data Penyewa -->
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">

                                    <thead>
                                        <tr>
                                            <th>Username</th>
                                            <th>NIK</th>
                                            <th>Nama Lengkap</th>
                                            <th>No. HP</th>
                                            <th>Alamat Lengkap</th>
                                            <th>Foto Identitas (KTP & SIM A)</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        <?php if (!empty($dtpenyewa)) : ?>

                                            <?php foreach ($dtpenyewa as $p) : ?>

                                                <tr>
                                                    <td>
                                                        <?= htmlspecialchars($p['user_plg066']) ?>
                                                    </td>

                                                    <td>
                                                        <?= htmlspecialchars($p['nik066']) ?>
                                                    </td>

                                                    <td>
                                                        <?= htmlspecialchars($p['nm_lngkp066']) ?>
                                                    </td>

                                                    <td>
                                                        <?= htmlspecialchars($p['no_hp066']) ?>
                                                    </td>

                                                    <td>
                                                        <?= htmlspecialchars($p['almt_lngkp066']) ?>
                                                    </td>

                                                    <!-- Foto Identitas -->
                                                    <td>
                                                        <small class="font-weight-bold">KTP:</small><br>

                                                        <?php if (!empty($p['ft_ktp066'])) : ?>
                                                            <img
                                                                src="<?= base_url('img/'.$p['ft_ktp066']) ?>"
                                                                width="100"
                                                                style="border-radius:5px; margin-bottom:5px;"
                                                                alt="KTP">
                                                        <?php else : ?>
                                                            <small class="text-muted">Foto KTP belum tersedia</small>
                                                        <?php endif; ?>

                                                        <br>

                                                        <small class="font-weight-bold">SIM A:</small><br>

                                                        <?php if (!empty($p['ft_sim_a066'])) : ?>
                                                            <img
                                                                src="<?= base_url('img/'.$p['ft_sim_a066']) ?>"
                                                                width="100"
                                                                style="border-radius:5px;"
                                                                alt="SIM A">
                                                        <?php else : ?>
                                                            <small class="text-muted">Foto SIM A belum tersedia</small>
                                                        <?php endif; ?>
                                                    </td>

                                                    <!-- Tombol Aksi -->
                                                    <td>
                                                        <a href="<?= base_url('?url=c_master/Penyewa_C066/edit/'.$p['user_plg066']) ?>"
                                                           class="btn btn-warning btn-sm mb-1">
                                                            <i class="fas fa-edit"></i>
                                                            Edit
                                                        </a>

                                                        <a href="<?= base_url('?url=c_master/Penyewa_C066/delete/'.$p['user_plg066']) ?>"
                                                           class="btn btn-danger btn-sm mb-1"
                                                           onclick="return confirm('Apakah anda yakin ingin menghapus data penyewa ini?')">
                                                            <i class="fas fa-trash"></i>
                                                            Hapus
                                                        </a>
                                                    </td>
                                                </tr>

                                            <?php endforeach; ?>

                                        <?php else : ?>

                                            <tr>
                                                <td colspan="7" class="text-center">
                                                    Data penyewa belum tersedia.
                                                </td>
                                            </tr>

                                        <?php endif; ?>

                                    </tbody>

                                </table>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>