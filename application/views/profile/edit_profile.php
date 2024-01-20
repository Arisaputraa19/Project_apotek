<div class="wrapper">
    <?php include 'menu.php'; ?>
    <div class="card shadow mb-4">
		<div class="card-header py-3">
			<a href="<?= base_url(); ?>#" class="btn btn-danger"><i class="fa fa-chevron-left"></i> Kembali</a>
		</div>
		<div class="card-body">
    <div class="core">
        <?php echo $this->session->flashdata('failed'); ?>
        <form action="<?= base_url(); ?>profile/edit-profile" method="post" enctype="multipart/form-data">
        <img src="<?php echo base_url('assets/images/banner/01.jpg')?>" width="750">
            <div class="form-group">
                <label for="name">Ganti Nama</label>
                <input type="text" name="name" value="<?= $user['name']; ?>" class="form-control" id="name" required autocomplete="off">
                <small class="form-text text-danger pl-1"><?php echo form_error('name'); ?></small>
            </div>
            <div class="form-group">
                <label for="photo">Ganti Foto Profil</label><br>
                <img src="<?= base_url(); ?>assets/images/profile/<?= $user['photo_profile']; ?>" alt="Foto profil <?= $user['name']; ?>" class="photo-profile">
                <input type="file" name="newphoto" class="form-control mt-2" id="photo">
            </div>
            <button class="btn btn-danger">Update</button>
        </form>
    </div>
    </div>
	</div>
</div>