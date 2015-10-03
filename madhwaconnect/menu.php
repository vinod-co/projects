<div id="menu_container"></div>


<?php
	include_once "config.php";
	include_once "functions.php";
	$current_user = get_from_session("current_user");

	$sql = "select * from usertypes where not_listed_in_search is null order by typename";

	if($current_user["username"]=="administrator"){
		$sql = "select * from usertypes order by typename";
	}

	$usertypes = R::getAll($sql);

	$current_user_type = -1;
	$current_user = get_from_session("current_user");
	if($current_user!=null){
		$current_user_type = $current_user["usertype"];
	}
	// echo "\$current_user_type = " . $current_user_type;
	// echo '\$current_user["id"] = ' . $current_user["id"];
	// echo 'is_enduser(\$current_user["id"])' . is_enduser($current_user["id"]);
?>



<script type="text/javascript">
	$(function() {

		var menuItems = [
			{
				name: "Home",
				url: "http://madhwaconnect.com"
			},
			{
				name: "Services",
				options: [
					{name: "All", url: "view_profiles.php"},
					{name: "Religious", options: [
						<?php
						foreach($usertypes as $ut){
							if($ut["id"]==$current_user_type ||
								$ut["relegious_yesno"]==0){
								continue;
							}
							?>
						{name: "<?php echo $ut["typename"];?>", url: "view_profiles.php?type=<?php echo $ut["id"];?>"},
							<?php
						}
						?>
					]},
					{name: "Value added", options: [
						<?php
						foreach($usertypes as $ut){
							if($ut["id"]==$current_user_type ||
								$ut["relegious_yesno"]==1){
								continue;
							}
							?>
						{name: "<?php echo $ut["typename"];?>", url: "view_profiles.php?type=<?php echo $ut["id"];?>"},
							<?php
						}
						?>
					]},

	
				]
			}
		];

		if(window.user_loggedin){
			var mi = {
				<?php
					$cnt = get_unread_messages_count($current_user["id"]);
					$mi_name = "Messages";
					if($cnt>0){
						$mi_name = "Messages ({$cnt})";
					}
				?>
				name: "<?php echo $mi_name; ?>",
				options: [
					{name: "All messages", url: "all_messages.php"},
					{name: "Unread messages", url: "unread_messages.php"}
				]
			};
			menuItems.push(mi);
			mi = {
				name: "Service requests",
				options: [
					{name: "Create a new request", url: "create_new_service_request.php"},
					{name: "My service requests", url: "my_service_requests.php"},
					<?php 

						if($current_user_type!=0 && is_enduser($current_user["id"])==0){
					?>
					{name: "Browse and respond", url: "browse_service_requests.php"},
					<?php 
						}
					?>
				]
			};
			menuItems.push(mi);
			mi = {
				name: "Settings",
				options: [
					{name: "Edit profile", url: "edit_profile.php"},

					<?php
					if(!is_enduser($current_user["id"])){
					?>
					{name: "Edit services", url: "edit_services.php"},
					<?php
					}
					?>
					{name: "Change password", url: "change_password.php"},
					{name: "Profile picture", url: "update_profile_picture.php"},
					<?php 

						if($current_user_type!=0 && is_enduser($current_user["id"])==0){
					?>
					{name: "Calendar", url: "calendar.php"},
					<?php 
						}
					?>
				]
			}
			menuItems.push(mi);
		}
		<?php
			
			if($current_user["username"]=="administrator"){
		?>

		// allowed only for admins (TODO)
		// replace 'true' with is_admin
		var menuItems = [
			{
				name: "Home",
				url: "http://madhwaconnect.com"
			},
			{
				name: "Dashboard",
				url: "admin.php"
			},
			{
				name: "Services",
				options: [
					{name: "All", url: "view_profiles.php"},
					{name: "Religious", options: [
						<?php
						foreach($usertypes as $ut){
							if($ut["id"]==$current_user_type ||
								$ut["relegious_yesno"]==0){
								continue;
							}
							?>
						{name: "<?php echo $ut["typename"];?>", url: "view_profiles.php?type=<?php echo $ut["id"];?>"},
							<?php
						}
						?>
					]},
					{name: "Value added", options: [
						<?php
						foreach($usertypes as $ut){
							if($ut["id"]==$current_user_type ||
								$ut["relegious_yesno"]==1){
								continue;
							}
							?>
						{name: "<?php echo $ut["typename"];?>", url: "view_profiles.php?type=<?php echo $ut["id"];?>"},
							<?php
						}
						?>
					]},
				]
			},
			{
				name: "Registrations",
				options: [
					{ name: "Pending for approvals", url: "registrations_pending_for_approval.php"},
					{ name: "Declined registrations", url: "declined_registrations.php"},
					{ name: "Suspended registrations", url: "suspended_registrations.php"},
				]
			},
			{
				name: "Messages",
				options: [
					{ name: "Broadcast", url: "broadcast.php"}
				]
			},		
			{
				name: "Users & Services",
				options: [
					{ name: "User types", url: "user_types.php"},
					{ name: "Services", url: "categories_and_services.php"}
				]
			},
			{
				name: "Settings",
				options: [
					{name: "Change password", url: "change_admin_password.php"},
				]
			}
		];

		<?php

				
			}
		?>

		// if(window.user_loggedin){
		// 	menuItems.push({
		// 		name: "Logout",
		// 		url: "logout.php"
		// 	});
		// }

		$('#menu_container').EZMenu(menuItems);
	});
</script>

<style type="text/css">
	body {
		/*font-family: verdana;
		font-size: 0.8em;*/
	}
	#main {
		/*width: 90%;*/
		margin: 0 auto;

	}
	#container ul.ez_menu {
		position: relative !important;
	}

	ul.menu_list li a {
		text-decoration: none;
		padding: 3px;
		margin: 3px;
		font-weight: bolder;

	}
	/*ul.menu_list li {
		background-color: rgba(200, 0, 0, .5);
		color: white;
	}*/


	ul.ez_menu ul.menu_list {
		/*font-size: 14px;*/
		width: 200px;
	}
</style>
