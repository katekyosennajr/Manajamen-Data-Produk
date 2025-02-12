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
        $search = $this->input->get('search');
        $sort_by = $this->input->get('sort_by', TRUE) ?: 'name';
        $sort_order = $this->input->get('sort_order', TRUE) ?: 'asc';
        
        $data['products'] = $this->product_model->get_all_products($search, $sort_by, $sort_order);
        $data['title'] = 'Daftar Produk';
        $data['search'] = $search;
        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;
        
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
            $this->session->set_flashdata('success', 'Produk berhasil ditambahkan');
            redirect('products');
        }
    }

    public function edit($id = NULL) {
        if ($id === NULL) {
            redirect('products');
        }

        $this->form_validation->set_rules('name', 'Nama Produk', 'required');
        $this->form_validation->set_rules('price', 'Harga Produk', 'required|numeric');
        $this->form_validation->set_rules('stock', 'Jumlah Stok', 'required|numeric');

        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Edit Produk';
            $data['product'] = $this->product_model->get_product_by_id($id);
            
            if (empty($data['product'])) {
                show_404();
            }
            
            $this->load->view('templates/header', $data);
            $this->load->view('products/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $data = array(
                'name' => $this->input->post('name'),
                'price' => $this->input->post('price'),
                'stock' => $this->input->post('stock'),
                'is_sell' => $this->input->post('is_sell') ? 1 : 0
            );
            
            $this->product_model->update_product($id, $data);
            $this->session->set_flashdata('success', 'Produk berhasil diperbarui');
            redirect('products');
        }
    }

    public function delete($id = NULL) {
        if ($id === NULL) {
            redirect('products');
        }

        $product = $this->product_model->get_product_by_id($id);
        if (empty($product)) {
            show_404();
        }

        $this->product_model->delete_product($id);
        $this->session->set_flashdata('success', 'Produk berhasil dihapus');
        redirect('products');
    }
}
