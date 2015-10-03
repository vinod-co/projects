<?php

	// view_one_profile.php

	$id = null;
	if(isset($_REQUEST["id"])){
		$id = $_REQUEST["id"];
	}

	include_once "config.php";

	$current_user = get_from_session("current_user");
	if(is_null($current_user)){
		?>
		<div>
			<h3>Please login to access this feature</h3>
		</div>

		<?php
		return;
	}


	$sql = "select * from users where id = ?";
	$user = R::getRow($sql, array($id));

	$usertype = R::getCell("select typename from usertypes where id = ?", 
		array($user["usertype"]));

?>


<div>
	<form class="classic">
	<div style="width: 150px; padding: 10px; float: left; min-height: 500px; ">
		<p>
			<?php
				$profile_picture = "images/profile/default.jpg";
				if($user["profile_picture"]!=null){
					$profile_picture = $user["profile_picture"];
				}
			?>
			<img src="<?php echo $profile_picture; ?>" style="width: 120px; border-radius: 5px;">
		</p>
	</div>
	<div id="column1">

		<p>
			<h3><?php echo $user["firstname"]; ?> <?php echo $user["lastname"]; ?>, <?php echo $usertype; ?></h3>
		</p>
		<p>
			<label>Contact numbers</label>
			<span>: 
			<?php 
				$temp_ar = array($user["cellphone"], $user["another_cellphone"], 
					$user["landline"], $user["another_landline"]);
				$contact_numbers = "";
				foreach($temp_ar as $t){
					if($t==null || $t=="") continue;
					$contact_numbers .= $t . ", ";
				}

				if($contact_numbers != ""){
					$contact_numbers = substr($contact_numbers, 0, strlen($contact_numbers)-2);
				}
				echo $contact_numbers;
			?></span>
		</p>
		<p>
			<label>Emails</label>
			<span>: 
			<?php 
				$temp_ar = array($user["email"], $user["another_email"]);
				$emails = "";
				foreach($temp_ar as $t){
					if($t==null || $t=="") continue;
					$emails .= $t . ", ";
				}

				if($emails != ""){
					$emails = substr($emails, 0, strlen($emails)-2);
				}
				echo $emails;
			?></span>
		</p>
		<p>
			<label>Address</label>
			<span>: 
				<?php echo $user["addr1"]; ?>
				<?php echo $user["addr2"]; ?>
				<?php echo $user["city"]; ?>
				<?php echo $user["state"]; ?>
				<?php echo $user["pincode"]; ?>
				<?php echo $user["country"]; ?>
			</span>
		</p>

		<p>
			<label>Company name</label>
			<span>: <?php echo $user["company_name"]; ?></span>
		</p>

		<p>
			<label>Experience</label>
			<span>: <?php echo $user["exp_years"]==null?0:$user["exp_years"]; ?> years, 
				<?php echo $user["exp_months"]==null?0:$user["exp_months"]; ?> months</span>
		</p>

		<p>
			<label>Profession</label>
			<span>: <?php echo $user["profession"]; ?></span>
		</p>

		<p>
			<label>Gotra</label>
			<span>: <?php echo $user["gotra"]; ?></span>
		</p>

		<p>
			<label>Matha</label>
			<span>: <?php echo $user["matha"]; ?></span>
		</p>

		<p>
			<label>Qualification</label>
			<span>: <?php echo $user["qualification"]; ?></span>
		</p>

		<p>
			<label>Additional info</label>
			<span>: <?php echo $user["additional_info"]; ?></span>
		</p>

		<?php

			$sql = "select * from categories c join services s on "
				. "c.id = s.category_id "
				. "where s.id in (select serviceid from userservices where userid=?) "
				. "order by c.category";

			$services = R::getAll($sql, array($id));

			if(count($services)>0){

		?>
		<p>
			<fieldset>
				<legend>Services offered:</legend>
				<span>
				<?php 

					$prev = "";
					$tmp_services = "";
					foreach($services as $service){
						if($prev==""){
							$prev=$service["category"];
						}

						if($prev!=$service["category"]){

							$tmp_services = substr($tmp_services, 0, strlen($tmp_services)-2);
							echo "<h3>{$prev}: </h3>";
							echo "<span>{$tmp_services}</span>";

							$prev=$service["category"];
							$tmp_services = "";
						}
						
						$tmp_services .= $service["service"] . ", ";
					}

					if($tmp_services!=""){
						$tmp_services = substr($tmp_services, 0, strlen($tmp_services)-2);
						echo "<h3>{$prev}: </h3>";
						echo "<span>{$tmp_services}</span>";
					}
				?>
				</span>			
			</fieldset>
		</p>
		<?php
			}
		?>
	</div>
	</form>
</div>

<script type="text/javascript">
	$(function(){
		$(".ui-dialog-title").text("<?php echo $user["firstname"]; ?> <?php echo $user["lastname"]; ?>");
	});
</script>