$(document).ready(function(){
	checkbox.pageLoad();
	checkbox.events();

});
checkbox = {

	pageLoad: function() {

		//   Hide the border by commenting out the variable below
	    var $on = 'section';
	    $($on).css({
	      'background':'none',
	      'border':'none',
	      'box-shadow':'none'
	    });
	},
	events: function() {
        $(document).on('click','.checkbox-top',function(){
        	//CHECKBOX
            var $this = $(this);
		     
		    // $this will contain a reference to the checkbox   
		    if ($this.is(':checked')) {
		       alert();
		    } else {
		        // the checkbox was unchecked
		    }
        });
	}
}
request = {

};

