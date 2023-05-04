<?php
class Api_model extends CI_Model {    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    function add_table_data($data, $table){
        $this->db->insert($table, $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    function add_multi_table_data($data, $table){
        $this->db->insert_batch($table, $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    function update_table_data($data, $id, $table) {
        $this->db->set($data);
        $this->db->where("id", $id);
        if($this->db->update($table)){
            return true;
        } else{
            return false;
        }
    }
    function update_table_data_use_field($data, $check_field, $check_val, $table_name) {
        $this->db->set($data);
        $this->db->where($check_field, $check_val);
        if($this->db->update($table_name)){
            return true;
        } else{
            return false;
        }
    }
    function deleted_table_data($check_field, $check_val, $table_name){
        $this->db->set("is_deleted", '1');
        $this->db->where($check_field, $check_val);
        if($this->db->update($table_name)){
            return true;
        } else{
            return false;
        }
    }
    function hard_deleted_table_data($check_field, $check_val, $table_name) {
		$this->db->where($check_field, $check_val);
        if($this->db->delete($table_name)){
            return true;
        } else{
            return false;
        }
	}
    function listing_table_data($table_name) {
        $this->db->select('*');
        $this->db->from($table_name);
        $this->db->where("is_deleted", '0');
        $this->db->order_by("id", "desc");

        if($query = $this->db->get()){
            return $query->result_array();
        }else{
            return false;
        }
    }
    function listing_table_data_by_limit($table_name, $start, $limit) {
        $this->db->select('*');
        $this->db->from($table_name);
        $this->db->where("is_deleted", '0');
        $this->db->order_by("id", "desc");
        $this->db->limit($limit, $start);

        if($query = $this->db->get()){
            return $query->result_array();
        }else{
            return false;
        }
    }
    function listing_table_data_by_sequence($table_name) {
        $this->db->select('*');
        $this->db->from($table_name);
        $this->db->where("is_deleted", '0');
        $this->db->order_by("sequence_no", "asc");

        if($query = $this->db->get()){
            return $query->result_array();
        }else{
            return false;
        }
    }
    function listing_table_data_by_sequence_by_home($table_name) {
        $this->db->select('*');
        $this->db->from($table_name);
        $this->db->where("is_deleted", '0');
        $this->db->order_by("is_home", "1");
        $this->db->order_by("sequence_no", "asc");

        if($query = $this->db->get()){
            return $query->result_array();
        }else{
            return false;
        }
    }
    function list_table_data_by_values($values, $table_name) {
        $this->db->select('*');
        $this->db->from($table_name);
        $this->db->where($values);
        $this->db->where("is_deleted", '0');
        $this->db->order_by("id", "asc");

        if($query = $this->db->get()){
            return $query->result_array();
        }else{
            return false;
        }
    }
    function listing_table_data_about_by_sequence($table_name, $status) {
        $this->db->select('*');
        $this->db->from($table_name);
        $this->db->where("is_deleted", '0');
        $this->db->where("is_section", $status);
        $this->db->order_by("sequence_no", "asc");

        if($query = $this->db->get()){
            return $query->result_array();
        }else{
            return false;
        }
    }
    function get_table_data_by_id($id, $table_name) {
        $this->db->select('*');
        $this->db->from($table_name);
        $this->db->where(array("is_deleted" => '0', "id" => $id));

        if($query = $this->db->get()){
            return $query->row_array();
        }else{
            return false;
        }
    }
    function get_table_data_by_values($values, $table_name) {
        $this->db->select('*');
        $this->db->from($table_name);
        $this->db->where($values);
        $this->db->where("is_deleted", '0');

        if($query = $this->db->get()){
            return $query->row_array();
        }else{
            return false;
        }
    }
}