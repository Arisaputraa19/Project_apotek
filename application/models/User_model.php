<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function getUsers($number,$offset){
        $this->db->order_by('id', 'desc');
        return $this->db->get('user',$number,$offset);
    }

    public function getProfile(){
        $id = $this->session->userdata('id');
        return $this->db->get_where('user', ['id' => $id])->row_array();
    }

    public function register(){
        $email = addslashes(htmlspecialchars($this->input->post('email', true)));
        $checkEmail = $this->db->get_where('user', ['email' => $email])->row_array();
        if($checkEmail){
            $this->session->set_flashdata('failed', '<div class="alert alert-danger" role="alert">
            Email sudah ada!
            </div>');
            redirect(base_url() . 'register');
        }else{
            $name = addslashes(htmlspecialchars($this->input->post('name', true)));
            $password = $this->input->post('password');
            function textToSlug($text='') {
                $text = trim($text);
                if (empty($text)) return '';
                $text = preg_replace("/[^a-zA-Z0-9\-\s]+/", "", $text);
                $text = strtolower(trim($text));
                $text = str_replace(' ', '-', $text);
                $text = $text_ori = preg_replace('/\-{2,}/', '-', $text);
                return $text;
            }
            $username = textToSlug($name);
            $checkUsername = $this->db->get_where('user', ['username' => $username])->row_array();
            if($checkUsername){
                $username = $username . substr(rand(),0,3);
            }
            $data = [
                'name' => $name,
                'username' => $username,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'date_register' => date('Y-m-d H:i:s'),
                'photo_profile' => 'default.png'
            ];
            $this->db->insert('user', $data);
            $data = [
                'email' => $email,
                'date_subs' => date('Y-m-d H:i:s'),
                'code' => time() . rand()
            ];
            
        }
    }
    
    public function uploadPhoto(){
        $config['upload_path'] = './assets/images/profile/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = '2048';
        $config['file_name'] = round(microtime(true)*1000);
        $this->load->library('upload', $config);
        if($this->upload->do_upload('newphoto')){
            $return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
            return $return;
        }else{
            $return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());
            return $return;
        }
    }

    public function updateProfile($file){
        if($file == ""){
            $name = $this->input->post('name');
            $this->db->set('name', $name);
            $this->db->where('id', $this->session->userdata('id'));
            $this->db->update('user');
        }else{
            $name = $this->input->post('name');
            $this->db->set('name', $name);
            $this->db->set('photo_profile', $file);
            $this->db->where('id', $this->session->userdata('id'));
            $this->db->update('user');
        }
    }

}