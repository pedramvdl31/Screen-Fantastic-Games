$(document).ready(function(){
	inventorye.pageLoad();
	inventorye.events();

});
inventorye = {

	pageLoad: function() {
		$.ajaxSetup({
			headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') }
		});
		$('#fileupload').fileupload({
			// Uncomment the following to send cross-domain cookies:
			//xhrFields: {withCredentials: true},
			url: '/admins/inventories/upload',
			dataType:'json',
			autoUpload: true,

			done: function(e, data){

				r = data.result;
				if(r.success === true) {
					var path = r.path;
					var new_input = create_input(path);
					$("#imageDiv-main").append(new_input);
					// Remove disabled button and add in cancel button
					$(document).find('#displayImagesTable-main tbody tr .cancel').addClass('hide');
					$(document).find('#displayImagesTable-main tbody tr .remove').removeClass('hide');



			        // $(document).on('click','tbody  .template-upload',function(){
			        // 	//MUST FIND THE PREVIOUS PRIMARY AND ADD IT BACK TO INPUTS
			        // 	var tag_count = $('.primary-img-tag').length;
			        // 	if (tag_count > 0) {
			        // 		var pre_srcs_address = $('.primary-img-tag').parents('.template-upload:first').find('.btn-danger:first').attr('imgsrc');
			        // 		var input_html = '<input class="images" name="files[x][path]" type="hidden" value="'+pre_srcs_address+'" index="x">';
			        // 		$('#imageDiv').append(input_html);
			        // 	};
			        // 	reindex_image_div();
			        // 	$('.primary-img-tag').remove();
			        // 	$('.primary-img-input').remove();

			        // 	var this_name = $(this).find('.btn-danger:first').attr('imgsrc');
			        //  	var label_html = '<span class="label label-primary primary-img-tag">Primary Image</span>';
			        //  	var new_input_html = '<input class="images primary-img-input" name="primary_image" type="hidden" value="'+this_name+'" >'
			        //  	$(this).children('td').eq(1).append(label_html);
			        //  	$('#imageDiv').find('input[value="'+this_name+'"]').remove();
			        //  	$('#imageDiv-primary').append(new_input_html);
			        // });
				}
			}
		}).bind('fileuploadstop', function (e) {
			$("#imageDiv-main input").each(function(e) {
				$(this).attr('name','pre_files_primary['+e+'][path]');
			});
			var change_indication = '<input type="hidden" name="main_changed" value="true">';
			$('#fileupload').append(change_indication);
			inventorye.reindex_main();
		});

		$('#fileupload-extra').fileupload({
			// Uncomment the following to send cross-domain cookies:
			//xhrFields: {withCredentials: true},
			url: '/admins/inventories/upload',
			dataType:'json',
			autoUpload: true,

			done: function(e, data){
				r = data.result;
				if(r.success === true) {
					var path = r.path;
					var new_input = create_input(path);
					$("#imageDiv-extra").append(new_input);
					// Remove disabled button and add in cancel button
					$(document).find('#displayImagesTable-extra tbody tr .cancel').addClass('hide');
					$(document).find('#displayImagesTable-extra tbody tr .remove').removeClass('hide');

				}
			}
		}).bind('fileuploadstop', function (e) {
			$("#imageDiv-extra input").each(function(e) {
				$(this).attr('name','pre_files['+e+'][path]');
			});
			inventorye.reindex_extra();			
		});

		$('#fileupload-description').fileupload({
			// Uncomment the following to send cross-domain cookies:
			//xhrFields: {withCredentials: true},
			url: '/admins/inventories/upload',
			dataType:'json',
			autoUpload: true,

			done: function(e, data){
				r = data.result;
				if(r.success === true) {
					var path = r.path;
					var new_input = create_input(path);
					$("#imageDiv-description").append(new_input);
					// Remove disabled button and add in cancel button
					$(document).find('#displayImagesTable-des tbody tr .cancel').addClass('hide');
					$(document).find('#displayImagesTable-des tbody tr .remove').removeClass('hide');

				}
			}
		}).bind('fileuploadstop', function (e) {
			$("#imageDiv-description input").each(function(e) {
				$(this).attr('name','pre_files_description['+e+'][path]');
			});
			var changed_indication = '<input type="hidden" name="des_changed" value="true">';
			$('#fileupload').append(changed_indication);
			inventorye.reindex_des();		
		});
	},
	events: function() {
		$(document).on('click','#add-option',function(){
        	var text = $('#option-text').val();
        	var extra_price = $('#option-price').val();
        	var new_extra_price = $('#option-price').val().replace(/,/g, '');

        	if (!$.isBlank(text)) {
        		$('#option-form').removeClass('has-error');
        		var all_option_count = $('.all-options').length;
        		var new_count = all_option_count + 1;
        		var option_html = '<span class="clearfix all-options label label-default col-md-12">'+
        			'<span class="this-count">'+new_count+'</span>: '+text;
        		if (new_extra_price>0) {
        			option_html+=' (+₩'+extra_price+')';
        		}

        		option_html += '<i class="glyphicon glyphicon-trash pull-right trash-i"></i>';
        		option_html += '<input type="hidden" class="text-form" name="options['+new_count+'][text]" value="'+text+'">';
        		option_html += '<input type="hidden" class="price-form" name="options['+new_count+'][price]" value="'+new_extra_price+'">';
        		option_html += '</span>';


        		$('#options-container').append(option_html);

            } else {
            	$('#option-form').addClass('has-error');
            }

        });
        $(document).on('click','.trash-i',function(){
        	var option_id = $(this).attr('option-id');
        	var count = $('.deleted-options').length;
        	var deleted_input = '<input type="hidden" name="deleted-option['+count+']" class="deleted-options" value="'+option_id+'">';
        	$('#deleted_options_container').append(deleted_input);
        	$(this).parents('.all-options:first').remove();
        	$( ".all-options" ).each(function( index ) {
        		var new_index = index+1;
        		$(this).find('.this-count:first').text(new_index);
        		$(this).find('.text-form').attr('name','options['+new_index+'][text]');
        		$(this).find('.price-form').attr('name','options['+new_index+'][price]');
			});
        });

        $(document).on('click','.view-image',function(){
         var image_url = $(this).parents('.thumbnail:first').find('.image-url').attr('src');
         $('#modal-image').attr('src',image_url);
         $('#task_image').modal('show');
        });
        $(document).on('click','.delete-image',function(){
        	var image_url = $(this).parents('.thumbnail:first').find('.image-url').attr('src');
        	var input = create_input_deleted(image_url);
        	$("#deletedImageDiv").append(input);
        	$(this).parents('.existingImagesDiv').remove();
        });

        $(document).on('click','.change-image',function(){
        	var kind = $(this).parents('.existingImagesDiv').attr('kind');
        	var image_url = $(this).parents('.thumbnail:first').find('.image-url').attr('src');
        	$(this).parents('.existingImagesDiv').remove();
        	$('.'+kind+'_image_container').removeClass('hide');
        	 $('html, body').animate({
		        scrollTop: $('.'+kind+'_image_container').offset().top
		    }, 1000);
        });


        $(document).on('click','#submit-form',function(){
        	$('#fileupload').submit();
        });

        $(document).on('click','.remove',function(){
        	var kind = $(this).parents('.top:first').attr('kind');
        	var this_val = $(this).attr('imgsrc');
        	
        });

		$("#tag_select").change(function(){
			$('.tag_dup').addClass('hide');
			var dup = false;
			var selected_val = $("#tag_select option:selected").val();
			var selected_text = $("#tag_select option:selected").text();
			var this_html = '<div class="tag_div" tag_id="'+selected_val+'"tag_text="'+selected_text+'"><input type="hidden" name="tag['+selected_val+']" value="1"><span class="label label-danger tag_label" tag_id='+selected_val+'>'+selected_text+' <span class="badge delete_tag"><i class="glyphicon glyphicon-remove"></i></span></span></div>';
			$("#tag_select").val('');
			$( ".tag_div" ).each(function( index ) {
			  if ($(this).attr('tag_id') == selected_val) {dup=true};
			});
			if (dup==false) {
				$('#tags-container').append(this_html);
			} else {
				$('.tag_dup').removeClass('hide');
			}
			
		});


        $(document).on('click','.delete_tag',function(){
        	$(this).parents('.tag_div').remove();
        });
        
        $("#rate").priceFormat({
			'prefix':''
		});
        $(".number").priceFormat({
			'prefix':''
		});
	},
	reindex_main: function() {
		// next reindex the new incoming images
		$("#imageDiv-main input").each(function(e) {
			var image_src = $(this).val();
			$(document).find('#displayImagesTable-main tbody tr').eq(e).find('.remove').attr('imgSrc',image_src);
		});
	},
	reindex_extra: function() {
		// next reindex the new incoming images
		$("#imageDiv-extra input").each(function(e) {
			var image_src = $(this).val();
			$(document).find('#displayImagesTable-extra tbody tr').eq(e).find('.remove').attr('imgSrc',image_src);
		});
	},
	reindex_des: function() {
		// next reindex the new incoming images
		$("#imageDiv-description input").each(function(e) {
			var image_src = $(this).val();
			$(document).find('#displayImagesTable-des tbody tr').eq(e).find('.remove').attr('imgSrc',image_src);
		});
	}
}
request = {

};
// Create input
function create_input_deleted(path) {
	var count = $(document).find('.images_del').length;
	return '<input class="images_del" name="del_files['+count+'][path]" type="hidden" value="'+path+'"/>';
}
// Create input
function create_input(path) {
	var count = $(document).find('.images').length;
	return '<input class="images" name="files['+count+'][path]" type="hidden" value="'+path+'"/>';
}
function reindex_image_div() {
		$("#imageDiv input").each(function(e) {
			$(this).attr('name','files['+e+'][path]');
			$(this).attr('index',e);
		});
}
(function($){
  $.isBlank = function(obj){
    return(!obj || $.trim(obj) === "");
  };
})(jQuery);
