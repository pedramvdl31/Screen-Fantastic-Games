$(document).ready(function(){
	add.pageLoad();
	add.events();

});
add = {

	pageLoad: function() {
		$.ajaxSetup({
			headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') }
		});
	  $(window).keydown(function(event){
	    if(event.keyCode == 13) {
	      event.preventDefault();
	      return false;
	    }
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
	  	$('.keyword-text').keydown(function(event){
		    if(event.keyCode == 13) {
		    	event.preventDefault();
	            $('#keyword-dup').addClass('hide');
	            var this_text = $(this).val();
	            $(this).val('');
	            var dup = 0;
	            var obj = $('.label-keyword');
	            var count = $('.label-keyword').length;
	            $('.label-keyword').removeClass('new-zip');
	            if (!$.isBlank(this_text)) {
	                $('.this-keyword-t').each(function( index ) {
	                  if ($(this).text() == this_text) {
	                    dup = 1;
	                  };
	                });
	                if (dup == 0) {
	                    var label_html = '<span class="label label-success label-keyword new-zip '+this_text+'" > <span class="this-keyword-t">'+this_text+'</span> <i class="glyphicon glyphicon-trash delete-keyword"></i></span>';
	                    var input_html = '<input class="'+this_text+'" type="hidden" name="keywords['+count+this_text+']" value="'+this_text+'" >';
	                    $('#keyword-group-wrapper').append(label_html);
	                    $('#keyword-group-wrapper').append(input_html);
	                } else {
	                    $('#keyword-dup').removeClass('hide');
	                }
	            }
		    }
	  	});
        
        $(document).on('click', '.add-keyword', function() {
            $('#keyword-dup').addClass('hide');
            var this_text = $(this).parents('.input-group').find('.keyword-text').val();
            $(this).parents('.input-group').find('.keyword-text').val('');
            var dup = 0;
            var obj = $('.label-keyword');
            var count = $('.label-keyword').length;
            $('.label-keyword').removeClass('new-zip');
            if (!$.isBlank(this_text)) {
                $('.this-keyword-t').each(function( index ) {
                  if ($(this).text() == this_text) {
                    dup = 1;
                  };
                });
                if (dup == 0) {
                    var label_html = '<span class="label label-success label-keyword new-zip '+this_text+'" > <span class="this-keyword-t">'+this_text+'</span> <i class="glyphicon glyphicon-trash delete-keyword"></i></span>';
                    var input_html = '<input class="'+this_text+'" type="hidden" name="keywords['+count+this_text+']" value="'+this_text+'" >';
                    $('#keyword-group-wrapper').append(label_html);
                    $('#keyword-group-wrapper').append(input_html);
                } else {
                    $('#keyword-dup').removeClass('hide');
                }
            }
        });
        $(document).on('click', '.delete-keyword', function() {
            var this_text = $(this).parents('.label-keyword').find('.this-keyword-t').text();
            $('.'+this_text).remove();
        });
	}
}
request = {
	add: function(id) {
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
function addf(url)
{

}
(function($){
  $.isBlank = function(obj){
    return(!obj || $.trim(obj) === "");
  };
})(jQuery);