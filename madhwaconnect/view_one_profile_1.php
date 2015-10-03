<?php include_once "header.php"; ?>
<?php include_once "config.php"; ?>
<?php include_once "menu.php"; ?>
<?php include_once "functions.php"; ?>

<?php
	
	$current_user = get_from_session("current_user");
	if($current_user==null){
		store_in_session("message", "You must be logged in to access this page");
		header("Location: ./index.php");
		return;
	}

	$id = $_REQUEST["id"];
	$sql = "select * from users where id = ?";
	$user = R::getRow($sql, array($id));

	$sql = "select typename from usertypes where id=?";
	$usertype = R::getCell($sql, array($user["usertype"]));

	$profile_picture = $user["profile_picture"];
	if($profile_picture==null){
		$profile_picture = "./images/profile/default.jpg";
	}
	else{
		$profile_picture = "./images/profile/default.jpg";
		if($user["profile_picture"]!=null){
			$ext = substr(strtolower($user["profile_picture"]), -4);
			if($ext == ".jpg" ||
				$ext == ".bmp" || 
				$ext == ".gif" || 
				$ext == ".png"){
				$profile_picture = $user["profile_picture"];
			}
		}		
	}
?>
<style type="text/css">
	.serviceitem {
		width: 250px;
		display: inline-block;
		margin: 3px;
		padding: 3px;
	}

</style>


<div id="view_one_profile_container">
	<div>
		<h1 style="height: 150px;">
			<img src="<?php echo $profile_picture; ?>" class="profile_picture"> 
			<span style="display: inline-block; margin-top: 10px; ">
				<?php echo $user["firstname"]; ?> <?php echo $user["lastname"]; ?></span>
			<span style="display: block; font-size: 0.5em; margin-top: 15px; ">
				<?php echo $usertype; ?></span>

			<script type="text/javascript">
				var email_to_user = {
					firstname: "<?php echo $user["firstname"]; ?>",
					lastname: "<?php echo $user["lastname"]; ?>",
					email: "<?php echo $user["email"]; ?>"
				};
			</script>

				<div class="action_bar">
					<span class="hyperlink" href="javscript:void()" 
						onclick="fnCommunicate(<?php echo $id;?>, 'email', email_to_user)">
						<img src="images/email.jpg" title="Send an email"/>
					</span>
					<span class="hyperlink" href="javascript:void()" 
						onclick="fnCommunicate(<?php echo $id;?>, 'message')">
						<img src="images/message.jpg" title="Send a message" />
					</span>
					<span class="hyperlink" href="javascript:void()" 
						onclick="fnViewCalendar(<?php echo $id;?>)">
						<img src="images/calendar.jpg" title="View calendar" />
					</span>


					

				</div>

			</h1>
			<?php
				if($current_user["username"]=="administrator"){
					if($user["registration_status"]=="approved"){
					?>
					<button type="button"
						class="submit"
						style="background-color: red; "
						data-status="suspended" >Suspend user</button>
					<?php
					}
					else if($user["registration_status"]=="suspended"){
					?>
					<button type="button"
						class="submit"
						style="background-color: green; "
						data-status="approved" >Restore user</button>
					<?php
					}
					
				}
			?>
	</div>
	<form class="uiv2-form" style="display: block;">

		
		<fieldset>
		    <div class="legend">Contact Details</div>

		    <div class="uiv2-form-row">
		    	<span class="uiv2-form-label">Mobile number</span>
		        <span class="uiv2-form-label" style="text-align: left; width: 400px; ">
		        	+91 <?php echo $user["cellphone"]; ?></span>
		    </div>

		    <?php
		    	if($user["another_cellphone"]!=null){
		    		?>
		    <div class="uiv2-form-row">
		    	<span class="uiv2-form-label">Mobile number</span>
		        <span class="uiv2-form-label" style="text-align: left; width: 400px; ">
		        	<?php echo $user["another_cellphone"]; ?></span>
		    </div>
		    		<?php
		    	}
		    ?>

		    <?php
		    	if($user["landline"]!=null){
		    		?>
		    <div class="uiv2-form-row">
		    	<span class="uiv2-form-label">Landline number</span>
		        <span class="uiv2-form-label" style="text-align: left; width: 400px; ">
		        	<?php echo $user["landline"]; ?></span>
		    </div>
		    		<?php
		    	}
		    ?>

		    <?php
		    	if($user["another_landline"]!=null){
		    		?>
		    <div class="uiv2-form-row">
		    	<span class="uiv2-form-label">Landline number</span>
		        <span class="uiv2-form-label" style="text-align: left; width: 400px; ">
		        	<?php echo $user["another_landline"]; ?></span>
		    </div>
		    		<?php
		    	}
		    ?>

		    <div class="uiv2-form-row">
		    	<span class="uiv2-form-label">Email address</span>
		        <span class="uiv2-form-label" style="text-align: left; width: 400px; ">
		        	<?php echo $user["email"]; ?></span>
		    </div>

		    <?php
		    	if($user["another_email"]!=null){
		    		?>
		    <div class="uiv2-form-row">
		    	<span class="uiv2-form-label">Email address</span>
		        <span class="uiv2-form-label" style="text-align: left; width: 400px; ">
		        	<?php echo $user["another_email"]; ?></span>
		    </div>
		    		<?php
		    	}
		    ?>

		    <?php
		    	if($user["addr1"]!=null){
		    		?>
		    <div class="uiv2-form-row">
		    	<span class="uiv2-form-label">Address</span>
		        <span class="uiv2-form-label" style="text-align: left; width: 400px; ">
		        	<?php echo $user["addr1"]; ?></span>
		    </div>
		    		<?php
		    	}
		    ?>

		    <?php
		    	if($user["addr2"]!=null){
		    		?>
		    <div class="uiv2-form-row">
		    	<span class="uiv2-form-label">Area</span>
		        <span class="uiv2-form-label" style="text-align: left; width: 400px; ">
		        	<?php echo $user["addr2"]; ?></span>
		    </div>
		    		<?php
		    	}
		    ?>

		    <?php
		    	if($user["city"]!=null){
		    		?>
		    <div class="uiv2-form-row">
		    	<span class="uiv2-form-label">City</span>
		        <span class="uiv2-form-label" style="text-align: left; width: 400px; ">
		        	<?php echo $user["city"]; ?></span>
		    </div>
		    		<?php
		    	}
		    ?>

		    <?php
		    	if($user["state"]!=null){
		    		?>
		    <div class="uiv2-form-row">
		    	<span class="uiv2-form-label">State</span>
		        <span class="uiv2-form-label" style="text-align: left; width: 400px; ">
		        	<?php echo $user["state"]; ?></span>
		    </div>
		    		<?php
		    	}
		    ?>

		    <?php
		    	if($user["pincode"]!=null){
		    		?>
		    <div class="uiv2-form-row">
		    	<span class="uiv2-form-label">Pincode</span>
		        <span class="uiv2-form-label" style="text-align: left; width: 400px; ">
		        	<?php echo $user["pincode"]; ?></span>
		    </div>
		    		<?php
		    	}
		    ?>

		    <?php
		    	if($user["country"]!=null){
		    		?>
		    <div class="uiv2-form-row">
		    	<span class="uiv2-form-label">Country</span>
		        <span class="uiv2-form-label" style="text-align: left; width: 400px; ">
		        	<?php echo $user["country"]; ?></span>
		    </div>
		    		<?php
		    	}
		    ?>

			
		</fieldset>

		<div id="divServices">
		</div>

		<fieldset>
			<div class="legend">Additional fields</div>
			

		    <?php
		    	if($user["username"]!=null){
		    		?>
		    <div class="uiv2-form-row">
		    	<span class="uiv2-form-label">Username</span>
		        <span class="uiv2-form-label" style="text-align: left; width: 400px; ">
		        	<?php echo $user["username"]; ?></span>
		    </div>
		    		<?php
		    	}
		    ?>

		    <?php
		    	if($user["company_name"]!=null){
		    		?>
		    <div class="uiv2-form-row">
		    	<span class="uiv2-form-label">Company name</span>
		        <span class="uiv2-form-label" style="text-align: left; width: 400px; ">
		        	<?php echo $user["company_name"]; ?></span>
		    </div>
		    		<?php
		    	}
		    ?>

		    <?php
		    	if($user["exp_years"]!=null && $user["exp_years"]>0){
		    		?>
		    <div class="uiv2-form-row">
		    	<span class="uiv2-form-label">Experience (years)</span>
		        <span class="uiv2-form-label" style="text-align: left; width: 400px; ">
		        	<?php echo $user["exp_years"]; ?></span>
		    </div>
		    		<?php
		    	}
		    ?>

		    <?php
		    	if($user["exp_months"]!=null && $user["exp_months"]>0){
		    		?>
		    <div class="uiv2-form-row">
		    	<span class="uiv2-form-label">Experience (months)</span>
		        <span class="uiv2-form-label" style="text-align: left; width: 400px; ">
		        	<?php echo $user["exp_months"]; ?></span>
		    </div>
		    		<?php
		    	}
		    ?>

		    <?php
		    	if($user["profession"]!=null){
		    		?>
		    <div class="uiv2-form-row">
		    	<span class="uiv2-form-label">Profession</span>
		        <span class="uiv2-form-label" style="text-align: left; width: 400px; ">
		        	<?php echo $user["profession"]; ?></span>
		    </div>
		    		<?php
		    	}
		    ?>

		    <?php
		    	if($user["gotra"]!=null){
		    		?>
		    <div class="uiv2-form-row">
		    	<span class="uiv2-form-label">Gotra</span>
		        <span class="uiv2-form-label" style="text-align: left; width: 400px; ">
		        	<?php echo $user["gotra"]; ?></span>
		    </div>
		    		<?php
		    	}
		    ?>

		    <?php
		    	if($user["matha"]!=null){
		    		?>
		    <div class="uiv2-form-row">
		    	<span class="uiv2-form-label">Mutt</span>
		        <span class="uiv2-form-label" style="text-align: left; width: 400px; ">
		        	<?php echo $user["matha"]; ?></span>
		    </div>
		    		<?php
		    	}
		    ?>

		    <?php
		    	if($user["qualification"]!=null){
		    		?>
		    <div class="uiv2-form-row">
		    	<span class="uiv2-form-label">Qualification</span>
		        <span class="uiv2-form-label" style="text-align: left; width: 400px; ">
		        	<?php echo $user["qualification"]; ?></span>
		    </div>
		    		<?php
		    	}
		    ?>

		    <?php
		    	if($user["additional_info"]!=null){
		    		?>
		    <div class="uiv2-form-row">
		    	<span class="uiv2-form-label">Additional info</span>
		        <span class="uiv2-form-label" style="text-align: left; width: 400px; ">
		        	<?php echo $user["additional_info"]; ?></span>
		    </div>
		    		<?php
		    	}
		    ?>

		    <?php
		    	if($user["date_of_registration"]!=null){
		    		?>
		    <div class="uiv2-form-row">
		    	<span class="uiv2-form-label">Registered on</span>
		        <span class="uiv2-form-label" style="text-align: left; width: 400px; ">
		        	<?php echo date('d-m-Y', strtotime($user["date_of_registration"])); ?>
		        	<?php
		        		$sql1 = "select datediff(sysdate(), date_of_registration) from users where id=?";
		        		$days_since = R::getCell($sql1, array($id));
		        		if($days_since==0){
		        			echo "&nbsp;&nbsp;&nbsp; (Joined today)";
		        		}
		        		else if($days_since==1){
		        			echo "&nbsp;&nbsp;&nbsp; (Joined yesterday)";
		        		}
		        		else{
		        			echo "&nbsp;&nbsp;&nbsp; (Joined {$days_since} days ago)";
		        		}

		        		
		        	?></span>
		    </div>
		    		<?php
		    	}
		    ?>
		</fieldset>
		<?php
			$sql = "select count(*) from userservices where userid=?";
			$services_count = R::getCell($sql, array($id));

			if($services_count>0){
		?>
		<h2>Services offered</h2>

		<?php
				$sql = "select distinct c.id as id, category from categories c "
				. "join services s on c.id = s.category_id "
				. "join userservices us on s.id = us.serviceid "
				. "where userid=?";

				$categories = R::getAll($sql, array($id));

				foreach($categories as $category){
		?>
		<fieldset>
			<div class="legend"><?php echo $category["category"]; ?></div>
			<div style="padding: 20px;">
				<?php
					$sql = "select service from userservices us join services s on s.id = us.serviceid "
						. "where userid=? and category_id=? order by service";
					$user_services = R::getAll($sql, array($id, $category["id"]));

					foreach($user_services as $us){
						?>
						<span class="serviceitem">
						<?php echo $us["service"]; ?></span>
						<?php
					}
				?>
			</div>
		</fieldset>
		<?php
				}
			}
		?>
	</form>
</div>

<?php include_once "footer.php"; ?>
<script type="text/javascript">
	$(function(){
		$(".action_bar").show();
	});
</script>
<script type="text/javascript">
	$(function(){
		$("button.submit").click(function(){
			var me = $(this);
			$.ajax({
				invoker: me,
				method: "POST",
				url: "change_registration_status.php",
				data: {
					userid: <?php echo $user["id"]?>,
					status: $(this).attr("data-status")
				},
				success: function(data){
					if(typeof(data)=="string"){
						data = JSON.parse(data);
					}
					
					if(data.status==true){
						window.location = "<?php echo $url; ?>";
					}
				}
			});
		});
	});
</script>