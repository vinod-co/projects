<?php	
	// browse_service_requests.php
?>
<?php include_once "config.php"; ?>
<?php include_once "header.php"; ?>
<?php include_once "functions.php"; ?>

<?php
	$current_user = get_from_session("current_user");
	if($current_user==null){
		store_in_session("message", "You must login to access this page");
		store_in_session("redirect_to", "browse_service_requests.php");
		header("Location: ./login_f.php");
		return;
	}
?>
<style type="text/css">
	@import "css/experiment.css";
</style>
<?php include_once "menu.php"; ?>

<div id="browse_service_requests_container">
	<div id="browse_service_requests_header">
		<h1>Service requests for you</h1>
	</div>


<?php
	$sql = "select * from view_service_requests vsr "
		. "where target_usertype = ? and status=? and id not in "
		. "(select sr_id from srresponses where response_from_id=? and sr_id=vsr.id) "
		. "order by id desc";
	// echo $sql . "<br />";
	// echo $current_user["usertype"] . "<br />";
	// echo $current_user["id"] . "<br />";

	$data = R::getAll($sql, 
		array($current_user["usertype"], "open", $current_user["id"]));
	$count = count($data);	

	if($count == 0){
		?>
		<h3>There are no service requests for you at this time</h3>
		<?php
	}
	else{
		?>
		<h3>You have <?php echo  $count; ?> service request<?php echo $count>1?"s":"";?></h3>
		<?php
?>
<p>

	<a href="view_sr_history.php">View history</a>
</p>
<div class="db-main-table">
<table cellspacing = "0" style="width: 100%">
	<thead>
	<tr>
		<td style="width: 300px">Title</td>
		<td>Requested by</td>
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
			<?php echo $d["firstname"] . " " . $d["lastname"]; ?>
		</td>
		<td>
			<?php echo $d["created_datetime"]; ?>
		</td>
		<td>
			<span style="display:none; " class="service_description"><?php echo $d["service_description"]; ?></span>
			<button class="submit" data-id="<?php echo $d["id"]; ?>" 
				data-to_id="<?php echo $d["created_by"]; ?>" data-action="respond">Respond</button>
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

<div id="dlg_respond_to_service_request">
	<form>
		<input type="hidden" name="to_id"  id="to_id" />
		<input type="hidden" name="response_to"  id="response_to" />
		<input type="hidden" name="sr_id"  id="sr_id" />
		
		<h1>Service request by <span id="requested_by"></span></h1>
		<p>
			<span id="title"></span>
		</p>
		<p>
			<span id="service_description"></span>
		</p>
		<hr />
		<p>Your response:</p>
		<textarea id="message_text" 
			style="width: 550px; height: 150px; font-family: inherit; "></textarea>
		<p>
			<button class="submit" id="submit_response">Submit my response</button>
			&nbsp;&nbsp;
			<span style="cursor: pointer; text-decoration: underline; " 
				class="close_dlg_respond_to_service_request">Cancel</span>

			<script type="text/javascript">
				$(".close_dlg_respond_to_service_request").click(function(){
					$("#dlg_respond_to_service_request").dialog("close");
				});
			</script>
		</p>
	</form>
</div>

<script type="text/javascript">
	$(function(){
		var options = {
			width: 600,
			resizable: false,
			draggable: false,
			autoOpen: false,
			modal: true
		};
		$("#dlg_respond_to_service_request").dialog(options);

		$("button[data-action=respond]").click(function(){
			var tds = $(this).closest("tr").find("td");

			var sr_id = $("button[data-action=respond]").attr("data-id");
			var created_by = $("button[data-action=respond]").attr("data-to_id");
			var title = $(tds[0]).html().trim();
			var requested_by = $(tds[1]).html().trim();
			var service_description = $(tds[3]).find("span").html().trim();
			
			$("#dlg_respond_to_service_request input#sr_id").val(sr_id);
			$("#dlg_respond_to_service_request input#to_id").val(created_by);
			$("#dlg_respond_to_service_request input#response_to").val(title);
			$("#dlg_respond_to_service_request span#title").html(title);
			$("#dlg_respond_to_service_request span#requested_by").html(requested_by);
			$("#dlg_respond_to_service_request span#service_description").html(service_description);

			$(".ui-dialog-titlebar").css("display", "none");
			$("#dlg_respond_to_service_request").dialog("open");
		});

		$("button#submit_response").click(function(){
			fnPostMessage($(this).closest("form"));
		});

	});
</script>

<?php include_once "footer.php"; ?>
