<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

	public function __construct(){
        parent::__construct();
        $this->load->model('Categories_model');
        $this->load->helper('cookie');
        $this->load->library('form_validation');
        if(!$this->session->userdata('login')){
            $cookie = get_cookie('e382jxndj');
            if($cookie == NULL){
                redirect(base_url() . 'login?redirect=profile');
            }else{
                $getCookie = $this->db->get_where('user', ['cookie' => $cookie])->row_array();
                if($getCookie){
                    $dataCookie = $getCookie;
                    $dataSession = [
                        'id' => $dataCookie['id']
                    ];
                    $this->session->set_userdata('login', true);
                    $this->session->set_userdata($dataSession);
                }else{
                    redirect(base_url() . 'login?redirect=profile');
                }
            }
        }
    }

    public function index(){
        $data['title'] = 'Profil | Website_Apotek';
        $data['css'] = 'profile';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('profile/index');
    }

    public function riwayat_transaksi(){
        $data['title'] = 'Profil | Website_Apotek';
        $data['css'] = 'profile';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('profile/riwayat_transaksi');
    }

    public function edit_profile(){
        $this->form_validation->set_rules('name', 'Nama', 'required', ['required' => 'Nama wajib diisi'
	    ]);
	    if($this->form_validation->run() == false){
            $data['title'] = 'Edit Profil | Website_Apotek';
            $data['css'] = 'profile';
            $data['user'] = $this->User_model->getProfile();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('profile/edit_profile', $data);
        }else{
            if($_FILES['newphoto']['name'] != ""){
                $data = array();
                $upload = $this->User_model->uploadPhoto();
                if($upload['result'] == 'success'){
                    $file = $upload['file']['file_name'];
                    $this->User_model->updateProfile($file);
                    $this->session->set_flashdata('success', "<script>
                        swal({
                        text: 'Profil berhasil diupdate',
                        icon: 'success'
                        });
                        </script>");
                        redirect(base_url() . 'profile/edit-profile');
                }else{
                    $this->session->set_flashdata('failed', "<div class='alert alert-danger' role='alert'>
                    Gagal update profil, pastikan foto profil baru berukuran maksimal 2mb dan berformat png, jpg, jpeg. Silakan ulangi lagi.
                    </div>");
                    redirect(base_url() . 'profile/edit-profile');
                }
            }else{
                $file = '';
                $this->User_model->updateProfile($file);
                $this->session->set_flashdata('success', "<script>
                    swal({
                    text: 'Profil berhasil diupdate',
                    icon: 'success'
                    });
                    </script>");
                    redirect(base_url() . 'profile/edit-profile');
            }
        }
    }

    public function change_password(){
        $this->form_validation->set_rules('oldpassword', 'Password Lama', 'required', ['required' => 'Password lama wajib diisi'
	    ]);
        $this->form_validation->set_rules('newpassword', 'Password Baru', 'required', ['required' => 'Password baru wajib diisi'
	    ]);
	    if($this->form_validation->run() == false){
            $data['title'] = 'Ganti Kata Sandi | Website_Apotek';
            $data['css'] = 'profile';
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('profile/change_password', $data);
        }else{
            $user = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
            if(password_verify($this->input->post('oldpassword'), $user['password'])){
                if($this->input->post('newpassword') ==  $this->input->post('confirmpassword')){
                    $pass = password_hash($this->input->post('newpassword'), PASSWORD_DEFAULT);
                    $this->db->set('password', $pass);
                    $this->db->where('id', $this->session->userdata('id'));
                    $this->db->update('user');
                    $this->session->set_flashdata('failed', "<script>
                        swal({
                        text: 'Password berhasil diubah',
                        icon: 'success'
                        });
                        </script>");
                    redirect(base_url() . 'profile/change-password');
                }else{
                    $this->session->set_flashdata('failed', "<script>
                        swal({
                        text: 'Konfirmasi password tidak sama. Silakan coba lagi',
                        icon: 'error'
                        });
                        </script>");
                    redirect(base_url() . 'profile/change-password');
                }
            }else{
                $this->session->set_flashdata('failed', "<script>
                    swal({
                    text: 'Password lama salah. Silakan coba lagi',
                    icon: 'error'
                    });
                    </script>");
                redirect(base_url() . 'profile/change-password');
            }
        }
    }

}