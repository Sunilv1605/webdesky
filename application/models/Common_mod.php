<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Common_mod extends CI_Model {
  public function __construct(){
    parent::__construct();
    $this->load->database();
    $this->db_prefix = 'web_';
    $this->users = $this->db_prefix.'users';
  }
  public function save($table, $data){
    if($this->db->insert($table,$data))
    {
      return $this->db->insert_id();
    }
    else
    {
      return FALSE;
    }
  }
  public function sun_bulk_save($table, $data){
    return $this->db->insert_batch($table, $data);
  }
  public function check_exist($table,$data){
    return $this->db->get_where($table,$data)->row_array();
  }
  public function fiter_data($table,$column,$value){
    // return $this->db->get_where($table, array($column=>$value))->result_array();
    if($table=='mu_file'){
      $this->db->order_by('file_insert_date', 'DESC');
    }
    return $this->db->get_where($table, array($column=>$value))->result_array();
    // $this->db->get_where($table, array($column=>$value));
  }
  public function get_individual_data($table,$column,$value){
    return $this->db->get_where($table, array($column=>$value))->row_array();
  }
  public function get_data($table){
    return $this->db->get($table)->result_array();
  }
  public function update($table,$data,$id){
    $this->db->where('id', $id);
    return $this->db->update($table,$data); 
  }
  /*
  * $filter_data is a array contains some values
  * where_col -> compare column name
  * where_val -> compare column value
  * table_name -> which table you want to update data
  * update_data -> data which is to be updated with column name and value
  */
  public function custom_update($filter_data){
    $this->db->where($filter_data['where_col'], $filter_data['where_val']);
    return $this->db->update($filter_data['table_name'],$filter_data['update_data']); 
  }
  public function remove($table,$column,$value){
    return $this->db->delete($table, array($column=> $value)); 
  }
  public function filter_data_order($table,$data){
    $this->db->order_by('id', 'DESC');
    return $this->db->get_where($table, $data)->result_array();
  }
  public function get_individuals_datas($table,$data){
    return $this->db->get_where($table, $data)->row_array();
  }

  public function modCheckUserExist($username){
    $sql = "SELECT * FROM $this->users WHERE (email='".$username."' OR username='".$username."') ";
    return $this->db->query($sql)->row_array();
  }
}