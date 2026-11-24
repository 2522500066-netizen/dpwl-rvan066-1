<div class="container-fluid">
    <!-- Header -->
    <div class="bg-success text-white p-4 mb-4">
        <h4>Konfirmasi Transaksi</h4>
        <p class="mb-0">
            Periksa kembali rincian sewa dan uang muka sebelum mengajukan transaksi.
        </p>
    </div>
    <!-- Ringkasan Sewa -->
    <div class="card mb-4">
        <div class="card-header bg-light">
            <strong>Ringkasan Sewa</strong>
        </div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-md-4 font-weight-bold">Kode Transaksi</div>
                <div class="col-md-8">
                    <?= htmlspecialchars($kode_sewa) ?>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-4 font-weight-bold">Tanggal Mulai</div>
                <div class="col-md-8">
                    <?= date('d M Y', strtotime($tgl_mulai)) ?>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-4 font-weight-bold">Tanggal Selesai</div>
                <div class="col-md-8">
                    <?= date('d M Y', strtotime($tgl_selesai)) ?>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-4 font-weight-bold">Waktu Pengambilan</div>
                <div class="col-md-8">
                    <?= date('d M Y H:i', strtotime($wkt_ambil)) ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Detail Kendaraan -->
    <div class="card mb-4">
        <div class="card-header bg-light">
            <strong>Detail Kendaraan yang Disewa</strong>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-striped mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Kendaraan</th>
                            <th>Nomor Polisi</th>
                            <th class="text-right">Harga per Hari</th>
                            <th class="text-center">Durasi</th>
                            <th class="text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dtcheckout as $m) : ?>
                            <tr>
                                <td>
                                    <?= htmlspecialchars($m['nm_mobil']) ?>
                                </td>
                                <td>
                                    <?= htmlspecialchars($m['no_plat']) ?>
                                </td>
                                <td class="text-right">
                                    Rp <?= number_format($m['hrg_sewa'], 0, ',', '.') ?>
                                </td>
                                <td class="text-center">
                                    <?= $m['n_hari'] ?> hari
                                </td>
                                <td class="text-right">
                                    Rp <?= number_format(
                                        $m['hrg_sewa'] * $m['n_hari'],
                                        0,
                                        ',',
                                        '.'
                                    ) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Total Pembayaran -->
    <div class="row justify-content-end">
        <div class="col-md-5">
            <div class="card border-success">
                <div class="card-header bg-light">
                    <strong>Ringkasan Pembayaran</strong>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Total Sewa</span>
                        <strong>
                            Rp <?= number_format($total_sewa, 0, ',', '.') ?>
                        </strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Uang Muka (DP 30%)</span>
                        <strong class="text-success">
                            Rp <?= number_format($dp, 0, ',', '.') ?>
                        </strong>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span>Sisa Pembayaran</span>
                        <strong>
                            Rp <?= number_format($sisa, 0, ',', '.') ?>
                        </strong>
                    </div>
                    <small class="text-muted d-block mt-3">
                        Pembayaran uang muka sebesar 30% dari total biaya sewa.
                        Bukti pembayaran akan diunggah setelah transaksi diajukan
                        dan diverifikasi oleh admin.
                    </small>
                </div>
            </div>
        </div>
    </div>
    <!-- Tombol -->
    <div class="d-flex justify-content-between mt-4 mb-4">
        <!-- Kembali ke Keranjang -->
        <a href="<?= base_url('Sewa_C/keranjang') ?>"
           class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i>
            Kembali ke Keranjang
        </a>
        <!-- Konfirmasi Transaksi -->
        <form action="<?= base_url('Sewa_C/ajukantransaksi/' . $kode_sewa) ?>" method="POST">
            <input type="hidden" name="kode_sewa"
                   value="<?= htmlspecialchars($kode_sewa) ?>">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-check"></i>
                Konfirmasi dan Ajukan Transaksi
            </button>
        </form>
    </div>
</div>