

	</div><!-- end of main-wrapper -->

<!-- testing for message -->
<?php
	if(isset($_SESSION["message"])){
		$msg = $_SESSION["message"];
		?>
		<script type="text/javascript">
			
			$(function(){
				fnShowMessage("<?php echo $msg; ?>")
				// window.alert("<?php echo $msg; ?>");
			
			});

		</script>
		<?php	
		unset($_SESSION["message"]);
	}
	
	?>

</div><!-- end of container -->

<script type="text/javascript">
	$(function(){


		$(".action_bar").hide();
		
		$(".one_profile").on("mouseover", function(){
			$(".action_bar").hide();
			$(this).find(".action_bar").show();
		});
		$(".one_profile").on("mouseout", function(){
			$(".action_bar").hide();
		});


		$("input[name=search_token]").focus();

		var options = {
			autoOpen: false,
			title: "Send a message",
			minWidth: 650,
			modal: true,
			resizable: false
		};
		$("div.communicate").dialog(options);

		$("#btn_hide_dlg_communicate_message").click(function(){
			$("div.communicate").dialog("close");
		});
	});
</script>

<div id="dialog-confirm">
</div>

<div id="message_box">
</div>

<div id="dlg_view_calendar">
	<div id="dlg_view_calendar_content"></div>
</div>

<div id="dlg_communicate_message" class="communicate">
	<h3>Post a short message</h3>
	<form class="classic" onsubmit="return false;">
		<!-- <fieldset>
			<legend>Enter message</legend> -->
			<p>
				<textarea style="font: inherit; resizable: false; width: 100%; height: 150px" 
					id="message_text" name="message_text" ></textarea> 
				<span class="error" id="error_message_text"></span>
			</p>
			<p>
				<span class="error" id="message_text_error"></span>
			</p>
			<p>
				<button class="submit" onclick="fnPostMessage(this.form)">Submit</button>

				<a href="#" id="btn_hide_dlg_communicate_message">Cancel</a>
			</p>
		<!-- </fieldset> -->
	</form>
</div>

<div id="dlg_communicate_email" class="communicate">
	<h3>Send an email to <span id="firstname"></span> <span id="lastname"></span>
		(<span id="email_to"></span>)</h3>

	<form class="classic" onsubmit="return false;">
		<p>
			Subject: <br />
			<input type="text" style="width: 100%; font: inherit; " id="subject" name="subject" />
		</p>
		<p>
			<span class="error" id="subject_error"></span>
		</p>
		<p>
			Message: 
			<textarea style="font: inherit; resizable: false; width: 100%; height: 150px" 
				id="message_text" name="message_text" ></textarea> 
		</p>
		<p>
			<span class="error" id="message_text_error"></span>
		</p>
		<p>
			<button class="submit" onclick="fnPostEmail(this.form)">Submit</button>

			<span class="hyperlink hide_dlg_email" >Cancel</span>
		</p>
	</form>
</div>

<script type="text/javascript">
	$(function(){
		$(".hide_dlg_email").click(function(){
			$("#dlg_communicate_email").dialog("close");
		});

		$("span.view_full_profile").click(function(){

			if(!user_loggedin){
				$(".ui-dialog-titlebar").css("display", "block");
				$("#dlg_login_required").dialog("open");
				
				return;
			}

			var id = $(this).attr("data-userid");
			$.ajax({
				url: "view_one_profile.php",
				data: {
					id: id
				},
				success: function(resp){
					$(".ui-dialog-titlebar").css("display", "block");
					$("#dlg_view_single_profile").html(resp)
						.dialog("open");
					
				}
			});
		});

		var options = {
			width: 900,
			height: 600,
			autoOpen: false,
			modal: true,
			title: "Complete Profile",
			resizable: false,
			draggable: false
		};
		$("#dlg_view_single_profile").dialog(options);

		options = {
			title: "Privilaged access",
			width: 350,
			height: 200,
			resizable: false,
			draggable: false,
			modal: true,
			autoOpen: false,
			buttons: [
				{
					text: "Close",
					click: function(){
						$("#dlg_login_required").dialog("close");
					}
				}
			]
		};
		$("#dlg_login_required").dialog(options);

	});
</script>

<div id="dlg_view_single_profile">
</div>

<div id="dlg_login_required">
	<h3>Please login to access this feature.</h3>
</div>

</body>
</html>