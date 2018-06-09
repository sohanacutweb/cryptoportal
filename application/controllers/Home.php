<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller{
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
		
		/* if($this->session->userdata('usertype') && $this->session->userdata('username')!="")
		{
			$data['user_sess_data'] = $this->session->userdata();
		}
		$data['title'] = 'Baby Health Safety Blogs for mom & Baby Blog for Baby fashion - Babylamore';
		$data['cookie_postal_code'] = $this->input->cookie('UserLocationPostalCode');
		$data['categories'] = $this->admin_model->getMainBusinessCategories($catid=null);
		$data['b_popular_categories'] = $this->admin_model->getBusinessPopularCategories();
		$data['p_popular_categories'] = $this->admin_model->getProductPopularCategories();
		$data['forums'] = $this->forum_model->getAllOpenForums();
		$data['sliderImages'] = $this->home_model->getSliderImages(1); */
		$data['title'] = 'Home Page';
		$this->load->view('frontend/layouts/header',$data);
		$this->load->view('frontend/blocks/home', $data);
		$this->load->view('frontend/layouts/footer',$data);

	}
	}