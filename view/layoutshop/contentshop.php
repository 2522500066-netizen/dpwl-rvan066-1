<!-- Products Start -->
<hr>
<div class="container-fluid pt-5">
    <div class="row px-xl-5 pb-3">

        <?php if (!empty($dtmobil)) : ?>
            <?php foreach ($dtmobil as $m) : ?>
                <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                    <div class="card product-item border-0 mb-4">
                        <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                            <img class="img-fluid w-100" src="<?= base_url('img/' . ($m['ft_dpn'] ?? 'Depan_BN_1234_A.jpg')); ?>" alt="<?= htmlspecialchars($m['nm_mobil'] ?? ''); ?>">
                        </div>
                        <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                            <h6 class="text-truncate mb-3"><?= htmlspecialchars($m['nm_mobil']); ?></h6>
                            <div class="d-flex justify-content-center">
                                <h6>Rp <?= number_format($m['hrg_hari'], 0, ',', '.'); ?>/hari</h6>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between bg-light border">
                            <a href="<?= base_url('?url=Shopping/detail/' . rawurlencode($m['no_plat'])); ?>" class="btn btn-sm text-dark p-0">
                                <i class="fas fa-eye text-danger mr-1"></i>View Detail
                            </a>

                            <a href="<?= base_url('?url=Sewa_C/simpan/' . rawurlencode($m['no_plat'])); ?>"
                               class="btn btn-sm text-dark p-0">
                                <i class="fas fa-shopping-cart text-info mr-1"></i>
                                Pilih Sewa
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="col-12 text-center">
                <p class="text-muted">Data mobil belum tersedia.</p>
            </div>
        <?php endif; ?>

    </div>
</div>
<!-- Products End -->