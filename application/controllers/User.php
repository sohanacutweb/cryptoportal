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
		// Load User model
        $this->load->model('users');
	}
	// Show login page
	public function index() {
		$data['title'] = 'Login Page';
    	$this->load->view('frontend/layouts/header',$data);
		$this->load->view('users/login_form');
    	$this->load->view('frontend/layouts/footer',$data);
	}
	
	// Show registration page
	
	public function register() {
		$data['title'] = 'Registeration Page';
    	$this->load->view('frontend/layouts/header',$data);
    	$this->load->view('users/register');
    	$this->load->view('frontend/layouts/footer',$data);
	}
    
    // Action Register
  public function actionregister()
  {
    // field name, error message, validation rules
    $this->form_validation->set_rules('fname', 'First Name', 'trim|required');
    if(!$this->session->userdata('logged_in')){
    	$this->form_validation->set_rules('username', 'User Name', 'trim|required|min_length[4]|is_unique[users.username]');
    	$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
    	$this->form_validation->set_rules('password', 'New Signup Password', 'trim|required|min_length[4]|max_length[32]');
    	$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
    }
    $this->form_validation->set_rules('country', 'Country', 'trim|required');
    $this->form_validation->set_rules('address', 'Address', 'trim|required');
    $this->form_validation->set_rules('city', 'Town / City', 'trim|required');
    $this->form_validation->set_rules('postcode', 'Postcode / Zip', 'trim|required');
 
    if($this->form_validation->run() == FALSE) {
      $this->register();
    } else {
      // post values personal details
      $fname = $this->input->post('fname');
      $lname = $this->input->post('lname');
      $username = $this->input->post('username');
      $email = $this->input->post('email');
      $password = $this->input->post('password');
      //post values billing details
      $productName = $this->input->post('product_name');
      $productTotal = $this->input->post('product_price');
      $country = $this->input->post('country');
      $address = $this->input->post('address');
      $state = $this->input->post('state');
      $city = $this->input->post('city');
      $postcode = $this->input->post('postcode');
      $phone = $this->input->post('phone');
      // set post values for user
      $this->users->setfName($fname);
      $this->users->setlName($lname);
      $this->users->setUserName($username);
      $this->users->setEmail($email);
      $this->users->setPassword(MD5($password));
      $this->users->setStatus(1);
      // set post value for order
      $this->users->setCountry($country);
      $this->users->setState($state);
      $this->users->setCity($city);
      $this->users->setAddress($address);
      $this->users->setPostcode($postcode);
      $this->users->setPhone($phone);
      $this->users->setItemName($productName);
      $this->users->setItemPrice($productTotal);
      // insert values in user
      if($this->session->userdata('logged_in')){
      	$user_id = $this->session->userdata('logged_in')['id'];
      }else{
      	$user_id = $this->users->createUser();
      }
      $this->users->setUserID($user_id);
      // insert values in order
      $this->users->generateOrder();
      redirect('user/thankyou');
    }
  }
  public function actionlogin() {

	$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
	$this->form_validation->set_rules('password', 'Password', 'trim|required');

	if ($this->form_validation->run() == FALSE) {
		$this->index();
	} else {
		$data = array(
		'email' => $this->input->post('email'),
		'password' => $this->input->post('password')
		);
		$result = $this->users->login($data);

		if ($result == TRUE) {

			$email = $this->input->post('email');
			$result = $this->users->read_user_information($email);
		if ($result != false) {
			$session_data = array(
			'id'    => $result[0]->id,
			'uname' => $result[0]->username,
			'email' => $result[0]->email,
			'fname' => $result[0]->fname,
			'lname' => $result[0]->lname,
			);
			// Add user data in session
			$this->session->set_userdata('logged_in', $session_data);
			redirect('admin');
		}
		} else {
			$this->session->set_userdata('invalid', 'Invalid email or password');
			$this->index();
		}
	}
  }
  public function logout(){
  	$this->session->sess_destroy();
  	redirect('user');
  }
  public function thankyou(){
  	$data['title'] = 'Thank You Page';
	$this->load->view('frontend/layouts/header',$data);
	$this->load->view('users/thankyou');
	$this->load->view('frontend/layouts/footer',$data);
  }
}
?>