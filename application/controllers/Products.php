<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('product_model');
        $this->load->helper(['url', 'form']);
        $this->load->library(['form_validation', 'session']);
    }

    private function set_validation_rules() {
        $this->form_validation->set_rules('name', 'Nama Produk', 'required|trim|min_length[3]|max_length[255]');
        $this->form_validation->set_rules('price', 'Harga Produk', 'required|numeric|greater_than_equal_to[0]');
        $this->form_validation->set_rules('stock', 'Jumlah Stok', 'required|integer|greater_than_equal_to[0]');
        
        // Set pesan error kustom
        $this->form_validation->set_message('required', '{field} harus diisi');
        $this->form_validation->set_message('min_length', '{field} minimal {param} karakter');
        $this->form_validation->set_message('max_length', '{field} maksimal {param} karakter');
        $this->form_validation->set_message('numeric', '{field} harus berupa angka');
        $this->form_validation->set_message('integer', '{field} harus berupa bilangan bulat');
        $this->form_validation->set_message('greater_than_equal_to', '{field} tidak boleh negatif');
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
        $this->set_validation_rules();
        
        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Tambah Produk Baru';
            $data['action'] = site_url('products/add');
            
            $this->load->view('templates/header', $data);
            $this->load->view('products/form', $data);
            $this->load->view('templates/footer');
        } else {
            $data = array(
                'name' => $this->input->post('name'),
                'price' => $this->input->post('price'),
                'stock' => $this->input->post('stock'),
                'is_sell' => $this->input->post('is_sell') ? 1 : 0,
                'created_at' => date('Y-m-d H:i:s')
            );
            
            if ($this->product_model->insert_product($data)) {
                $this->session->set_flashdata('success', 'Produk berhasil ditambahkan');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan produk');
            }
            redirect('products');
        }
    }

    public function edit($id = NULL) {
        if ($id === NULL) {
            redirect('products');
        }

        $product = $this->product_model->get_product_by_id($id);
        if (empty($product)) {
            $this->session->set_flashdata('error', 'Produk tidak ditemukan');
            redirect('products');
        }

        $this->set_validation_rules();

        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Edit Produk';
            $data['product'] = $product;
            $data['action'] = site_url('products/edit/' . $id);
            
            $this->load->view('templates/header', $data);
            $this->load->view('products/form', $data);
            $this->load->view('templates/footer');
        } else {
            $data = array(
                'name' => $this->input->post('name'),
                'price' => $this->input->post('price'),
                'stock' => $this->input->post('stock'),
                'is_sell' => $this->input->post('is_sell') ? 1 : 0,
                'updated_at' => date('Y-m-d H:i:s')
            );
            
            if ($this->product_model->update_product($id, $data)) {
                $this->session->set_flashdata('success', 'Produk berhasil diperbarui');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui produk');
            }
            redirect('products');
        }
    }

    public function delete($id = NULL) {
        if ($id === NULL) {
            redirect('products');
        }

        $product = $this->product_model->get_product_by_id($id);
        if (empty($product)) {
            $this->session->set_flashdata('error', 'Produk tidak ditemukan');
            redirect('products');
        }

        if ($this->product_model->delete_product($id)) {
            $this->session->set_flashdata('success', 'Produk berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus produk');
        }
        redirect('products');
    }
}
