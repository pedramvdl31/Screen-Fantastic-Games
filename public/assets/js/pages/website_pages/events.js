$(document).ready(function(){
	blank.pageLoad();
	blank.events();

});
blank = {

	pageLoad: function() {
		$.ajaxSetup({
			headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') }
		});
	},
	events: function() {
        $(document).on('click','.interested_btn',function(){
        	$(this).find('.interested-icon').css('color','#d9534f');
        });
        $(document).on('click','._ignore_',function(){
		});
	}
}
request = {
	blank: function(id) {
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
function blankf(url)
{

}
