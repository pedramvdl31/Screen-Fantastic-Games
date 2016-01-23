$(document).ready(function(){
	users.pageLoad();
	users.events();

});
users = {

	pageLoad: function() {
		$.ajaxSetup({
			headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') }
		});

	},
	events: function() {
		$(".searchByButton").click(function(){
			var type = $( "#searchBy option:selected" ).text();
			search = {};
			search[type] = {};

			$(this).parents('.searchByFormGroup:first').find('.searchInputItem').each(function(e){
				var name = $(this).attr('name');
				search[type][name] = $(this).val();
			});
			request.search_users(search);
		});
		$("#searchBy").change(function(){
			var search = $(this).find('option:selected').val();
			$(".searchByFormGroup").addClass('hide');
			$("#searchBy-"+search).removeClass('hide');
		});

	}
}
request = {
	search_users: function(search) {
		var token = $('meta[name=csrf-token]').attr('content');
		console.log(search);
		$.post(
			'/users/return-users',
			{
				"_token": token,
				search: search
			},
			function(result){
				var status = result.status;
					var message = result.message;
					var table_tbody = result.users_tbody;
					$("#userSearchTable").removeClass('hide');
					$("#userSearchTable tbody").html(table_tbody);
				}
				);
	}
};

