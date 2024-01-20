<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About extends CI_Controller {

    public function index(){
        $data['title'] = 'Tentang | Website_Apotek';
        $this->load->view('templates/header', $data);
        $this->load->view('page/about');
        $this->load->view('templates/navbar');
    }

}