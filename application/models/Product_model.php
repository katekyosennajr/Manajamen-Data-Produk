<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function get_all_products($search = '', $sort_by = 'name', $sort_order = 'asc') {
        if (!empty($search)) {
            $this->db->like('name', $search);
            $this->db->or_like('price', $search);
            $this->db->or_like('stock', $search);
        }
        
        // Validasi kolom sorting yang diizinkan
        $allowed_sort = array('name', 'price', 'stock');
        if (!in_array($sort_by, $allowed_sort)) {
            $sort_by = 'name';
        }
        
        // Validasi urutan sorting yang diizinkan
        $sort_order = strtolower($sort_order);
        if (!in_array($sort_order, array('asc', 'desc'))) {
            $sort_order = 'asc';
        }
        
        $this->db->order_by($sort_by, $sort_order);
        $query = $this->db->get('products');
        return $query->result();
    }
    
    public function get_product_by_id($id) {
        $query = $this->db->get_where('products', array('id' => $id));
        return $query->row();
    }
    
    public function insert_product($data) {
        return $this->db->insert('products', $data);
    }

    public function update_product($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('products', $data);
    }

    public function delete_product($id) {
        $this->db->where('id', $id);
        return $this->db->delete('products');
    }
}
