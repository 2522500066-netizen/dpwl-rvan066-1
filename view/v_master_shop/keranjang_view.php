<?php
// Cek apakah keranjang memiliki data
$ada_keranjang = !empty($datakeranjang);
$total_sewa = 0;
$jumlah_hari = 0;
if ($ada_keranjang) {
    $kode_sewa   = $datakeranjang[0]['kode_sewa'];
    $tgl_mulai   = $datakeranjang[0]['tgl_mulai'];
    $tgl_selesai = $datakeranjang[0]['tgl_selesai'];
    $wkt_ambil   = $datakeranjang[0]['wkt_ambil'];
    $status_sewa = $datakeranjang[0]['status_sewa'];
}
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- INFORMASI TRANSAKSI -->
            <?php
            if (!empty($pesan)) {
                echo "<script>alert('" . $pesan . "');</script>";
            }
            ?>
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h4>Informasi Transaksi</h4>
                </div>
                <div class="card-body">
                    <?php if ($ada_keranjang) : ?>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <p class="text-muted mb-1">Kode transaksi</p>
                                <h4>
                                    <strong><?= htmlspecialchars($kode_sewa); ?></strong>
                                </h4>
                            </div>
                            <div class="col-md-6">
                                <p class="text-muted mb-1">Status</p>
                                <span class="badge badge-secondary">
                                    <?= htmlspecialchars($status_sewa); ?>
                                </span>
                            </div>
                        </div>
                        <form action="<?= base_url('Sewa_C/updatekeranjang'); ?>"
                            method="POST">
                            <input type="hidden"
                                name="kode_sewa"
                                value="<?= htmlspecialchars($kode_sewa); ?>">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Tanggal mulai</label>
                                    <input type="date"
                                        name="tgl_mulai"
                                        class="form-control"
                                        value="<?= $tgl_mulai; ?>"
                                        min="<?= date('Y-m-d'); ?>"
                                        required>
                                </div>
                                <div class="col-md-4">
                                    <label>Tanggal selesai</label>
                                    <input type="date"
                                        name="tgl_selesai"
                                        class="form-control"
                                        value="<?= $tgl_selesai; ?>"
                                        min="<?= $tgl_mulai; ?>"
                                        required>
                                </div>
                                <div class="col-md-4">
                                    <label>Waktu pengambilan</label>
                                    <input type="datetime-local"
                                        name="wkt_ambil"
                                        id="wkt_ambil"
                                        value="<?= $wkt_ambil; ?>"
                                        min="<?= $tgl_mulai; ?>"
                                        class="form-control"
                                        required>
                                </div>
                            </div>
                            <button type="submit"
                                class="btn btn-outline-success mt-4">
                                <i class="fa fa-save"></i>
                                Update Keranjang
                            </button>
                        </form>
                    <?php else : ?>
                        <div class="alert alert-info mb-0">
                            Keranjang Anda masih kosong.
                            Silakan pilih mobil terlebih dahulu.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <!-- DAFTAR MOBIL -->
            <?php if ($ada_keranjang) : ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>Kendaraan</th>
                                <th class="text-center">Nomor Polisi</th>
                                <th class="text-right">Harga per Hari</th>
                                <th class="text-center">Durasi</th>
                                <th class="text-right">Subtotal</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($datakeranjang as $row) : ?>
                                <?php
                                $durasi = max(1, (int)$row['n_hari']);
                                $harga = (float)$row['hrg_hari'];
                                $subtotal = $harga * $durasi;
                                $total_sewa += $subtotal;
                                $jumlah_hari = $durasi;
                                ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="<?= base_url('img/' . $row['ft_depan']); ?>"
                                                alt="Foto mobil"
                                                style="width:120px;height:85px;object-fit:cover;"
                                                class="mr-3">
                                            <span>
                                                <?= htmlspecialchars($row['nm_mobil']); ?>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="text-center align-middle">
                                        <?= htmlspecialchars($row['no_plat']); ?>
                                    </td>
                                    <td class="text-right align-middle">
                                        Rp <?= number_format($harga, 0, ',', '.'); ?>
                                    </td>
                                    <td class="text-center align-middle">
                                        <?= $durasi; ?> hari
                                    </td>
                                    <td class="text-right align-middle">
                                        Rp <?= number_format($subtotal, 0, ',', '.'); ?>
                                    </td>
                                    <td class="text-center align-middle">
                                        <a href="<?= base_url('Sewa_C/hapus/' . urlencode($row['no_plat'] . '|' . $kode_sewa)); ?>"
                                            class="btn btn-outline-danger btn-sm"
                                            onclick="return confirm('Yakin ingin menghapus mobil ini dari keranjang?')">
                                            <i class="fa fa-trash"></i>
                                            Hapus
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-right">
                                    <strong>Total Sewa</strong>
                                </td>
                                <td class="text-right">
                                    <strong>
                                        Rp <?= number_format($total_sewa, 0, ',', '.'); ?>
                                    </strong>
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- CHECKOUT -->
                <div class="row mt-4 mb-5">
                    <div class="col-md-9">
                        <p class="mt-3">
                            Checkout mengajukan transaksi kepada admin.
                            Status kendaraan tidak berubah menjadi disewa
                            sampai transaksi disetujui admin.
                        </p>
                    </div>
                    <div class="col-md-3">
                        <a href="<?= base_url('shopping'); ?>"
                            class="btn btn-danger btn-lg btn-block">
                            <i class="fas fa-arrow-left mr-1"></i>
                            Pilih Mobil
                        </a>
                        <a href="<?= base_url('Sewa_C/checkout/' . $kode_sewa); ?>"
                            class="btn btn-success btn-lg btn-block">
                            <i class="fa fa-arrow-right"></i>
                            Checkout / Lihat Konfirmasi
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>