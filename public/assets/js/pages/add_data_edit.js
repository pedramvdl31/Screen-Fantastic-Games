$(document).ready(function(){
	add_data.pageLoad();
	add_data.stepy();
	add_data.events();

});
add_data = {
	pageLoad: function() {
		$.ajaxSetup({
			headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') }
		});
		$('#myTabs a').click(function (e) {
		  e.preventDefault()
		  $(this).tab('show')
		});
		tinymce.init({
			fontsize_formats: "8pt 10pt 12pt 14pt",
			selector: ".des",
			menubar: false,
			toolbar: "undo redo pastetext | styleselect |  bold italic | fontsizeselect"
		});

		$('#form-1 #fileupload').fileupload({
		// Uncomment the following to send cross-domain cookies:
		//xhrFields: {withCredentials: true},
		url: '/admins/pages/pages-slider/upload',
		dataType:'json',
		autoUpload: true,
		done: function(e, data){
			r = data.result;
			if(r.success === true) {
				var path = r.path;
				var new_input = create_input(path);
				$("#imageDiv").append(new_input);
				// Remove disabled button and add in cancel button
				$(document).find('#displayImagesTable tbody tr .cancel').addClass('hide');
				$(document).find('#displayImagesTable tbody tr .remove').removeClass('hide');
			}
		}
		});

		$('#form-2 #fileupload').fileupload({
		// Uncomment the following to send cross-domain cookies:
		//xhrFields: {withCredentials: true},
		url: '/admins/pages/pages-image/upload',
		dataType:'json',
		autoUpload: true,
		done: function(e, data){
			r = data.result;
			if(r.success === true) {
				var path = r.path;
				var new_input_single_image = create_input_single_image(path);
				$("#imageDiv-single").html('');
				$("#imageDiv-single").append(new_input_single_image);
				$('.single-image-container').remove();
				// Remove disabled button and add in cancel button
				$(document).find('#displayImagesTable tbody tr .cancel').addClass('hide');
				$(document).find('#displayImagesTable tbody tr .remove').removeClass('hide');
			}
		}
		});
	},
	stepy: function() {
		$(document).on('click','.tab-li',function(){
			var this_href = $(this).find('.stepy-wrapper-md:first').attr('href');
			var new_href = this_href.replace('#','');
			$('.my-tab').addClass('hide');
			$('.my-tab#'+new_href).removeClass('hide');
        });
		$(document).on('click','.stepy-btn-nxt',function(){
			var this_step =  $(this).parents('.tab-footer').attr('this-step');
			if (this_step != 'last') {
				var this_href = $('.active.tab-li').next("li").find('.stepy-wrapper-md:first').attr('href');
				var new_href = this_href.replace('#','');
				$('.active.tab-li').removeClass('active').next("li").addClass('active');
				$('.my-tab').addClass('hide');
				$('.my-tab#'+new_href).removeClass('hide');
			}
        });
		$(document).on('click','.stepy-btn-pre',function(){
			var this_step =  $(this).parents('.tab-footer').attr('this-step');
			if (this_step != 'first') {
				var this_href = $('.active.tab-li').prev("li").find('.stepy-wrapper-md:first').attr('href');
				var new_href = this_href.replace('#','');
				$('.active.tab-li').removeClass('active').prev("li").addClass('active');
				$('.my-tab').addClass('hide');
				$('.my-tab#'+new_href).removeClass('hide');			
			} else {
				return false;
			}

        });

        // stepy-btn-pre

        // stepy-btn-nxt
	},
	events: function() {
		$(document).on('click','.delete-image',function(){
        	var image_url = $(this).parents('.thumbnail:first').find('.image-url').attr('src');
        	$(this).parents('.my-tab:first').find('.images[value="'+image_url+'"]').remove();
        	$(this).parents('.existingImagesDiv:first').remove();
        	reindex_input();
        });
		$(document).on('click','#add-more-section',function(event){
			event.preventDefault();
			request.add_section();
        });


		$(document).on('click','.delete-image-single',function(){
        	var image_url = $(this).parents('.thumbnail:first').find('.image-url').attr('src');
        	alert(image_url);
        	$(this).parents('.my-tab:first').find('.images-single[value="'+image_url+'"]').remove();
        	$(this).parents('.existingImagesDiv:first').remove();
        	reindex_input();
        });


		$(document).on('click','.preview-btn',function(){
			$('.top-form#fileupload').submit();
        });


	}
}
request = {
	add_section: function(id) {
		var token = $('meta[name=csrf-token]').attr('content');
		$.post(
			'/admins/pages/add-section-edit',
			{
				"_token": token
			},
			function(result){
				var status = result.status;
				var section_html = result.section_html;
				

				switch(status) {
					case 200: 
						$('.section-wrapper').append(section_html);
						tinymce.init({
							fontsize_formats: "8pt 10pt 12pt 14pt",
							selector: ".des",
							menubar: false,
							toolbar: "undo redo pastetext | styleselect |  bold italic | fontsizeselect"
						});
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
function add_dataf(url)
{

}
// Create input
function create_input_single_image(path) {
	return '<input class="images-single" name="file-single[0][path]" type="hidden" value="'+path+'"/>';
}
function create_input(path) {
	var count = $(document).find('.images').length;
	return '<input class="images" name="files['+count+'][path]" type="hidden" value="'+path+'"/>';
}
function reindex_input() {
	var count = $(document).find('.images').length;
	$( ".images" ).each(function(key) {
		$(this).attr('name','files['+key+'][path]');
	});
}