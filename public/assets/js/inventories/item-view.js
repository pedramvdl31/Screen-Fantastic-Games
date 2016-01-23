$(document).ready(function(){
	item_view.pageLoad();
	item_view.events();

});
item_view = {

	pageLoad: function() {
		$.ajaxSetup({
			headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') }
		});
	    $("input[name='demo_vertical2']").TouchSpin({
          verticalbuttons: true,
          verticalupclass: 'glyphicon glyphicon-plus',
          verticaldownclass: 'glyphicon glyphicon-minus',
        });
        $("img.lazy").lazyload();
	},
	events: function() {

        $(document).on('click','#add-to-wishlist',function(){
        	var this_id = $(this).attr('item-id');
        	requestw.item_liked(this_id);
        });

        $(document).on('click','.edit-this-review',function(){
        	var title = $(this).parents('.media-body').find('.this-review-title').text();
        	var description = $(this).parents('.media-body').find('.this-review-description').text();
        	var this_review = $(this).attr('this-review');
        	$('#review_edit_title').val(title);
        	$('#review_edit_description').val(description);
        	$('#review-edit-modal').modal('show');
        	$('#post-edit-this-review').attr('this-review',$(this).attr('this-review'));
        });

        $(document).on('click','#post-edit-this-review',function(){
        	var title = $('#review_edit_title').val();
        	var description = $('#review_edit_description').val();
        	requestw.post_review_edit(title,description,$('#this-inventory').val(),$(this).attr('this-review'));
        });

        $(document).on('click','#qna-btn',function(){
        	_this = $(this);
        	requestw.user_authcheck(_this,'qna');
        });
        $(document).on('click','#review-btn',function(){
        	_this = $(this);
        	requestw.user_authcheck_review(_this,$(this).attr('inventory-id'));
        });

        $(document).on('click','#qna-modal-post-btn',function(){
        	var title = $('#q_and_a_title').val();
        	var description = $('#q_and_a_description').val();
        	requestw.post_q_and_a(title,description,$(this).attr('inventory-id'));
        });
        $(document).on('click','#review-modal-post-btn',function(){
        	var title = $('#review_title').val();
        	var description = $('#review_description').val();
        	requestw.post_review(title,description,$(this).attr('inventory-id'));
        });
        $(document).on('mouseenter','.child-item',function(e){
        	 
     		e.preventDefault(); // same thing as above
        	var this_src = $(this).find('img').attr('src');
        	var banner_src = $('.banner-item').find('img').attr('src');
        	//SWIPE IMAGES
        	$('.banner-item').find('img').attr('src',this_src);
        	$('.thumbnail').removeClass('active-item');
        	$(this).addClass('active-item');
 			
        });
        $(document).on('click','#add-to-cart-onpage',function(e){
        	e.preventDefault(); // same thing as above
        	var $this = $(this);
        	var item_id = $this.attr('this-item');
        	var qty = $('#demo3').val();
        	requestw.add_to_cart(item_id,qty);
        });
        $(document).on('click','#proceed-to-payment',function(e){
			var selected_items_count = $('.selected_items').length;
			if (selected_items_count > 0) {
				$('#all_options_form').addClass('remove-error');
				$('#options-help').addClass('hide');
				$('#proceed-form').submit();
			} else {
				$('#all_options_form').addClass('has-error');
				$('#options-help').removeClass('hide');
			}
        });
        $("#all_options").change(function(){
        	var base_price = parseInt($('#base_price').val().replace(/,/g, ''));
        	var this_extra_price = parseInt($( "#all_options option:selected" ).val());
        	var this_option_id = parseInt($( "#all_options option:selected" ).attr('option-id'));
        	var this_item_text = $( "#all_options option:selected" ).text();
        	var total_amount = base_price + this_extra_price;
        	var item_id = $('#this_item_id').val();
        	var selected_count = $('.selected_items').length;
        	var html =  '<div class="selected_items" this-price="'+total_amount+'">'+
                          '<span class="col-md-8 seperator" style="padding-left:0;line-height:30px">'+this_item_text+'</span>'+
                          '<span class="col-md-3 seperator">'+ 
                            '<div class="spiner-container" style="width:100%">'+
	                          '<i class="glyphicon glyphicon-minus-sign spinner-minus minus-x"></i>'+
	                            '<input type="text" class="form-control spinner-input selected-items-quantity" value="1" readonly>'+
	                          '<i class="glyphicon glyphicon-plus-sign spinner-plus plus-x"></i>'+
	                        '</div>'+
                          '</span>'+
                          '<span class="col-md-1 seperator">'+ 
                            '<i style="line-height:30px" class="glyphicon glyphicon-trash pull-right remove-selected-item"></i>'+
                          '</span>'+
                          '<input type="hidden" this-options="'+this_option_id+'" class="quantity-input" name="selected_input['+item_id+']['+this_option_id+']['+selected_count+'][qty]" value="1">'+
                        '</div>';

            $('#selected_items_container').append(html);

	        total_price();
		});


		$(document).on('click','.remove-selected-item',function(e){
			$(this).parents('.selected_items:first').remove();
			var item_id = $('#this_item_id').val();
			$(".selected_items").each(function(index) {
				var this_option_id = parseInt($(this).find('.quantity-input').attr('this-options'));
				$(this).find('.quantity-input').attr('name','selected_input['+item_id+']['+this_option_id+']['+index+'][qty]');
			});

			total_price();
        });

        $(document).on('click','.spinner-minus',function(){
        	var input_val = parseInt($(this).parents('.spiner-container').find('.spinner-input:first').val());
        	if (input_val>1) {
        		var new_val = input_val - 1;
        		$(this).parents('.spiner-container').find('.spinner-input:first').val(new_val);
        		$(this).parents('.selected_items').find('.quantity-input:first').val(new_val);
        		total_price();
        	};

		});
        $(document).on('click','.spinner-plus',function(){
        	var input_val = parseInt($(this).parents('.spiner-container').find('.spinner-input:first').val());
        	var new_val = input_val + 1;
        	$(this).parents('.spiner-container').find('.spinner-input:first').val(new_val);
        	$(this).parents('.selected_items').find('.quantity-input:first').val(new_val);
        	total_price();
		});

	}
}
requestw = {
		user_authcheck: function(_this,kind) {
		var token = $('meta[name=csrf-token]').attr('content');
		$.post(
			'/users/auth-check',
			{
				"_token": token
			},
			function(result){
				var status = result.status;
				switch(status) {
					case 200: 
						$('#'+kind+'-modal').modal('show');
						$('#'+kind+'-modal-post-btn').attr('inventory-id',_this.attr('inventory-id'))
					break;				
					case 400: 
						$('#login-modal').modal('show');
					break;
					default:
					break;
				}

				}
				);
	},
	user_authcheck_review: function(_this,inventory_id) {
		var token = $('meta[name=csrf-token]').attr('content');
		$.post(
			'/users/auth-check-review',
			{
				"_token": token,
				'inventory_id':inventory_id
			},
			function(result){
				var status = result.status;
				switch(status) {
					case 200: 
						$('#review-modal').modal('show');
						$('#review-modal-post-btn').attr('inventory-id',_this.attr('inventory-id'));
					break;				
					case 201: 
						$('#has-reviewed-modal').modal('show');
					break;				
					case 400: 
						$('#login-modal').modal('show');
					break;
					default:
					break;
				}

				}
				);
	},



	post_q_and_a: function(title,description,inventory_id) {
		var token = $('meta[name=csrf-token]').attr('content');
		$.post(
			'/questions-and-answers/ajax-add',
			{
				"_token": token,
				"title":title,
				"description":description,
				"inventory_id":inventory_id
			},
			function(result){
				var status = result.status;

				switch(status) {
					case 200: 
						$('#successfully_posted_qna').removeClass('hide');
						setTimeout(function(){ 
							var qna_html = '<div class="media">'+
								'<div class="media" style="">'+
								'<div class="media-body">'+
								'<h4 class="media-heading">'+title+'&nbsp<span class="qa-meta">'+$('#this_username').val()+'&nbspnow</sapn></h4>'+description+
								'</div></div></div><hr>';

							$('#q_and_a_title').val('');
        					$('#q_and_a_description').val('');
							$('#successfully_posted_qna').addClass('hide');
							$('#qna-modal').modal('hide');
							$('.qna-container').append(qna_html);
						}, 500);
						
					break;				
					case 400: 
						
					break;
					default:
					break;
				}

				}
				);
	},
		post_review_edit: function(title,description,inventory_id,review_id) {
		var token = $('meta[name=csrf-token]').attr('content');
		$.post(
			'/reviews/ajax-edit',
			{
				"_token": token,
				"title":title,
				"description":description,
				"inventory_id":inventory_id,
				"review_id":review_id
			},
			function(result){
				var status = result.status;
				var this_review_id = result.this_review_id;

				switch(status) {
					case 200: 
						$('#successfully_edited_review').removeClass('hide');
						setTimeout(function(){ 
							$('#review-edit-modal').modal('hide');
							$('.body-'+review_id).find('.this-review-title').text(title);
							$('.body-'+review_id).find('.this-review-description').text(description);
						}, 500);
					break;				
					case 400: 
						
					break;
					default:
					break;
				}

				}
				);
	},
		post_review: function(title,description,inventory_id) {
		var token = $('meta[name=csrf-token]').attr('content');
		$.post(
			'/reviews/ajax-add',
			{
				"_token": token,
				"title":title,
				"description":description,
				"inventory_id":inventory_id
			},
			function(result){
				var status = result.status;
				var this_review_id = result.this_review_id;

				switch(status) {
					case 200: 
						$('#successfully_posted_review').removeClass('hide');
						setTimeout(function(){ 
							var review_html = '<div class="media">'+
								'<div class="media" style="">'+
								'<div class="media-body body-'+this_review_id+'">'+
								'<h4 class="media-heading"><span class="this-review-title">'+title+'</span>&nbsp'+
								'<span class="qa-meta">'+$('#this_username').val()+'&nbspnow&nbsp<i this-review="'+this_review_id+'" class="glyphicon glyphicon-edit edit-this-review" style="color:#337ab7"></i></sapn>'+
								'</h4><span class="this-review-description">'+description+'</span>'+
								'</div></div></div><hr>';


							$('#review_title').val('');
        					$('#review_description').val('');
							$('#successfully_posted_review').addClass('hide');
							$('#review-modal').modal('hide');
							$('.review-container').append(review_html);
						}, 500);
						
					break;				
					case 400: 
						
					break;
					default:
					break;
				}

				}
				);
	},
		item_liked: function(this_id) {
		var token = $('meta[name=csrf-token]').attr('content');
		$.post(
			'/inventories/inv-liked',
			{
				"_token": token,
				"this_id":this_id
			},
			function(result){
				var status = result.status;
				var count = result.liked_session_count;

				var icon_type = $('#like-icon-type').val();

				if (count > 0) {
					$('.liked-heart').removeClass('glyphicon-'+icon_type+'-empty').addClass('glyphicon-'+icon_type);
					$('.like-badge').text(count);
				};

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
	},
	add_to_cart: function(i_id,qty) {
		var token = $('meta[name=csrf-token]').attr('content');
		$('#add-to-cart-modal').modal('hide');
		

		$.post(
			'/invoices/add-to-cart',
			{
				"_token": token,
				"i_id" : i_id,
				"qty":qty
			},
			function(result){
				var status = result.status;
				var count = parseInt(result.cart_session_count);

				switch(status) {
					case 200: 
					$('#success-cart-modal').modal('show');

						if (count > 0) {
							$('.cart-badge').text(count);
						};

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
function total_price() {
	// alert();
	var total = 0;
	$(".selected_items").each(function(e) {
		var this_price = $(this).attr('this-price');
		var this_quntity = parseInt($(this).find('.selected-items-quantity:first').val());
		var new_total = this_quntity * this_price;
		total = total + new_total;
	});
	if (total > 0) {
		$('#non-selected').addClass('hide');
	} else {
		$('#non-selected').removeClass('hide');
	}

	var new_total = addCommas(total);
	$('#total_price').text(new_total);
	$('#well-price-t').text(new_total+'원');
}

function addCommas(nStr)
{
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}
