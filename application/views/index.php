  <br>
  <br>
  <br>
<div class="category-menu">
    <div class="main-category">
      <div class="item" data-toggle="modal" data-target="#modalMoreCategory">
          <img src="<?= base_url(); ?>assets/images/icon/category-more.svg">
          <p>SELENGKAPNYA</p>
      </div>
      <?php foreach($categoriesLimit->result_array() as $c): ?>
        <a href="<?= base_url(); ?>c/<?= $c['slug']; ?>">
          <div class="item">
              <img src="<?= base_url(); ?>assets/images/icon/<?= $c['icon']; ?>">
              <p><?= $c['name']; ?></p>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
</div>

<!-- Modal More Category -->
<div class="modal fade" id="modalMoreCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="main-category">
          <?php foreach($categories->result_array() as $c): ?>
            <a href="<?= base_url(); ?>c/<?= $c['slug']; ?>">
              <div class="item">
                  <img src="<?= base_url(); ?>assets/images/icon/<?= $c['icon']; ?>">
                  <p><?= $c['name']; ?></p>
              </div>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="product-wrapper">
  <br>
  <br>
  <br>
  <div class="main-product">
    <?php if($recent->num_rows() > 0){ ?>
    <?php foreach($recent->result_array() as $p): ?>
        <a href="<?= base_url(); ?>p/<?= $p['slug']; ?>">
          <div class="card">
            <img src="<?= base_url(); ?>assets/images/product/<?= $p['img']; ?>" class="card-img-top" >
            <div class="card-body text-danger">
              <p class="card-text mb-4"><?= $p['title']; ?></p>
                <p>Rp <?= str_replace(",",".",number_format($p['price'])); ?></p>
            </div>
          </div>
        </a>
    <?php endforeach; ?>
    <div class="clearfix"></div>
    <?php }else{ ?>
      <div class="alert alert-warning">Upss.. Belum ada produk!</div>
    <?php } ?>
  </div>
  <?php if($allProducts->num_rows() > 50){ ?>
    <a href="<?= base_url(); ?>products"><button class="more">Selengkapnya</button></a>
  <?php } ?>
</div>