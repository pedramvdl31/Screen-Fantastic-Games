$(document).ready(function(){
	sales.pageLoad();
	sales.events();

});
sales = {

	pageLoad: function() {
		$.ajaxSetup({
			headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') }
		});
	},
	events: function() {
	$(document).bind('keypress', function(e) {
		if(e.keyCode==13){
			e.preventDefault();
		}
	});
    $(document).on('click','.btn-number',function(e){
        e.preventDefault();
        var fieldName = $(this).attr('data-field');
        var type      = $(this).attr('data-type');
        var input = $("input[name='"+fieldName+"']");
        var currentVal = parseInt($(this).parents('.input-group:first').find('.input-number:first').val());
        var cur_minus = currentVal - 1;
        var cur_plus = currentVal + 1;

        if (!isNaN(currentVal)) {

            if(type == 'minus') {
                if(currentVal > $('.input-number').attr('min')) {
                	$(this).parents('.input-group:first').find('.input-number:first').val(currentVal - 1);
                } 
                if(cur_minus == $('.input-number').attr('min')) {
                    $(this).attr('disabled', true);
                }
            } else if(type == 'plus') {

                if(currentVal < $('.input-number').attr('max')) {
                    $(this).parents('.input-group:first').find('.input-number:first').val(currentVal + 1);
                    $(this).parents('.input-group:first').find('.btn-number:first').attr('disabled', false);
                }
                if(cur_plus == $('.input-number').attr('max')) {
                    $(this).attr('disabled', true);
                }
            }
        } else {
            input.val(0);
        }
    	// var single_price = parseInt($(this).parents('.item-quantity:first').attr('single-price'));
    	// var quantity = parseInt($(this).parents('.input-group:first').find('.input-number:first').val());
    	// var total = single_price * quantity;
    	// var new_total = digits(total);
     //    var shipping_cost = $('.shipping-text').attr('this-shipping');
     //    var tax = $('.tax-text').attr('this-tax');
     //    var subtotal_all = 0;

    	// $(this).parents('.item-row').find('.item-row-total:first').text( new_total+'원');
    	// $(this).parents('.item-row').find(".item-row-total").attr('this-total',total);
    	// $(".item-row-total").each(function(){
    	// 	each_price = parseInt($(this).attr('this-total'));
    	// 	subtotal_all = subtotal_all + each_price;
    	// });
    	// var new_subtotal = digits(subtotal_all);
     //    $('.subtotal-text').text(new_subtotal+'원');
     //    var total_after_all = parseInt(subtotal_all) + parseInt(shipping_cost);

     //    var total_after_all_formated = digits(total_after_all);

     //    $('.total-text').text(total_after_all_formated+'원');
    });


	$(document).on('click','.select-item-btn',function(){
		var item_id = $(this).attr('item_id');
		var qty = $(this).parents('.caption:first').find('.input-number').val();
		request.item_selected(item_id,qty);
    });
	$(document).on('click','.remove-item',function(){
		var order_id = $(this).attr('order_id');
		$('.'+order_id).remove();
		request.item_removed(order_id);
    });

	$("#view_all_inv").click(function(){
		request.view_all_items();
	});

	$(".searchByButton").click(function(){
		var type = $( "#searchBy option:selected" ).val();
		search = {};
		search[type] = {};

		if (type == "price_range") {
			var min = $('#min-price').val();
			var max = $('#max-price').val();
			if (!$.isBlank(min) && !$.isBlank(max)) {
				search[type]['min'] = min;
				search[type]['max'] = max;
				request.search_users(search);
			} else {
				alert('undefined format');
			}
		} else {
			$(this).parents('.searchByFormGroup:first').find('.searchInputItem').each(function(e){
				var name = $(this).attr('name');
				search[type] = $(this).val();
			});			
			request.search_users(search);	
		}
	});
	$('.searchInputItem').keypress(function(e){
        if(e.which == 13){//Enter key pressed
			var type = $( "#searchBy option:selected" ).val();
			search = {};
			search[type] = {};

			if (type == "price_range") {
				var min = $('#min-price').val();
				var max = $('#max-price').val();
				if (!$.isBlank(min) && !$.isBlank(max)) {
					search[type]['min'] = min;
					search[type]['max'] = max;
					request.search_users(search);
				} else {
					alert('undefined format');
				}
			} else {
				$(this).parents('.searchByFormGroup:first').find('.searchInputItem').each(function(e){
					var name = $(this).attr('name');
					search[type] = $(this).val();
				});			
				request.search_users(search);	
			}	        	
        }
    });

	$("#searchBy").change(function(){
		var search = $(this).find('option:selected').val();
		$(".searchByFormGroup").addClass('hide');
		$("#searchBy-"+search).removeClass('hide');
	});
	}
}
request = {
	search_users: function(search) {
		var token = $('meta[name=csrf-token]').attr('content');
		$.post(
			'/admins/inventories/return-item',
			{
				"_token": token,
				search: search
			},
			function(result){
				var status = result.status;
				var html_data = result.items['data'];
				switch(status) {
				case 200: 
					$('#item-html').html(html_data);
				break;				
				case 400: 
					
				break;
				default:
				break;
				}
				}
				);
	},
	item_selected: function(id,qty) {
		var token = $('meta[name=csrf-token]').attr('content');
		$.post(
			'/admins/inventories/item-selected',
			{
				"_token": token,
				item_id: id,
				qty:qty
			},
			function(result){
				var status = result.status;
				var html_data_i = result.html_data;
				switch(status) {
				case 200: 
					$('#checkout_table_html').html(html_data_i);
				break;				
				case 400: 
					
				break;
				default:
				break;
				}
				}
				);
	},
	item_removed: function(order_id) {
		var token = $('meta[name=csrf-token]').attr('content');
		$.post(
			'/admins/inventories/item-removed',
			{
				"_token": token,
				order_id: order_id
			},
			function(result){
				var status = result.status;
				var html_data_i = result.html_data;
				var new_total = result.new_total;
				switch(status) {
				case 200: 
					$('#total_text').text(new_total);
					// $('#checkout_table_html').append(html_data_i);
				break;				
				case 400: 
					
				break;
				default:
				break;
				}
				}
				);
	},
	view_all_items: function() {
		var token = $('meta[name=csrf-token]').attr('content');
		$.post(
			'/admins/inventories/view-all-items',
			{
				"_token": token
			},
			function(result){
				var status = result.status;
				var html_data_s = result.html_data_s;
				switch(status) {
				case 200: 
					$('#item-html').html(html_data_s['data']);
				break;				
				case 400: 
					
				break;
				default:
				break;
				}
				}
				);
	}
};
function salesf(url)
{

}
(function($){
  $.isBlank = function(obj){
    return(!obj || $.trim(obj) === "");
  };
})(jQuery);