function fnValidateNewUserRegistration(f){
	$("span.error").text("");
	var isValid = true;

	var firstErrorId = "";

	var username = f.username.value;
	username = username.trim() || username;
	if(username.length==0){
		if(firstErrorId==""){
			firstErrorId = "error_username";
		}
		$("#error_username").text("Username is required");
		isValid = false;
	}

	$.ajax({
		url: "check_username_availability.php",
		method: "GET",
		async: false,
		data: {
			username: username
		},
		success: function(data){
			if(!data.status){
				if(firstErrorId==""){
					firstErrorId = "error_username";
				}
				
				$("#error_username").text("This username is already taken");
				isValid = false;
			}
		}
	});

	var password = f.password.value;
	password = password.trim() || password;
	if(password.length==0){
		if(firstErrorId==""){
			firstErrorId = "error_password";
		}
		$("#error_password").text("Password is required");
		isValid = false;
	}

	var confirm_password = f.confirm_password.value;
	confirm_password = confirm_password.trim() || confirm_password;
	if(confirm_password.length==0){
		if(firstErrorId==""){
			firstErrorId = "error_confirm_password";
		}
		$("#error_confirm_password").text("Password confirmation is required");
		isValid = false;
	}

	if(password!=confirm_password){
		if(firstErrorId==""){
			firstErrorId = "error_confirm_password";
		}
		$("#error_confirm_password").text("Passwords don't match.");
		isValid = false;
	}
	
	var firstname = f.firstname.value;
	firstname = firstname.trim() || firstname;
	if(firstname.length==0){
		if(firstErrorId==""){
			firstErrorId = "error_firstname";
		}
		$("#error_firstname").text("Firstname is required");
		isValid = false;
	}

	var lastname = f.lastname.value;
	lastname = lastname.trim() || lastname;
	if(lastname.length==0){
		if(firstErrorId==""){
			firstErrorId = "error_lastname";
		}
		$("#error_lastname").text("Lastname is required");
		isValid = false;
	}

	var cellphone = f.cellphone.value;
	cellphone = cellphone.trim() || cellphone;
	if(!cellphone.match(/^\d{10}$/g)){
		if(firstErrorId==""){
			firstErrorId = "error_cellphone";
		}
		$("#error_cellphone").text("Please enter a valid cellphone number");
		isValid = false;
	}
	$.ajax({
		url: "check_phone_already_used.php",
		method: "GET",
		async: false,
		data: {
			cellphone: cellphone
		},
		success: function(data){
			if(!data.status){
				if(firstErrorId==""){
					firstErrorId = "error_cellphone";
				}
				$("#error_cellphone").text("This phone is already registered with us");
				isValid = false;
			}
		}
	});

	var email = f.email.value;
	var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if(!re.test(email)){
    	if(firstErrorId==""){
			firstErrorId = "error_email";
		}
		$("#error_email").text("Please enter a valid email id");
		isValid = false;
    }
    $.ajax({
		url: "check_email_already_used.php",
		method: "GET",
		async: false,
		data: {
			email: email
		},
		success: function(data){
			if(!data.status){
				if(firstErrorId==""){
					firstErrorId = "error_email";
				}
				
				$("#error_email").text("This email is already registered with us");
				isValid = false;
			}
		}
	});

	var area = f.addr2.value;
	area = area.trim() || area;
	if(area.length==0){
		if(firstErrorId==""){
			firstErrorId = "error_addr2";
		}
		$("#error_addr2").text("Area is required");
		isValid = false;
	}

	var city = f.city.value;
	city = city.trim() || city;
	if(city.length==0){
		if(firstErrorId==""){
			firstErrorId = "error_city";
		}
		$("#error_city").text("City is required");
		isValid = false;
	}

	var type = $("#type").val();
	if(type==-1){
		if(firstErrorId==""){
			firstErrorId = "error_type";
		}
		$("#error_type").text("Please select a type");
		isValid = false;
	}

	try{
		var another_cellphone = f.another_cellphone.value;
		another_cellphone = another_cellphone.trim() || another_cellphone;
		if(another_cellphone!="" && !another_cellphone.match(/^\d{10}$/g)){
			if(firstErrorId==""){
				firstErrorId = "error_another_cellphone";
			}
			$("#error_another_cellphone").text("Please enter a valid phone number");
			isValid = false;
		}
	}catch(e){
		console.log(e);
	}

	try{
		var landline = f.landline.value;
		landline = landline.trim() || landline;
		if(landline!="" && !landline.match(/^\d{8,12}$/g)){
			if(firstErrorId==""){
				firstErrorId = "error_landline";
			}
			$("#error_landline").text("Please enter a valid phone number");
			isValid = false;
		}
	}catch(e){
		console.log(e);
	}


	try{
		var another_landline = f.another_landline.value;
		another_landline = another_landline.trim() || another_landline;
		if(another_landline!="" && !another_landline.match(/^\d{8,12}$/g)){
			if(firstErrorId==""){
				firstErrorId = "error_another_landline";
			}
			$("#error_another_landline").text("Please enter a valid phone number");
			isValid = false;
		}
	}catch(e){
		console.log(e);
	}


	try{
		var pincode = f.pincode.value;
		pincode = pincode.trim() || pincode;
		if(pincode!="" && !pincode.match(/^\d{2,6}$/g)){
			if(firstErrorId==""){
				firstErrorId = "error_pincode";
			}
			$("#error_pincode").text("Please enter a valid pincode");
			isValid = false;
		}
	}catch(e){
		console.log(e);
	}


	try{
		var exp_years = f.exp_years.value;
		exp_years = exp_years.trim() || exp_years;
		if(exp_years!="" && !exp_years.match(/^\d{1,2}$/g)){
			if(firstErrorId==""){
				firstErrorId = "error_exp_years";
			}
			$("#error_exp_years").text("Please enter a valid value for years");
			isValid = false;
		}
	}catch(e){
		console.log(e);
	}


	try{
		var exp_months = f.exp_months.value;
		exp_months = exp_months.trim() || exp_months;
		if(exp_months!="" && !exp_months.match(/^\d{1,2}$/g)){
			if(firstErrorId==""){
				firstErrorId = "error_exp_months";
			}
			$("#error_exp_months").text("1 - 11");
			isValid = false;
		}
	}catch(e){
		console.log(e);
	}


	var human_check = f.human_check.value;
	human_check = human_check.trim() || human_check;
	var re = /^\d+$/;
	if(human_check.length==0 || !re.test(human_check)){
		if(firstErrorId==""){
			firstErrorId = "error_human_check";
		}
		$("#error_human_check").text("Please enter a number.");
		isValid = false;
	}
	else if(window.human_check_result!=human_check){
		if(firstErrorId==""){
			firstErrorId = "error_human_check";
		}
		$("#error_human_check").text("OOPS! You got it wrong this time.");
		isValid = false;
	}

	var tnc = $("#tnc:checked").length > 0;

	if(!tnc){
		if(firstErrorId==""){
			firstErrorId = "error_tnc";
		}
		
		$("#error_tnc").text("You must agree to our terms and conditions");
		isValid = false;
	}

	var checkboxesCount = $("div#divServices :checkbox").length;
	var checkedCount = $("div#divServices :checked").length;

	if(checkboxesCount>0 && checkedCount==0){
		if(firstErrorId==""){
			firstErrorId = "error_type";
		}
		$("#error_type").text("You have to select at least one service for this type");
		isValid = false;
	}


	if(!isValid){
		firstErrorId = "#" + firstErrorId;
		$("html, body").animate({ scrollTop: $(firstErrorId).position().top }, "slow");
	}

	return isValid;
}

function fnCheckUsernameAvailability(){
	$("#error_username").text("");
	$("#availability").html("");

	var username = $("#username").val();
	username = username.trim() || username;
	if(username.length==0){
		$("#error_username").text("Please enter a username before checking for availability");
		return;
	}

	$.ajax({
		url: "check_username_availability.php",
		method: "GET",
		data: {
			username: username
		},
		success: function(data){
			if(data.status){
				$("#availability").html("<img src='images/available.png' />");
			}
			else{
				$("#availability").html("<img src='images/not-available.png' />");
			}
		}
	});

}