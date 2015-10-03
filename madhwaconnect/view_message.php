<?php

	// view_message.php

	$message_id = null;
	if(isset($_REQUEST["message_id"])){
		$message_id = $_REQUEST["message_id"];
	}


	include_once "config.php";

	$curr_user = get_from_session("current_user");
	if(is_null($curr_user)){
		store_in_session("message", "you must login to access this page.");
		header("Location: index.php");
		return;		
	}	

	$my_id = $curr_user["id"];

	$sql = "select * from messages where ? in (from_id, to_id) and id = ?";
	$data = R::getRow($sql, array($my_id, $message_id));

	if(is_null($data)){
		store_in_session("message", "You are trying to access a message that either does not exist or not meant for you.");
		header("Location: index.php");
		return;		
	}


	$sql = "select * from view_user_messages where message_id = ?";
	$data = R::getRow($sql, array($message_id));
	$fnCommunicate_userId = $data["from_id"];
	$from_fullname = $data["from_id"]==0?"Administrator": $data["from_fullname"];
	$thread_id = $data["thread_id"];	

	$sql = "update messages set is_read=1 where thread_id = ? and to_id = ?";
	R::exec($sql, array($thread_id, $my_id));


	$sql = "select * from messages where thread_id = ? order by message_sent_datetime";
	$messages = R::getAll($sql, array($thread_id));
?>
<?php include_once "header.php"; ?>
<style type="text/css">
	@import "css/experiment.css";
</style>
<script type="text/javascript">
	window.fnCommunicate_userId = <?php echo $fnCommunicate_userId; ?>;
</script>

<?php include_once "menu.php"; ?>

<div id="view_message_container">
	<div id="view_message_header">
		<h1>Conversations with <?php echo $from_fullname; ?></h1>
	</div>

	<div class="db-main-table">
	<table cellspacing = "0" style="table-layout: fixed; width: 100%">
		<tbody>
		<?php
			foreach($messages as $d){
				if($d["from_id"] == $my_id){
					$css = "class=\"unread\"";
				}
				else{
					$css = "";
				}
		?>
		<tr <?php echo $css; ?>>
			<td style="width: 200px !important; vertical-align: top !important; ">
				<?php echo date("d/m/Y h:i:s", strtotime($d["message_sent_datetime"])); ?>
			</td>
			<td>
			<b><?php 
				if($d["from_id"]==$my_id){
					echo "Me";
				}
				else{
					echo $from_fullname;
				} 
			?>: </b>
			<div style="white-space: pre-wrap"><?php echo $d["message_text"]; ?></div>
			</td>
		</tr>
			<?php
		}
	?>

	<?php if($data["from_id"]!=0){ ?>
		<tr class="unread">
			<td style="background-color: #ddd;">&nbsp;</td>
			<td style="background-color: #ddd;">
				<form class="classic" method="POST" onsubmit="return false;">
				<input type="hidden" id="thread_id" name="thread_id" 
					value="<?php echo $thread_id; ?>" />
				<p>Send <?php echo $from_fullname; ?> a message</p>
				<p>
					<textarea style="font: inherit; resizable: false; width: 100%; height: 150px" 
						id="message_text" name="message_text" ></textarea> 
					<span class="error" id="error_message_text"></span>
				</p>
				<p>
					<span class="error" id="message_text_error"></span>
				</p>
				<p>
					<button class="submit" onclick="fnReplyToMessage(this.form)">Submit</button>
				</p>
				</form>
			</td>
		</tr>
	<?php } ?>
	</tbody>
	</table>
	</div>

<script type="text/javascript">
	$(function(){
		$("html, body").animate({ scrollTop: $(document).height() }, "slow");
		return false;
	});
</script>

</div>
<?php include_once "footer.php"; ?>
