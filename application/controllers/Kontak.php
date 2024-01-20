<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kontak extends CI_Controller {

    public function index(){
        $data['title'] = 'Kontak | Website_Apotek';
        $this->load->view('templates/header', $data);
        $this->load->view('page/kontak');
        $this->load->view('templates/navbar');
    }

}