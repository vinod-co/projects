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

?>
<style type="text/css">
	.serviceitem {
		width: 250px;
		display: inline-block;
	}

</style>
<?php include_once "menu.php"; ?>
<div id="edit_services_container">
	<div class="edit_services_header">
		<h1>Edit services</h1>
	</div>

	<form class="uiv2-form" method="POST" 
		action="edit_services_action.php">

		<?php
			$current_user_services = get_services_for_user($current_user["id"]);

			$sql = "select * from categories where usertype=? order by category";
			$categories = R::getAll($sql, array($current_user["usertype"]));


			foreach($categories as $category){
		?>
		<div id="category<?php echo $category["id"]; ?>">
			<fieldset>
				<div class="legend"><?php echo $category["category"]; ?></div>
				<div style="padding: 20px 20px 0;">
					<span class="linkSelectAll">Select all</span> 
					<span class="linkDeselectAll">Deselect all</span> 
				</div>
				<div style="padding: 20px;">
					<?php
						$sql = "select * from services where category_id=? order by service";
						$services = R::getAll($sql, array($category["id"]));

						foreach($services as $service){
							?>
							<span class="serviceitem"><input type="checkbox" id="service" name="service[]" 
								<?php
									if(in_array($service["id"], $current_user_services)){
										echo "checked";
									}
								?>
								value="<?php echo $service["id"]; ?>">
							<?php echo $service["service"]; ?></span>
							<?php
						}
					?>
				</div>
			</fieldset>
		</div>
		<?php
			}
		?>
		

		<p>
			<button class="submit">Update</button>
			<a href="./" >Cancel</a>
		</p>

	</fieldset>
</form>


<script type="text/javascript">
	$(function(){
		$("span.linkSelectAll").click(function(){
			var checkboxes = $(this).closest("fieldset").find("input[type=checkbox]");
			checkboxes.prop("checked", true);
		});		
		$("span.linkDeselectAll").click(function(){
			var checkboxes = $(this).closest("fieldset").find("input[type=checkbox]");
			checkboxes.prop("checked", false);
		});	
	});
</script>
<?php include_once "footer.php"; ?>