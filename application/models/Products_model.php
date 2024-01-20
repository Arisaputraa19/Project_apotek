<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products_model extends CI_Model {

    public function getProducts($number,$offset){
        $this->db->select("products.id AS productsId, products.title AS productsTitle, products.price AS productsPrice, products.stock AS productsStock, products.date_submit AS productsDate, products.img AS productsImg, products.publish AS productsPublish, categories.name AS categoriesName");
        $this->db->join("categories", "products.category=categories.id");
        $this->db->order_by("products.id", "desc");
        return $this->db->get("products",$number,$offset);
    }


    public function getAllProductsByCategory($c, $type = ""){
        if($type == ""){
            $this->db->where('publish', 1);
            $this->db->where('category', $c);
            $this->db->order_by('id', 'desc');
            return $this->db->get('products');
            $this->db->where('publish', 1);
            $this->db->where('category', $c);
            $this->db->where('condit', 2);
            $this->db->order_by('id', 'desc');
            return $this->db->get('products');
        }
    }

    public function getImgProductBySlug($slug){
        $product = $this->db->get_where('products', ['slug' => $slug])->row_array();
        return $this->db->get_where('img_product', ['id_product' => $product['id']]);
    }

    public function getProductsLimit(){
        $this->db->select("*");
        $this->db->from("products");
        $this->db->order_by("id", "desc");
        $this->db->limit(50);
        $this->db->where('publish', 1);
        return $this->db->get();
    }

    public function getBestProductsLimit(){
        $this->db->select("*");
        $this->db->from("products");
        $this->db->order_by("transaction", "desc");
        $this->db->limit(6);
        $this->db->where('publish', 1);
        return $this->db->get();
    }

    public function getProductById($id){
        $this->db->select("*,products.id AS productId, products.slug AS slugP");
        $this->db->from("products");
        $this->db->join("categories", "products.category=categories.id");
        $this->db->order_by("products.id", "desc");
        $this->db->where('products.id', $id);
        return $this->db->get()->row_array();
    }

    public function getProductBySlug($slug){
        $this->db->select("*,products.id AS productId, products.slug AS slugP");
        $this->db->from("products");
        $this->db->join("categories", "products.category=categories.id");
        $this->db->order_by("products.id", "desc");
        $this->db->where('products.slug', $slug);
        return $this->db->get()->row_array();
    }

    public function uploadImg(){
        $config['upload_path'] = './assets/images/product/';
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

    public function insertImg($upload, $id){
        $data = [
            'id_product' => $id,
            'img' => $upload['file']['file_name']
        ];
        $this->db->insert('img_product', $data);
    }

    public function insertProduct($upload){
        $title = $this->input->post('title');
        $price = $this->input->post('price');
        $stock = $this->input->post('stock');
        $category = $this->input->post('category');
        $condit = $this->input->post('condit');
        $img = $upload['file']['file_name'];
        $description = $this->input->post('description');
        $date_submit = date("Y-m-d H:i:s");
        $publish = $this->input->post('status');
        function textToSlug($text='') {
            $text = trim($text);
            if (empty($text)) return '';
            $text = preg_replace("/[^a-zA-Z0-9\-\s]+/", "", $text);
            $text = strtolower(trim($text));
            $text = str_replace(' ', '-', $text);
            $text = $text_ori = preg_replace('/\-{2,}/', '-', $text);
            return $text;
        }
        $slug =  textToSlug($title);
        $data = [
            "title" => $title,
            "price" => $price,
            "stock" => $stock,
            "category" => $category,
            "condit" => $condit,
            "img" => $img,
            "description" => $description,
            "date_submit" => $date_submit,
            "publish" => $publish,
            "slug" => $slug
        ];
        $this->db->insert('products', $data);
    }

    public function updateProduct($img, $id){
        $title = $this->input->post('title');
        $price = $this->input->post('price');
        $stock = $this->input->post('stock');
        $category = $this->input->post('category');
        $condit = $this->input->post('condit');
        $img = $img;
        $description = $this->input->post('description');
        $publish = $this->input->post('status');
        function textToSlug($text='') {
            $text = trim($text);
            if (empty($text)) return '';
            $text = preg_replace("/[^a-zA-Z0-9\-\s]+/", "", $text);
            $text = strtolower(trim($text));
            $text = str_replace(' ', '-', $text);
            $text = $text_ori = preg_replace('/\-{2,}/', '-', $text);
            return $text;
        }
        $slug =  textToSlug($title);
        $data = [
            "title" => $title,
            "price" => $price,
            "stock" => $stock,
            "category" => $category,
            "condit" => $condit,
            "img" => $img,
            "description" => $description,
            "publish" => $publish,
            "slug" => $slug
        ];

        $this->db->where('id', $id);
        $this->db->update('products', $data);
    }

    public function updateViewer($slug){
        $result = $this->db->get_where('products', ['slug' => $slug])->row_array();
        $newV = (int)$result['viewer'] + 1;
        $this->db->set('viewer', $newV);
        $this->db->where('id', $result['id']);
        $this->db->update('products');
    }

}