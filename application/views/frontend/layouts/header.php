<!DOCTYPE html>
	<html lang="zxx" class="no-js">
	<head>
		<!-- Mobile Specific Meta -->
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- Favicon-->
		<link rel="shortcut icon" href="<?php echo base_url();?>assets/img/fav.png">
		<!-- Author Meta -->
		<meta name="author" content="CodePixar">
		<!-- Meta Description -->
		<meta name="description" content="">
		<!-- Meta Keyword -->
		<meta name="keywords" content="">
		<!-- meta character set -->
		<meta charset="UTF-8">
		<!-- Site Title -->
		<title>Creative Agency</title>

		<link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet"> 
			<!--
			CSS
			============================================= -->
			<link rel="stylesheet" href="<?php echo base_url();?>assets/frontend/css/bootstrap.css" />
			<link rel="stylesheet" href="<?php echo base_url();?>assets/frontend/css/font-awesome.min.css" />
			
			<!--<link rel="stylesheet" href="css/linearicons.css">-->
			
			<!--<link rel="stylesheet" href="<?php echo base_url();?>assets/frontend/css/jquery.DonutWidget.min.css" />-->
			<link rel="stylesheet" href="<?php echo base_url();?>assets/frontend/css/owl.carousel.css">
			<link rel="stylesheet" href="<?php echo base_url();?>assets/frontend/css/main.css">
			<link rel="stylesheet" href="<?php echo base_url();?>assets/frontend/css/style.css">
		</head>
		<body>

			<!-- Start Header Area -->
			<header class="default-header">
				<nav class="navbar navbar-expand-lg  navbar-light">
					<div class="container">
						  <a class="navbar-brand" href="<?php echo base_url(); ?>">
						  	<img src="<?php echo base_url();?>assets/img/logo.png" alt="">
						  </a>
						  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						    <span class="navbar-toggler-icon"></span>
						  </button>

						  <div class="collapse navbar-collapse justify-content-end align-items-center" id="navbarSupportedContent">
						    <ul class="navbar-nav">
								<li><a href="<?php echo base_url(); ?>#home">Home</a></li>
								<li><a href="<?php echo base_url(); ?>#service">Service</a></li>
								<li><a href="<?php echo base_url(); ?>#project">project</a></li>
								<li><a href="<?php echo base_url(); ?>#blog">blog</a></li>
								<li><a href="<?php echo base_url(); ?>#team">team</a></li>
								<li><a href="<?php echo base_url(); ?>pricing">pricing</a></li>
								<?php if($this->session->userdata('logged_in')){ ?>
								<li><a href="<?php echo base_url(); ?>admin" class="dashboard">Dashboard</a></li>
							    <?php }else{ ?>
							    <li><a href="<?php echo base_url(); ?>pricing">sign up</a></li>
								<?php } ?>
								<?php if($this->session->userdata('logged_in')){ ?>
								<li><a href="<?php echo base_url(); ?>user/logout">log out</a></li>
							    <?php }else{ ?>
                                <li><a href="<?php echo base_url(); ?>user">log in</a></li>
							    <?php } ?>
							   <!-- Dropdown -->
							    <!--<li class="dropdown">
							      <a class="dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
							        Pages
							      </a>
							      <div class="dropdown-menu">
							        <a class="dropdown-item" href="generic.html">Generic</a>
							        <a class="dropdown-item" href="elements.html">Elements</a>
							      </div>
							    </li>-->								
						    </ul>
						  </div>						
					</div>
				</nav>
			</header>