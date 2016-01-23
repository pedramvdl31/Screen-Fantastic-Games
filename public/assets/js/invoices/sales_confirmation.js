$(document).ready(function(){
	salesc.pageLoad();
	salesc.events();

});
salesc = {

	pageLoad: function() {
		$.ajaxSetup({
			headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') }
		});

		$('.right_col').click(function (e){
		  e.preventDefault()
		});

		var profiles =
		{
			window800:
			{
				height:$( window ).height()-10,
				width:$( window ).width()-10,
				status:1,
				center:1
			},

			window200:
			{
				height:200,
				width:200,
				status:1,
				resizable:0
			},

			windowCenter:
			{
				height:300,
				width:400,
				center:1
			},

			windowNotNew:
			{
				height:300,
				width:400,
				center:1,
				createnew:0
			},

			windowCallUnload:
			{
				height:300,
				width:400,
				center:1
			},

		};
        	$(".popupwindow").popupwindow(profiles);
	},
	events: function() {
        $(document).on('click','#view-receipt',function(){

        });
        $(document).on('click','#submit-btn',function(){
        	$('#invoice_form').submit();
        });
        $(document).on('click','._ignore_',function(){
		});
	}
}
request = {
	salescs: function(id) {
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
function salescf(url)
{

}
