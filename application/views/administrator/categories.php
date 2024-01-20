<?php echo $this->session->flashdata('upload'); ?>

<!-- Begin Page Content -->
<div class="container-fluid">
	<!-- Page Heading -->

	<!-- DataTales Example -->
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<a href="#" class="btn btn-primary" data-toggle="modal" data-target="#addCategory">Tambah Kategori Produk</a>
		</div>
		<div class="card-body"> 
            <?php if($getCategories->num_rows() > 0){ ?>
			<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>No</th>
							<th>Icon Produk</th>
							<th>Nama Kategori Produk</th>
                            <th style="width: 100px"></th>
						</tr>
					</thead>
					<tfoot></tfoot>
					<tbody class="data-content">
                        <?php $no = 1 ?>
						<?php foreach($getCategories->result_array() as $data): ?>
						<tr>
                            <td><?= $no ?></td>
                            <td><img style="width: 50px" src="<?= base_url(); ?>assets/images/icon/<?= $data['icon']; ?>"></td>
                            <td><?= $data['name']; ?></td>
                            <td>
                                <a href="<?= base_url() ;?>administrator/category/<?= $data['id']; ?>" class="btn btn-sm btn-info"><i class="fa fa-pen"></i></a>
                                <a href="<?= base_url() ;?>administrator/deleteCategory/<?= $data['id']; ?>" onclick="return confirm('Yakin ingin menghapus kategori? Semua produk dengan kategori ini akan ikut terhapus')" class="btn btn-sm btn-danger"><i class="fa fa-trash-alt"></i></a>
                            </td>
                        </tr>
                        <?php $no++ ?>
                        <?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<?php }else{ ?>
			<div class="alert alert-warning" role="alert">
				Opss, kategori masih kosong, yuk tambah kategori sekarang.
			</div>
            <?php } ?>
		</div>
	</div>
</div>
<!-- /.container-fluid -->

<!-- Modal Add Category -->
<div class="modal fade" id="addCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="<?= base_url(); ?>administrator/categories" method="post" enctype="multipart/form-data">
					<div class="form-group">
						<label for="name">Nama Kategori Produk</label>
						<input type="text" class="form-control" id="name" name="name" autocomplete="off" required/>
					</div>
					<div class="form-group">
						<label for="icon">Icon Kategori Produk</label>
						<input type="file" class="form-control" required name="icon" id="icon"/>
						<small id="iconHelp" class="form-text text-muted">100 x 100px</small>
					</div>
					<button type="submit" class="btn btn-primary" id="btnAddCategory">
						Tambahkan Produk
					</button>
				</form>
			</div>
		</div>
	</div>
</div>
