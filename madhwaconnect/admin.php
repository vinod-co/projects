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

<?php include_once "config.php"; ?>

<?php include_once "menu.php"; ?>

<div id="admin_options_container">

	<div id="admin_options_header">
		<h1>Administrator dashboard</h1>
	</div>

	<div id="report_1" class="reports">
		<?php include_once "admin_reports_1.php"; ?>
	</div>
	<div id="report_2" class="reports">
		<?php include_once "admin_reports_2.php"; ?>
	</div>
	<div id="report_3" class="reports">
		<?php include_once "admin_reports_3.php"; ?>
	</div>
</div>

<?php include_once "footer.php"; ?>