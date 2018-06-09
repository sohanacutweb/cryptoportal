<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pricing extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		//$this->load->model('admin_model');
		//$this->load->model('home_model');
		//$this->load->model('customers_model');
		//$this->load->model('vendors_model');
		//$this->load->model('forum_model');
		//$this->load->library('pagination');
		$this->load->helper('cookie');
		// Load session library
		$this->load->library('session');
	}
	public function index()
	{
		
		$data['title'] = 'Pricing Page';
    	$this->load->view('frontend/layouts/header',$data);
    	$this->load->view('frontend/blocks/pricing',$data);
    	$this->load->view('frontend/layouts/footer',$data);

	}
	}