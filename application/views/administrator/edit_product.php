<?php echo $this->session->flashdata('upload'); ?>

<!-- Begin Page Content -->
<div class="container-fluid">
	<!-- Page Heading -->

	<!-- DataTales Example -->
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<a href="<?= base_url(); ?>administrator/products" class="btn btn-danger"><i class="fa fa-times-circle"></i> Batal</a>
		</div>
		<div class="card-body">
			<form action="<?= base_url(); ?>administrator/product/<?= $product['productId'] ?>/edit" method="post" enctype="multipart/form-data">
				<div class="form-row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="title">Nama Produk</label>
							<input type="text" class="form-control" id="title" name="title" placeholder="Isikan Nama Produk" autocomplete="off" required value="<?= $product['title']; ?>"/>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="price">Harga Produk</label>
							<input type="number" class="form-control" id="price" name="price" placeholder="Harga Produk" autocomplete="off"required value="<?= $product['price']; ?>"/>
						</div>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="stock">Jumlah Produk</label>
							<input type="number" class="form-control" id="stock" name="stock" placeholder="Jumlah Produk" autocomplete="off"required value="<?= $product['stock']; ?>"/>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="cat">Kategori Produk</label>
							<select class="form-control" id="cat" name="category">]
								<option value="<?= $product['category'] ?>"><?= $product['name'] ?></option>
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
							<select class="form-control" id="condit" name="condit">
                                <?php if($product['condit'] == 1){ ?>
                                    <option value="1">Masih Tersedia</option>
								    <option value="2">Produk Habis</option>
                                <?php }else{ ?>
								    <option value="2">Masih Tersedia</option>
                                    <option value="1">Produk Habis</option>
                                <?php } ?>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="status">Status Produk</label>
							<select class="form-control" id="status" name="status">
                                <?php if($product['publish'] == 1){ ?>
                                    <option value="1">Publish</option>
								    <option value="2">Draft</option>
                                <?php }else{ ?>
								    <option value="2">Draft</option>
                                    <option value="1">Publish</option>
                                <?php } ?>
							</select>
						</div>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="img">Foto Utama</label>
							<input type="file" name="img" id="img" class="form-control"/>
						</div>
                        <label>Foto Lama</label>
                        <img src="<?= base_url(); ?>assets/images/product/<?= $product['img']; ?>" style="width: 150px">
                        <input type="hidden" name="oldImg" value="<?= $product['img']; ?>">
                    </div>
				</div>
				<div class="form-group">
					<label for="description">Deskripsi</label>
					<textarea class="form-control" id="description" name="description" rows="7" required><?= $product['description']; ?></textarea>
				</div>
				<button type="submit" class="btn btn-primary">Edit Produk</button>
			</form>
		</div>
	</div>
</div>
<!-- /.container-fluid -->
