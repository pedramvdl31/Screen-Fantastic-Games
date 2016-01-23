$(document).ready(function(){
	registration.pageLoad();
	registration.events();
	registration.file_upload();

});
registration = {
	pageLoad: function() {
	},
	events: function() {
		$('#submit-btn').click(function(){
			var reg_form = $('#reg-form').serialize();
			request.form_validate(reg_form);
		});
	},
		file_upload: function(){
		$('#form-submit-btn').change(function () {
			$('#loading-icons-1').removeClass('hide');

			event.stopPropagation(); // Stop stuff happening
		    event.preventDefault(); // Totally stop stuff happening

		    // START A LOADING SPINNER HERE

		    // Create a formdata object and add the files
		    var this_file = new FormData();
		    $.each(this.files, function(key, value)
		    {
		        this_file.append(key, value);
		    });
		 	$.ajax({
			        url: '/users/send-file-temp',
			        type: 'POST',
			        data: this_file,
			        cache: false,
			        dataType: 'json',
			        processData: false, // Don't process the files
			        contentType: false, // Set content type to false as jQuery will tell the server its a query string request
			        success: function(data, textStatus, jqXHR)
			        {
			        	var status = data.status;
			        	switch (status){
			        		case 'success':
			        			$('#loading-icons-1').addClass('hide');
			        			var image_name = data.image_name;
			        			var image_type = data.image_type;
			        			var html = '/assets/images/profile-images/tmp/'+image_name+'.'+image_type;
			        			$('.profile-picture').attr('src',html);

			        			var hidden_form = '<input type="hidden" id="profile-pic" name="profile-image" value="'+image_name+'.'+image_type+'">';
			        			$('#profile-pic').remove();
			        			$('.form-frame').append(hidden_form);
			        		break;
			        		case 'error':

			        		break;
			        	}
			        },
			        error: function(jqXHR, textStatus, errorThrown)
			        {

			        }
			    });
			});
		}
}
request = {
	form_validate: function(reg_form) {
		var token = $('meta[name=csrf-token]').attr('content');
		$.post(
			'/users/validate',
			{
				"_token": token,
				"reg_form":reg_form
			},
			function(result){
				var status = result.status;
				var call_back = result.validation_callback;
				reset_errors();
				view_errors(call_back);
				switch(status) {
					case 200: // Approved
					break;

					default:
					break;
				}
			}
			);
	}
};
function reset_errors()
{
	$('.error').addClass('hide');
}
function view_errors(data)
{
	var error_status = false;
	$.each(data, function (i, j) {
		var message = null;
 		switch(i){
 			case "first_name":
 			if (j['status'] == 400) {
 				error_status = true;
 				 message = j['message'];
 				 $('.error-first_name').removeClass('hide').html(message);
 				}
 			break;
 			case "last_name":
 			if (j['status'] == 400) {
 				error_status = true;
 				 message = j['message'];
 				 $('.error-last_name').removeClass('hide').html(message);
 				}
 			break;
 			case "phone":
 			if (j['status'] == 400) {
 				error_status = true;
 				 message = j['message'];
 				 $('.error-phone').removeClass('hide').html(message);
 				}
 			break;
 			case "age":
	 			if (j['status'] == 400) {
	 				error_status = true;
	 				message = j['message'];
	 				$('.error-age').removeClass('hide').html(message);
	 			};
 			break;
 			case "email":
 			if (j['status'] == 400) {
 				error_status = true;
 				message = j['message'];
 				$('.error-email').removeClass('hide').html(message);
 			}
 			break;
 			case "username":
 			if (j['status'] == 400) {
 				error_status = true;
 				message = j['message'];
 				$('.error-username').removeClass('hide').html(message);
 			}
 			break;
 			case "password":
 			if (j['status'] == 400) {
 				error_status = true;
 				message = j['message'];
 				$('.error-password').removeClass('hide').html(message);
 			}
 			break;
 			case "password_again":
 			if (j['status'] == 400) {
 				error_status = true;
 				message = j['message'];
 				$('.error-password-again').removeClass('hide').html(message);
 			}
 			break;
 		}

	});
 		//IF THERE WAS NO ERRORS SUBMIT THE FORM
 		if (error_status == false) {
 			$('#reg-form').submit()
 		};

}