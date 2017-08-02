$(document).ready(function(){

    // Override append function to handle dynamic dom additions using triggers.
    (function($) {
      var origAppend = $.fn.append;

      $.fn.append = function () {
          return origAppend.apply(this, arguments).trigger("append");
      };
    })(jQuery);

    // Handle contact form submission
    $('#url_form').on('submit', function(e) {
        e.preventDefault();  //prevent form from submitting

        var form_button = $('#url_form_submit');
        form_button.prop('disabled', true);

        var form = $(this);
        var error = {};
    		var url = $('#url').val().trim();
    		var csrf_token = $('#csrf_token').val().trim();

        // Validations
    		if (url == '' || url == null || !isURL(url)) {
    			$('#url').addClass('invalid');
    			$('#url_error').show();
    			error['url'] = true;
    		} else {
    			$('#url').removeClass('invalid');
    			$('#url_error').hide();
    			delete error['url'];
    		}

        // Submit using ajax if validation is successful
    		if (Object.keys(error).length == 0) {
        			var formData = {
                  'url' : url,
                  'csrf_token': csrf_token //for csrf validation
        			};
    	        $.ajax({
    	            type        : 'POST',
    	            url         : '/php/url_shortener.php',
    	            data        : formData,
    	            dataType    : 'json',
    	            encode      : true,
    	            beforeSend  : function() {
    	            	form_button.html('Shortening...');
    	            }
    	        })
    	        .done(function(data) {
    	            if (data !=null && data.hasOwnProperty('status') && data.status === 'success') {
                      addNewURL(data.short_url, url);
    	            } else {
          	    		 	$('.form-message').text('Something went wrong, go back and try again!').show().addClass('red');
    	            }

          	    		 	form_button.html('Shorten');
             });
  		}

  		form_button.prop('disabled', false);
  });
});


function addNewURL(short_url, destination_url) {
	var html = '<div class="url_card"><a class="from_url" target="_blank" href="index.php?goto='+short_url+'">'+short_url+'</a><div class="to_url">'+destination_url+'</div></div>';
	$('#recent').prepend(html);
}


//function to validate urls at the front end. Ideally would use a library like https://www.npmjs.com/package/valid-url
function isURL(str) {
  var pattern = new RegExp('^(https?:\\/\\/)?'+ // protocol
  '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.?)+[a-z]{2,}|'+ // domain name
  '((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
  '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // port and path
  '(\\?[;&a-z\\d%_.~+=-]*)?'+ // query string
  '(\\#[-a-z\\d_]*)?$','i'); // fragment locator
  return pattern.test(str);
}
