<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-center mb-4">
  <h1 class="h3 mb-0 text-gray-800">DASHBOARD</h1>
</div>

<!-- Content Row -->
<div class="row">

  <?php $data = $this->db->get('user')->num_rows(); ?>
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">USER</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $data; ?></div>
          </div>
          <div class="col-auto">
            <i class="fas fa-calendar fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">PESANAN MASUK</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
          </div>
          <div class="col-auto">
            <i class="fas fa-calendar fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php $data = $this->db->get('categories')->num_rows(); ?>
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">KATEGORI PRODUK</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $data; ?></div>
          </div>
          <div class="col-auto">
            <i class="fas fa-calendar fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php $data = $this->db->get('products')->num_rows(); ?>
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">DATA PRODUK</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $data; ?></div>
          </div>
          <div class="col-auto">
            <i class="fas fa-calendar fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
          <div align="center" style="margin:15px 0px 0px 0px">
          <script type="text/javascript" src="http://localtimes.info/clock.php?continent=Asia&country=Indonesia&city=Jakarta&widget_number=125&cp3_Hex=000000&cp2_Hex=040404&cp1_Hex=FFFFFF&ham=0&fwdt=125&ham=1"></script>
          </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>

</div>