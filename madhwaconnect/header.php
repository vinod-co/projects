<?php include_once "check_for_auto_login.php"; ?>
<?php
	include_once "config.php";
	include_once "functions.php";

	function endsWith($haystack, $needle){
		return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
	}

	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	
	if(isset($_SESSION["current_user"])){
		$current_user = $_SESSION["current_user"];
		$current_user_fullname = $current_user["firstname"] . " " . $current_user["lastname"];
		$user_loggedin = true;
	}
	else{
		$user_loggedin = false;
	}
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="jquery/jquery-ui.css">
	<link href="css/default.css" rel="stylesheet" type="text/css" >
	<link href="css/form.css" rel="stylesheet" type="text/css" >

	<style type="text/css">
		@import /**/"ezmenuapi/jquery.ez.menu.min.css";

	</style>

	<script src="jquery/jquery-2.1.1.min.js"></script>
	<script src="jquery/jquery-ui.min.js"></script>

	<script src="ezmenuapi/jquery.ez.menu.min.js">
	</script>

	<script type="text/javascript">
		var user_loggedin = false;
		<?php if($user_loggedin==true){
			?>
			user_loggedin = true;
			<?php
		}
		?>
	</script>

	<script src="script/utilities.js">
	</script>



	<!--
<script type="text/javascript" src="script/menu.js">
	</script>
-->


	<title>Madhwa Connect</title>

</head>
<body>
<?php
	$show_header = true;
	if(isset($_REQUEST["nh"])){
		$show_header = false;
	}

	if($show_header){
?>
<div class="top-strip">
	<div class="top-strip-wrapper">
		<div class="top-strip-left">
			<form action="view_profiles.php" style="float: left; margin-right: 30px;">
				<input type="hidden" name="search_type" value="regular" >
				<input class="search-box" placeholder="Search..." 
					onclick="this.style.border='none'" name="search_token"/>
				<!-- <input type="submit" value="Search" /> -->
			</form>
			<a href="advanced_search.php" 
				style="margin-top: 5px; height: 30px; display: inline-block;">Advanced search</a>
		</div>
		<div class="top-strip-right"
			style="margin-top: 5px; height: 30px; ">
			<?php
				// check for login status and if logged in, 
				// replace the following div content with Currently logged in user's name
				// and provide a button to logout

				if($user_loggedin==true){
			?>
			<span title="<?php echo $current_user_fullname . '(' . 
				get_usertype($current_user["usertype"]) . ')'; ?>">
			Welcome <?php echo $current_user_fullname; ?> </span>
			<span style="width: 20px; display: inline-block; "></span>
			<a href="logout.php">Logout</a> 
			<?php
				}
				else {
			?>


			<a href="login_f.php?nh" id="login_link">Login</a> | 
			<a href="register.php?nh">Register</a> 
			<?php
				}
			?>
		</div>
	</div>
</div>
<?php } ?>
<div id="container" class="container">
		<div class="header">
		<a href="./">
		<div class="header-logo"></div>
		</a>
		</div>
		
		<div class="main-wrapper"> 

