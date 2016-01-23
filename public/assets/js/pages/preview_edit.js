$(document).ready(function(){
	preview.pageLoad();
	preview.events();

});
preview = {

	pageLoad: function() {
		$.ajaxSetup({
			headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') }
		});
		$(function () {
		    $(".grid2").sortable({
		        tolerance: 'pointer',
		        revert: 'invalid',
		        placeholder: 'span2 well placeholder tile',
		        forceHelperSize: true,
		        start: function( event, ui ) {

		        },
		        stop: function( event, ui ) {
        			var result = $(".grid2").sortable("toArray");
        			$('.sorted-inputs').html('');
					$.each( result, function( key, value ) {
					  var new_html = '<input type="hidden" name="sorted['+key+'][title]" value="'+value+'">';
					  $('.sorted-inputs').append(new_html);
					});
		        },
		    });
		});


	},
	events: function() {
        $(document).on('mousedown','.parent-div',function(event){

        	switch (event.which) {
		        case 1:
		            $(this).find('.drag-icon').addClass('hide');
		            break;
		    }

        	
        });
        $(document).on('mouseup','.parent-div',function(event){
        	switch (event.which) {
		        case 1:
		        	var _this = $(this);
		        	setTimeout(function(){ 
		        		_this.find('.drag-icon').removeClass('hide');
		        	 }, 500);
		            break;
		    }

        	
        });



	}
}
request = {
	preview: function(id) {
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
function previewf(url)
{

}
