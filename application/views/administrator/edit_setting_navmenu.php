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
                <div class="card-body">
                    <form action="<?= base_url(); ?>administrator/setting/navmenu/<?= $menu['id']; ?>" method="post">
                        <div class="form-group">
                            <label for="title">Nama Halaman</label>
                            <input type="text" class="form-control" id="title" name="title" value="<?= $menu['title']; ?>" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="link">Link</label>
                            <input type="text" class="form-control" id="link" name="link" autocomplete="off" value="<?= $menu['link']; ?>">
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Halaman</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
