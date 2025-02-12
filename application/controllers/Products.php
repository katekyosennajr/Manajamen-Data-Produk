<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('product_model');
        $this->load->helper('url');
        $this->load->library('form_validation');
    }

    public function index() {
        $data['products'] = $this->product_model->get_all_products();
        $data['title'] = 'Daftar Produk';
        
        $this->load->view('templates/header', $data);
        $this->load->view('products/index', $data);
        $this->load->view('templates/footer');
    }

    public function add() {
        $this->form_validation->set_rules('name', 'Nama Produk', 'required');
        $this->form_validation->set_rules('price', 'Harga Produk', 'required|numeric');
        $this->form_validation->set_rules('stock', 'Jumlah Stok', 'required|numeric');
        
        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Tambah Produk Baru';
            
            $this->load->view('templates/header', $data);
            $this->load->view('products/add', $data);
            $this->load->view('templates/footer');
        } else {
            $data = array(
                'name' => $this->input->post('name'),
                'price' => $this->input->post('price'),
                'stock' => $this->input->post('stock'),
                'is_sell' => $this->input->post('is_sell') ? 1 : 0
            );
            
            $this->product_model->insert_product($data);
            redirect('products');
        }
    }
}
