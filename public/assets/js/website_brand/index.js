$(document).ready(function(){
	website_b.pageLoad();
	website_b.events();

});
website_b = {

	pageLoad: function() {
		$.ajaxSetup({
			headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') }
		});
				$('#fileupload').fileupload({
			// Uncomment the following to send cross-domain cookies:
			//xhrFields: {withCredentials: true},
			url: '/admins/website-brand/upload',
			dataType:'json',
			autoUpload: true,

			done: function(e, data){

				r = data.result;
				if(r.success === true) {
					var path = r.path;
					var new_input = create_input(path);
					$("#imageDiv-main").append(new_input);
					$('#brand_image_row').find('.image-url').attr('src',path);
				}
			}
		}).bind('fileuploadstop', function (e, data) {

		});
	},
	events: function() {
        $(document).on('click','.website_b',function(){
        	//CHECKBOX
            var $this = $(this);
		     
		    // $this will contain a reference to the checkbox   
		    if ($this.is(':checked')) {
		       
		    } else {
		        // the checkbox was unchecked
		    }
        });
	}
}
request_w = {
	website_b: function(id) {
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
function create_input(path) {
	var count = $(document).find('.images').length;
	return '<input class="images" name="files[0][path]" type="hidden" value="'+path+'"/>';
}
