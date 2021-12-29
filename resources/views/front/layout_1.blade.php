<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="og:type" content="website" />
	<meta name="twitter:card" content="photo" />
	<title>@yield('title')</title>
	<link rel="icon" type="image/png" sizes="32x32" href="/{{ check_host() }}assets/images/favicon-icon.png">

	<link rel="stylesheet" type="text/css" href="/{{ check_host() }}assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/{{ check_host() }}assets/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="/{{ check_host() }}assets/css/slick.css">
	<link rel="stylesheet" type="text/css" href="/{{ check_host() }}assets/css/custom.css?v={{ time() }}">
	<link rel="stylesheet" type="text/css" href="/{{ check_host() }}assets/css/style.css?v={{ time() }}">
    @yield('css')
</head>
<body>
	<header class="header-style-2">
		<nav class="navbar navbar-expand-lg">
		  <div class="container">
		    <a class="navbar-brand" href="/">
				<img src="/{{ check_host() }}assets/images/logo.png" class="img-fluid" >
			</a>
		    <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		      <img src="/{{ check_host() }}assets/images/menu-icon.svg">
		    </button> -->
		    <div class="collapse navbar-collapse" id="navbarSupportedContent">

			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" href="/">HOME</a>
		        </li>
				<!-- <li class="nav-item">
					<a class="nav-link" href="/about-us">ABOUT</a>
		        </li> -->

				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
					OUR COMPANY
					</a>
					<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
						<li class="bg-cs-dark">
							<a class="dropdown-item" href="/about-us">ABOUT US</a>
						</li>
						<li  class="bg-cs-dark">
							<a class="dropdown-item" href="/diamonds">WHAT WE HAVE</a>
						</li>
						<li class="bg-cs-dark">
							<a class="dropdown-item" href="/manufacturing">MANUFACTURING</a>
						</li>
						<li class="bg-cs-dark">
							<a class="dropdown-item" href="/grading">GRADING</a>
						</li>
					</ul>
				</li>

				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
						OUR PRODUCT
					</a>
					<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
						<li class="bg-cs-dark">
							<a class="dropdown-item" href="/customer/search-diamonds/polish-diamonds">POLISH DIAMONDS</a>
						</li>
						<li  class="bg-cs-dark">
							<a class="dropdown-item" href="/customer/search-diamonds/4p-diamonds">4P DIAMONDS</a>
						</li>
						<li class="bg-cs-dark">
							<a class="dropdown-item" href="/customer/search-diamonds/rough-diamonds">ROUGH DIAMONDS</a>
						</li>
					</ul>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="/contact">CONTACT</a>
				</li>
			</ul>
		    </div>
		    <div class="ms-auto header-right-menu">
		    	<ul class="navbar-nav ms-auto">
		    		<li class="nav-item">
		    			<a class="nav-link active" aria-current="page" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample"><img src="/{{ check_host() }}assets/images/menu-icon.svg" ></a>
		    		</li>
		    		<li class="nav-item">
						@auth
						<a class="nav-link active" aria-current="page" href="/customer/logout"><img src="/{{ check_host() }}assets/images/mono-exit.svg" ></a>
						@endauth
						@guest
		    			<a class="nav-link active" aria-current="page" href="/customer/login"><img src="/{{ check_host() }}assets/images/user.svg" ></a>
						@endguest
		    		</li>
		    	</ul>
		    	<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
		    		<div class="offcanvas-header">
		    			<button type="button" class="btn-close text-reset ms-auto" data-bs-dismiss="offcanvas" aria-label="Close"></button>
		    		</div>
		    		<div class="offcanvas-body">
		    			<ul class="list-unstyled">
		    				<li><a class="nav-link" aria-current="page" href="/">Home</a></li>
		    				<li><a class="nav-link" aria-current="page" href="/about-us">About Us</a></li>
		    				<li><a class="nav-link" aria-current="page" href="/blog">Blog</a></li>
		    				<li><a class="nav-link" aria-current="page" href="/customer/contact">Contact</a></li>
		    				<li><a class="nav-link" aria-current="page" href="/manufacturing">Manufacturing</a></li>
		    				<li><a class="nav-link" aria-current="page" href="/grading">What we follow?</a></li>
		    				<li><a class="nav-link" aria-current="page" href="/customer/search-diamonds/polish-diamonds">Polish Diamonds</a></li>
		    				<li><a class="nav-link" aria-current="page" href="/customer/search-diamonds/4p-diamonds">4P Diamonds</a></li>
		    				<li><a class="nav-link" aria-current="page" href="/customer/search-diamonds/rough-diamonds">Rough Diamonds</a></li>
		    				<li><a class="nav-link" aria-current="page" href="/why-to-order-online">Why to Order Online?</a></li>
		    				<li><a class="nav-link" aria-current="page" href="/diamonds">What we have?</a></li>
		    				<li><a class="nav-link" aria-current="page" href="/events">Events</a></li>
		    				<li><a class="nav-link" aria-current="page" href="/media">Media</a></li>
		    				<li><a class="nav-link" aria-current="page" href="/gallery">Gallery</a></li>
		    				<li><a class="nav-link" aria-current="page" href="/blog">Blogs</a></li>
		    				<li><a class="nav-link" aria-current="page" href="/business-policy">Business Policy</a></li>
		    				<li><a class="nav-link" aria-current="page" href="/terms-conditions">Terms & Condition</a></li>
		    				<li><a class="nav-link" aria-current="page" href="/privacy-policy">Privacy Policy</a></li>
		    			</ul>
		    		</div>
		    	</div>
		    </div>
			</div>
		  </div>
		</nav>
	</header>

    @yield('content')

	<div class="live-chat">
		<button class="live-chat-btn" onclick="openForm()">
			<img src="/{{ check_host() }}assets/images/chat_conversation.svg" alt="chat-icon" class="chat-icon img-fluid" >
		</button>

		<div class="chat-popup" id="myForm">
			<div class="chat-header">
				<a href="/"><img src="/{{ check_host() }}assets/images/logo.png" class="img-fluid" alt="logo" ></a>
				<button type="button" class="btn cancel" onclick="closeForm()"><img src="/{{ check_host() }}assets/images/close.svg" alt="close" class="img-fluid" ></button>
			</div>
			<div class="chat-body">
				<div class="chat-container">
					<div class="sender">
						<div class="chat-content">
							<p class="">ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<!-- site-footer -->

<footer class="site-footer">
	<div class="container">
		<div class="footer-form">
			<div class="d-flex align-items-center">
				<img src="/{{ check_host() }}assets/images/envelope.svg" class="img-fluid" ><p class="mb-0">Signup Newsletter</p></div>
				<form class="footer_form">
					<div class="input-group">
						<input type="email" class="form-control" placeholder="Enter your email" aria-label="Enter your email" aria-describedby="button-addon">
						<button class="btn btn-primary" type="button" id="button-addon">Subscribe</button>
					</div>
				</form>
			</div>
			<div class="footer-content">
				<div class="row">
					<div class="col col-12 col-sm-12 col-md-6 col-lg-3">
						<div class="quick-link-content">
							<h4 class="title">About Janvi</h4>
							<ul class="list-unstyled footer-link mb-0">
								<li class="item"><a href="/about-us">About us</a></li>
								<li class="item"><a href="/gallery">Gallery</a></li>
								<li class="item"><a href="/media">Media</a></li>
								<li class="item"><a href="/events">Events</a></li>
								<li class="item"><a href="/business-policy">Business Policy</a></li>
								<li class="item"><a href="/blog">Blogs</a></li>
							</ul>
						</div>
					</div>
					<div class="col col-12 col-sm-12 col-md-6 col-lg-3">
						<div class="quick-link-content">
							<h4 class="title">Information</h4>
							<ul class="list-unstyled footer-link mb-0">
								<li class="item"><a href="/order-details">Order Details</a></li>
								<li class="item"><a href="/privacy-policy"> Privacy Policy </a></li>
								<li class="item"><a href="/terms-conditions"> Terms & Conditions </a></li>
								<li class="item"><a href="Javascript:;">Support Now</a></li>
								<li class="item"><a href="/manufacturing">Manufacturing</a></li>
								<li class="item"><a href="/grading">Grading</a></li>
							</ul>
						</div>
					</div>
					<div class="col col-12 col-sm-12 col-md-6 col-lg-3">
						<div class="quick-link-content">
							<h4 class="title">My Account</h4>
							<ul class="list-unstyled footer-link mb-0">
								<li class="item"><a href="/customer/my-account">My Account</a></li>
								<li class="item"><a href="/customer/wishlist">Wishlist</a></li>
								<li class="item"><a href="/customer/checkout">Checkout</a></li>
								<li class="item"><a href="/customer/cart">Cart</a></li>
							</ul>
						</div>
					</div>
					<div class="col col-12 col-sm-12 col-md-6 col-lg-3">
						<div class="quick-link-content">
							<h4 class="title">Contact Us</h4>
							<div class="footer-info">
								<ul class="country_address_links">
									<li>
										<span class="flag-icon">
											<img src="/{{ check_host() }}assets/images/india.png" alt="" >
										</span>
										<span class="location">India</span>
										<div class="location-address">
											<div class="location_inner">
												<p class="add"><span>Address :</span>It is a long edad fg fact that a reader will be distr</p>
												<p class="mail"><span>Email :</span><a href="mailto:abc@gmail.com">abc@gmail.com</a></p>
												<p class="phone"><span>Phone No. :</span><a href="tel:+91 4567890923">+91 4567890923</a></p>
											</div>
										</div>
									</li>
									<li>
										<span class="flag-icon">
											<img src="/{{ check_host() }}assets/images/usa.png" alt="" >
										</span>
										<span class="location">USA</span>
										<div class="location-address">
											<div class="location_inner">
												<p class="add"><span>Address :</span>It is a long edad fg fact that a reader will be distr</p>
												<p class="mail"><span>Email :</span><a href="mailto:abc@gmail.com">abc@gmail.com</a></p>
												<p class="phone"><span>Phone No. :</span><a href="tel:+91 4567890923">+91 4567890923</a></p>
											</div>
										</div>
									</li>
								</ul>

								<p class="social-media-link"><span>Connect With :</span></p>
								<ul class="list-unstyled social-link mb-0">
									<li class="link-item"><a href="https://www.facebook.com/" target="_blank"><img src="/{{ check_host() }}assets/images/facebook.svg" class="img-fluid" ></a></li>
									<li class="link-item"><a href="https://www.instagram.com/" target="_blank"><img src="/{{ check_host() }}assets/images/instagram.svg" class="img-fluid" ></a></li>
									<li class="link-item"><a href="https://twitter.com/" target="_blank"><img src="/{{ check_host() }}assets/images/twitter.svg" class="img-fluid" ></a></li>
									<li class="link-item"><a href="https://www.youtube.com/" target="_blank"><img src="/{{ check_host() }}assets/images/youtube.svg" class="img-fluid" ></a></li>
									<li class="link-item"><a href="javascript:;" target="_blank"><img src="/{{ check_host() }}assets/images/whatsapp.svg" class="img-fluid" ></a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="copyright text-center">
			<p class="mb-0">Copyright © 2021 <a href="/">JANVI LGE</a>. All Rights Reserved.</p>
		</div>
	</div>
</footer>
<script src="/{{ check_host() }}assets/js/jquery-3.6.0.min.js"></script>
<script src="/{{ check_host() }}assets/js/bootstrap.bundle.min.js"></script>
<script src="/{{ check_host() }}assets/js/parallax.js"></script>
<script src="/{{ check_host() }}assets/js/slick.min.js"></script>
<script src="/{{ check_host() }}assets/js/custom.js"></script>
<script>
$(document).ready(function(){
	$('ul.dropdown-menu li .active').removeClass('active');
	$('a[href="' + location.pathname + '"]').addClass('active').closest('li').addClass('active');
});
</script>
@yield('js')
</body>
</html>