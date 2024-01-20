<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('Categories_model');
		$this->load->model('Products_model');
		$this->load->model('Settings_model');
		$this->load->helper('cookie');
	}

	public function index(){
		$data['title'] =  'HOME | Website_Apotek';
		$data['css'] = 'style';
		$data['responsive'] = 'style-responsive';
		$data['setting'] = $this->Settings_model->getSetting();
		$data['categories'] = $this->Categories_model->getCategories();
		$data['categoriesLimit'] = $this->Categories_model->getCategoriesLimit();
		$data['recent'] = $this->Products_model->getProductsLimit();
		$data['best'] = $this->Products_model->getBestProductsLimit();
		$data['allProducts'] = $this->db->get('products');
		$this->load->view('templates/header', $data);
		$this->load->view('templates/navbar');
		$this->load->view('templates/banner');
		$this->load->view('index', $data);
		$this->load->view('templates/footer');
	}

	public function notfound(){
		$this->load->view('404');
	}

	public function login(){
		$this->load->helper('cookie');
		if($this->session->userdata('admin')){
			redirect(base_url() . 'administrator');
        }else{
			$cookie = get_cookie('djehbicd');
            if($cookie != NULL){
				$getCookie = $this->db->get_where('admin', ['cookie' => $cookie])->row_array();
                if($getCookie){
                    $dataCookie = $getCookie;
                    $this->session->set_userdata('admin', true);
					redirect(base_url() . 'administrator');
                }
            }
		}
        $this->form_validation->set_rules('username', 'username', 'required', ['required' => 'username wajib diisi']);
        if($this->form_validation->run() == false){
          $this->load->view('login');
        }else{
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $cookie = $this->input->post('cookie');
            $admin = $this->db->get_where('admin', ['username' => $username])->row_array();

            if($admin){
                if(password_verify($password, $admin['password'])){
                if($cookie != NULL){
                    $key = random_string('alnum', 64);
                    set_cookie('djehbicd', $key, 3600*24*30*12);
                    $this->db->set('cookie', $key);
                    $this->db->update('admin');
                }                             
                $this->session->set_userdata('admin', true);
                $this->session->set_userdata($data);
                redirect(base_url() . 'administrator');
                }else{
                  $this->session->set_flashdata('failed', '<div class="alert alert-danger" role="alert">
                              Password salah!
                            </div>');
                            redirect(base_url() . 'login/admin');
                }
              }else{
              $this->session->set_flashdata('failed', '<div class="alert alert-danger" role="alert">
                Username salah!
              </div>');
              redirect(base_url() . 'login/admin');
            }
        }
	}

	public function logout(){
		$sess = ['login','id'];
		$this->session->unset_userdata($sess);
        delete_cookie('e382jxndj');
        redirect(base_url() . 'login');
	}

}
