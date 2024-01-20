<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('Categories_model');
		$this->load->model('Products_model');
	}

	public function index(){
		$ob = $_GET['ob'];
		$maxprice = $_GET['maxprice'];
		$minprice = $_GET['minprice'];
		$condition = $_GET['condition'];
		if($ob != NULL){
		}else if($condition != NULL){
			if($condition == "1"){
				$data['titleHead'] = 'Kondisi > tersedia';
				$data['products'] = $this->Products_model->getAllProducts("1");
			}else if($condition == "2"){
				$data['titleHead'] = 'Kondisi > kosong';
				$data['products'] = $this->Products_model->getAllProducts("2");
			}
		}else{
			$data['titleHead'] = '';
			$data['products'] = $this->Products_model->getAllProducts("");
		}
		$data['title'] = 'Semua Produk | Website_Apotek';
		$data['css'] = 'products';
		$data['responsive'] = 'product-responsive';
		$this->load->view('templates/header', $data);
		$this->load->view('templates/navbar');
		$this->load->view('page/products', $data);
		$this->load->view('templates/footerv2');
	}

	public function detail_product($slug){
		$getProduct = $this->Products_model->getProductBySlug($slug);
		if($getProduct == NULL){
			redirect(base_url() . '404');
		}else{
			$this->Products_model->updateViewer($slug);
			$data['title'] = $getProduct['title'] . ' | Website_Apotek';
			$data['css'] = 'detail';
			$data['responsive'] = '';
			$data['product'] = $getProduct;
			$data['img'] = $this->Products_model->getImgProductBySlug($slug);
			$this->load->view('templates/header', $data);
			$this->load->view('templates/navbar');
			$this->load->view('page/detail', $data);
			$this->load->view('templates/footerv2');
		}
	}

	public function getgrosir(){
		$product = $_GET['product'];
		$stock = $_GET['stock'];
		$this->db->where('product', $product);
		$this->db->where('min <=', $stock);
		$this->db->order_by('id', 'desc');
		$db = $this->db->get('grosir')->row_array();
		$prod = $this->db->get_where('products', ['id' => $product])->row_array();
		$setting = $this->db->get('settings')->row_array();
		if($db){
			echo $db['price'];
		}else{
			return false;
		}
	}

}
