<!-- Detail Mobil Start -->
<div class="container pt-4">

    <div class="row justify-content-center pb-5">

        <!-- Foto Mobil -->
        <div class="col-lg-4 col-md-5 mb-3">
            <div id="product-carousel" class="carousel slide"
                data-ride="carousel">

                <div class="carousel-inner bg-light rounded shadow-sm">

                    <div class="carousel-item active">
                        <img class="d-block w-100"
                            src="<?= base_url('img/' . rawurlencode($mobil['ft_depan'])) ?>"
                            alt="Foto Depan"
                            style="height:260px; object-fit:cover;">
                    </div>

                    <div class="carousel-item">
                        <img class="d-block w-100"
                            src="<?= base_url('img/' . rawurlencode($mobil['ft_blkg'])) ?>"
                            alt="Foto Belakang"
                            style="height:260px; object-fit:cover;">
                    </div>

                    <div class="carousel-item">
                        <img class="d-block w-100"
                            src="<?= base_url('img/' . rawurlencode($mobil['ft_interior'])) ?>"
                            alt="Foto Interior"
                            style="height:260px; object-fit:cover;">
                    </div>

                </div>

                <a class="carousel-control-prev"
                    href="#product-carousel" data-slide="prev">
                    <i class="fa fa-2x fa-angle-left text-dark"></i>
                </a>

                <a class="carousel-control-next"
                    href="#product-carousel" data-slide="next">
                    <i class="fa fa-2x fa-angle-right text-dark"></i>
                </a>

            </div>
        </div>

        <!-- Informasi Mobil -->
        <div class="col-lg-6 col-md-7 mb-3">

            <div class="h-100 bg-light p-4 rounded shadow-sm">

                <h5 class="mb-1">
                    <?= $mobil['nm_mobil']; ?>
                </h5>

                <h5 class="text-success mb-3">
                    Rp <?= number_format($mobil['hrg_hari'], 0, ',', '.'); ?>
                    <small class="text-muted font-weight-normal">/ hari</small>
                </h5>

                <table class="table table-sm table-borderless mb-3"
                    style="font-size:13px;">

                    <tr>
                        <td style="width:35%; font-weight:normal;" class="py-1">
                            Nomor Plat
                        </td>
                        <td class="py-1">
                            : <span class="badge badge-secondary"><?= $mobil['no_plat']; ?></span>
                        </td>
                    </tr>

                    <tr>
                        <td class="py-1 font-weight-normal">Jenis / Tipe</td>
                        <td class="py-1">: <?= $mobil['jns_mobil']; ?></td>
                    </tr>

                    <tr>
                        <td class="py-1 font-weight-normal">Transmisi</td>
                        <td class="py-1">: <?= $mobil['transmisi']; ?></td>
                    </tr>

                    <tr>
                        <td class="py-1 font-weight-normal">Tahun Buat</td>
                        <td class="py-1">: <?= $mobil['thn_buat']; ?></td>
                    </tr>

                    <tr>
                        <td class="py-1 font-weight-normal">Kapasitas Kursi</td>
                        <td class="py-1">: <?= $mobil['nkursi']; ?> Orang</td>
                    </tr>

                    <tr>
                        <td class="py-1 font-weight-normal">Kapasitas Bagasi</td>
                        <td class="py-1">: <?= $mobil['nbagasi']; ?></td>
                    </tr>

                    <tr>
                        <td class="py-1 font-weight-normal">Status Unit</td>
                        <td class="py-1">:
                            <span class="badge badge-success"><?= $mobil['status_unit'] ?></span>
                        </td>
                    </tr>

                </table>

                <div class="mb-3" style="font-size:13px;">
                    <span class="text-dark">Catatan Unit:</span>
                    <p class="text-muted mb-0">
                        <?= !empty($mobil['cttn_unit'])
                            ? $mobil['cttn_unit']
                            : 'Tidak ada catatan khusus untuk unit ini.'; ?>
                    </p>
                </div>

                <div class="d-flex align-items-center pt-1">

                    <a href="<?= base_url('?url=Sewa_C/simpan/' . rawurlencode($mobil['no_plat'])); ?>"
                        class="btn btn-primary btn-sm px-3 py-2 mr-2">
                        <i class="fas fa-shopping-cart mr-1"></i>
                        Pilih Sewa
                    </a>

                    <a href="<?= base_url('?url=Shopping/index'); ?>"
                        class="btn btn-secondary btn-sm px-3 py-2">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Kembali
                    </a>

                </div>

            </div>
        </div>

    </div>
</div>
<!-- Detail Mobil End -->