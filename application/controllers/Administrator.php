<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administrator extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper('cookie');
        $this->load->library('form_validation');
        $this->load->model('Categories_model');
        $this->load->model('Products_model');
        $this->load->model('Settings_model');
        $this->load->model('Order_model');
        if(!$this->session->userdata('admin')){
            $cookie = get_cookie('djehbicd');
            if($cookie == NULL){
                redirect(base_url());
            }else{
                $getCookie = $this->db->get_where('admin', ['cookie' => $cookie])->row_array();
                if($getCookie){
                    $this->session->set_userdata('admin', true);
                }else{
                    redirect(base_url());
                }
            }
        }
    }

    public function index(){
        $data['title'] = 'Dashboard | Website_Apotek';
        $this->load->view('templates/header_admin', $data);
        $this->load->view('administrator/index');
        $this->load->view('templates/footer_admin');
    }

    public function users(){
        $data['title'] = 'Pengguna | Website_Apotek';
        $config['base_url'] = base_url() . 'administrator/users/';
        $config['total_rows'] = $this->User_model->getUsers("","")->num_rows();
        $config['per_page'] = 10;
        $config['first_link']       = 'First';
        $config['last_link']        = 'Last';
        $config['next_link']        = 'Next';
        $config['prev_link']        = 'Prev';
        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tagl_close']  = '</span>Next</li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tagl_close']  = '</span></li>';
        $from = $this->uri->segment(3);
        $this->pagination->initialize($config);
        $data['users'] = $this->User_model->getUsers($config['per_page'], $from);
        $this->load->view('templates/header_admin', $data);
        $this->load->view('administrator/users', $data);
        $this->load->view('templates/footer_admin');
    }

    public function active_user($id){
        $this->db->set('is_activate', 1);
        $this->db->where('id', $id);
        $this->db->update('user');
        redirect(base_url() . 'administrator/users');
    }

    public function nonactive_user($id){
        $this->db->set('is_activate', 0);
        $this->db->where('id', $id);
        $this->db->update('user');
        redirect(base_url() . 'administrator/users');
    }

    // categories
    public function categories(){
        $this->form_validation->set_rules('name', 'Name', 'required', ['required' => 'Nama kategori wajib diisi']);
        if($this->form_validation->run() == false){
            $data['title'] = 'Kategori | Website_Apotek';
            $data['getCategories'] = $this->Categories_model->getCategories();
            $this->load->view('templates/header_admin', $data);
            $this->load->view('administrator/categories', $data);
            $this->load->view('templates/footer_admin');
        }else{
            $data = array();
            $upload = $this->Categories_model->uploadIcon();

            if($upload['result'] == 'success'){
                $this->Categories_model->insertCategory($upload);
                $this->session->set_flashdata('upload', "<script>
                    swal({
                    text: 'Kategori berhasil ditambahkan',
                    icon: 'success'
                    });
                    </script>");
                    redirect(base_url() . 'administrator/categories');
            }else{
                $this->session->set_flashdata('failed', "<div class='alert alert-danger' role='alert'>
                Gagal menambah kategori, pastikan icon berukuran maksimal 2mb dan berformat png, jpg, jpeg. Silakan ulangi lagi.
              </div>");
                redirect(base_url() . 'administrator/categories');
            }
        }
    }

    public function category($id){
        $this->form_validation->set_rules('name', 'Name', 'required', ['required' => 'Nama kategori wajib diisi']);
        if($this->form_validation->run() == false){
            $data['title'] = 'Edit Kategori | Website_Apotek';
            $data['category'] = $this->Categories_model->getCategoryById($id);
            $this->load->view('templates/header_admin', $data);
            $this->load->view('administrator/edit_category', $data);
            $this->load->view('templates/footer_admin');
        }else{
            if($_FILES['icon']['name'] != ""){
                $data = array();
                $upload = $this->Categories_model->uploadIcon();
                if($upload['result'] == 'success'){
                    $this->Categories_model->updateCategory($upload['file']['file_name'], $id);
                    $this->session->set_flashdata('upload', "<script>
                        swal({
                        text: 'Kategori berhasil diubah',
                        icon: 'success'
                        });
                        </script>");
                        redirect(base_url() . 'administrator/categories');
                }else{
                    $this->session->set_flashdata('failed', "<div class='alert alert-danger' role='alert'>
                    Gagal mengubah kategori, pastikan icon berukuran maksimal 2mb dan berformat png, jpg, jpeg. Silakan ulangi lagi.
                  </div>");
                    redirect(base_url() . 'administrator/category/' . $id);
                }
            }else{
                $oldIcon = $this->input->post('oldIcon');
                $this->Categories_model->updateCategory($oldIcon, $id);
                $this->session->set_flashdata('upload', "<script>
                    swal({
                    text: 'Kategori berhasil diubah',
                    icon: 'success'
                    });
                    </script>");
                redirect(base_url() . 'administrator/categories');
            }
        }
    }

    public function deleteCategory($id){
        $this->db->where('id', $id);
        $this->db->delete('categories');
        $this->db->where('category', $id);
        $this->db->delete('products');
        $this->session->set_flashdata('upload', "<script>
            swal({
            text: 'Kategori berhasil dihapus',
            icon: 'success'
            });
            </script>");
        redirect(base_url() . 'administrator/categories');
    }

    // products
    public function products(){
        $data['title'] = 'Produk | Website_Apotek';
        $config['base_url'] = base_url() . 'administrator/products/';
        $config['total_rows'] = $this->Products_model->getProducts("","")->num_rows();
        $config['per_page'] = 10;
        $config['first_link']       = 'First';
        $config['last_link']        = 'Last';
        $config['next_link']        = 'Next';
        $config['prev_link']        = 'Prev';
        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tagl_close']  = '</span>Next</li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tagl_close']  = '</span></li>';
        $from = $this->uri->segment(3);
        $this->pagination->initialize($config);
        $data['getProducts'] = $this->Products_model->getProducts($config['per_page'], $from);
        $this->load->view('templates/header_admin', $data);
        $this->load->view('administrator/products', $data);
        $this->load->view('templates/footer_admin');
    }

    public function add_product(){
        $this->form_validation->set_rules('title', 'title', 'required', ['required' => 'Judul wajib diisi']);
        if($this->form_validation->run() == false){
            $data['title'] = 'Tambah Produk | Website_Apotek';
            $data['categories'] = $this->Categories_model->getCategories();
            $this->load->view('templates/header_admin', $data);
            $this->load->view('administrator/add_product', $data);
            $this->load->view('templates/footer_admin');
        }else{
            $data = array();
            $upload = $this->Products_model->uploadImg();
            if($upload['result'] == 'success'){
                $this->Products_model->insertProduct($upload);
                $this->session->set_flashdata('upload', "<script>
                    swal({
                    text: 'Produk berhasil ditambahkan',
                    icon: 'success'
                    });
                    </script>");
                    redirect(base_url() . 'administrator/products');
            }else{
                $this->session->set_flashdata('failed', "<div class='alert alert-danger' role='alert'>
                Gagal menambah produk, pastikan icon berukuran maksimal 2mb dan berformat png, jpg, jpeg. Silakan ulangi lagi.
              </div>");
                redirect(base_url() . 'administrator/product/add');
            }
        }
    }

    public function add_img_product($id){
        $this->form_validation->set_rules('help', 'help', 'required');
        if($this->form_validation->run() == false){
            $data['title'] = 'Tambah Gambar | Website_Apotek';
            $data['product'] = $this->Products_model->getProductById($id);
            $data['img'] = $this->db->get_where('img_product', ['id_product' => $id]);
            $this->load->view('templates/header_admin', $data);
            $this->load->view('administrator/add_img_product', $data);
            $this->load->view('templates/footer_admin');
        }else{
            $data = array();
            $upload = $this->Products_model->uploadImg();
            if($upload['result'] == 'success'){
                $this->Products_model->insertImg($upload, $id);
                $this->session->set_flashdata('upload', "<script>
                    swal({
                    text: 'Gambar berhasil ditambahkan',
                    icon: 'success'
                    });
                    </script>");
                    redirect(base_url() . 'administrator/product/add-img/'.$id);
            }else{
                $this->session->set_flashdata('failed', "<div class='alert alert-danger' role='alert'>
                Gagal menambah gambar, pastikan gambar berukuran maksimal 10mb dan berformat png, jpg, jpeg. Silakan ulangi lagi.
              </div>");
                redirect(base_url() . 'administrator/product/add-img/'.$id);
            }
        }
    }

    public function add_grosir_product($id){
        $this->form_validation->set_rules('min', 'min', 'required', ['required' => 'Jumlah min. harus diisi']);
        if($this->form_validation->run() == false){
            $data['title'] = 'Tambah Harga Grosir | Website_Apotek';
            $data['product'] = $this->Products_model->getProductById($id);
            $this->db->order_by('id', 'desc');
            $data['grosir'] = $this->db->get_where('grosir', ['product' => $id]);
            $this->load->view('templates/header_admin', $data);
            $this->load->view('administrator/add_grosir_product', $data);
            $this->load->view('templates/footer_admin');
        }else{
            $this->db->order_by('id', 'desc');
            $check = $this->db->get_where('grosir', ['product' => $id]);
            $min = $this->input->post('min');
            $price = $this->input->post('price');
            $product = $this->Products_model->getProductById($id);
            if($check->num_rows() > 0){
                $jmlsebelumnya = $check->row_array()['min'] + 1;
                if($min < $jmlsebelumnya){
                    $this->session->set_flashdata('failed', "<div class='alert alert-danger' role='alert'>
                    Gagal menambahkan harga grosir, pastikan jumlah minimal adalah $jmlsebelumnya
                  </div>");
                    redirect(base_url() . 'administrator/product/grosir/'.$id);
                }else{
                    $data = [
                        'min' => $min,
                        'price' => $price,
                        'product' => $id
                    ];
                    $this->db->insert('grosir', $data);
                    $this->session->set_flashdata('upload', "<script>
                    swal({
                    text: 'Harga grosir berhasil ditambahkan',
                    icon: 'success'
                    });
                    </script>");
                    redirect(base_url() . 'administrator/product/grosir/'.$id);
                }
            }else{
                if($min < 2){
                    $this->session->set_flashdata('failed', "<div class='alert alert-danger' role='alert'>
                    Gagal menambahkan harga grosir, pastikan jumlah minimal adalah 2
                  </div>");
                    redirect(base_url() . 'administrator/product/grosir/'.$id);
                }else{
                    $data = [
                        'min' => $min,
                        'price' => $price,
                        'product' => $id
                    ];
                    $this->db->insert('grosir', $data);
                    $this->session->set_flashdata('upload', "<script>
                    swal({
                    text: 'Harga grosir berhasil ditambahkan',
                    icon: 'success'
                    });
                    </script>");
                    redirect(base_url() . 'administrator/product/grosir/'.$id);
                }
            }
        }
    }

    public function delete_img_other_product($id, $idp){
        $this->db->where('id', $id);
        $this->db->delete('img_product');
        $this->session->set_flashdata('upload', "<script>
        swal({
        text: 'Gambar berhasil dihapus',
        icon: 'success'
        });
        </script>");
        redirect(base_url() . 'administrator/product/add-img/'.$idp);
    }

    public function edit_product($id){
        $this->form_validation->set_rules('title', 'title', 'required', ['required' => 'Judul wajib diisi']);
        if($this->form_validation->run() == false){
            $data['title'] = 'Edit Produk | Website_Apotek';
            $data['categories'] = $this->Categories_model->getCategories();
            $data['product'] = $this->Products_model->getProductById($id);
            $this->load->view('templates/header_admin', $data);
            $this->load->view('administrator/edit_product', $data);
            $this->load->view('templates/footer_admin');
        }else{
            if($_FILES['img']['name'] != ""){
                $data = array();
                $upload = $this->Products_model->uploadImg();

                if($upload['result'] == 'success'){
                    $this->Products_model->updateProduct($upload['file']['file_name'], $id);
                    $this->session->set_flashdata('upload', "<script>
                        swal({
                        text: 'Produk berhasil diubah',
                        icon: 'success'
                        });
                        </script>");
                        redirect(base_url() . 'administrator/products');
                }else{
                    $this->session->set_flashdata('failed', "<div class='alert alert-danger' role='alert'>
                    Gagal mengubah produk, pastikan icon berukuran maksimal 2mb dan berformat png, jpg, jpeg. Silakan ulangi lagi.
                </div>");
                    redirect(base_url() . 'administrator/product/' . $id . '/edit');
                }
            }else{
                $oldImg = $this->input->post('oldImg');
                $this->Products_model->updateProduct($oldImg, $id);
                $this->session->set_flashdata('upload', "<script>
                    swal({
                    text: 'Produk berhasil diubah',
                    icon: 'success'
                    });
                    </script>");
                redirect(base_url() . 'administrator/products');
            }
        }
    }

    public function product($id){
        $data['title'] = 'Detail Produk | Website_Apotek';
        $data['product'] = $this->Products_model->getProductById($id);
        $this->load->view('templates/header_admin', $data);
        $this->load->view('administrator/detail_product', $data);
        $this->load->view('templates/footer_admin');
    }

    public function delete_product($id){
        $this->db->where('id', $id);
        $this->db->delete('products');
        $this->session->set_flashdata('upload', "<script>
            swal({
            text: 'Produk berhasil dihapus',
            icon: 'success'
            });
            </script>");
        redirect(base_url() . 'administrator/products');
    }

    // settings
    public function settings(){
        $data['title'] = 'Pengaturan | Website_Apotek';
        $this->load->view('templates/header_admin', $data);
        $this->load->view('administrator/settings', $data);
        $this->load->view('templates/footer_admin');
    }

    
    public function navmenu_setting(){
        $data['title'] = 'Pengaturan | Website_Apotek';
        $data['menu'] = $this->db->get('menu');
        $this->load->view('templates/header_admin', $data);
        $this->load->view('administrator/setting_navmenu', $data);
        $this->load->view('templates/footer_admin');
    }

    public function add_navmenu_setting(){
        $this->form_validation->set_rules('title', 'Judul', 'required', ['required' => 'Judul wajib diisi']);
        if($this->form_validation->run() == false){
            $data['title'] = 'Pengaturan | Website_Apotek';
            $data['menu'] = $this->db->get('menu');
            $this->load->view('templates/header_admin', $data);
            $this->load->view('administrator/add_setting_navmenu', $data);
            $this->load->view('templates/footer_admin');
        }else{
            $this->Settings_model->addNavMenu();
            $this->session->set_flashdata('upload', "<script>
                swal({
                text: 'Menu Berhasil Disimpan',
                icon: 'success'
                });
                </script>");
            redirect(base_url() . 'administrator/setting/navmenu');
        }
    }

    public function edit_navmenu_setting($id){
        $this->form_validation->set_rules('title', 'Judul', 'required', ['required' => 'Judul wajib diisi']);
        if($this->form_validation->run() == false){
            $data['title'] = 'Pengaturan | Website_Apotek';
            $data['menu'] = $this->db->get_where('menu', ['id' => $id])->row_array();
            $this->load->view('templates/header_admin', $data);
            $this->load->view('administrator/edit_setting_navmenu', $data);
            $this->load->view('templates/footer_admin');
        }else{
            $this->Settings_model->editNavMenu($id);
            $this->session->set_flashdata('upload', "<script>
                swal({
                text: 'Menu Berhasil Diubah',
                icon: 'success'
                });
                </script>");
            redirect(base_url() . 'administrator/setting/navmenu');
        }
    }

    public function delete_navmenu($id){
        $this->db->where('id', $id);
        $this->db->delete('menu');
        $this->db->where('submenu', $id);
        $this->db->delete('submenu');
        $this->session->set_flashdata('upload', "<script>
            swal({
            text: 'Menu Berhasil Dihapus',
            icon: 'success'
            });
            </script>");
        redirect(base_url() . 'administrator/setting/navmenu');
    }

    public function delete_navsubmenu($id){
        $this->db->where('id', $id);
        $this->db->delete('submenu');
        $this->session->set_flashdata('upload', "<script>
            swal({
            text: 'Submenu Berhasil Dihapus',
            icon: 'success'
            });
            </script>");
        redirect(base_url() . 'administrator/setting/navmenu');
    }

    public function banner_setting(){
        $data['title'] = 'Pengaturan | Website_Apotek';
        $data['banner'] = $this->Settings_model->getBanner();
        $this->load->view('templates/header_admin', $data);
        $this->load->view('administrator/setting_banner', $data);
        $this->load->view('templates/footer_admin');
    }

    public function add_banner_setting(){
        $data['title'] = 'Pengaturan | Website_Apotek';
        $this->load->view('templates/header_admin', $data);
        $this->load->view('administrator/add_setting_banner', $data);
        $this->load->view('templates/footer_admin');
    }

    public function add_banner_setting_post(){
        $data = array();
        $upload = $this->Settings_model->uploadImg();
        if($upload['result'] == 'success'){
            $insert = $this->Settings_model->insertBanner($upload);
            if($insert){
                $this->session->set_flashdata('upload', "<script>
                    swal({
                    text: 'Banner berhasil ditambahkan',
                    icon: 'success'
                    });
                    </script>");
                redirect(base_url() . 'administrator/setting/banner');
            }else{
                $this->session->set_flashdata('failed', "<div class='alert alert-danger' role='alert'>
                Gagal menambah banner, gambar yang kamu upload tidak berukuran 1700x400px.
                </div>");
                redirect(base_url() . 'administrator/setting/banner/add');
            }
        }else{
            $this->session->set_flashdata('failed', "<div class='alert alert-danger' role='alert'>
            Gagal menambah banner, pastikan banner berukuran maksimal 2mb, berformat png, jpg, jpeg. Dan berukuran 1600x400px.
            </div>");
            redirect(base_url() . 'administrator/setting/banner/add');
        }
    }

    public function delete_banner($id){
        $this->db->where('id', $id);
        $this->db->delete('banner');
        $this->session->set_flashdata('upload', "<script>
            swal({
            text: 'Banner Berhasil Dihapus',
            icon: 'success'
            });
            </script>");
        redirect(base_url() . 'administrator/setting/banner');
    }

    // ajax
    public function ajax_get_product_by_id($id){
        $return = $this->Products_model->getProductById($id);
        echo json_encode($return);
    }

    // edit
    public function edit(){
        $data['title'] = 'Edit Profil Admin | Website_Apotek';
        $admin = $this->db->get('admin')->row_array();
        $data['admin'] = $admin;
        $this->load->view('templates/header_admin', $data);
        $this->load->view('administrator/edit', $data);
        $this->load->view('templates/footer_admin');
    }

    public function edit_username(){
        $this->db->set('username', $this->input->post('username'));
        $this->db->update('admin');
        $this->session->set_flashdata('upload', "<script>
            swal({
            text: 'Username berhasil diubah',
            icon: 'success'
            });
            </script>");
        redirect(base_url() . 'administrator/edit');
    }

    public function edit_pass(){
        $admin = $this->db->get('admin')->row_array();
        if(password_verify($this->input->post('oldPassword'), $admin['password'])){
            if($this->input->post('newPassword') ==  $this->input->post('confirmPassword')){
                $pass = password_hash($this->input->post('newPassword'), PASSWORD_DEFAULT);
                $this->db->set('password', $pass);
                $this->db->update('admin');
                $this->session->set_flashdata('upload', "<script>
                    swal({
                    text: 'Password berhasil diubah',
                    icon: 'success'
                    });
                    </script>");
                redirect(base_url() . 'administrator/edit');
            }else{
                $this->session->set_flashdata('upload', "<script>
                    swal({
                    text: 'Konfirmasi password tidak sama. Silakan coba lagi',
                    icon: 'error'
                    });
                    </script>");
                redirect(base_url() . 'administrator/edit');
            }
        }else{
            $this->session->set_flashdata('upload', "<script>
                swal({
                text: 'Password lama salah. Silakan coba lagi',
                icon: 'error'
                });
                </script>");
            redirect(base_url() . 'administrator/edit');
        }
    }

    public function logout(){
        $sess = ['admin'];
		$this->session->unset_userdata($sess);
        delete_cookie('djehbicd');
        redirect(base_url() . 'login/admin');
    }

}
