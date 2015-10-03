<?php
	// registrations_pending_for_approval.php

	include_once "config.php";


	$current_user = get_from_session("current_user");

	if(is_null($current_user)){
		store_in_session("message", "You must login to access this page");
		header("Location: index.php");
		return;
	}

	$data = R::getAll("select * from users where registration_status = 'pending'");
	$count = count($data);
?>
<?php include_once "header.php"; ?>
<style type="text/css">
	@import "css/experiment.css";
</style>

<?php include_once "menu.php"; ?>

<div id="registrations_pending_for_approval_container">

	<div id="registrations_pending_for_approval_header">
		<h1>Registrations pending for approval</h1>
	</div>



<?php
	if($count == 0){
		?>
		<h3>No new registrations :-(</h3>
		<?php
	}
	else{
		?>
		<h3><span id="reg_count"><?php echo  $count; ?></span> new registration<?php echo $count>1?"s":"";?></h3>
		<?php
	}
?>

<div class="db-main-table">
<table cellspacing = "0" style="width: 100%">
	<thead>
	<tr>
		<td style="width: 50px">&nbsp;</td>
		<td style="width: 200px">Name</td>
		<td style="width: 200px">Cellphone</td>
		<td style="width: 200px">Email</td>
		<!-- <td style="width: 200px">Address</td> -->
		<td>Action</td>
	</tr>
	</thead>
	<tbody>
<?php

	foreach($data as $d){

		?>
	<tr>
		<td>&nbsp;</td>
		<td>
			<a href="view_one_profile_for_approve_decline.php?id=<?php echo $d["id"]; ?>&discriminator=1">
				<?php echo $d["firstname"]; ?> <?php echo $d["lastname"]; ?>
			</a>
		</td>
		<td>
			<?php echo $d["cellphone"]; ?>
		</td>
		<td>
			<?php echo $d["email"]; ?>
		</td>
		<!-- <td>
			<?php echo $d["addr1"]; ?> <?php echo $d["addr2"]; ?>
			<?php echo $d["city"]; ?> <?php echo $d["state"]; ?>
		</td> -->
		<td>
			<button class="submit" data-userid="<?php echo $d["id"]; ?>" data-status="approved">Approve</button>
			<button class="submit" data-userid="<?php echo $d["id"]; ?>" data-status="declined" style="background-color: red; ">Decline</button>
		</td>
	</tr>
		<?php
	}
?>
</tbody>
</table>
</div>
<script type="text/javascript">
	$(function(){
		$("button.submit").click(function(){
			var me = $(this);
			$.ajax({
				invoker: me,
				method: "POST",
				url: "change_registration_status.php",
				data: {
					userid: $(this).attr("data-userid"),
					status: $(this).attr("data-status")
				},
				success: function(data){
					debugger;
					if(typeof(data)=="string"){
						data = JSON.parse(data);
					}
					
					if(data.status==true){
						$(this.invoker).closest("tr").remove();
						var regCount = parseInt($("#reg_count").text())-1;
						if(regCount==0){
							$("#reg_count").parent().html("No new registrations :-(");
						}
						else{
							$("#reg_count").text(regCount);
						}
					}
				}
			});
		});
	});
</script>


</div>

<?php include_once "footer.php"; ?>
