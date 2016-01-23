$(document).ready(function(){
	slideredit.pageLoad();
	slideredit.events();

});
slideredit = {

	pageLoad: function() {
		$.ajaxSetup({
			headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') }
		});
		$('#fileupload').fileupload({
			// Uncomment the following to send cross-domain cookies:
			//xhrFields: {withCredentials: true},
			url: '/admins/pages/sliders/upload',
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
	},
	events: function() {
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
	}
}
requestedit = {

};
// Create input
function create_input(path) {
	var count = $(document).find('.images').length;
	return '<input class="images" name="files['+count+'][path]" type="hidden" value="'+path+'"/>';
}
// Create input
function create_input_deleted(path) {
	var count = $(document).find('.images_del').length;
	return '<input class="images_del" name="del_files['+count+'][path]" type="hidden" value="'+path+'"/>';
}