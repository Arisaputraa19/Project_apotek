<div class="wrapper">
    <div class="title-head">
        <?php if($titleHead == ""){ ?>
            <h2 class="title">Kategori <?= $nameCat ?></h2>
        <?php }else{ ?>
            <h2 class="title">Kategori <?= $nameCat ?> > <?= $titleHead ?></h2>
        <?php } ?>
    </div>
    <div class="core">
        <?php $setting = $this->db->get('settings')->row_array(); ?>
        <div class="main-product">
            <?php if($products->num_rows() > 0){ ?>
            <?php foreach($products->result_array() as $p): ?>
                <a href="<?= base_url(); ?>p/<?= $p['slug']; ?>">
                <div class="card">
                    <img src="<?= base_url(); ?>assets/images/product/<?= $p['img']; ?>" class="card-img-top" >
                    <div class="card-body">
                    <p class="card-text mb-0"><?= $p['title']; ?></p>
                    <br>
                        <p class="text-danger">Rp <?= str_replace(",",".",number_format($p['price'])); ?></p>
                    </div>
                </div>
                </a>
            <?php endforeach; ?>
            <div class="clearfix"></div>
            <?php }else{ ?>
                <div class="alert alert-warning">Upss. Tidak ada produk yang dapat ditampilkan</div>
            <?php } ?>
        </div>
    </div>
</div>