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
    
    public function insert_product($data) {
        return $this->db->insert('products', $data);
    }
}
