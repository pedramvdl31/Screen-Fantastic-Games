$(document).ready(function(){
	main.pageLoad();
	main.events();

});
main = {

	pageLoad: function() {
		$.ajaxSetup({
			headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') }
		});






		$('#nav').affix({
		  offset: {
		    top: 140
		  }
		});
		$('#nav').on('affix.bs.affix', function () {
		    $('.original-nav').addClass('hide');
		    $('.aff-nav').removeClass('hide');
		});
		$('#nav').on('affix-top.bs.affix', function () {
		    $('.original-nav').removeClass('hide');
		    $('.aff-nav').addClass('hide');
		});



	},
	events: function() {
		$(".thumbnail-wrapper").hover(function(){
		    $(this).find('.thumb_like_btn').removeClass('hide');
		    }, function(){
		    $(this).find('.thumb_like_btn').addClass('hide');
		});

		$("#sound-btn").click(function(){
			var html = '<audio autoplay id="intro-song" loop>'+
	            			'<source src="/assets/music/intro_song.mp3" type="audio/mpeg">'+
	          			'</audio>';
	        $('#audio-container').append(html);
			$('#sound-btn').addClass('hide');
			$('#mute-btn').removeClass('hide');
		});
		$("#mute-btn").click(function(){
				$('#intro-song').remove();
				$('#mute-btn').addClass('hide');
				$('#sound-btn').removeClass('hide');
		});

		$(".cat-li").click(function(){
			var this_cat = $(this).attr('this-cat');
			$('.inv-cat-container').addClass('hide');
			$('.'+this_cat).removeClass('hide');
		});

		$('.sec_login').click(function(){
			$('#add-to-cart-modal').modal('hide');
			$('#login-modal').modal('show');
		});

		$('.back-to-home').click(function(){
			window.location = "/";
		});

        $(document).on('click','.new-thumbnail',function(){
   //      	var $this = $(this);
   //      	var item_id = $this.attr('item-id');

			// window.location.replace("/items/"+item_id);
        });

        $(document).on('click','#add-to-cart-btn',function(){
        	var $this = $(this);
        	var item_id = $('#item-id-modal').val();
        	requestw.add_to_cart(item_id);
        });

        $(document).on('click','#add-to-cart-onpage',function(){
        	var $this = $(this);
        	var item_id = $this.attr('this-item');
        	requestw.add_to_cart(item_id);
        });

        $(document).on('click','#view_item',function(){
	       var this_href = $(this).attr('this-item');
	       window.location.replace("/items/"+this_href);
        });

        $(document).on('click','.login-btn',function(){
			$('#login-modal').modal('show');
        });

        $(document).on('click','.layout-btn',function(){
        	//CHECKBOX
            var $this = $(this);
		    // $this will contain a reference to the checkbox   
		    if ($this.is(':checked')) {
		       var this_href = $this.attr('this-href');
		       window.location.replace("/"+this_href);
		    } 
        });
        $(document).on('click','.thumb_like_btn',function(){
        	var this_id = $(this).parents('.thumbnail-wrapper').attr('this-item');
        	requestw.item_liked(this_id);
        	$(this).addClass('hide');
        	$(this).parents('.thumbnail-wrapper').find('.thumb_like_btn_active').removeClass('hide');
        });
        $(document).on('click','.thumb_like_btn_active',function(){

        	var this_id = $(this).parents('.thumbnail-wrapper').attr('this-item');
        	requestw.item_liked_removed(this_id);
        	$(this).addClass('hide');
        });

	}
}
requestw = {
	add_to_cart: function(i_id) {
		var token = $('meta[name=csrf-token]').attr('content');
		$('#add-to-cart-modal').modal('hide');
		$.post(
			'/invoices/add-to-cart',
			{
				"_token": token,
				"i_id" : i_id
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
				var l_html = result.liked_session_html;
				if (count > 0) {
					$('.liked-heart').removeClass('glyphicon-'+icon_type+'-empty').addClass('glyphicon-'+icon_type);
					$('.like-badge').text(count);
				};

				switch(status) {
					case 200: 
						$('#liked-li').html(l_html);
					break;				
					case 400: 
						
					break;
					default:
					break;
				}

				}
				);
	},
	item_liked_removed: function(this_id) {
		var token = $('meta[name=csrf-token]').attr('content');
		$.post(
			'/inventories/like-removed',
			{
				"_token": token,
				"this_id":this_id
			},
			function(result){
				var status = result.status;
				var count = parseInt(result.liked_session_count);
				var icon_type = $('#like-icon-type').val();
				var l_html = result.liked_session_html;
				if (count > 0) {
					$('.liked-heart').removeClass('glyphicon-'+icon_type+'-empty').addClass('glyphicon-'+icon_type);
					$('.like-badge').text(count);
				} else {
					$('.like-badge').text('');
					$('.liked-heart').removeClass('glyphicon-'+icon_type).addClass('glyphicon-'+icon_type+'-empty');
				}

				switch(status) {
					case 200: 
						$('#liked-li').html(l_html);
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

