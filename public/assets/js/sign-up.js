// Author: Sumeet..... Edited on 2021-10-25
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
    }
});
$(document).on('change', '#email, #mobile', function () {
    $.ajax({
        type: "POST",
        url: "/checkEmailMobile",
        data: {'name': $(this).val(), 'type': $(this).attr('id') == 'email' ? 2 : 1},
        // cache: false,
        context: this,
        dataType: 'JSON',
        success: function(response) {
            if(response.error) {
                $.toast({
                    heading: 'Error',
                    text: response.message,
                    icon: 'error',
                    position: 'top-right'
                });
                $(this).val('');
            }
        },
        failure: function (response) {
            $.toast({
                heading: 'Error',
                text: 'Oops, something went wrong...!',
                icon: 'error',
                position: 'top-right'
            });
        }
    });
});
$("#msform").validate({
    errorClass: 'red-error',
    errorElement: 'div',
    rules: {
        name: {required: true, rangelength: [3,50]},
        email: {
            required: true,
            email: true,
            /* remote: {
                url: "/checkEmailMobile",
                type: "post",
                data: {'name': $(this).val(), 'type': $(this).attr('id') == 'email' ? 2 : 1}
            } */
        },
        mobile: {required: true, number: true, rangelength: [10,11]},
        address: {required: true, rangelength: [10,200]},
        country: {required: true},
        state: {required: true},
        city: {required: true},
        company_name: {required: true, minlength: 4, maxlength: 100},
        company_office_no: {required: true},
        company_email: {required: true, email: true},
        company_gst_pan: {required: true, minlength: 10, maxlength: 15},
        company_address: {required: true, rangelength: [10,200]},
        company_country: {required: true},
        company_state: {required: true},
        company_city: {required: true},
        id_upload: {required: true},
        privacy_terms: {required: true}
    },
    messages: {
        name: {required: "Please enter your name"},
        email: {
            required: "Please enter your email address",
            email: "Your email address must be in the format of name@domain.com"
        },
        mobile: {
            required: "Please enter your mobile number",
            number: "Your contact number should only consist of numeric digits"
        },
        address: {required: "Please enter your address"},
        country: {required: "Please select the country"},
        state: {required: "Please select the state/province"},
        city: {required: "Please enter the city name"},
        company_name: {required: "Please enter your company name"},
        company_office_no: {required: "Please enter your company office number"},
        company_email: { required: "Please enter your company email address"},
        company_gst_pan: {required: "Please enter your company GST or PAN"},
        company_address: {required: "Please enter your company address"},
        company_country: {required: "Please select the country"},
        company_state: {required: "Please select the state/province"},
        company_city: {required: "Please enter the city name"},
        id_proof: {required: "Please upload your business ID proof"},
        privacy_terms: {required: "Please check-mark/accept our terms of use and privacy policy"}
    },
    errorPlacement: function(error, element) {
        error.appendTo( element.parent().nextAll("div.errTxt") );
    },
    submitHandler: function(form) {
        // do other things for a valid form
        // form.submit();
        var formData = new FormData(form);
        formData.append('id_upload', $('#id_upload')[0].files);
        console.log(formData);
        $.ajax({
            type: "POST",
            url: "signup",
            data: formData,
            // cache: false,
            processData : false,
            contentType : false,
            context: this,
            dataType: 'JSON',
            success: function(response) {
                if(response.error) {
                    $.toast({
                        heading: 'Error',
                        text: response.message,
                        icon: 'error',
                        position: 'top-right'
                    });
                }
            },
            failure: function (response) {
                $.toast({
                    heading: 'Error',
                    text: 'Oops, something went wrong...!',
                    icon: 'error',
                    position: 'top-right'
                });
            }
        });
    }
});

$(document).ready(function () {
	// Sing US js
    var current_fs, next_fs, previous_fs; //fieldsets
    var left, opacity, scale; //fieldset properties which we will animate
    var animating; //flag to prevent quick multi-click glitches
    $(document).on('click', '.next-1, .next-2', function () {
        if($(this).hasClass('next-1') && $('#name, #email, #mobile, #state, #city, #address, #country').valid() == false) {
            return false;
        }
        else if($(this).hasClass('next-2') && $('#company_name, #company_office_no, #company_email, #company_gst_pan, #company_address, #company_country, #company_state, #company_city').valid() == false) {
            return false;
        }
        if(animating) return false;
        animating = true;
        current_fs = $(this).parent();
        next_fs = $(this).parent().next();
        //activate next step on progressbar using the index of next_fs
        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
        //show the next fieldset
        next_fs.show();
        //hide the current fieldset with style
        current_fs.animate({opacity: 0}, {
            step: function(now, mx) {
                //as the opacity of current_fs reduces to 0 - stored in "now"
                //1. scale current_fs down to 80%
                scale = 1 - (1 - now) * 0.2;
                //2. bring next_fs from the right(50%)
                left = (now * 50)+"%";
                //3. increase opacity of next_fs to 1 as it moves in
                opacity = 1 - now;
                current_fs.css({});
                next_fs.css({'left': left, 'opacity': opacity});
            },
            duration: 0,
            complete: function(){
                current_fs.hide();
                animating = false;
            },
            //this comes from the custom easing plugin
            easing: 'easeInOutBack'
        });
    });
    /* $(".submit").click(function(){
        return false;
    }); */

  $("input").keypress(function(){
   if ( $(this).val().length >= 1){
    $(this).addClass('active');
    }
  });
  $('.digit-group').find('input').each(function() {
  	$(this).attr('maxlength', 1);
  	$(this).on('keyup', function(e) {
  		var parent = $($(this).parent());

  		if(e.keyCode === 8 || e.keyCode === 37) {
  			var prev = parent.find('input#' + $(this).data('previous'));

  			if(prev.length) {
  				$(prev).select();
  			}
  		} else if((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 39) {
  			var next = parent.find('input#' + $(this).data('next'));

  			if(next.length) {
  				$(next).select();
  			} else {
  				if(parent.data('autosubmit')) {
  					parent.submit();
  				}
  			}
  		}
  	});
  });



});