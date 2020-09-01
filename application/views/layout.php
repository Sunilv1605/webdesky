<?php
// $this->load->view('include/header');
if(isset($data) && count($data)> 0){
	$this->load->view($view."/".$page,$data); 
}
else{
	$this->load->view($view."/".$page); 
} 
// $this->load->view('include/footer');
?>