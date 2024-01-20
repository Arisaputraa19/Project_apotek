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
                    <form action="<?= base_url(); ?>administrator/setting/navmenu/add" method="post">
                        <div class="form-group">
                            <label for="title">Judul Halaman</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Isikan Judul Halaman" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="submenu">Submenu Halaman</label>
                            <select name="submenu" id="submenu" class="form-control">
                            <option value="0">Tidak ada</option>
                            <?php foreach($menu->result_array() as $m): ?>
                                <option value="<?= $m['id']; ?>"><?= $m['title']; ?></option>
                            <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="link">Link</label>
                            <input type="text" class="form-control" id="link" name="link" placeholder="Isikan Link Halaman" autocomplete="off">
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Halaman</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
