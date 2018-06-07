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
		$this->load->view('frontend/home', $data);
		$this->load->view('frontend/layouts/footer',$data);

	}

	public function localVendors() 
	{

		if($this->session->userdata('usertype') && $this->session->userdata('username')!="")
		{
			$data['user_sess_data'] = $this->session->userdata();
		}
		$data['title'] = 'Search Vendor';
		//Get the cookie info
		$data['cookie_postal_code'] = $this->input->cookie('UserLocationPostalCode');
		
		if(!$this->uri->segment(2))
			{
				if(!$this->input->get())
				{
					redirect("local-vendors/".$this->uri->segment(2)."?zip=".$data['cookie_postal_code'],"refresh");
				}
			}
		//Get All business categories
		$data['categories'] = $this->admin_model->getBusinessCategoriesForFilter();
		//Get all open forum
		$data['forums'] = $this->forum_model->getAllOpenForums();
		if($this->uri->segment(2))
			{
				$cat_slug = $this->uri->segment(2);
				$s_category = $this->admin_model->getBusinessCategoryIdBySlug($cat_slug);
			}
		else{
				//$s_category = $this->input->get('category');
				$cat_slug = $this->input->get('category');
				if(isset($cat_slug) && !empty($cat_slug)){
					$s_category  = $this->admin_model->getBusinessCategoryIdBySlug($cat_slug);
				}else{
					$s_category  = '';
				}
				
			}
			
			$data['s_category']  = $s_category;
			$data['sub_categories'] = $this->admin_model->getBusinessSubCategoriesForFilter($s_category);
			$data['zip'] = $zip	= $this->input->get('zip');
			if($this->input->get('zip'))
			{
				$cookie = array(
					'name' => 'UserLocationPostalCode',
					'value' => $this->input->get('zip'),
					'expire' => time() + 86500,
					'path'   => '/'
				);
				$this->input->set_cookie($cookie);
			}
			$data['vendor_name'] = $vendor_name	 	=	$this->input->get('vendor_name');
			$data['distance'] = $distance	 	=	$this->input->get('distance');
			$subcat =  array();
			$subCategories = $this->input->get('subcat');
			for($i=0; $i<count($subCategories);$i++)
			{
				$subcat[] = $this->admin_model->getBusinessCategoryIdBySlug($subCategories[$i]);
				
			}
			if(empty($distance)){
				$zipcodes = ""; 
			}
			else if($distance=="all"){
				$zipcodes = "all"; 
			}
			else{
				$zipcodes = $this->home_model->getNearestZipCodes($zip, $distance);
			}
			//print_r($zipcodes );die;
			$data['pro_vendorlist'] = $svendorlist = $this->home_model->searchProVendor($limit=3, $vendor_name, $s_category, $zip, $distance, $zipcodes, $subcat, $membership_id=5);
			
			$svendor_arr = $this->home_model->searchBusiness($limit='all', $start=0, $vendor_name, $s_category, $zip, $distance, $zipcodes, $subcat, $membership_id='');
			
			$perpage = 18;
			$config  = array();
			$config["base_url"] = base_url()."local-vendors/". $cat_slug;
			$total_row = count($svendor_arr) ;
			$config["total_rows"] = $total_row;
			$config["per_page"] = $perpage;
			$config['use_page_numbers'] = TRUE;
			$config['num_links'] = $total_row;
			$config['page_query_string']  = TRUE;
			$config['reuse_query_string'] = TRUE;
			$config['full_tag_open'] = "<ul class='pagination'>";
			$config['full_tag_close'] ="</ul>";
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = "<li class='active'><a href='#'>";
			$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
			$config['next_tag_open'] = "<li>";
			$config['next_tagl_close'] = "</li>";
			$config['prev_tag_open'] = "<li>";
			$config['prev_tagl_close'] = "</li>";
			$config['first_tag_open'] = "<li>";
			$config['first_tagl_close'] = "</li>";
			$config['last_tag_open'] = "<li>";
			$config['last_tagl_close'] = "</li>";
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';

			$this->pagination->initialize($config);
			if($this->input->get('per_page')){
			$page = ($this->input->get('per_page')) ;
			$start = ($this->input->get('per_page') - 1) * $config["per_page"];
			}
			else{
			$page = 1;
			$start = 0;
			}
			$data['s_vendorlist'] = $svendorlist = $this->home_model->searchBusiness($config["per_page"], $start, $vendor_name, $s_category, $zip, $distance, $zipcodes, $subcat, $membership_id='');
			//$data['b_vendorlist'] = $svendorlist = $this->home_model->searchBusiness($config["per_page"], $start, $vendor_name, $s_category, $zip, $distance, $zipcodes, $subcat, $membership_id='');
			
			$str_links = $this->pagination->create_links();
			$data["links"] = explode('&nbsp;',$str_links );
	
		//}	
		$this->load->view('frontend/layouts/header_view',$data);
		$this->load->view('frontend/vendors_search_view', $data);
		$this->load->view('frontend/layouts/footer_view',$data);
	}	
	public function localsearch()
	{
	if($this->session->userdata('usertype') && $this->session->userdata('username')!="")
		{
			$data['user_sess_data'] = $this->session->userdata();
		}
		$data['title'] = 'Home';
		$data['cookie_postal_code'] = $this->input->cookie('UserLocationPostalCode');
		$data['categories'] = $this->admin_model->getMainBusinessCategories($catid=null);
		$data['b_popular_categories'] = $this->admin_model->getBusinessPopularCategories();
		$data['p_popular_categories'] = $this->admin_model->getProductPopularCategories();
		$data['forums'] = $this->forum_model->getAllOpenForums();
		$data['sliderImages'] = $this->home_model->getSliderImages(1);

		$this->load->view('frontend/layouts/header_view',$data);
		$this->load->view('frontend/local_search_view', $data);
		$this->load->view('frontend/layouts/footer_view',$data);
	}	
	
	public function vendorsStorefront()
	{
		$data['categories'] = $this->admin_model->getMainBusinessCategories($catid=null);
		$data['forums'] = $this->forum_model->getAllOpenForums();
		$business_slug = $this->uri->segment(2);
		$vendor_id = $this->home_model->getVendorID($business_slug);
		
		$data['title'] = $this->vendors_model->getBusinessNameBySlug($business_slug);
		
		if($this->session->userdata('usertype') && $this->session->userdata('username')!="")
		{
			$data['user_sess_data'] = $this->session->userdata();
			$customer_user_id = $data['user_sess_data']['user_id']; 
			$data['favorite_status'] = $this->home_model->getFavoriteStatus($vendor_id ,$customer_user_id);
		}
		if($vendor_id!=0){
			$data['vendor_info']  	= $this->home_model->getVendorsInfo($vendor_id);
			$data['vendor_album'] 	= $this->home_model->getVendorsAlbum($vendor_id);
			$data['allimages'] 	  	= $this->home_model->getAlbumAllImages($vendor_id);
			$data['allvideos'] 		= $this->home_model->getAllVideos($vendor_id);
			$data['vendor_review'] 	= $this->home_model->getVendorReviews($vendor_id);
		}
		else{
			$data['vendor_info']  	= $this->vendors_model->getVendorBySlug($business_slug);
		}
		
		/* echo "<pre>";
		print_r($data['vendor_info']);
		die; */
		
		$this->load->view('frontend/layouts/header_view',$data);
		$this->load->view('frontend/vendors_storefront_view', $data);
		$this->load->view('frontend/layouts/footer_view',$data);
	}
	public function resetSearchVendor()
	{
		$cookie = array(
				'name' => 'UserLocationPostalCode',
				'value' => '',
				'expire' => time()+86500,
				'path'   => '/'
			);
		$this->input->set_cookie($cookie);
		
	}
	public function vendorsWebsiteClick()
	{

		$vendor_id 	= $this->input->post('vendor_id');
		$href 		= $this->input->post('href');
		if($this->home_model->addVendorsWebsiteClick($this->input->post())==true)
		{
			echo "DONE!";
		}
		
	}
	public function galleryImages()
	{

		$album_id = $this->input->post('album_id');
		$data['gallery_images'] = $this->home_model->getAlbumGalleryImages($album_id);
		$data['album_name'] = $this->home_model->getAlbumTitle($album_id);
		$this->load->view('frontend/popup/gallery_view', $data);
		
	}
	public function getFullReview()
	{
		$review_id = $this->input->post('review');
		$data['review'] = $this->home_model->getFullReview($review_id);
		$this->load->view('frontend/popup/fullreview_view', $data);
		
	}
	public function submitReview()
	{
		if($this->session->userdata('usertype')=='customer' && $this->session->userdata('username')!="")
		{
			$data['user_sess_data'] = $this->session->userdata();
			if($this->input->post()){
				$customer_user_id 	= $this->input->post('customer_user_id');
				$vendor_user_id 	= $this->input->post('vendor_user_id');
				if($customer_user_id == $this->session->userdata('user_id'))
				{
					if($this->home_model->checkReview($customer_user_id, $vendor_user_id)== FALSE){
						if($this->home_model->submitReview($this->input->post()) == TRUE)
						{
							echo '<div class="alert alert-success">	
							<button class="close" aria-label="close" data-dismiss="alert" >×</button>
									<strong> Success! </strong> Reviews submitted Successfully.
								</div>';
						}	
						else
						{
							echo '<div class="alert alert-danger">
							<button class="close" aria-label="close" data-dismiss="alert" >×</button>							
									<strong> Error! </strong> Error in submitting.
								</div>';
						}
					}
					else
						{
							echo '<div class="alert alert-danger">	
							<button class="close" aria-label="close" data-dismiss="alert" >×</button>
									<strong> Error! </strong> You have already submitted your reviews.
								</div>';
						}
					
				}
				else
				{
					echo '<div class="alert alert-danger">	
					<button class="close" aria-label="close" data-dismiss="alert" >×</button>
								<strong> Error! </strong> Not a valid customer.
							</div>';
				}
			}
		}
	}

	public function contactVendor()
	{
		if($this->input->post()){
			$vendor_email	= $this->input->post('vendor_email');
			$vendor_user_id 	= $this->input->post('vendor_user_id');
			$data['vendors_firstname'] 	= $this->admin_model->getUserFirstname($vendor_user_id);
				if($this->home_model->saveThisMessage($this->input->post()) == TRUE)
					{
						$config['charset'] = 'utf-8';
						$config['wordwrap'] = TRUE;
						$config['mailtype'] = 'html';
						$config['newline'] = "<br>";
						$config['crlf'] = "<br>";
						$EmailFrom = $this->admin_model->getAdminDefaultEmail();
						$subject ="BabyL’Amore Inquiry";
						$data['contactdata'] = $this->input->post();
						$message = $this->load->view('email_layouts/contactvendor', $data,  TRUE);

						$this->email->initialize($config);
						$this->email->from($EmailFrom ,"BabyL'Amore");  
						$this->email->to($vendor_email); 
						$this->email->subject($subject);
						$this->email->message($message);	
						$this->email->send();
						echo '<div class="alert alert-success">	
						<button class="close" aria-label="close" data-dismiss="alert" >×</button>
								<strong> Success! </strong> Your form was submitted successfully. Vendor will contact you shortly.
							</div>';
					}	
					else
					{
						echo '<div class="alert alert-danger">	
								<button class="close" aria-label="close" data-dismiss="alert" >×</button>
								<strong> Error! </strong> Error in submitting.
							</div>';
					}
					
			}
	}
	/***==============================================
		Products Section
	===============================================***/
	public function shop()
	{
		if($this->session->userdata('usertype') && $this->session->userdata('username')!="")
		{
			$data['user_sess_data'] = $this->session->userdata();
		}
		
		$data['categories'] = $this->admin_model->getProductFilterCategories();
		$data['forums'] = $this->forum_model->getAllOpenForums();
		if($this->uri->segment(2))
		{
			$cat_slug = $this->uri->segment(2);
			$p_category = $this->admin_model->getProductCategoryIdBySlug($cat_slug);
			$catName = $this->admin_model->getProductCategoryNameBySlug($cat_slug);
			$data['title'] = $catName;
			
		}
		else{
			$cat_slug = $this->input->get('category');
			if(isset($cat_slug) && !empty($cat_slug)){
				$p_category  = $this->admin_model->getProductCategoryIdBySlug($cat_slug);
			}else{
				$p_category  = '';
			}
			$catName = $this->admin_model->getProductCategoryName($p_category);
			$data['title'] = $catName;
		}

		if($this->input->get() || ( !empty($p_category))){
			$p_types = $this->input->get('types');
			$p_brands = $this->input->get('brands');
			$p_price = $this->input->get('price');
			
			$p_type =  array();
			for($i=0; $i<count($p_types);$i++)
			{
				
				$p_type[] = $this->admin_model->getProductTypeIdBySlug($p_types[$i]);
				
			}
			$p_brand =  array();
			for($i=0; $i<count($p_brands);$i++)
			{ 
				$p_brand[] = $this->admin_model->getProductBrandIdBySlug($p_brands[$i]); 
			}
			
			if($p_category==""){
				$data['product_brands'] = $this->admin_model->getAllProductBrands();
			}else{
				$product_brands = $this->admin_model->getProductBrandsByCategory($p_category);
				$probrands = array_filter(explode(",",$product_brands));
				$productbrands = array();
				for($l=0; $l<count($probrands); $l++){
					$brandslug = $this->admin_model->getBrandSlugById($probrands[$l]);
					$brandname = $this->admin_model->getBrandNameById($probrands[$l]);
					$productbrands[] = array("brand_id"=>$probrands[$l], "brand_slug"=> $brandslug,"brand_name"=> $brandname);
				}
				$data['product_brands'] = $productbrands;
			}

			$data['product_types'] = $this->admin_model->getProductTypeByCategory($p_category);
			$data['product_name'] = $product_name	=	$this->input->get('product_name');
			$searched_products = $this->home_model->searchProducts($perpage="all", $start=0, $product_name, $p_category, $p_type, $p_brand, $p_price);
			$perpage = 6;
			$config = array();
			$config["base_url"] = base_url()."shop/". $cat_slug;
			$total_row = count($searched_products);
			$config["total_rows"] = $total_row;
			$config["per_page"] = $perpage;
			$config['use_page_numbers'] = TRUE;
			$config['num_links'] = $total_row;
			$config['page_query_string']  = TRUE;
			$config['reuse_query_string'] = TRUE;
			$config['full_tag_open'] = "<ul class='pagination'>";
			$config['full_tag_close'] ="</ul>";
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = "<li class='active'><a href='#'>";
			$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
			$config['next_tag_open'] = "<li>";
			$config['next_tagl_close'] = "</li>";
			$config['prev_tag_open'] = "<li>";
			$config['prev_tagl_close'] = "</li>";
			$config['first_tag_open'] = "<li>";
			$config['first_tagl_close'] = "</li>";
			$config['last_tag_open'] = "<li>";
			$config['last_tagl_close'] = "</li>";
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';

			$this->pagination->initialize($config);
			if($this->input->get('per_page')){
				$page = ($this->input->get('per_page')) ;
				$start = ($this->input->get('per_page') - 1) * $config["per_page"];
			}
			else{
				$page = 1;
				$start = 0;
			}
			//$data["products"] = $this->home_model->products($config["per_page"], $start);
			$data['products'] = $products = $this->home_model->searchProducts($config["per_page"],$start,$product_name, $p_category, $p_type, $p_brand, $p_price);
			$str_links = $this->pagination->create_links();
			$data["links"] = explode('&nbsp;',$str_links );
			
			/* $curr_product_brands = array();
			foreach($searched_products as $spro){
				if($spro['product_brand'] !=0){
					$curr_product_brands[] = $spro['product_brand'];	
				}
			}
			$used_brands = array_unique($curr_product_brands);
			$data['curr_product_brands'] = $this->admin_model->getAssignedProductBrands($used_brands);
			*/
		}
		else
		{
			$data['product_brands'] = $this->admin_model->getAllProductBrands();
			$data['product_types'] = $this->admin_model->getProductTypes();
		
			//$data['products'] = $products = $this->home_model->products();
			$searched_products = $this->home_model->productCount();
			$perpage = 6;
			$config = array();
			$config["base_url"] = base_url()."shop";
			$total_row = count($searched_products);
			$config["total_rows"] = $total_row;
			$config["per_page"] = $perpage;
			$config['use_page_numbers'] = TRUE;
			$config['num_links'] = $total_row;
			$config['page_query_string']  = TRUE;
			$config['full_tag_open'] = "<ul class='pagination'>";
			$config['full_tag_close'] ="</ul>";
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = "<li class='active'><a href='#'>";
			$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
			$config['next_tag_open'] = "<li>";
			$config['next_tagl_close'] = "</li>";
			$config['prev_tag_open'] = "<li>";
			$config['prev_tagl_close'] = "</li>";
			$config['first_tag_open'] = "<li>";
			$config['first_tagl_close'] = "</li>";
			$config['last_tag_open'] = "<li>";
			$config['last_tagl_close'] = "</li>";
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';

			$this->pagination->initialize($config);
			if($this->input->get('per_page')){
			$page = ($this->input->get('per_page')) ;
			$start = ($this->input->get('per_page') - 1) * $config["per_page"];
			}
			else{
			$page = 1;
			$start = 0;
			}
			$data["products"] = $this->home_model->products($config["per_page"], $start);
			$str_links = $this->pagination->create_links();
			$data["links"] = explode('&nbsp;',$str_links );
			/*
			$curr_product_brands = array();
			foreach($searched_products as $spro){
				if($spro['product_brand'] !=0){
					$curr_product_brands[] = $spro['product_brand'];	
				}
			}
			$used_brands = array_unique($curr_product_brands);
			$data['curr_product_brands'] = $this->admin_model->getAssignedProductBrands($used_brands);
			*/
		}	

		$this->load->view('frontend/layouts/header_view',$data);
		$this->load->view('frontend/product_search_view', $data);
		$this->load->view('frontend/layouts/footer_view',$data);
	}
	public function singleProduct()
	{
		
		$data['categories'] = $this->admin_model->getProductCategories();
		$data['forums'] = $this->forum_model->getAllOpenForums();
		$product_slug = $this->uri->segment(2);
		$product_id = $this->home_model->getProductIdBySlug($product_slug);
		$product_title = $this->home_model->getProductNameById($product_id);
		
		$seo_title = $this->home_model->getProductSeoTitle($product_id);
		$data['seo_description'] = $seo_description = $this->home_model->getProductSeoDescription($product_id);
		$data['seo_keywords'] = $seo_keywords = $this->home_model->getProductSeoKeywords($product_id);
		if(!empty($seo_title) && $seo_title !="")
		{
			$data['title'] = $seo_title;
		}
		else{
			$data['title'] = $product_title;
		}
		$data["single_product"] = $this->home_model->getSingleProduct($product_id);
		$data["single_product_gallery"] = $this->home_model->getSingleProductGallery($product_id);
		$data["single_product_categories"] = $this->home_model->getSingleProductCategories($product_id);
		$data["single_product_type"] = $this->home_model->getSingleProductTypes($product_id);
		if($this->session->userdata('usertype') && $this->session->userdata('username')!="")
		{
			$data['user_sess_data'] = $this->session->userdata();
			$customer_user_id = $data['user_sess_data']['user_id'];
			$data['fav_product_status'] = $this->home_model->getFavoriteProductStatus($product_id ,$customer_user_id);
		
		}
		$this->load->view('frontend/layouts/header_view',$data);
		$this->load->view('frontend/single_product_view', $data);
		$this->load->view('frontend/layouts/footer_view',$data);
	}	
	/*********************************
	Post Pages
	************************************/
	public function ideaandinspiration()
	{
		$data['title'] = "Idea and inspirations";
		$data['forums'] = $this->forum_model->getAllOpenForums();
		$data['posts'] = $this->admin_model->getAllPosts();
		$data['post_categories'] = $this->admin_model->getPostCategories();
		
		if($this->session->userdata('usertype') && $this->session->userdata('username')!="")
		{
			$data['user_sess_data'] = $this->session->userdata();
		}
		$this->load->view('frontend/layouts/header_view',$data);
		$this->load->view('frontend/ideaandinspiration_view', $data);
		$this->load->view('frontend/layouts/footer_view',$data);
	}
	public function posts()
	{
		$data['title'] = "Posts";
		$data['forums'] = $this->forum_model->getAllOpenForums();
	
		$data['post_categories'] = $this->admin_model->getPostCategories();
		if($this->session->userdata('usertype') && $this->session->userdata('username')!="")
		{
			$data['user_sess_data'] = $this->session->userdata();
		}
		$perpage = 16;
			$config = array();
			$config["base_url"] = base_url("posts");
			$total_row = count($this->admin_model->getAllPosts());
			$config["total_rows"] = $total_row;
			$config["per_page"] = $perpage;
			$config['use_page_numbers'] = TRUE;
			$config['num_links'] = $total_row;
			$config['page_query_string']  = TRUE;
			$config['reuse_query_string'] = TRUE;
			$config['full_tag_open'] = "<ul class='pagination'>";
			$config['full_tag_close'] ="</ul>";
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = "<li class='active'><a href='#'>";
			$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
			$config['next_tag_open'] = "<li>";
			$config['next_tagl_close'] = "</li>";
			$config['prev_tag_open'] = "<li>";
			$config['prev_tagl_close'] = "</li>";
			$config['first_tag_open'] = "<li>";
			$config['first_tagl_close'] = "</li>";
			$config['last_tag_open'] = "<li>";
			$config['last_tagl_close'] = "</li>";
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';

			$this->pagination->initialize($config);
			if($this->input->get('per_page')){
			$page = ($this->input->get('per_page')) ;
			$start = ($this->input->get('per_page') - 1) * $config["per_page"];
			}
			else{
			$page = 1;
			$start = 0;
			}
			//$data["products"] = $this->home_model->products($config["per_page"], $start);
			$data['posts'] = $this->home_model->getAllPosts($config["per_page"], $start);
			$str_links = $this->pagination->create_links();
			$data["links"] = explode('&nbsp;',$str_links );
			
		$this->load->view('frontend/layouts/header_view',$data);
		$this->load->view('frontend/blogposts_view', $data);
		$this->load->view('frontend/layouts/footer_view',$data);
	}	
	public function category()
	{
		$data['title'] = "Category";
		$data['forums'] = $this->forum_model->getAllOpenForums();
	 	$category_slug = $this->uri->segment(2);
	 	$category_id = $this->admin_model->getCategoryIDBySlug($category_slug);

		$data['single_category'] = $this->admin_model->getSingleCategory($category_id);
		
		if($this->session->userdata('usertype') && $this->session->userdata('username')!="")
		{
			$data['user_sess_data'] = $this->session->userdata();
		}
		$perpage = 8;
			$config = array();
			$config["base_url"] = base_url("category")."/". $category_slug;
			$total_row = count($this->admin_model->getAllPostsByCategory($category_id));
			$config["total_rows"] = $total_row;
			$config["per_page"] = $perpage;
			$config['use_page_numbers'] = TRUE;
			$config['num_links'] = $total_row;
			$config['page_query_string']  = TRUE;
			$config['reuse_query_string'] = TRUE;
			$config['full_tag_open'] = "<ul class='pagination'>";
			$config['full_tag_close'] ="</ul>";
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = "<li class='active'><a href='#'>";
			$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
			$config['next_tag_open'] = "<li>";
			$config['next_tagl_close'] = "</li>";
			$config['prev_tag_open'] = "<li>";
			$config['prev_tagl_close'] = "</li>";
			$config['first_tag_open'] = "<li>";
			$config['first_tagl_close'] = "</li>";
			$config['last_tag_open'] = "<li>";
			$config['last_tagl_close'] = "</li>";
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';

			$this->pagination->initialize($config);
			if($this->input->get('per_page')){
			$page = ($this->input->get('per_page')) ;
			$start = ($this->input->get('per_page') - 1) * $config["per_page"];
			}
			else{
			$page = 1;
			$start = 0;
			}
			//$data["products"] = $this->home_model->products($config["per_page"], $start);
			$data['posts'] = $this->home_model->getAllPostsByCategory($config["per_page"], $start, $category_id);
			$str_links = $this->pagination->create_links();
			$data["links"] = explode('&nbsp;',$str_links );
			
		$this->load->view('frontend/layouts/header_view',$data);
		$this->load->view('frontend/category_view', $data);
		$this->load->view('frontend/layouts/footer_view',$data);
	}	
	public function singlePost()
	{
		$post_slug = $this->uri->segment(2);
		$post_id = $this->home_model->getPostIdBySlug($post_slug);
		if($this->home_model->getPostSeoTitle($post_id)!='')
		{
			$data['title'] = $this->home_model->getPostSeoTitle($post_id);
		}
		else
		{
			$data['title'] = $this->home_model->getSinglePostTitle($post_id);
		
		}
		$data['forums'] = $this->forum_model->getAllOpenForums();
		$data['posts'] = $this->admin_model->getAllPosts();
		$data['singlePost'] = $this->admin_model->getSinglePost($post_id );
		$data['post_categories'] = $this->admin_model->getPostCategories();
		
		if($this->session->userdata('usertype') && $this->session->userdata('username')!="")
		{
			$data['user_sess_data'] = $this->session->userdata();
		}
		/* echo "<pre>";
		print_r($data);
		die; */
		$this->load->view('frontend/layouts/header_view',$data);
		$this->load->view('frontend/singlepost_view', $data);
		$this->load->view('frontend/layouts/footer_view',$data);
	}
	public function page()
	{
		$page_slug = $this->uri->segment(2);
		$page_id = $this->home_model->getPageIdBySlug($page_slug);
		if($this->home_model->getPageSeoTitle($page_id)!='')
		{
			$data['title'] = $this->home_model->getPageSeoTitle($page_id);
		}
		else
		{
			$data['title'] = $this->home_model->getSinglePageTitle($page_id);
		}
		$data['forums'] = $this->forum_model->getAllOpenForums();
		$data['singlePage'] = $this->admin_model->getSinglePage($page_id );
		
		if($this->session->userdata('usertype') && $this->session->userdata('username')!="")
		{
			$data['user_sess_data'] = $this->session->userdata();
		}
		$this->load->view('frontend/layouts/header_view',$data);
		$this->load->view('frontend/singlepage_view', $data);
		$this->load->view('frontend/layouts/footer_view',$data);
	}
	
	// Contact us page 
	public function contactus(){
		$data['title'] = "Contact Us";
		if($this->session->userdata('usertype') && $this->session->userdata('username')!="")
		{
			$data['user_sess_data'] = $this->session->userdata();
		}
		if($this->input->post()){
			$data['contactdata']= $this->input->post();
			$config['charset'] = 'utf-8';
			$config['wordwrap'] = TRUE;
			$config['mailtype'] = 'html';
			$config['newline'] = "<br>";
			$config['crlf'] = "<br>";
			$EmailFrom = $this->admin_model->getAdminDefaultEmail();
			$EmailTo = $this->admin_model->getAdminDefaultEmail();
			$subject ="BabyL’Amore Contact Us Page Inquiry";
			$data['contactdata'] = $this->input->post();
			$message = $this->load->view('email_layouts/contactadmin', $data,  TRUE);
			$this->email->initialize($config);
			$this->email->from($EmailFrom ,"BabyL'Amore");  
			$this->email->to($EmailTo);	
			$this->email->subject($subject);
			$this->email->message($message);	
			$this->email->send();
			$data['success'] = "<strong> Success! </strong> Your form was submitted successfully. Admin will contact you shortly.";
			
		}
		$this->load->view('frontend/layouts/header_view',$data);
		$this->load->view('frontend/contactus_view', $data);
		$this->load->view('frontend/layouts/footer_view',$data);
	}

	public function getGeoPostalCode()
	{
		
		if(isset($_POST['lat'], $_POST['lng'])) {
			$lat = $_POST['lat'];
			$lng = $_POST['lng'];

			$url = sprintf("https://maps.googleapis.com/maps/api/geocode/json?latlng=%s,%s&sensor=true", $lat, $lng);

			$content = file_get_contents($url); // get json content

			$metadata = json_decode($content, true); //json decoder
			//print_r($metadata);die;

			if(count($metadata['results']) > 0) {
				
				for($i=0; $i<count($metadata['results'][0]['address_components']); $i++)
				{
				$longnames = $metadata['results'][0]['address_components'][$i]['long_name']; 
				$type = $metadata['results'][0]['address_components'][$i]['types'][0];
					if(!empty($type) && ($type=='postal_code') && !empty($longnames))
					{
						$postal_code = $longnames;
						$cookie = array(
							'name' => 'UserLocationPostalCode',
							'value' => $postal_code,
							'expire' => time()+86500,
							'path'   => '/'
							);
						$this->input->set_cookie($cookie);
					}
				}

			}
			
			else {
				// no results returned
			}
			
		
			
		}
		
	}
		
	// get all the zipcodes within the specified radius - default 20
	function zipcodeRadius($lat, $lon, $radius)
	{
		$radius = $radius ? $radius : 20;
		$sql = 'SELECT distinct(ZipCode) FROM zipcode  WHERE (3958*3.1415926*sqrt((Latitude-'.$lat.')*(Latitude-'.$lat.') + cos(Latitude/57.29578)*cos('.$lat.'/57.29578)*(Longitude-'.$lon.')*(Longitude-'.$lon.'))/180) <= '.$radius.';';
		$result = $this->db->query($sql);
		// get each result
		$zipcodeList = array();
		while($row = $this->db->fetch_array($result))
		{
			array_push($zipcodeList, $row['ZipCode']);
		}
		return $zipcodeList;
	}

}