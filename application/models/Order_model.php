<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model {

    public function getCartUser(){
        $id = $this->session->userdata('id');
        return $this->db->get_where('cart', ['user' => $id]);
    }

}