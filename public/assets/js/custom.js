	// live chate popup
	function openForm() {
		document.getElementById("myForm").style.display = "block";
	}

	function closeForm() {
		document.getElementById("myForm").style.display = "none";
	}
$(document).ready(function () {

	// header style 2 (with login)
	(function () {
		"use strict";
		if ($('[data-bs-toggle="offcanvas"]').length) {
			document
			.querySelector('[data-bs-toggle="offcanvas"]')
			.addEventListener("click", function () {
				document.querySelector(".offcanvas-collapse").classList.toggle("open");
			});
		}
	})();

	jQuery('.btn-close').click(function(){
		jQuery('.offcanvas-style-2').removeClass('open');
	})


	$('.home-blog-list').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		arrows: true,
	});
	$('.home-client-list').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		arrows: true,
	});
	$('.partners-slider').slick({
		slidesToShow: 5,
		slidesToScroll: 1,
		arrows: true,
		responsive: [
			{
				breakpoint: 1024,
				settings: {
					slidesToShow: 4,
				}
			},
			{
				breakpoint: 767,
				settings: {
					slidesToShow: 3,
				}
			},
			{
				breakpoint: 480,
				settings: {
					slidesToShow: 2,
				}
			}
		]
	});


	$('.product--slider').slick({
		dots: false,
		arrows: false,
		infinite: true,
		speed: 200,
		slidesToShow: 1,
		slidesToScroll: 1,
		autoplay: false,
		autoplaySpeed: 2000,
		cssEase: 'linear',
		asNavFor: '.product--slider-thumb',
		responsive: [
		{
			breakpoint: 1024,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1,
			}
		},
		{
			breakpoint: 600,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1
			}
		},
		{
			breakpoint: 480,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1
			}
		}
		]
	});

	$('.product--slider-thumb').slick({
		dots: false,
		arrows: false,
		infinite: false,
		slidesToShow: 4,
		slidesToScroll: 4,
		asNavFor: '.product--slider',
		focusOnSelect: true,
		responsive: [
		{
			breakpoint: 1024,
			settings: {
				slidesToShow: 4,
				slidesToScroll: 4
			}
		},
		{
			breakpoint: 600,
			settings: {
				slidesToShow: 4,
				slidesToScroll: 4
			}
		},
		{
			breakpoint: 480,
			settings: {
				slidesToShow: 4,
				slidesToScroll: 4
			}
		}
		]
	});


	// about js
	jQuery('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {

        var href = jQuery(e.target).attr('href');
        var $curr = jQuery(".checkout-bar  a[href='" + href + "']").parent();

        jQuery('.checkout-bar li').removeClass();

        $curr.addClass("active");
        $curr.prevAll().addClass("visited");

    });

    jQuery('.next-tab').click(function(){

        var next = jQuery('.nav-tabs > .active').next('li');
        if(next.length){
            next.find('a').trigger('click');
            console.log('next if');
        }else{
            jQuery('#nav-tab a:first').tab('show');
            console.log('next else');
        }
    });
    jQuery('.previous-tab').click(function(){

        var prev = jQuery('.nav-tabs > .active').prev('li')
        if(prev.length){
            prev.find('a').trigger('click');
            console.log('prev if');
        }else{
            jQuery('#nav-tab a:last').tab('show');
            console.log('prev else');
        }
    });

	// ******* filter-input-slider *******
	// ******* filter-input-slider *******
	var count = 1;
	jQuery( "#filter-toggle" ).click(function() {
		// jQuery('.filter-toggle').toggle();
		var sliders = document.querySelectorAll('.min-max-slider');
		sliders.forEach( function(slider) {
			init(slider,count,'click');
		});
		count++;
	});

	var thumbsize = 14;

	function draw(slider,splitvalue) {

		/* set function vars */
		var min = slider.querySelector('.min');
		var max = slider.querySelector('.max');
		var lower = slider.querySelector('.lower');
		var upper = slider.querySelector('.upper');
		var legend = slider.querySelector('.legend');
		var thumbsize = parseInt(slider.getAttribute('data-thumbsize'));
		var rangewidth = parseInt(slider.getAttribute('data-rangewidth'));
		var rangemin = parseInt(slider.getAttribute('data-rangemin'));
		var rangemax = parseInt(slider.getAttribute('data-rangemax'));

		/* set min and max attributes */
		min.setAttribute('max',splitvalue);
		max.setAttribute('min',splitvalue);

		/* set css */
		min.style.width = parseInt(thumbsize + ((splitvalue - rangemin)/(rangemax - rangemin))*(rangewidth - (2*thumbsize)))+'px';
		max.style.width = parseInt(thumbsize + ((rangemax - splitvalue)/(rangemax - rangemin))*(rangewidth - (2*thumbsize)))+'px';
		min.style.left = '0px';
		max.style.left = parseInt(min.style.width)+'px';
		min.style.top = lower.offsetHeight+'px';
		max.style.top = lower.offsetHeight+'px';
		legend.style.marginTop = min.offsetHeight+'px';
		slider.style.height = (lower.offsetHeight + min.offsetHeight + legend.offsetHeight)+'px';

		/* correct for 1 off at the end */
		if(max.value>(rangemax - 1)) max.setAttribute('data-value',rangemax);

		/* write value and labels */
		max.value = max.getAttribute('data-value');
		min.value = min.getAttribute('data-value');
		lower.innerHTML = min.getAttribute('data-value');
		upper.innerHTML = max.getAttribute('data-value');

	}

	function init(slider,count,action) {
		console.log(count);
		/* set function vars */
		if(count == 1){
			var min = slider.querySelector('.min');
			var max = slider.querySelector('.max');
			var rangemin = parseInt(min.getAttribute('min'));
			var rangemax = parseInt(max.getAttribute('max'));
			var avgvalue = (rangemin + rangemax)/2;
			var legendnum = slider.getAttribute('data-legendnum');

			/* set data-values */
			min.setAttribute('data-value',rangemin);
			max.setAttribute('data-value',rangemax);

			/* set data vars */
			slider.setAttribute('data-rangemin',rangemin);
			slider.setAttribute('data-rangemax',rangemax);
			slider.setAttribute('data-thumbsize',thumbsize);
			slider.setAttribute('data-rangewidth',slider.offsetWidth);

			/* write labels */
			var lower = document.createElement('span');
			var upper = document.createElement('span');
			lower.classList.add('lower','value');
			upper.classList.add('upper','value');
			if(action != "click"){
			lower.appendChild(document.createTextNode(rangemin));
			upper.appendChild(document.createTextNode(rangemax));
			slider.insertBefore(lower,min.previousElementSibling);
			slider.insertBefore(upper,min.previousElementSibling);
		}
			/* write legend */
			var legend = document.createElement('div');
			legend.classList.add('legend');
			var legendvalues = [];
			for (var i = 0; i < legendnum; i++) {
				legendvalues[i] = document.createElement('div');
				var val = Math.round(rangemin+(i/(legendnum-1))*(rangemax - rangemin));
				legendvalues[i].appendChild(document.createTextNode(val));
				legend.appendChild(legendvalues[i]);
			}
			slider.appendChild(legend);
			/* draw */
			draw(slider,avgvalue);
			/* events */
			min.addEventListener("input", function() {update(min);});
			max.addEventListener("input", function() {update(max);});
		}
	}

	function update(el){
		/* set function vars */
		var slider = el.parentElement;
		var min = slider.querySelector('#min');
		var max = slider.querySelector('#max');
		var minvalue = Math.floor(min.value);
		var maxvalue = Math.floor(max.value);

		/* set inactive values before draw */
		min.setAttribute('data-value',minvalue);
		max.setAttribute('data-value',maxvalue);

		var avgvalue = (minvalue + maxvalue)/2;
		/* draw */
		draw(slider,avgvalue);
	}

	var sliders = document.querySelectorAll('.min-max-slider');
	sliders.forEach( function(slider) {
		init(slider,1,'direct');
	});






});



