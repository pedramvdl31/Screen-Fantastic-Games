$(document).ready(function(){
	tadd.pageLoad();
	tadd.events();

});
tadd = {

	pageLoad: function() {
		$.ajaxSetup({
			headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') }
		});
	},
	events: function() {
		$("#rate").numeric();

        $(document).on('click','.tadd',function(){
         
        });
	}
}
rrequest = {

};

