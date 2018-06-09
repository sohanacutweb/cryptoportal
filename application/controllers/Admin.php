<?php
Class Admin extends CI_Controller{
	public function __construct(){
		//load librairies and helper function
		parent::__construct();
		// Load session library
		$this->load->library('session');
	}
	public function index(){
		if($this->session->userdata('logged_in')){
			return $this->load->view('admin/dashboard');
	    }else{
	    	redirect('user');
	    }
	}
}
?>