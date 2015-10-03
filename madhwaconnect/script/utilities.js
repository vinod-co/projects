/* utilities.js */

var fnViewCalendar = function(userId){
	var options = {
		autoOpen: false,
		title: "View available dates",
		modal: true,
		minHeight: 300,
		minWidth: 400,
		resizable: false,
		open: function (event, ui) {
	        $('#dlg_view_calendar_content').load('view_calendar.php?for_user='+userId);
		}
	};
	$("#dlg_view_calendar").dialog(options).dialog("open");
	$(".ui-dialog-titlebar").css("display", "none");
};

var fnCommunicate = function(userId, communicationType, to_user){
	if(user_loggedin==true){
		switch(communicationType){
			case "message":
				window.fnCommunicate_userId = userId;
				$("#dlg_communicate_message").dialog("open");
				$(".ui-dialog-titlebar").css("display", "none");
				break;

			case "email":
				window.fnCommunicate_userId = userId;
				$("span#firstname").html(to_user.firstname);
				$("span#lastname").html(to_user.lastname);
				$("span#email_to").html(to_user.email);
				$("#dlg_communicate_email").dialog("open");
				$(".ui-dialog-titlebar").css("display", "none");
				break;

			case "sms":
				alert("Pending feature... :-(");
				break;
		}
	}	
	else{
		// alert("Please login to access this feature");
		$(".ui-dialog-titlebar").css("display", "block");
		$("#dlg_login_required").dialog("open");
	}
};

var fnPostMessage = function(f){
	debugger;
	var message_text;
	message_text = $(f).find("#message_text").val();
	if(message_text.length==0){
		$(f).find("#message_text_error").html("Please enter something to send as message :-)");
		return;
	}

	var to_id = $(f).find("#to_id").val() || window.fnCommunicate_userId;
	var response_to = $(f).find("#response_to").val() || "";

	
	var data = {
		to_id: to_id,
		message_text: message_text
	};
	if(response_to!=""){
		data.message_text = "RESPONSE TO : " + response_to + "\n\n" + message_text;
		data.response_code = 1;
		data.sr_id = $(f).find("#sr_id").val()
	}

	$.ajax({
		url: "post_message.php",
		method: "POST",
		data: data,
		async: false,
		success: function(data){
			data = JSON.parse(data);
			if(data.status==true){
				f.reset();
				$("#dlg_communicate_message").dialog("close");
				alert("Your message is successfully posted.");
			}
			else{
				alert("OOPS! - There was an error while posting your message.");
			}
		}
	});
}

var fnReplyToMessage = function(f){
	var message_text, threadId;
	threadId = $(f).find("#thread_id").val();
	message_text = $(f).find("#message_text").val();
	if(message_text.length==0){
		$(f).find("#message_text_error").html("Please enter something to send as message :-)");
		return;
	}
	$.ajax({
		url: "post_message.php",
		method: "POST",
		data: {
			message_text: message_text,
			to_id: window.fnCommunicate_userId,
			thread_id: threadId
		},
		async: false,
		success: function(data){
			data = JSON.parse(data);
			if(data.status==true){
				document.location.reload();
			}
			else{
				alert("OOPS! - There was an error while posting your message.");
			}
		}
	});
};

var fnValidate_forgot_password_form = function (f){
	debugger;
	var username_email = $(f).find("#username_email").val();
	if(username_email.length==0){
		$(f).find("#username_email_error").html("Please enter username/email");
		return false;
	}
	return true;
};

var fnCheckForLoginAndRedirectTo = function(url){
	if(user_loggedin==true){
		window.location = url;
	}	
	else{
		$(".ui-dialog-titlebar").css("display", "block");
		$("#dlg_login_required").dialog("open");
	}
}

var fnPostEmail = function(f){
	var subject;
	var message_text;

	subject = $(f).find("#subject").val();
	message_text = $(f).find("#message_text").val();
	if(subject.length==0){
		$(f).find("#subject_error").html("Please enter subject");
		return;
	}
	if(message_text.length==0){
		$(f).find("#message_text_error").html("Please enter something to send as message :-)");
		return;
	}
	$.ajax({
		url: "post_email.php",
		method: "POST",
		data: {
			subject: subject,
			message_text: message_text,
			to_id: window.fnCommunicate_userId
		},
		async: false,
		success: function(data){
			data = JSON.parse(data);
			if(data.status==true){
				f.reset();
				$("#dlg_communicate_email").dialog("close");
				alert("Your email has been sent.");
			}
			else{
				alert("OOPS! - There was an error while sending email.");
			}
		}
	});
};

var fnShowMessage = function(msg){
	var options = {
		title: "Madhwa Connect",
		resizable: false,
		draggable: false,
		autoOpen: true,
		modal: true,
		buttons: [
			{
				text: "OK",
				click: function(){
					$("#message_box").dialog("close");
				}
			}
		]
	};
	$("#message_box").html(msg);
	$("#message_box").dialog(options);
};