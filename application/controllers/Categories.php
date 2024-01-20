<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('Categories_model');
		$this->load->model('Products_model');
	}

	public function index($c){
    $cat = $this->Categories_model->getIdCategoryBySlug($c);
		$ob = $_GET['ob'];
		$maxprice = $_GET['maxprice'];
		$minprice = $_GET['minprice'];
		$condition = $_GET['condition'];
		if($ob != NULL){
		}else if($condition != NULL){
			if($condition == "1"){
				$data['titleHead'] = 'Kondisi > tersedia';
				$data['products'] = $this->Products_model->getAllProductsByCategory($cat, "1");
			}else if($condition == "2"){
				$data['titleHead'] = 'Kondisi > kosong';
				$data['products'] = $this->Products_model->getAllProductsByCategory($cat, "2");
			}
		}else{
			$data['titleHead'] = '';
			$data['products'] = $this->Products_model->getAllProductsByCategory($cat, "");
		}
		$data['title'] = 'Kategori | Website_Apotek' . $this->Categories_model->getNameCategoryBySlug($c) . ' - ';
		$data['css'] = 'products';
		$data['responsive'] = 'product-responsive';
        $data['slug'] = $c;
		$data['nameCat'] = $this->Categories_model->getNameCategoryBySlug($c);
		$this->load->view('templates/header', $data);
		$this->load->view('templates/navbar');
		$this->load->view('page/categories', $data);
	}

}
