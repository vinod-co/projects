<?php include_once "header.php"; ?>
<?php include_once "menu.php"; ?>
<div>
<?php
	// view_profiles.php
	

	include_once "config.php"; 

	$current_user_type = -1;
	$current_user = get_from_session("current_user");

	$sql = "select * from users where usertype != " . $current_user_type
		. " and registration_status = 'approved' " 
		. " and usertype in (select id from usertypes where not_listed_in_search is null) ";

	if($current_user!=null){
		$current_user_type = $current_user["usertype"];

		// if administrator only
		if($current_user_type==0){
			$sql = "select * from users where usertype != " . $current_user_type
		." and registration_status = 'approved' ";
		}
	}

	$search_type = "regular";
	$condition1 = "";
	$search_token = "";
	if(isset($_REQUEST["search_type"])){
		$search_type = $_REQUEST["search_type"];
	}
	$search_date = "";
	$search_date1 = "";
	$search_place = "";
	$search_usertype = "";

	if($search_type == "advanced"){
		$search_date1 = $_REQUEST["date"];
		if($search_date1!=""){
			$search_date = DateTime::createFromFormat('d/m/Y', $search_date1)->format('Y-m-d');
		}
		
		$search_place = $_REQUEST["place"];
		$search_usertype = $_REQUEST["usertype"];

		if($search_date!=""){
			$condition1 = "id not in (select user_id from calendar where blocked_date='" 
				. $search_date . "')";
		}
		if($search_place!=""){
			$search_place1 = "'%" . $search_place . "%'";

			$tmp_condition =  "(addr1 like {$search_place1} or addr2 like {$search_place1} or city like {$search_place1} or state like {$search_place1} or country like {$search_place1})";
			if($condition1!=""){
				$condition1 = $condition1 . " and " . $tmp_condition; 
			}
			else {
				$condition1 = $tmp_condition;
			}

		}
		if($search_usertype!=-1 && $search_usertype!=""){
			$tmp_condition = "usertype = " . $search_usertype;

			if($condition1!=""){
				$condition1 = $condition1 . " and " . $tmp_condition; 
			}
			else {
				$condition1 = $tmp_condition;
			}
		}

		if($condition1!=""){
			$sql .= " and " . $condition1;
		}

		$sql .= " order by lower(trim(firstname))";

	}
	else if($search_type=='regular') {

		$type = "";

		$condition = "";

		if(isset($_REQUEST["type"])){
			$type = $_REQUEST["type"];

			if($type!=$current_user_type){
				$condition = "usertype=" . $type;
				$ut = R::load("usertypes", $type);

				?>
				<?php // opening h1 tag is in the header.php ?>
				List of <?php echo $ut->typename; ?>s 
				<?php
			}
			else{
				?>
				<?php // opening h1 tag is in the header.php ?>
				All service providers 

				<?php			
			}

		}
		else {
			?>
			<?php // opening h1 tag is in the header.php ?>
			All service providers  

			<?php
		}

		if(isset($_REQUEST["search_token"])){
			$search_token = $_REQUEST["search_token"];

			$condition1 = <<<EOT
match(
firstname,
lastname,
email,
another_email,
addr1,
addr2,
city,
state,
country,
company_name,
profession,
gotra,
matha,
qualification,
additional_info)
against (? in boolean mode)
EOT;
		}

		if($condition!=""){
			$sql .= " and " . $condition;
		}

		if($condition1!=""){
			$sql .= " and " . $condition1;
		}

		$sql .= " order by lower(trim(firstname))";
	}
	else if($search_type=='report_2') {
		$days = $_REQUEST["days"];
		$condition1 = "datediff(sysdate(), date_of_registration) <= " . $days;
		$sql = "select * from users where usertype != 0 and " . $condition1;
		$sql .= " order by lower(trim(firstname))";

		echo "New registrations since last " . $days . " days ";
	}
	else if($search_type=='report_3') {
		$city = $_REQUEST["city"];
		if($city=="Others"){
			$city="";
		}

		$condition1 = "city = '" . $city . "'";
		$usertypename = "Users";
		if(isset($_REQUEST["usertype"])){
			$ut = $_REQUEST["usertype"];
			$condition1 .= " and usertype=" . $ut;
			$usertypename = $_REQUEST["typename"] . "s";
		}

		$sql = "select * from users where usertype != 0 and " . $condition1;
		$sql .= " order by lower(trim(firstname))";

		if($city==""){
			$city = "other cities";
		}
		echo "{$usertypename} residing in " . $city ;
		// echo "<br />" . $sql . "<br />";
	}
	?>
	
	<style type="text/css">
		.view_full_profile{
			text-decoration: underline;
			cursor: pointer;
			padding: 10px 20px 10px 0;
			color: blue;
		}
	</style>
	<?php
	if(!$user_loggedin){
		?>
		<div id="loginDiv" style="display: none">
			<script type="text/javascript" src="script/login.js"></script>
			<form>
				Login to view full details:
				<input type="text" name="username_email" placeholder="Username/Email" />
				<input type="password" name="password" placeholder="Password" />
				<button type="button" class="submit" onclick="fnLoginAjax(this.form)">Login</button>
				<span id="login_err" class="error"></span>
			</form>
			<br />
			<a href="register.php">New users register here</a>
		</div>
		<?php

	}

	?>


	<?php

	if($condition1==""){
		$data = R::getAll($sql);	
	}
	else if($search_type=="advanced" || $search_type=="report_2" || $search_type=="report_3"){
		$data = R::getAll($sql);	
	}
	else {

		$search_token_for_like = "%" . $search_token . "%";
		$sql1 = <<<EOT
select distinct u.* from users u
left join categories c on u.usertype=c.usertype
left join services s on s.category_id = c.id
left join userservices us on us.serviceid = s.id and us.userid=u.id
left join usertypes ut on u.usertype = ut.id
where (c.category like ? or 
s.service like ? or 
u.firstname like ? or 
u.lastname like ? or 
u.email like ? or 
u.another_email like ? or 
u.addr1 like ? or 
u.addr2 like ? or 
u.city like ? or 
u.state like ? or 
u.country like ? or 
u.company_name like ? or 
u.profession like ? or 
u.gotra like ? or 
u.matha like ? or 
u.qualification like ? or 
u.additional_info like ? or 
ut.typename like ? )
and u.usertype in (select id from usertypes where not_listed_in_search is null)
and u.registration_status = 'approved'
EOT;
		
		// if administrator only
		if($current_user_type==0){
$sql1 = <<<EOT
select distinct u.* from users u
left join categories c on u.usertype=c.usertype
left join services s on s.category_id = c.id
left join userservices us on us.serviceid = s.id and us.userid=u.id
left join usertypes ut on u.usertype = ut.id
where c.category like ? or 
s.service like ? or 
u.firstname like ? or 
u.lastname like ? or 
u.email like ? or 
u.another_email like ? or 
u.addr1 like ? or 
u.addr2 like ? or 
u.city like ? or 
u.state like ? or 
u.country like ? or 
u.company_name like ? or 
u.profession like ? or 
u.gotra like ? or 
u.matha like ? or 
u.qualification like ? or 
u.additional_info like ? or 
ut.typename like ? 
EOT;

		}

		$sql = $sql1 . " union " . $sql;

		$data = R::getAll($sql, array($search_token_for_like, $search_token_for_like, $search_token_for_like, $search_token_for_like, $search_token_for_like, $search_token_for_like, $search_token_for_like, $search_token_for_like, $search_token_for_like, $search_token_for_like, $search_token_for_like, $search_token_for_like, $search_token_for_like, $search_token_for_like, $search_token_for_like, $search_token_for_like, $search_token_for_like, $search_token_for_like, $search_token));
	}
	
	$search_count = count($data);
	?>

<!-- Advanced search container begins here -->
<?php 

	if($search_type=="advanced"){
?>
<script type="text/javascript">
	$(function(){
		var options = {
			// dateFormat: 'yy-mm-dd'
			dateFormat: 'dd/mm/yy'
		};
		$(".date").datepicker(options);
	});
</script>
	
		<div id="advanced_search_container">
			<div class="advanced_search_header">
				<h1>Advanced Search</h1>
			</div>
			<form class="uiv2-form" action="view_profiles.php">
				<input type="hidden" name="search_type" value="advanced">
				<fieldset>
				    <div class="legend">You can search for specific people by filling in one or more of the following</div>

				    <div class="uiv2-form-row">
				    	<span class="uiv2-form-label">Date</span>
				        <div class="uiv2-form-input">
				        	<span>
				        		<input type="text" id="date" name="date" size="15"
				        			class="date" 
				        			value = "<?php echo $search_date1;?>"/>
				        	</span>
				        	<span class="error" id="error_date"></span>
				        </div>
				    </div>

				    <div class="uiv2-form-row">
				    	<span class="uiv2-form-label">Place</span>
				        <div class="uiv2-form-input">
				        	<span>
				        		<input type="text" id="place" name="place" size="15" 
				        			value = "<?php echo $search_place;?>"/>
				        	</span>
				        	<span class="error" id="error_place"></span>
				        </div>
				    </div>


				    <div class="uiv2-form-row">
				    	<script type="text/javascript">
							var usertypeFields = {};
						</script>
				    	<span class="uiv2-form-label">Category</span>
				        <div class="uiv2-form-input">
				        	<span>
				        		<select name="usertype" id="type" class="dropdown">
									<option value="-1"></option>

									<?php
										include_once "config.php";
										$usertypes = R::getAll("select * from usertypes order by typename");
										
										foreach($usertypes as $usertype){
											$usertype_id = $usertype['id'];
											$selected_attribute = "";
											if($usertype_id==$search_usertype){
												$selected_attribute = "selected='selected'";
											}
											echo "<option value='{$usertype_id}' {$selected_attribute} >{$usertype['typename']}</option>";

											?>
											<script type="text/javascript">
												usertypeFields["<?php echo $usertype['id']; ?>"] = "<?php echo $usertype['fields']; ?>";
											</script>
											<?php
										}
									?>
								</select>
				        	</span>
				        	<span class="error" id="error_category"></span>
				        </div>
				    </div>
				    <div class="gap"></div>
				    <div class="uiv2-form-row">
				    	<span class="uiv2-form-label">&nbsp;</span>
				        <div class="uiv2-form-input">
				        	<span>
				        		<button class="submit">Search</button>
				        	</span>
				        </div>
				    </div>
				    
				</fieldset>
			</form>
		</div>

<?php
	}
?>
<!-- Advanced search container ends here -->


	(Total : <?php echo $search_count; ?>
		<?php 
		if($search_token!=""){
			?>
			matching '<?php echo $search_token; ?>'
			<?php
		}
		?>
	) 
	<?php 
    		if(!$user_loggedin){
    ?>
    <marquee scrollamount="2" style="padding: 10px; background-color: rgba(208, 34, 12, 0.94); color: white; ">
		To view complete details - please login or register
    </marquee>
    <?php
    		}
    ?>
    
    </div>
	<div class="gap"></div>
	<?php

	$ut = R::getAll("select id, typename from usertypes");
	$ut_map = [];
	foreach($ut as $one_ut){
		$ut_map[$one_ut["id"]] = $one_ut["typename"];
	}

	foreach($data as $d){
		$name = "{$d["firstname"]} {$d["lastname"]}";
		$email = "{$d["email"]}";
		$cellphone = "{$d["cellphone"]}";

		$addr1 = $d["addr1"];
		$addr2 = $d["addr2"];
		$city = $d["city"];
		$state = $d["state"];
		$country = $d["country"];


		if(!$user_loggedin){
			$size = strlen($email);
			// $email = substr($email, 0, 5) . str_pad("", 5, "*") . substr($email, $size-5);
			// $cellphone = substr($cellphone, 0, 3) . str_pad("", 4, "*") . substr($cellphone, 7);
			$email = substr($email, 0, 4) . str_pad("", 10, "*");
			$cellphone = substr($cellphone, 0, 4) . str_pad("", 6, "*");
		}
		?>

		<div class="one_profile">
			<fieldset>
				<div class="basic_info">
					<?php
						if($current_user!=null){
							$profile_picture = "images/profile/default.jpg";

							
							if($d["profile_picture"]!=null){
								$ext = substr(strtolower($d["profile_picture"]), -4);

								if($ext == ".jpg" ||
									$ext == ".bmp" || 
									$ext == ".gif" || 
									$ext == ".png"){
									$profile_picture = $d["profile_picture"];
								}
							}
					?>
					<img src="<?php echo $profile_picture; ?>" 
						class="profile_picture" 
						title = "<?php echo $name;?>" />
					<?php
						}
					?>
					<div>
						<div style="width: 350px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"
							title = "<?php echo $name;?>" >
							<label>Name</label>: 
							<?php echo $name;?></div>
					</div>
					<div>
						<div><label>Type</label>:
							<?php echo $ut_map[$d["usertype"]];?></div>
					</div>
					<div>
						<div style="width: 350px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
							<label>Email</label>: 
							<?php echo $email;?></div>
					</div>
					<div>
						<div><label>Cellphone</label>: 
							+91 <?php echo $cellphone;?></div>
					</div>

					<div class="action_bar">
						<span class="hyperlink"
							onclick="fnCommunicate(<?php echo $d["id"];?>, 'email', {firstname: '<?php echo $d["firstname"];?>', lastname: '<?php echo $d["lastname"];?>', email: '<?php echo $d["email"];?>'})">
							<img src="images/email.jpg" title="Send an email"/>
						</span>
						<span class="hyperlink"
							onclick="fnCommunicate(<?php echo $d["id"];?>, 'message')">
							<img src="images/message.jpg" title="Send a message" />
						</span>
						<span class="hyperlink" 
							onclick="fnViewCalendar(<?php echo $d["id"];?>)">
							<img src="images/calendar.jpg" title="View calendar" />
						</span>
					</div>
					
				</div>

				<div class="description">
					<div>
						<!--
						<div><label>Address</label>: </div>
						<div style="width: 350px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
							
							<?php echo $addr1;?>
							<?php echo $addr2;?>
						
						</div>
						
						<div style="width: 350px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
							<?php echo $city;?>
							<?php echo $state;?>
							<?php echo $country;?>
						</div>

						<div class="gap"></div>
						<div style="width: 350px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
							<?php echo $d["additional_info"];?>
						</div>
						-->
						<div>
							<!-- <span data-userid="<?php echo $d["id"];?>" 
								class="view_full_profile">View full profile</span> -->
								<span class="hyperlink" style="text-decoration: underline"
									onclick="fnCheckForLoginAndRedirectTo('view_one_profile_1.php?id=<?php echo $d["id"];?>')">
									View full profile
								</a>
						</div>
					</div>
					
				</div>
			</fieldset>
		</div>
		<?php
		
	}
?>

<?php include_once "footer.php"; ?>

