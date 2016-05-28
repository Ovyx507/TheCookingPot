$(document).ready(function(){

	$(document).on('click','.submit',function(){

		$.ajax({
				type: "GET",
				url: "login/m_aj",
				data: {masa : "hai la masa!" },
				success: function(result){
					alert(result);
				}
		});


	});


});