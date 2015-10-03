<?php
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	if (!isset($_SESSION["current_user"])) {
		$_SESSION["message"] = "You need to login for accessing this page";
		header("Location: ./index.php");
		return;
	}
?>
<?php include_once "header.php"; ?>

<?php 

	include_once "config.php"; 
	include_once "functions.php";
	$current_user = get_from_session("current_user");
	$current_user_profile_picture = $current_user["profile_picture"];

	if($current_user_profile_picture==null || $current_user_profile_picture==""){
		$current_user_profile_picture = "./images/profile/default.jpg";
	}
?>

<?php include_once "menu.php"; ?>

<div id="update_profile_picture_container">
	<div id="update_profile_picture_header">
		<h1>Update profile picture</h1>
	</div>


<form class="uiv2-form" method="POST" 
	action="update_profile_picture_action.php" 
	enctype="multipart/form-data" 
	id="form_update_profile_picture"
	onsubmit = "return fnValidateForm()">
	<fieldset>
		<div class="legend">Recomended 200px X 200px</div>

		<div class="uiv2-form-row">
			<span class="uiv2-form-label">&nbsp;</span>
	    </div>
		<div class="uiv2-form-row">
			<span class="uiv2-form-label">&nbsp;</span>
			<div class="uiv2-form-input">
				<img class="profile_picture" src="<?php echo $current_user_profile_picture; ?>">
			</div>
	    </div>

		<div class="uiv2-form-row">
			<span class="uiv2-form-label">Select a new profile picture (Max 1MB)</span>
			<div class="uiv2-form-input">
	        	<span>
	        		<input type="file" 
	        			style="margin-top: 10px;"
	        			id="profile_picture" name="profile_picture" 
						value="" />
	        	</span>
	        	<span class="uiv2-field-required">*</span>
	        	<span class="error" id="error_profile_picture"></span>
	        </div>
	    </div>
	    <div class="uiv2-form-row">
	    	<span class="uiv2-form-label">&nbsp;</span>
	    </div>
		<div class="uiv2-form-row">
			<span class="uiv2-form-label">&nbsp;</span>
			<div class="uiv2-form-input">
	        	<button class="submit">Update</button>
	        </div>
	    </div>
	</fieldset>
</form>


<script type="text/javascript">
	$(function(){
		$('#profile_picture').bind('change', function() {
			window.do_not_upload = false;
			var size = this.files[0].size;
			var limit = 1024*1024; // 1MB
			if(size>limit){
				window.do_not_upload = true;
			}
		});
	});

	var fnValidateForm = function(){
		if(window.do_not_upload==true){
			fnShowMessage("Please choose another file <br />(less than 1MB)");
			return false;
		}
		return true;
	};
</script>
</div>
<?php include_once "footer.php"; ?>

