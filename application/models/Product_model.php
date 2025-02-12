<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function get_all_products() {
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
