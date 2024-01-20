<?php if($this->session->userdata('login')){ ?>
  <?php
  $user = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
  $cart = $this->db->get_where('cart', ['user' => $this->session->userdata('id')]);
  ?>
<?php } ?>
<?php
$menu = $this->db->get('menu');
$settingss = $this->db->get('settings')->row_array();
?>

<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark" style="background-color: #005CAA !important">
  <div class="container">
    <div class="collapse navbar-collapse ml-3" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
      <?php foreach($menu->result_array() as $m): ?>
      <?php
      if(substr($m['link'],0,4) == "http" || substr($m['link'],0,3) == "www"){
          $newlink1 = $m['link'];
      }else{
          $newlink1 = base_url() . $m['link'];
      }
      ?>
      <?php if($this->Settings_model->getSubMenu($m['id'])->num_rows() > 0){ ?>
        
        <li class="nav-item dropdown">
          <a class="nav-link text-light dropdown-toggle" href="#" id="navbarDropdownCategories<?= $m['id'] ?>" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?= $m['title']; ?>
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownCategories<?= $m['id'] ?>">
            <?php foreach($this->Settings_model->getSubMenu($m['id'])->result_array() as $cat): ?>
              <?php
              if(substr($cat['link'],0,4) == "http" || substr($cat['link'],0,3) == "www"){
                  $newlink = $cat['link'];
              }else{
                  $newlink = base_url() . $cat['link'];
              }
              ?>
              <a class="dropdown-item" href="<?= $newlink; ?>"><?= $cat['name']; ?></a>
            <?php endforeach; ?>
          </div>
        </li>
      <?php }else{ ?>
        <li class="nav-item active">
          <a class="nav-link" href="<?= $newlink1; ?>"><?= $m['title']; ?></a>
        </li>
      <?php } ?>
      <?php endforeach; ?>
      </ul>
      <br>
      <div>
      </div>
      <?php if($this->session->userdata('login')){ ?>
        <a href="<?= base_url(); ?>cart" class="text-light navbar-cart-inform">
          <i class="fa fa-shopping-cart"></i>
          <?php if($cart->num_rows() > 0){ ?>
            Cart(<?= $cart->num_rows(); ?>)
          <?php }else{ ?>
            Cart
          <?php } ?>
        </a>
      <?php } ?>
    </div>
    <?php if(!$this->session->userdata('login')){ ?>
      <div class="for-hidden">
      </div>
    <?php }else{ ?>
      <div>
      <img src="<?= base_url(); ?>assets/images/profile/<?= $user['photo_profile']; ?>" class="photo-profile-mobile" alt="Photo Profile <?= $user['name']; ?>" class="photo" data-toggle="dropdown" id="dropdownPhotoProfileNavbarMobile" aria-haspopup="true" aria-expanded="false">
      <div class="dropdown-menu dropdownPhotoProfileNavbarMobile" aria-labelledby="dropdownPhotoProfileNavbarMobile">
        <a class="dropdown-item" href="<?= base_url(); ?>profile">Profile</a>
        <a class="dropdown-item" href="<?= base_url(); ?>logout">Keluar</a>
      </div>
    </div>
    <?php } ?>
  </div>
</nav>
<div class="top-nav"></div>
