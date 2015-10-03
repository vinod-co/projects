<?php
	// my_service_requests.php
?>
<?php include_once "config.php"; ?>
<?php include_once "header.php"; ?>
<style type="text/css">
	@import "css/experiment.css";
</style>
<?php include_once "menu.php"; ?>

<div id="my_service_requests_container">
	<div id="my_service_requests_header">
		<h1>My service requests</h1>
	</div>


<?php
	$data = R::getAll("select * from view_service_requests where created_by = ?", 
		array($current_user["id"]));
	$count = count($data);	

	if($count == 0){
		?>
		<h3>You haven't created any service requests</h3>
		<a href="create_new_service_request.php">Click here</a> to create one.
		<?php
	}
	else{
		?>
		<h3>You have <?php echo  $count; ?> service request<?php echo $count>1?"s":"";?></h3>
		<?php
	
	
?>

<div class="db-main-table">
<table cellspacing = "0" style="width: 100%">
	<thead>
	<tr>
		<td style="width: 300px">Title</td>
		<td>Target users</td>
		<td>Status</td>
		<td style="width: 200px">Created on</td>
		<td>Action</td>
	</tr>
	</thead>
	<tbody>
<?php
	foreach($data as $d){

		?>
	<tr>
		<td>
			<?php echo $d["title"]; ?>
		</td>
		<td>
			<?php echo $d["typename"]; ?>
		</td>
		<td>
			<?php echo strtoupper($d["status"]); ?>
		</td>
		<td>
			<?php echo $d["created_datetime"]; ?>
		</td>
		<td>
			<?php
				if($d["status"]=="open"){
					?>
			<button class="submit" data-action="close">Close</button>
					<?php
				}
				else {
					?>
			<button class="submit" data-action="reopen">Reopen</button>
					<?php
				}
			?>
		</td>
	</tr>
		<?php
	}
?>
</tbody>
</table>
</div>

<?php

	}
?>
</div>
<?php include_once "footer.php"; ?>
