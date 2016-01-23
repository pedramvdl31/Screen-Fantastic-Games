$(document).ready(function(){
	blank.pageLoad();
	blank.events();

});
blank = {

	pageLoad: function() {
        $(document).on('click','.spinner-minus',function(){
        	var input_val = parseInt($(this).parents('.spiner-container').find('.spinner-input:first').val());
        	if (input_val>0) {
        		var new_val = input_val - 1;
        		$(this).parents('.spiner-container').find('.spinner-input:first').val(new_val);
        	};
		});
        $(document).on('click','.spinner-plus',function(){
        	var input_val = parseInt($(this).parents('.spiner-container').find('.spinner-input:first').val());
        	var new_val = input_val + 1;
        	$(this).parents('.spiner-container').find('.spinner-input:first').val(new_val);
		});
	}
}

function blankf(url)
{

}
(function($){
  $.isBlank = function(obj){
    return(!obj || $.trim(obj) === "");
  };
})(jQuery);