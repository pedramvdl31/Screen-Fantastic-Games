$(document).ready(function(){
	invoice.pageLoad();
	invoice.events();
	invoice.stepy();
});
invoice = {

	pageLoad: function() {
		$.ajaxSetup({
			headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') }
		});
	},
	events: function() {


        $("#pretax").priceFormat({
			'prefix':''
		});
        $("#tax").priceFormat({
			'prefix':''
		});
        $("#aftertax").priceFormat({
			'prefix':''
		});



		$(".searchByButton").click(function(){
			var type = $( "#searchBy option:selected" ).text();
			search = {};
			search[type] = {};

			$(this).parents('.searchByFormGroup:first').find('.searchInputItem').each(function(e){
				var name = $(this).attr('name');
				var new_name = name .slice(0, -4);
				search[type][new_name] = $(this).val();
			});
			request.search_users(search);
		});
		$("#searchBy").change(function(){
			var search = $(this).find('option:selected').val();
			$(".searchByFormGroup").addClass('hide');
			$("#searchBy-"+search).removeClass('hide');
		});
		//SET USER ID
        $(document).on('click','.invoice-customer',function(){
         	var _this = $(this);
		     
		    // $this will contain a reference to the checkbox   
		    if (_this.is(':checked')) {
		    	var customer_id = _this.attr('customer_id');
		       $('#customer_id_input').val(customer_id);
		       request.user_info(customer_id);
		    } else {
		        $('#customer_id_input').val(0);
		    }
        });

	},	
	stepy: function() {
		$("#deliveryStepy li a").click(function(e){

			previous_step = $("#deliveryStepy .active");
			e.preventDefault();
			var href = $(this).attr('href');
			$("#deliveryStepy li").removeClass('active');
			$(this).parents('li:first').addClass('active');
			$(".steps").addClass('hide');
			$(href).removeClass('hide');

			if ((href == "#billingInfo")) {
				if (previous_step.hasClass('customerInfo') || previous_step.hasClass('menuSelection')) {
					var type = $(document).find('#searchCustomerNavTabs .active').attr('type');
					setCustomerInfo(type);
				} else if (previous_step.hasClass('deliverySetup')){
					updateBillingInfo();
				}
			} else if (href == "#deliverySetup"){
				//THERE WAS A SESSION DONT FILL THE DELIVERY ADDRESS, INSTEAD FILL IT IN PHP
				if (previous_step.hasClass('customerInfo')) {
					var type = $(document).find('#searchCustomerNavTabs .active').attr('type');
					if (type == "guests") {
						setCustomerInfo(type);
					}
				}
				setDeliveryAddress();
				

			} else if (href == '#confirmation'){
				varifyInputs();
			} else if (href == '#customerInfo') {
				if (previous_step.hasClass('deliverySetup')) {
					var type = $(document).find('#searchCustomerNavTabs .active').attr('type');
					if (type == "guests") {
						updateGuestInfoFromDeliverySetup();
					}
				} else {
					var type = $(document).find('#searchCustomerNavTabs .active').attr('type');
					if (type == "guests") {
						updateGuestInfo();
					}

				}
			}

		});

		$(".next").click(function(){


			$("#deliveryStepy .active").next('li').addClass('row-active');
			$("#deliveryStepy li").removeClass('active');
			$(document).find(".row-active").addClass('active').removeClass('row-active');
			var href = $(document).find('#deliveryStepy .active a').attr('href');
			$(".steps").addClass('hide');
			$(href).removeClass('hide');

			if($(this).attr('step') == 3) {//this step is billing info
				var type = $(document).find('#searchCustomerNavTabs .active').attr('type');
				setCustomerInfo(type);
			}
			if($(this).attr('step') == 4) {//this step is billing info
				setDeliveryAddress();
			}
			if($(this).attr('step') == 5) {
				
				varifyInputs();
			}
		});
		$(".previous").click(function(){
			$("#deliveryStepy .active").prev('li').addClass('row-active');
			$("#deliveryStepy li").removeClass('active');
			$(document).find(".row-active").addClass('active').removeClass('row-active');
			var href = $(document).find('#deliveryStepy .active a').attr('href');
			$(".steps").addClass('hide');
			$(href).removeClass('hide');
				if($(this).attr('step') == 4) {//coming from billing info
					var type = $(document).find('#searchCustomerNavTabs .active').attr('type');
					if (type == "guests") {
						updateGuestInfo();
					}
				}
			if($(this).attr('step') == 5) {//coming from deliverySetup
				updateBillingInfo();
			}
		});

}
}
request = {
	search_users: function(search) {
		var token = $('meta[name=csrf-token]').attr('content');
		$.post(
			'/users/invoice-users',
			{
				"_token": token,
				search: search
			},
			function(result){
				var status = result.status;
					var message = result.message;
					var user_data = result.user_data;
					$("#userSearchTable").removeClass('hide');
					$("#userSearchTable tbody").html(user_data['users_tbody']);
				}
				);
	},
	user_info: function(id) {
		var token = $('meta[name=csrf-token]').attr('content');
		$.post(
			'/users/user-info',
			{
				"_token": token,
				"id": id
			},
			function(result){
				var status = result.status;
				var users = result.users;
				switch(status) {
					case 200: 

						fill_user_info(users);
					break;				
					case 400: 
						
					break;
					default:
					break;
				}

				}
				);
	},

};

function fill_user_info(data) {
	$('#firstName').val(data['firstname']);
	$('#lastName').val(data['lastname']);
	$('#email').val(data['email']);
	$('#phone').val(data['phone']);
	$('#street').val(data['street']);
	$('#unit').val(data['unit']);
	$('#zipcode').val(data['zipcode']);
	$('#city').val(data['city']);
	$('#state').val(data['state']);
	$('#country').val(data['country']);
	$('#payment_id').val(data['payment_id']);
}