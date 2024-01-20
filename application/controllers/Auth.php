<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('cookie');
		if($this->session->userdata('login')){
			redirect(base_url());
        }else{
			$cookie = get_cookie('e382jxndj');
            if($cookie != NULL){
				$getCookie = $this->db->get_where('user', ['cookie' => $cookie])->row_array();
                if($getCookie){
                    $dataCookie = $getCookie;
                    $dataSession = [
                        'id' => $dataCookie['id']
                    ];
                    $this->session->set_userdata('login', true);
					$this->session->set_userdata($dataSession);
					redirect(base_url());
                }
            }
		}
    }

    public function register(){
        $this->form_validation->set_rules('name', 'Name', 'required|max_length[40]', ['required' => 'Nama wajib diisi', 'max_length' => 'Panjang nama maksimal 40 karakter']);
        $this->form_validation->set_rules('email', 'Email', 'required|max_length[50]|valid_email', ['required' => 'Email wajib diisi', 'max_length' => 'Panjang email maksimal 50 karakter', 'valid_email' => 'Email tidak valid']);
        $this->form_validation->set_rules('password', 'Password', 'matches[password1]|required', ['matches' => 'password tidak sama', 'required' => 'Password wajib diisi']);
	    $this->form_validation->set_rules('password1', 'Password', 'matches[password]', ['matches' => 'password tidak sama']);
	    if($this->form_validation->run() == false){
            $data['title'] = 'Daftar | Website_Apotek';
            $data['css'] = 'auth';
            $this->load->view('auth/register', $data);
            $this->load->view('templates/footer_notmpl');
        }else{
            $this->User_model->register();
            $this->session->set_flashdata('success', "Berhasil Registrasi");
            redirect(base_url() . 'register');
        }
    }

    public function login(){
        $this->form_validation->set_rules('email', 'Email', 'required', ['required' => 'Email wajib diisi']);
        $this->form_validation->set_rules('password', 'Password', 'required', ['required' => 'Password wajib diisi'
	    ]);
	    if($this->form_validation->run() == false){
            $data['title'] = 'Login | Website_Apotek';
            $data['css'] = 'auth';
            $data['redirect'] = $_GET['redirect'];
            $this->load->view('auth/login', $data);
            $this->load->view('templates/footer_notmpl');
        }else{
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $remember = $this->input->post('remember');
            $user = $this->db->get_where('user', ['email' => $email])->row_array();
            if($user){
                if(password_verify($password, $user['password'])){
                    if($user['is_activate'] == 1){
                        $this->session->set_flashdata('failed', '<div class="alert alert-danger" role="alert">
                            Akun belum aktif, silakan verifikasi email terlebih dahulu
                        </div>');
                        redirect(base_url() . 'login');
                    }else{
                        $data = [
                            'id' => $user['id']
                        ];
                        if($remember != NULL){
                            $key = random_string('alnum', 64);
                            set_cookie('e382jxndj', $key, 3600*24*30*12);
                            $this->db->set('cookie', $key);
                            $this->db->where('id', $user['id']);
                            $this->db->update('user');
                        }
                        $this->session->set_userdata('login', true);
                        $this->session->set_userdata($data);
                        redirect(base_url() . $_GET['redirect']);
                    }
                }else{
                    $this->session->set_flashdata('failed', '<div class="alert alert-danger" role="alert">
                        Password salah
                    </div>');
                    redirect(base_url() . 'login');
                }
            }else{
                $this->session->set_flashdata('failed', '<div class="alert alert-danger" role="alert">
                    Email tidak terdaftar
                </div>');
                redirect(base_url() . 'login');
            }
        }
    }
    
}