$(document).ready(function(){
	checko.pageLoad();
	checko.events();

});
checko = {

	pageLoad: function() {
		$('#myTabs a').click(function (e) {
		  e.preventDefault();
		  $(this).tab('show');
		})

	},
	events: function() {
		$(document).bind('keypress', function(e) {
			if(e.keyCode==13){
				e.preventDefault();
			}
		});
		$('#submit-btn').click(function(e){
			
			var type = $('#address_type').val();
			if (type == "add_user") {
				var reg_form = $('.my_form').serialize();
				requestche.form_validate(reg_form);

			} else {
				$('.my_form').submit();
			}
			// request.form_validate(reg_form);
		});
        $(document).on('click','.tabs_title',function(){
        	$('#address_type').val($(this).attr('this-title'));
		});

        $(document).on('click','.table-tr',function(){
        	$('.table-tr').removeClass('success');
        	$(this).addClass('success');
        	$('#addresses_input').removeClass('hide');
        	$('.user_name').val($(this).find('.first_name:first').text()+' '+$(this).find('.lastname_name:first').text());
        	$('.user_phone').val($(this).find('.phone:first').text());
        	$('#user_id').val($(this).attr('user_id'));
        	$('.user_email').val($(this).find('.email:first').text());
        	$('.user_postcode').val($(this).find('.postcode:first').text());
        	$('.user_korean_new_address').val($(this).find('.korean_new_address:first').text());
        	$('.user_korean_old_address').val($(this).find('.korean_old_address:first').text());
        	$('.user_english_address_address').val($(this).find('.english_address_address:first').text());
        	$('.user_details').val($(this).find('.details:first').text());
		});


		$(".searchByButton").click(function(){
			var type = $( "#searchBy option:selected" ).text();
			search = {};
			search[type] = {};

			$(this).parents('.searchByFormGroup:first').find('.searchInputItem').each(function(e){
				var name = $(this).attr('name');
				search[type][name] = $(this).val();
			});
			requestche.search_users(search);
		});
		$("#searchBy").change(function(){
			var search = $(this).find('option:selected').val();
			$(".searchByFormGroup").addClass('hide');
			$("#searchBy-"+search).removeClass('hide');
		});
	}
}
requestche = {
	search_users: function(search) {
		var token = $('meta[name=csrf-token]').attr('content');
		console.log(search);
		$.post(
			'/users/return-users',
			{
				"_token": token,
				search: search
			},
			function(result){
				var status = result.status;
					var message = result.message;
					var table_tbody = result.users_tbody;
					$("#userSearchTable").removeClass('hide');
					$("#userSearchTable tbody").html(table_tbody);
				}
				);
	},
	form_validate: function(reg_form) {
		var token = $('meta[name=csrf-token]').attr('content');
		$.post(
			'/users/validate-sales',
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
function checkof(url)
{

}
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
		$('.my_form').submit()
	};

}