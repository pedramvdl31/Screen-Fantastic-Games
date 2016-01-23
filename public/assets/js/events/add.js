$(document).ready(function(){
	events.pageLoad();
	events.events();

});
events = {

	pageLoad: function() {
		$.ajaxSetup({
			headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') }
		});
		$( "#datepicker" ).datepicker({
		

			
		appendText: "(yyyy-mm-dd)",
		dateFormat: "yy-mm-dd"


		});

	  	tinymce.init({
			fontsize_formats: "8pt 10pt 12pt 14pt",
			selector: '.des',
			height: 500,
			theme: 'modern',
			plugins: [
			'advlist autolink lists link image charmap print preview hr anchor pagebreak',
			'searchreplace wordcount visualblocks visualchars code fullscreen',
			'insertdatetime media nonbreaking save table contextmenu directionality',
			'emoticons template paste textcolor colorpicker textpattern'
			],
			toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
			toolbar2: 'print preview media | forecolor backcolor emoticons',
			image_advtab: true,
			templates: [
			{ title: 'Test template 1', content: 'Test 1' },
			{ title: 'Test template 2', content: 'Test 2' }
			],
			paste_data_images: true
		});
	},
	events: function() {
        $(document).on('click','.events',function(){
        	if (!$.isEvents('text')) {

            }
        	//CHECKBOX
            var $this = $(this);
		     
		    // $this will contain a reference to the checkbox   
		    if ($this.is(':checked')) {
		       
		    } else {
		        // the checkbox was unchecked
		    }
        });
        $(document).on('click','._ignore_',function(){
		});
	}
}
request = {
	events: function(id) {
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
function eventsf(url)
{

}
