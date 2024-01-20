<div class="wrapper">
    <div class="core mt-4">
        <div class="product">
            <?php if($cart->num_rows() > 0){ ?>
            <?php foreach($cart->result_array() as $item): ?>
            <div class="item">
                <div class="item-main">
                    <img src="<?= base_url(); ?>assets/images/product/<?= $item['img']; ?>" alt="<?= $item['product_name']; ?>">
                    <a href="<?= base_url(); ?>p/<?= $item['slug']; ?>"><h2 class="title mb-0"><?= $item['product_name']; ?></h2></a>
                    <small class="text-muted">Jumlah: <?= $item['qty']; ?></small>
                    <h3 class="price mt-0 mb-0">Rp <?= number_format($item['price'] * $item['qty'],0,",","."); ?></h3>
                    <div class="clearfix"></div>
                </div>
                <a href="<?= base_url(); ?>cart/delete/<?= $item['id']; ?>" onclick="return confirm('Yakin ingin menghapus produk ini dari troli?')"><i class="fa fa-trash"></i></a>
            </div>
            <hr>
            <?php endforeach; ?>
            <a href="<?= base_url(); ?>cart/delete_cart" onclick="return confirm('Apakah Anda yakin akan mengosongkan Troli?')"><button class="btn btn-danger">Kosongkan</button></a>
            <?php }else{ ?>
                <div class="alert alert-warning">Upss. keranjang masih kosong. Yuk belanja terlebih dahulu..</div>
                <br><br><br>
            <?php } ?>
        </div>
        <?php
        $totalall = 0;
        $totalitem = 0;
        foreach($cart->result_array() as $c){
            $totalall += intval($c['price']) * intval($c['qty']);
            $totalitem += intval($c['qty']);
        }
        ?>
        <div class="total shadow">
        <img src="<?php echo base_url('assets/images/banner/01.jpg')?>" width="335" height="auto">
            <h2 class="title text-center">RIWAYAT TRANSAKSI</h2>
            <hr>
            <div class="list">
                <p>Total Jumlah Barang</p>
                <p><?= $totalitem; ?></p>
            </div>
            <div class="list">
                <p>Total Harga Barang</p>
                <p>Rp <?= number_format($totalall,0,",","."); ?></p>
            </div>
            <table class="table table-bordered">
            <tbody>
            <tr>
                <td>
                <label for="nama_user">Nama :</label>
                <input type="text" class="form-control" id="nama_user" name="nama_user" placeholder="Isikan Nama Lengkap">
                </td>
            </tr>
            <tr>
                <td>
                <label for="alamat_lengkap">Alamat Lengkap :</label>
                <input type="text" class="form-control" id="alamat_lengkap" name="alamat_lengkap" placeholder="Isikan Alamat Lengkap">
                </td>
            </tr>
            <tr>
                <td>
                <label for="no_handphone">No Handphone :</label>
                <input type="text" class="form-control" id="no_handphone" name="no_handphone" placeholder="Masukan No Handphone Aktif">
                </td>
            </tr>
            <tr>
            <td>
                <label for="metode_pembayaran">Metode Pembayaran</label>
                <select class="form-control" id="metode_pembayaran" name="metode_pembayaran">
                    <option value="transfer_bank">Pilih Metode Pembayaran :</option>
                    <option value="transfer_bank">Transfer via Bank</option>
                    <option value="kartu_kredit">Kartu Kredit</option>
                    <option value="e-wallet">E-Wallet</option>
                    <option value="dana">Dana</option>
                    <option value="tunai">Pembayaran Tunai</option>
                </select>
            </td>
            </tr>
            <tr id="bank-account" style="display: none;">
            <td>
                <label for="no_rekening">Nomor Rekening BCA :</label>
                <input type="text" class="form-control" id="no_rekening" name="no_rekening" placeholder="123456789101112" readonly>
            </td>
            </tr>
            <tr id="phone-number" style="display: none;">
                <td>
                    <label for="no_handphone">Nomor Rekening :</label>
                    <input type="text" class="form-control" id="no_handphone" name="no_handphone" placeholder="123456789010" readonly>
                </td>
            </tr>
            <tr>
                <td>
                <label for="upload_bukti">Unggah Foto Bukti Pembayaran :</label>
                <input type="file" class="form-control-file" id="upload_bukti" name="upload_bukti" accept="image/*">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                <div id="uploaded-photo"></div>
                </td>
            </tr>
            </tbody>
            </table>
            <?php if($cart->num_rows() > 0){ ?>
                <a href="<?= base_url('profile') ?>?order_success=true">
                    <button class="btn btn-danger btn btn-block mt-2" onclick="confirmGeneratePNGImage()">Check Out</button>
                </a>
            <?php }else{ ?>
                <a href="<?= base_url(); ?>">
                    <button class="btn btn-danger btn btn-block mt-2">Belanja Dulu</button>
                </a>
            <?php } ?>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script>

    function generatePNGImage() {
        var nama = document.getElementById("nama_user").value;
        var alamat = document.getElementById("alamat_lengkap").value;
        var noHandphone = document.getElementById("no_handphone").value;
        var metodePembayaran = document.getElementById("metode_pembayaran").value;
        var totalJumlahBarang = <?= $totalitem; ?>;
        var totalHargaBarang = <?= $totalall; ?>;
        var fileName = "bukti_transaksi.png";
        var canvas = document.createElement("canvas");
        var context = canvas.getContext("2d");

        canvas.width = 700;
        canvas.height = 500;
        
        // Menggambar latar belakang
        var backgroundImage = new Image();
        backgroundImage.src = "assets/images/banner/02.jpg"; // Ganti dengan path gambar latar belakang yang sesuai
        backgroundImage.onload = function() {
            context.drawImage(backgroundImage, 0, 0, canvas.width, canvas.height);
            
            // Menggambar teks hitam
            context.font = "17px Courier";
            context.fillStyle = "#001";
            context.fillText("Nama: " + nama, 10, 30);
            context.fillText("Alamat Lengkap: " + alamat, 10, 60);
            context.fillText("No Handphone: " + noHandphone, 10, 90);
            context.fillText("Metode Pembayaran: " + metodePembayaran, 10, 120);
            
            // Mengatur posisi teks "Total Jumlah Barang" dan "Total Harga Barang" di pojok kanan bawah
            var totalTextX = canvas.width - 10;
            var totalTextY = canvas.height - 20;
            context.textAlign = "right";
            context.fillText("Total Jumlah Barang: " + totalJumlahBarang, totalTextX, totalTextY);
            context.fillText("Total Harga Barang: Rp " + totalHargaBarang, totalTextX, totalTextY - 30);

            var image = canvas.toDataURL("image/png").replace("image/png", "image/octet-stream");
            var element = document.createElement("a");
            element.setAttribute("href", image);
            element.setAttribute("download", fileName);
            element.style.display = "none";
            document.body.appendChild(element);
            element.click();
            document.body.removeChild(element);
        };
    }

        function confirmGeneratePNGImage() {
        var confirmation = confirm("Apakah Anda yakin akan melanjutkan?");
        if (confirmation) {
            generatePNGImage();
        }
    }

    function showBankAccount() {
        var bankAccount = document.getElementById("bank-account");
        bankAccount.style.display = "block";
    }

    function hideBankAccount() {
        var bankAccount = document.getElementById("bank-account");
        bankAccount.style.display = "none";
    }

    function showPhoneNumber() {
        var phoneNumber = document.getElementById("phone-number");
        phoneNumber.style.display = "block";
    }

    function hidePhoneNumber() {
        var phoneNumber = document.getElementById("phone-number");
        phoneNumber.style.display = "none";
    }

    function previewPhoto(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('uploaded-photo');
            output.innerHTML = '<img src="' + reader.result + '" alt="Foto yang Diunggah">';
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    var uploadInput = document.getElementById('upload_bukti');
    uploadInput.addEventListener('change', previewPhoto);

    var metodePembayaran = document.getElementById('metode_pembayaran');
    metodePembayaran.addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex].value;
        
        if (selectedOption === "transfer_bank") {
            showBankAccount();
            hidePhoneNumber();
        } else if (selectedOption === "dana") {
            showPhoneNumber();
            hideBankAccount();
        } else {
            hideBankAccount();
            hidePhoneNumber();
        }
    });
</script>
