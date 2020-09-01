<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->model('Common_mod', 'Common');
		$this->db_prefix = 'web_';
		$this->users = $this->db_prefix.'users';
	}

	public function registration(){
		$res = array();
		$headers = apache_request_headers();
		if(isset($headers['Authorization']) && $headers['Authorization']=='Bearer partnerA'){
			// echo $_SERVER['REQUEST_METHOD'];
			if($_SERVER['REQUEST_METHOD']=='POST'){
				$user_id = 0;
				if(isset($_POST['user_id']) && $_POST['user_id']>0){
					$user_id = $_POST['user_id'];
					//check user is exist or not
					$where = array('id' => $user_id);
					$user_data = $this->Common->check_exist($this->users,$where);
					if(!isset($user_data) || count($user_data)<=0){
						$res['status'] = 207;
						$res['message'] = 'User does not exist';
						echo json_encode($res);
						exit();
					}
				}
				$req_fields = array('first_name', 'last_name', 'email', 'username', 'password');
				$dt = array();
				foreach ($req_fields as $key => $field) {
					if((!isset($_POST[$field]) || trim($_POST[$field])=='') && $user_id==0){
						$res['status'] = 203;
						$res['last_name'] = 'Required field missing : ('.$field.')';
						echo json_encode($res);
						exit();
					}
					else if(isset($_POST[$field]) && trim($_POST[$field])!=''){
						$dt[$field] = $_POST[$field];
					}
				}

				/* ***** check username and email is already exist or not *****/
				$where = array(
					'email' => $this->input->post('email')
				);
				$emailExist = $this->Common->check_exist($this->users, $where);
				if(isset($emailExist) && count($emailExist)>0){
					$res['status'] = 209;
					$res['message'] = 'Email alread Exist';
					echo json_encode($res); exit();
				}
				//username validation
				$where = array(
					'username' => $this->input->post('username')
				);
				$emailExist = $this->Common->check_exist($this->users, $where);
				if(isset($emailExist) && count($emailExist)>0){
					$res['status'] = 209;
					$res['message'] = 'Username alread Exist';
					echo json_encode($res); exit();
				}

				/* ***** check username and email is already exist or not *****/

				if(isset($_POST['password']) && trim($_POST['password'])!=''){
					$dt['password'] = sha1($_POST['password']);
				}
				if(isset($_FILES['profile_image']) && $_FILES['profile_image']['error']==0){
					$file = $_FILES['profile_image'];
					$target_path = './uploads/profile/';
					$ext = explode('.', basename($file['name']));
					$name_woext = $ext[0];
					$file_extension = end($ext);
					$new_name = time().$name_woext.'_'.rand(10,100).'.'.$file_extension;
					$target_path = $target_path . $new_name;
					if(move_uploaded_file($file['tmp_name'], $target_path)){
						$dt['profile_image'] = '/uploads/profile/'.$new_name;
					}
					else{
						$res['status'] = 205;
						$res['message'] = 'Due to technical Issue, Unable to process the request, please try again';
						echo json_encode($res);
						exit();
					}
				}
				else if($user_id==0){
					$res['status'] = 203;
					$res['message'] = 'Profile image is Required';
					echo json_encode($res);
					exit();
				}
				if($user_id==0){
					//this means a new user
					$last_id = $this->Common->save($this->users, $dt);
					$res['message'] = 'Successfully! Registration completed';
				}
				else{
					//alredy exist update the user
					$last_id = $this->Common->update($this->users,$dt,$user_id);
					$res['message'] = 'Successfully! Profile Updated';
				}
				if(isset($last_id) && $last_id>0){
					$res['status'] = 200;
				}
				else{
					$res['status'] = 205;
					$res['message'] = 'Due to technical Issue, Unable to process the request, please try again';
				}
				echo json_encode($res);
				exit();
			}
			else{
				$res['status'] = 201;
				$res['message'] = 'GET method is not allowed';
				$res['info'] = 'Use POST method to do registrations';
			}
		}
		else{
			$res['status'] = 201;
			$res['message'] = 'Authorization token expired';
			$res['extra'] = 'For testing purpose only : use toke - Bearer partnerA';
		}
		print_r($res);
	}

	/*
	* Login Authentication
	*/
	public function login(){
		$res = array();
		$headers = apache_request_headers();
		if(isset($headers['Authorization']) && $headers['Authorization']=='Bearer partnerA'){
			if($_SERVER['REQUEST_METHOD']=='POST'){
				$req_fields = array('username', 'password');
				$dt = array();
				foreach ($req_fields as $key => $field) {
					if(!isset($_POST[$field]) || trim($_POST[$field])==''){
						$res['status'] = 203;
						$res['last_name'] = 'Required field missing : ('.$field.')';
						echo json_encode($res);
						exit();
					}
				}
				$user = $this->input->post('username');
				$pass = $this->input->post('password');
				$where = array(
					''
				);
				$user_data = $this->Common->modCheckUserExist($user);
				if(isset($user_data) && count($user_data)>0){
					if($user_data['password']==sha1($pass)){
						$res['status'] = 200;
						$res['message'] = 'Successfully! logged in';
						$session_id = $this->createSessionId($user_data);
						$res['sessionId'] = $session_id;
					}
					else{
						$res['status'] = 208;
						$res['message'] = 'Password is Incorrect';
					}
				}
				else{
					$res['status'] = 208;
					$res['message'] = 'Username is not exist';
				}
				echo json_encode($res);
				exit();
			}
			else{
				$res['status'] = 201;
				$res['message'] = 'GET method is not allowed';
				$res['info'] = 'Use POST method to do login';
			}
		}
		else{
			$res['status'] = 201;
			$res['message'] = 'Authorization token expired';
			$res['extra'] = 'For testing purpose only : use toke - Bearer partnerA';
		}
		echo json_encode($res);
		exit();
	}

	/*
	* create unique session id
	* We use session_id to validate on every request
 	*/
	public function createSessionId($user_data){
		$unique_id = $user_data['id'].'__'.$user_data['username'].'__'.$user_data['email'];
		return $session_id = sha1($unique_id);
	}
}
