<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->model('Common_mod', 'Common');
		$this->db_prefix = 'web_';
		$this->users = $this->db_prefix.'users';
	}
	public function index()
	{
		$users = $this->Common->get_data($this->users);
		$data = array();
		$data['page']="users_list";
		$data['view']="frontend";
		$data['user_list']= (isset($users) && count($users)>0)?$users:array();
		$this->load->view('layout', $data);
	}
}
