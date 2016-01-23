$(document).ready(function(){
	order.pageLoad();
	order.events();

});
order = {

	pageLoad: function() {
		$.ajaxSetup({
			headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') }
		});
		  $(function() {
		    $( "#sortable" ).sortable({
				   stop: function( event, ui ) {reorder_data()}
				});
		    $( "#sortable" ).disableSelection();
		  });
	},
	events: function() {
        $(document).on('click','.order',function(){
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
requesto = {
	order: function(id) {
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
function reorder_data()
{
	var count = 0;
	$( "#sortable li" ).each(function() {
		count = count + 1;
		var this_id = $(this).attr('this-inv');
		$(this).find('.badge-s').text(count);
	  	$(this).find('.order-input-form').val(count);
	  	$(this).find('.order-input-form').attr('name',"order-input["+this_id+"]");
	});
}
