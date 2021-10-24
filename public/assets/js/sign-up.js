
$(document).ready(function () {
	// Sing US js
    var current_fs, next_fs, previous_fs; //fieldsets
    var left, opacity, scale; //fieldset properties which we will animate
    var animating; //flag to prevent quick multi-click glitches
    $(".next").click(function(){
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
    $(".submit").click(function(){
        return false;
    });

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

  // sing us js end

});