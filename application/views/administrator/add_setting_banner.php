<?php echo $this->session->flashdata('upload'); ?>

<!-- Begin Page Content -->
<div class="container-fluid">
	<!-- Page Heading -->
	<div class="row">
        <div class="col-md-3">
            <div class="card shadow">
                <div class="card-body">
                <?php include('menu-setting.php'); ?>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card shadow">
                <div class="card-header">
                </div>
                <div class="card-body">
                    <form action="<?= base_url(); ?>administrator/add_banner_setting_post" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <input type="file" name="img" id="img" class="form-control">
                            <small class="text-muted">1600 x 400px</small>
                        </div>
                        <button type="submit" class="btn btn-primary">Tambah Banner</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
