<div class="wrapper">
    <?php include 'menu.php'; ?>
    <div class="core">
        <div class="alert alert-info text-center">WELCOME !</div>
        <?php if (isset($_GET['order_success']) && $_GET['order_success'] === 'true') : ?>
        <div class="alert alert-danger">Pesanan Anda berhasil!</div>
        <?php endif; ?>
        <img src="<?php echo base_url('assets/images/banner/01.jpg')?>" width="800">
    </div>
</div>