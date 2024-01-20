<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings_model extends CI_Model {

    public function getSetting(){
        return $this->db->get('settings')->row_array();
    }

    public function getSubmenu($id){
      return $this->db->get_where('submenu', ['submenu' => $id]);
    }

    public function getBanner(){
      return $this->db->get('banner');
    }
    
    public function uploadImg(){
      $config['upload_path'] = './assets/images/banner/';
      $config['allowed_types'] = 'jpg|png|jpeg|image/png|image/jpg|image/jpeg';
      $config['max_size'] = '2048';
      $config['file_name'] = round(microtime(true)*1000);
      $this->load->library('upload', $config);
      if($this->upload->do_upload('img')){
          $return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
          return $return;
      }else{
          $return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());
          return $return;
      }
  }

    public function insertBanner($upload){
      $img = $upload['file']['file_name'];
      $info = getimagesize(base_url() . 'assets/images/banner/' . $img);
      if($info[0] != 1600 || $info[1] != 400){
        unlink("./assets/images/banner/$img");
        return false;
      }else{
        $data = [
          'img' => $img,
        ];
        $this->db->insert('banner', $data);
        return true;
      }
    }

    public function addNavMenu(){
      $title = $this->input->post('title', true);
      $submenu = $this->input->post('submenu', true);
      $link = $this->input->post('link', true);
      if($submenu == "0"){
        $data = [
          'title' => $title,
          'link' => $link
        ];
        $this->db->insert('menu', $data);
      }else{
        $data = [
          'name' => $title,
          'submenu' => $submenu,
          'link' => $link
        ];
        $this->db->insert('submenu', $data);
      }
  }

    public function editNavMenu($id){
      $title = $this->input->post('title', true);
      $link = $this->input->post('link', true);
      $data = [
          'title' => $title,
          'link' => $link
      ];
      $this->db->where('id', $id);
      $this->db->update('menu', $data);
    }

}
