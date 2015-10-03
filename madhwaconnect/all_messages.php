<?php

	// all_messages.php
	include_once "config.php";


	$current_user = get_from_session("current_user");

	if(is_null($current_user)){
		store_in_session("message", "You must login to access this page");
		header("Location: index.php");
		return;
	}

	$sql = "select count(*) from messages where to_id=? and is_read=0";
	$count = R::getCol($sql, array($current_user["id"]));
	$count = $count[0];

?>
<?php include_once "header.php"; ?>
<style type="text/css">
	@import "css/experiment.css";
</style>

<?php include_once "menu.php"; ?>

<div id="all_messages_container">
	<div id="all_messages_header">
		<h1>All messages</h1>
	</div>

<?php
	if($count == 0){
		?>
		<h3>You have no new messages :-(</h3>
		<?php
	}
	else{
		?>
		<h3>You have <?php echo  $count; ?> unread message<?php echo $count>1?"s":"";?></h3>
		<?php
	}
?>

<div class="db-main-table">
<table cellspacing = "0" style="width: 100%">
	<thead>
	<tr>
		<td style="width: 50px">&nbsp;</td>
		<td style="width: 200px">Sender</td>
		<td>Last message</td>
		<td style="width: 200px">Sent on</td>
	</tr>
	</thead>
	<tbody>
<?php
	$data = R::getAll("select * from view_user_messages where to_id = ?", 
		array($current_user["id"]));
	foreach($data as $d){

		$css="";
		if($d["is_read"]==0){
			$css = "class=\"unread\"";
		}
		?>
	<tr <?php echo $css; ?>>
		<td>&nbsp;</td>
		<td>
			<a href="view_message.php?message_id=<?php echo $d["message_id"];?>" >
			<?php echo $d["from_id"]==0?"Administrator":$d["from_fullname"]; ?>
			</a>
		</td>
		<td>
			<a href="view_message.php?message_id=<?php echo $d["message_id"];?>" >
			<?php echo $d["message_part"]; ?>
			</a>
		</td>
		<td>
			<a href="view_message.php?message_id=<?php echo $d["message_id"];?>" >
			<?php echo date("d/m/Y h:i:s", strtotime($d["message_sent_datetime"])); ?>
			</a>
		</td>
	</tr>
		<?php
	}
?>
</tbody>
</table>
</div>

</div>


<?php include_once "footer.php"; ?>
