// Author: Sumeet..... Edited on 2021-11-15
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
    },
    beforeSend: function (xhr) {
        $(".cs-loader").show();
    }
});
$(document).on('change', '#email, #mobile', function () {
    $('.cs-loader').show();
    $.ajax({
        type: "POST",
        url: "/checkEmailMobile",
        data: {'name': $(this).val(), 'type': $(this).attr('id') == 'email' ? 2 : 1},
        // cache: false,
        context: this,
        dataType: 'JSON',
        success: function(response) {
            $('.cs-loader').hide();
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
$(document).on('change', '#country', function () {
    $.ajax({
        type: "POST",
        url: "/getStates",
        data: { 'id': $(this).val() },
        // cache: false,
        context: this,
        dataType: 'JSON',
        success: function (response) {
            $('.cs-loader').hide();
            if (response.error) {
                $.toast({
                    heading: 'Error',
                    text: response.message,
                    icon: 'error',
                    position: 'top-right'
                });
            }
            else {
                $('#state').html(response.data).select2();
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
$(document).on('change', '#state', function () {
    $.ajax({
        type: "POST",
        url: "/getCities",
        data: { 'id': $(this).val() },
        // cache: false,
        context: this,
        dataType: 'JSON',
        success: function (response) {
            $('.cs-loader').hide();
            if (response.error) {
                $.toast({
                    heading: 'Error',
                    text: response.message,
                    icon: 'error',
                    position: 'top-right'
                });
            }
            else {
                $('#city').html(response.data).select2();
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
$(document).on('change', '#company_country', function () {
    $.ajax({
        type: "POST",
        url: "/getStates",
        data: { 'id': $(this).val() },
        // cache: false,
        context: this,
        dataType: 'JSON',
        success: function (response) {
            $('.cs-loader').hide();
            if (response.error) {
                $.toast({
                    heading: 'Error',
                    text: response.message,
                    icon: 'error',
                    position: 'top-right'
                });
            }
            else {
                $('#company_state').html(response.data).select2();
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
$(document).on('change', '#company_state', function () {
    $.ajax({
        type: "POST",
        url: "/getCities",
        data: { 'id': $(this).val() },
        // cache: false,
        context: this,
        dataType: 'JSON',
        success: function (response) {
            $('.cs-loader').hide();
            if (response.error) {
                $.toast({
                    heading: 'Error',
                    text: response.message,
                    icon: 'error',
                    position: 'top-right'
                });
            }
            else {
                $('#company_city').html(response.data).select2();
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
            email: true
        },
        password: { required: true, rangelength: [6, 15] },
        confirm_password: { required: true, equalTo: "#password" },
        // country_code: { required: true },
        mobile: {/*required: true,*/ number: true, rangelength: [10,11]},
        address: {required: true, rangelength: [10,200]},
        country: {required: true},
        state: {required: true},
        city: {required: true},
        pincode: { required: true, number: true},
        company_name: {required: true, minlength: 4, maxlength: 100},
        company_office_no: { required: true, rangelength: [10,11]},
        company_email: {required: true, email: true},
        company_gst_pan: {required: true, minlength: 9, maxlength: 15},
        company_address: {required: true, rangelength: [10,200]},
        company_country: {required: true},
        company_state: {required: true},
        company_city: {required: true},
        company_pincode: { required: true, number: true},
        id_upload: {required: true},
        privacy_terms: {required: true}
    },
    messages: {
        name: {required: "Please enter your name"},
        email: {
            required: "Please enter your email address",
            email: "Your email address must be in the format of name@domain.com"
        },
        password: { required: "Please enter password" },
        confirm_password: { required: "Please enter confirm password", equalTo: 'Those password didn\'t match. Try again' },
        // country_code: { required: "Please select country code" },
        mobile: {
            // required: "Please enter your mobile number",
            number: "Your contact number should only consist of numeric digits"
        },
        address: {required: "Please enter your address"},
        country: {required: "Please select the country"},
        state: {required: "Please select the state/province"},
        city: {required: "Please enter the city name"},
        pincode: {required: "Please enter the pincode"},
        company_name: {required: "Please enter your company name"},
        company_office_no: {required: "Please enter your company office number"},
        company_email: { required: "Please enter your company email address"},
        company_gst_pan: {required: "Please enter your company GST or PAN"},
        company_address: {required: "Please enter your company address"},
        company_country: {required: "Please select the country"},
        company_state: {required: "Please select the state/province"},
        company_city: {required: "Please enter the city name"},
        company_pincode: {required: "Please enter the pincode"},
        id_upload: {required: "Please upload your business ID proof"},
        privacy_terms: {required: "Please check-mark/accept our terms of use and privacy policy"}
    },
    errorPlacement: function(error, element) {
        if (element.attr('id') == 'id_upload') {
            error.appendTo(element.closest('.custom-file-field').nextAll("div.errTxt"));
        } else {
            error.appendTo(element.parent().nextAll("div.errTxt"));
        }
    },
    submitHandler: function(form) {
        // do other things for a valid form
        // form.submit();
        $('.cs-loader').show();
        var formData = new FormData(form);
        formData.append('id_upload', $('#id_upload')[0].files);
        $.ajax({
            type: "POST",
            url: "/customer/signup",
            data: formData,
            // cache: false,
            processData : false,
            contentType : false,
            context: this,
            dataType: 'JSON',
            success: function(response) {
                $('.cs-loader').hide();
                if (response.success == 1) {
                    /* $.toast({
                        heading: 'Success',
                        text: response.message,
                        icon: 'success',
                        position: 'top-right'
                    });
                    setTimeout(() => {
                        window.location = response.url;
                    }, 2000); */
                    $('.success-block').append(response.message).show();
                    $('#msform').remove();
                }
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
                $('.cs-loader').hide();
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
$(document).on('change', '#country_code', function () {
    $('#country').val($(this).val()).trigger('change');
});
$('#country_code').on('select2:open', function (e) {
    setTimeout(() => {
        $('#select2-country_code-results').parent().parent().css('width', '15vw');
    }, 10);
});
$(document).on('change', '#id_upload', function () {
    $(this).prev('.et_pb_contact_form_label').attr('data-content', $(this)[0].files[0].name);
});

$(document).ready(function () {
	// Sing US js
    var current_fs, next_fs, previous_fs; //fieldsets
    var left, opacity, scale; //fieldset properties which we will animate
    var animating; //flag to prevent quick multi-click glitches
    $(document).on('click', '.previous-1, .previous-2', function () {
        if (animating) return false;
        animating = true;
        current_fs = $(this).parent();
        previous_fs = $(this).parent().prev();
        //activate next step on progressbar using the index of previous_fs
        $("#progressbar li").eq($("fieldset").index(previous_fs)).addClass("active");
        $("#progressbar li").eq($("fieldset").index(previous_fs)+1).removeClass("active");
        //show the next fieldset
        previous_fs.show();
        //hide the current fieldset with style
        current_fs.animate({ opacity: 0 }, {
            step: function (now, mx) {
                //as the opacity of current_fs reduces to 0 - stored in "now"
                //1. scale current_fs down to 80%
                scale = 1 - (1 - now) * 0.2;
                //2. bring next_fs from the right(50%)
                left = (now * 50) + "%";
                //3. increase opacity of next_fs to 1 as it moves in
                opacity = 1 - now;
                current_fs.css({});
                previous_fs.css({ 'left': left, 'opacity': opacity });
            },
            duration: 0,
            complete: function () {
                current_fs.hide();
                animating = false;
            },
            //this comes from the custom easing plugin
            easing: 'easeInOutBack'
        });
    });
    $(document).on('click', '.next-1, .next-2', function () {
        if($(this).hasClass('next-1') && $('#name, #email, #password, #confirm_password, #mobile, #state, #city, #address, #country, #pincode').valid() == false) {
            return false;
        }
        else if($(this).hasClass('next-2') && $('#company_name, #company_office_no, #company_email, #company_gst_pan, #company_address, #company_country, #company_state, #company_city, #company_pincode').valid() == false) {
            return false;
        }
        else {
            setTimeout(() => {
                $('.errTxt').html('');
            }, 5);
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