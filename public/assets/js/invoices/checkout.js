$(document).ready(function(){
	chkout.pageLoad();
	chkout.events();

});
chkout = {

	pageLoad: function() {
        

	},
	events: function() {






    $('.btn-number').click(function(e){

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
    	var single_price = parseInt($(this).parents('.item-quantity:first').attr('single-price'));
    	var quantity = parseInt($(this).parents('.input-group:first').find('.input-number:first').val());
    	var total = single_price * quantity;
    	var new_total = digits(total);
        var shipping_cost = $('.shipping-text').attr('this-shipping');
        var tax = $('.tax-text').attr('this-tax');
        var subtotal_all = 0;

    	$(this).parents('.item-row').find('.item-row-total:first').text( new_total+'원');
    	$(this).parents('.item-row').find(".item-row-total").attr('this-total',total);
    	$(".item-row-total").each(function(){
    		each_price = parseInt($(this).attr('this-total'));
    		subtotal_all = subtotal_all + each_price;
    	});
    	var new_subtotal = digits(subtotal_all);
        $('.subtotal-text').text(new_subtotal+'원');
        var total_after_all = parseInt(subtotal_all) + parseInt(shipping_cost);

        var total_after_all_formated = digits(total_after_all);

        $('.total-text').text(total_after_all_formated+'원');
    });
    $('.input-number').focusin(function(){
       $(this).data('oldValue', $(this).val());
    });
    $('.input-number').change(function() {
        
        minValue =  parseInt($(this).attr('min'));
        maxValue =  parseInt($(this).attr('max'));
        valueCurrent = parseInt($(this).val());
        
        name = $(this).attr('name');
        if(valueCurrent >= minValue) {
            $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
        } else {
            alert('Sorry, the minimum value was reached');
            $(this).val($(this).data('oldValue'));
        }
        if(valueCurrent <= maxValue) {
            $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
        } else {
            alert('Sorry, the maximum value was reached');
            $(this).val($(this).data('oldValue'));
        }
        
        
    });
    $(".input-number").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) || 
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

	}
}
requestc = {
	chkout: function(id) {
		var token = $('meta[name=csrf-token]').attr('content');
		$.post(
			'/',
			{
				"_token": token
			},
			function(result){
				var status = result.status;

				switch(status) {
					case 200: 
						
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
function digits(num) {
   	var n= num.toString().split(".");
    //Comma-fies the first part
    n[0] = n[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    //Combines the two sections
    return n.join(".");
	
}
