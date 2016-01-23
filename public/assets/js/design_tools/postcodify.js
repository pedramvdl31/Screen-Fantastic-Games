$(document).ready(function(){
	postcodify.pageLoad_p();
	postcodify.events_p();

});
postcodify = {

	pageLoad_p: function() {
        $('.keyword').blur();
        $('.keyword').attr('placeholder','이곳에 도로명, 지번 또는 건물명을 검색 하십시오(도움말 참고) ');
	},
	events_p: function() {
        $(document).on('click','#postcodify_search_button',function(e){
            e.preventDefault();
        });
        $(document).on('click','.qt-sgn',function(e){
            $('#postcodify-modal').modal('show');
        });
        $(document).on('click','.postcodify_search_result',function(e){
            $(this).parents('.container:first').find('.my-input').removeClass('hide');
            $('.rd-only').attr('readonly',true);
        });
	}
}
reques_postc = {
	chkout: function(id) {
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
