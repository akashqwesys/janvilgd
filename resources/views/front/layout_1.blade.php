<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="og:type" content="website" />
	<meta name="twitter:card" content="photo" />
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>@yield('title')</title>
	<link rel="icon" type="image/png" sizes="32x32" href="/{{ check_host() }}assets/images/favicon-icon.png">

	<link rel="stylesheet" type="text/css" href="/{{ check_host() }}assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/{{ check_host() }}assets/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="/{{ check_host() }}assets/css/slick.css">
	<link rel="stylesheet" type="text/css" href="/{{ check_host() }}assets/css/custom.css?v={{ time() }}">
	<link rel="stylesheet" type="text/css" href="/{{ check_host() }}assets/css/style.css?v={{ time() }}">
	<link rel="stylesheet" type="text/css" href="/{{ check_host() }}assets/css/new-style.css?v={{ time() }}">
	<link rel="stylesheet" href="{{ asset(check_host().'admin_assets/toast/jquery.toast.css') }}">

	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
	{{-- <link rel="stylesheet" type="text/css" href="/{{ check_host() }}assets/build/css/intlTelInput.css"> --}}

	<style>
		.zoom>img {
			transition: width 1s;
			top: 15px;
			position: absolute;
			z-index: 9999;
			width: 11rem;
		}
		.navbar {
			padding-top: 1rem;
			padding-bottom: 1rem;
		}
		.card-body1{
			padding: 0px !important;
		}
		.row1 {
            padding-right: 20px !important;
            padding-left: 20px !important;
        }
		#myVideo {
		right: 0;
		bottom: 0;
		width: 100%;
		height: 100%;
		object-fit: cover;
    	object-position: center;
		}

		/* iframe {
			height:calc(100vh - 4px);
			width:calc(100vw - 4px);
			box-sizing: border-box;
		} */
	</style>

    @yield('css')
</head>
<body>
<!-- <iframe src="https://www.youtube.com/embed/AabGrt5l4JQ?version=3&enablejsapi=1&rel=0&modestbranding=1&autohide=1&mute=1&showinfo=0&controls=0&autoplay=1&disablekb=1&loop=1&playlist=AabGrt5l4JQ" frameborder="0" allowfullscreen width="1280" height="720"></iframe> -->
<!--
<script>
	"use strict";
if (document.readyState !== 'loading') init();
else document.addEventListener('DOMContentLoaded', init);

function init() {
    if (window.runOnce) return;

    if (typeof YT === 'undefined') {
        var tag = document.createElement('script');
        tag.src = "https://www.youtube.com/iframe_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
    }

    var iframes = [];

    for (var iframe of document.querySelectorAll("iframe[src]")) {
        var src = iframe.getAttribute("src");
        if (src.includes("youtube.com/embed/")) {
            if(!src.includes("enablejsapi=1"))
                if(src.includes("?"))
                    iframe.setAttribute("src", src + "&enablejsapi=1");
                else
                    iframe.setAttribute("src", src + "?enablejsapi=1");

            iframes.push(iframe);
        }
    }

    var overlayStyles = {
        display: "none",
        content:"",
        position: "absolute",
        left: 0,
        right: 0,
        cursor: "pointer",
        backgroundColor: "black",
        backgroundRepeat: "no-repeat",
        backgroundPosition: "center",
    };

    window.onYouTubeIframeAPIReady = function() {
        iframes.forEach(function(iframe) {
            var overlay = document.createElement('div');
            for (var style in overlayStyles) {
                overlay.style[style] = overlayStyles[style];
            }

            var wrapper = document.createElement('div');
            wrapper.style.display = "inline-block";
            wrapper.style.position = "relative";

            iframe.parentNode.insertBefore(wrapper, iframe);

            wrapper.appendChild(overlay);
            wrapper.appendChild(iframe);

            var onPlayerStateChange = function(event) {
                if (event.data == YT.PlayerState.ENDED) {
                    overlay.style.backgroundImage = "url(data:image/svg+xml;utf8;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMjgiIGhlaWdodD0iMTI4IiB2aWV3Qm94PSIwIDAgNTEwIDUxMCI+PHBhdGggZD0iTTI1NSAxMDJWMEwxMjcuNSAxMjcuNSAyNTUgMjU1VjE1M2M4NC4xNSAwIDE1MyA2OC44NSAxNTMgMTUzcy02OC44NSAxNTMtMTUzIDE1My0xNTMtNjguODUtMTUzLTE1M0g1MWMwIDExMi4yIDkxLjggMjA0IDIwNCAyMDRzMjA0LTkxLjggMjA0LTIwNC05MS44LTIwNC0yMDQtMjA0eiIgZmlsbD0iI0ZGRiIvPjwvc3ZnPg==)";
                    overlay.style.backgroundSize = "64px 64px";
                    overlay.style.top = 0;
                    overlay.style.bottom = 0;
                    overlay.style.display = "inline-block";
                } else if (event.data == YT.PlayerState.PAUSED) {
                    overlay.style.backgroundImage = "url(data:image/svg+xml;utf8;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZlcnNpb249IjEiIHdpZHRoPSIxNzA2LjY2NyIgaGVpZ2h0PSIxNzA2LjY2NyIgdmlld0JveD0iMCAwIDEyODAgMTI4MCI+PHBhdGggZD0iTTE1Ny42MzUgMi45ODRMMTI2MC45NzkgNjQwIDE1Ny42MzUgMTI3Ny4wMTZ6IiBmaWxsPSIjZmZmIi8+PC9zdmc+)";
                    overlay.style.backgroundSize = "40px 40px";
                    overlay.style.top = "0px";
                    overlay.style.bottom = "0px";
                    overlay.style.display = "inline-block";
                } else if (event.data == YT.PlayerState.PLAYING) {
                    overlay.style.display = "none";
                }
            };
            var player  = new YT.Player(iframe, {
                    events: {
                        'onStateChange': onPlayerStateChange
                    }
                });
            wrapper.addEventListener("click", function() {
                var playerState = player.getPlayerState();
                if (playerState == YT.PlayerState.ENDED) {
                    player.seekTo(0);
                } else if (playerState == YT.PlayerState.PAUSED) {
                    player.playVideo();
                }
            });
        });
    };
    window.runOnce = true;
}
	</script>
 -->

	<header class="header-style-2">
		<nav class="navbar navbar-expand-lg">
		  <div class="container">
		    <a class="navbar-brand zoom" href="/">
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
						<!-- <li  class="bg-cs-dark">
							<a class="dropdown-item" href="/customer/search-diamonds/4p-diamonds">4P DIAMONDS</a>
						</li>
						<li class="bg-cs-dark">
							<a class="dropdown-item" href="/customer/search-diamonds/rough-diamonds">ROUGH DIAMONDS</a>
						</li> -->
					</ul>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="/contact">CONTACT</a>
				</li>
			</ul>
		    </div>
		    <div class="ms-auto header-right-menu">
		    	<ul class="navbar-nav ms-auto">
		    		{{-- <li class="nav-item">
		    			<a class="nav-link active" aria-current="page" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample"><img src="/{{ check_host() }}assets/images/menu-icon.svg" ></a>
		    		</li> --}}
		    		<li class="nav-item">
						@auth
						<a class="nav-link active" aria-current="page" href="/customer/logout"><img src="/{{ check_host() }}assets/images/mono-exit.svg" ></a>
						@endauth
						@guest
		    			<a class="nav-link active" aria-current="page" href="/customer/login"><img src="/{{ check_host() }}assets/images/user.svg" ></a>
						@endguest
		    		</li>
		    	</ul>
		    	{{-- <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
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
		    				<!-- <li><a class="nav-link" aria-current="page" href="/customer/search-diamonds/4p-diamonds">4P Diamonds</a></li>
		    				<li><a class="nav-link" aria-current="page" href="/customer/search-diamonds/rough-diamonds">Rough Diamonds</a></li> -->
		    				<li><a class="nav-link" aria-current="page" href="/why-to-order-online">Why to Order Online?</a></li>
		    				<li><a class="nav-link" aria-current="page" href="/diamonds">What we have?</a></li>
		    				<li><a class="nav-link" aria-current="page" href="/events">Events</a></li>
		    				<li><a class="nav-link" aria-current="page" href="/media">Media</a></li>
		    				<li><a class="nav-link" aria-current="page" href="/gallery">Gallery</a></li>
		    				<li><a class="nav-link" aria-current="page" href="/blog">Blogs</a></li>
		    				<!-- <li><a class="nav-link" aria-current="page" href="/business-policy">Business Policy</a></li> -->
		    				<li><a class="nav-link" aria-current="page" href="/terms-conditions">Terms & Condition</a></li>
		    				<li><a class="nav-link" aria-current="page" href="/privacy-policy">Privacy Policy</a></li>
		    			</ul>
		    		</div>
		    	</div> --}}
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
								<!-- <li class="item"><a href="/business-policy">Business Policy</a></li> -->
								<li class="item"><a href="/blog">Blogs</a></li>
							</ul>
						</div>
					</div>
					<div class="col col-12 col-sm-12 col-md-6 col-lg-3">
						<div class="quick-link-content">
							<h4 class="title">Information</h4>
							<ul class="list-unstyled footer-link mb-0">
							<li class="item"><a href="/manufacturing">Manufacturing</a></li>
								<li class="item"><a href="/grading">Grading</a></li>
								<li class="item"><a href="/privacy-policy"> Privacy Policy </a></li>
								<li class="item"><a href="/terms-conditions"> Terms & Conditions </a></li>
								<li class="item"><a href="/contact">Contact Us</a></li>

							</ul>
						</div>
					</div>
					<div class="col col-12 col-sm-12 col-md-6 col-lg-3">
						<div class="quick-link-content">
							<h4 class="title">My Account</h4>
							<ul class="list-unstyled footer-link mb-0">
								@auth
								<li class="item"><a href="/customer/my-account">My Account</a></li>
								<li class="item"><a href="/order-details">Order Details</a></li>
								@endauth
								@guest
								<li class="item"><a href="/customer/login">Login</a></li>
								@endguest
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
												<ul>
													<li class="firstli">9757 Aspen Lane South Richmond Hill, NY 11419</li>
													<li class="secondli">info@mywebsite.com</li>
													<li class="thirdli">+1 (291) 939 9321</li>
												</ul>
											</div>
										</div>
									</li>
									<li>
									<span class="flag-icon">
											<img src="/{{ check_host() }}assets/images/usa.png" alt="" >
										</span>
										<span class="location">India</span>
										<div class="location-address">
											<div class="location_inner">
												<ul>
													<li class="firstli">9757 Aspen Lane South Richmond Hill, NY 11419</li>
													<li class="secondli">info@mywebsite.com</li>
													<li class="thirdli">+1 (291) 939 9321</li>
												</ul>
											</div>
										</div>
									</li>
								</ul>

								<p class="social-media-link"><span>Connect With :</span></p>
								<ul class="list-unstyled social-link mb-0">
									<li class="link-item"><a href="https://www.facebook.com/" target="_blank"><img src="/{{ check_host() }}assets/images/facebook.svg" class="img-fluid" ></a></li>
									<li class="link-item"><a href="https://www.instagram.com/" target="_blank"><img src="/{{ check_host() }}assets/images/instagram.svg" class="img-fluid" ></a></li>
									<li class="link-item"><a href="javascript:;" target="_blank"><img src="/{{ check_host() }}assets/images/whatsapp.svg" class="img-fluid" ></a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="copyright text-center">
			<p class="mb-0">Copyright © 2021 <a href="/">JANVI LGD PVT. LTD.</a>. All Rights Reserved.</p>
		</div>
	</div>
</footer>
<script src="/{{ check_host() }}assets/js/jquery-3.6.0.min.js"></script>
<script src="/{{ check_host() }}assets/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script src="/{{ check_host() }}assets/js/parallax.js"></script>
<script src="/{{ check_host() }}assets/js/slick.min.js"></script>
<script src="/{{ check_host() }}assets/js/custom.js"></script>
<script src="{{ asset(check_host().'admin_assets/toast/jquery.toast.js') }}"></script>
{{-- <script src="/{{ check_host() }}assets/build/js/intlTelInput.js"></script> --}}
<script>
    var input = document.querySelector("#phone");
    var iti= window.intlTelInput(input, {
		// allowDropdown: false,
		// autoHideDialCode: false,
		// autoPlaceholder: "off",
		// dropdownContainer: document.body,
		// excludeCountries: ["us"],
		// formatOnDisplay: false,
		// geoIpLookup: function(callback) {
		// 	$.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
		// 		var countryCode = (resp && resp.country) ? resp.country : "";
		// 		callback(countryCode);
		// 	});
		// },
		// hiddenInput: "full_number",
		// initialCountry: "auto",
		// localizedCountries: { 'de': 'Deutschland' },
		// nationalMode: false,
		// onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
		// placeholderNumberType: "MOBILE",
		// preferredCountries: ['cn', 'jp'],
		// separateDialCode: true,

		separateDialCode: true,
		// preferredCountries:["in"],
		hiddenInput: "full",
		//   utilsScript: "//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.js"
		utilsScript: "/{{ check_host() }}assets/build/js/utils.js"
	});

	$("form").submit(function() {
		var full_number = iti.getNumber(intlTelInputUtils.numberFormat.E164);
		$("input[name='txt_phone[full]'").val(full_number);
	});

	// var iti = window.intlTelInput(input, {
	// 	utilsScript: "../../build/js/utils.js?1638200991544" // just for formatting/placeholders etc
	// });
	// input.addEventListener("countrychange",function() {
	// 	alert(iti.getSelectedCountryData());
	// });

	$(document).ready(function(){
		AOS.init();
		<?php
			if (!isset($_SESSION['message'])) {
				$_SESSION['message'] = '';
			}
		?>
		if (<?php
		if (!empty(session()->get('success'))) {
			echo session()->get('success');
		} else {
			echo 0;
		}
		?> === 1)
		{
			$.toast({
				heading: 'Success',
				text: '<?php echo session()->get('message') ?>',
				icon: 'success',
				position: 'top-right'
			});
			<?php session(['success' => 0]); ?>
		}
		$('ul.dropdown-menu li .active').removeClass('active');
		$('a[href="' + location.pathname + '"]').addClass('active').closest('li').addClass('active');

		$(window).scroll(function(){

			if($(window).scrollTop() >= 60) {
				$(".zoom img").css({
					'transition': 'width 1s',
					'width': '8rem'
				});
			}
			if($(window).scrollTop() <= 50) {
				$(".zoom img").css({
					'transition': 'width 1s',
					'width': '11rem'
				});
			}

		});
	});
	</script>
	@if (request()->url() == url('/') . '/contact')
	<script>
	$(document).on('click', '#contact-submit-btn', function(e) {
		e.preventDefault();
		if ($('#fname').val() == '') {

		}
		$.ajax({
			type: "POST",
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			url: "/customer/contact",
			data: {
				'txt_name': $('#fname').val(),
				'txt_phone': $('#phone').val(),
				'country_code': $('#cs-fc').val(),
				'txt_email': $('#email').val(),
				'txt_subject': $('#subject').val(),
				'txt_msg': $('#message').val()
			},
			success: function (res) {
				if (res.success) {
					$.toast({
						heading: 'Success',
						text: res.message,
						icon: 'success',
						position: 'top-right'
					});
					setTimeout(() => {
						location.reload;
					}, 2000);
				} else {
					$.toast({
						heading: 'Error',
						text: res.message,
						icon: 'error',
						position: 'top-right'
					});
				}
			}
		});
	});
	</script>
	@endif

@yield('js')
</body>
</html>












