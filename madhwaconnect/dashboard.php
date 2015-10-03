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
	// dashboard.php

	include_once "config.php"; 



?>
<?php // opening h1 tag is in the header.php ?>
Dashboard
</h1>
<?php include_once "menu.php"; ?>




<?php include_once "footer.php"; ?>
