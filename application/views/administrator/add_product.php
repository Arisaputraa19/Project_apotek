<?php echo $this->session->flashdata('upload'); ?>

<!-- Begin Page Content -->
<div class="container-fluid">
	<!-- Page Heading -->
	
	<!-- DataTales Example -->
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<a href="<?= base_url(); ?>administrator/products" class="btn btn-danger"><i class="fa fa-times-circle"></i> Kembali</a>
		</div>
		<div class="card-body">
			<form action="<?= base_url(); ?>administrator/product/add" method="post" enctype="multipart/form-data">
				<div class="form-row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="title">Nama Produk</label>
							<input type="text" class="form-control" id="title" name="title" placeholder="Isikan Nama Produk" autocomplete="off" required value="<?php echo set_value('title'); ?>"/>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="price">Harga Produk</label>
							<input type="number" class="form-control" id="price" name="price" placeholder="Isikan Harga Produk" autocomplete="off" required value=<?php echo set_value('price'); ?>/>
						</div>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="stock">Jumlah Produk</label>
							<input type="number" class="form-control" id="stock" name="stock" placeholder="Isikan Jumlah Produk" autocomplete="off" required value=<?php echo set_value('stock'); ?>/>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="cat">Kategori Produk</label>
							<select class="form-control text-center" id="cat" name="category">
								<option selected disabled value="0">PILIH KATEGORI PRODUK</option>
								<?php foreach($categories->result_array() as $c): ?>
								<option value="<?= $c['id'] ?>"><?= $c['name'] ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="condit">Kondisi Produk</label>
							<select class="form-control text-center" id="condit" name="condit">
								<option value="1">Tersedia</option>
								<option value="2">Produk Habis</option>
							</select>
						</div>
					</div>
                    <div class="col-md-6">
						<div class="form-group">
							<label for="status">Status Produk</label>
							<select class="form-control text-center" id="status" name="status">
								<option value="1">Publish</option>
								<option value="2">Simpan</option>
							</select>
						</div>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="img">Masukan Gambar Produk</label>
							<input type="file" name="img" id="img" class="form-control" required value=<?php echo set_value('img'); ?>/>
						</div>
                    </div>
				</div>
				<div class="form-group text-center">
					<label for="description">Deskripsi Produk</label>
					<textarea class="form-control" id="description" name="description" rows="7"><?php echo set_value('description'); ?></textarea>
				</div>
				<button type="submit" class="btn btn-primary">Unggah Produk</button>
			</form>
		</div>
	</div>
</div>
<!-- /.container-fluid -->
