<div class="wrapper">
    <?php include 'menu.php'; ?>
    <div class="card shadow mb-4">
		<div class="card-header py-3">
			<a href="<?= base_url(); ?>#" class="btn btn-danger"><i class="fa fa-chevron-left"></i> Kembali</a>
		</div>
		<div class="card-body">

    <div class="core">
        <?php echo $this->session->flashdata('failed'); ?>
        <form action="<?= base_url(); ?>profile/change-password" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="oldpassword">Password Lama</label>
                <input type="password" name="oldpassword" class="form-control" id="oldpassword" required autocomplete="off" placeholder="Masukan Password Lama">
                <small class="form-text text-danger pl-1"><?php echo form_error('oldpassword'); ?></small>
            </div>
            <div class="form-group">
                <label for="newpassword">Password Baru</label>
                <input type="password" name="newpassword" class="form-control" id="newpassword" required autocomplete="off" placeholder="Masukan Password Baru">
                <small class="form-text text-danger pl-1"><?php echo form_error('newpassword'); ?></small>
            </div>
            <div class="form-group">
                <label for="confirmpassword">Konfirmasi Password Baru</label>
                <input type="password" name="confirmpassword" class="form-control" id="confirmpassword" required autocomplete="off" placeholder="Konfirmasi Masukan Password Baru">
                <small class="form-text text-danger pl-1"><?php echo form_error('confirmpassword'); ?></small>
            </div>
            <button class="btn btn-danger">Update</button>
        </form>
    </div>

    </div>
	</div>
</div>