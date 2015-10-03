var fnLoginAjax = function(f){

	$.ajax({
		method: "POST",
		url: "login_ajax.php",
		data: $(f).serializeArray(),
		success: function(data){
			data = JSON.parse(data);
			if(data.status){

				if(data.redirect){
					location.href = data.redirect;
				}
				else{
					$("#loginDiv").remove();
					location.reload();					
				}
			}
			else{
				$("#login_err").html(data.message);
			}
		}
	});
}