<?php
Class User extends CI_Controller {
	public function __construct() {
		parent::__construct();
		// Load form helper library
		$this->load->helper('form');
		// Load form validation library
		$this->load->library('form_validation');
		// Load session library
		$this->load->library('session');
		// Load database
		//$this->load->model('login_database');
	}
	// Show login page
	public function index() {
		$this->load->view('users/login_form');
	}
	
	// Show registration page
	
	public function user_registration_show() {
		$this->load->view('registration_form');
	}

}
?>