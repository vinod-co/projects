<?php

	// categories_and_services.php

	include_once "config.php";

	$current_user = get_from_session("current_user");

	if(is_null($current_user)){
		store_in_session("message", "You must login to access this page");
		header("Location: index.php");
		return;
	}

	// TODO
	// check for admin role



?>
<?php include_once "header.php"; ?>
<style type="text/css">
	@import "css/experiment.css";
	/*.ui-dialog-titlebar {
		display: none;
	}*/
</style>

<?php include_once "menu.php"; ?>

<div id="categories_and_services_container">
	<div id="categories_and_services_header">
		<h1>Categories and services</h1>
	</div>

<form class="classic">
	<fieldset>
		<legend>Add a category and services under the same</legend>
			<p>
				<label>Choose a usertype</label>
				<select id="usertype" name="usertype">
					<?php
						foreach($usertypes as $ut){
							?>
							<option value="<?php echo $ut["id"]; ?>"><?php echo $ut["typename"]; ?></option>
							<?php
						}
					?>
				</select>
			</p>
			<p>
				<label>Category</label>
				<input id="category" name="category" type="text" />
			</p>
			<p>
				<label style="top: -120px; position: relative; ">Enter the list of services<br />
					(Each service in separate lines)
				</label>

				<textarea id="services" name="services" style="width: 600px; height: 150px"></textarea>
			</p>
			<p>
				<button type="button" class="submit" id="btnSaveCategory">Save</button>

				&nbsp; &nbsp;

				<a href="javascript:void()" id="cancel">Cancel</a>
			</p>
	</fieldset>
	
	
</form>

<div class="gap"></div>

<div class="db-main-table">
<table cellspacing = "0" style="width: 100%">
	<thead>
	<tr>
		<td style="width: 50px">&nbsp;</td>
		<td style="width: 200px">Usertype</td>
		<td style="width: 200px">Category</td>
		<td>Services</td>
	</tr>
	</thead>
	<tbody>
<?php
	$data = R::getAll("select * from view_categories");

	foreach($data as $d){

		?>
	<tr class="unread">
		<td>
		</td>
		<td style="vertical-align: top; ">
				<?php echo $d["usertype"]; ?>
		</td>
		<td style="vertical-align: top; ">
			<a href="javascript:void()" data-category-id="<?php echo $d["category_id"]; ?>" 
				data-action="delete" style="display: inline-block">
				<img src="images/trash.png" style="width: 20px;"
					title="Delete '<?php echo $d["category"]; ?>'" />
			</a>
			<span>&nbsp;&nbsp;&nbsp;&nbsp;</span>
			<?php echo $d["category"]; ?>
		</td>
		<td style="white-space: normal; ">
			<?php
				$sql = "select * from services where category_id=?";
				$services = R::getAll($sql, array($d["category_id"]));
				foreach($services as $service){
					?>
			<a href="javascript:void" data-serviceid="<?php echo $service["id"];?>"
				style="display: inline-block; "
				data-action="edit-or-delete-service"><?php echo $service["service"];?></a>
				<span>, </span>
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

<div id="dlgEditOrDeleteService">
	<div class="gap"></div>
	<form>
		<input type="hidden" id="id" name="id">
		<input type="text" id="service" name="service"  style="font-size: 1em !important; "/>
		<p>
			<button type="button" class="submit" data-action="save-changes">Save</button>
			<button type="button" class="submit" data-action="delete-service">Delete</button>
			<a href="javascript:void()" id="linkCancel">Cancel</a>
		</p>
	</form>
</div>

<script type="text/javascript">

	$(function(){
		$("a[data-action=delete]").click(function(){
			var idToDelete = $(this).attr("data-category-id");
			$("#dialog-confirm").html("Are you sure to delete?");
			var options = {
				resizable: false,
				modal: true,
				title: "MadhwaConnect - Confirm",
				height: 150,
				width: 300,
				autoOpen: true,
				buttons: {
					"Yes": function () {
						$(this).dialog('close');

						$.ajax({
							url: "check_and_delete_category.php",
							data: {
								id: idToDelete
							},
							success: function(resp){
								if(typeof(resp)=="string"){
									resp = JSON.parse(resp);
								}

								if(resp.status==true){
									window.location.reload();
								}
								else{
									alert(resp.message);
								}
							}
						});
					},
						"No": function () {
						$(this).dialog('close');
					}
				}
			};
			$("#dialog-confirm").dialog(options);
		});
	});		
</script>

<script type="text/javascript">
	$(function(){

		$("#btnSaveCategory").click(function(){
			$.ajax({
				url: "save_category.php",
				data: $(this).closest("form").serialize(),
				success: function(resp){
					if(typeof(resp)=="string"){
						resp = JSON.parse(resp);
					}

					if(resp.status==true){
						window.location.reload();
					}
					else{
						fnShowMessage(resp.message);
					}
				}
			});
		});

	});
</script>

<script type="text/javascript">
	$(function(){
		var options = {
			autoOpen: false,
			modal: true,
			draggable: false,
			resizable: false,
			width: 350,
			height: 160,
			title: "Edit/Delete service"
		};
		$("#dlgEditOrDeleteService").dialog(options);
		$("a[data-action='edit-or-delete-service']").click(function(){
			$("#dlgEditOrDeleteService").find("#id").val($(this).attr("data-serviceid"));
			$("#dlgEditOrDeleteService").find("#service").val($(this).text());
			$("#dlgEditOrDeleteService").dialog("open");
		});

		$("#dlgEditOrDeleteService a#linkCancel").click(function(){
			$("#dlgEditOrDeleteService").dialog("close");
		});

		$("#dlgEditOrDeleteService button[data-action='save-changes']").click(function(){
			var id = $(this).closest("form").find("input#id").val();
			var service =  $(this).closest("form").find("input#service").val();

			$.ajax({
				url: "update_service.php",
				data: {
					id: id,
					service: service
				},
				success: function(resp){
					if(typeof(resp)=="string"){
						resp = JSON.parse(resp);
					}

					if(resp.status==true){
						$("div.db-main-table a[data-serviceid="+
							id +"]").text(service);
						$("#dlgEditOrDeleteService").dialog("close");
					}
					else{
						alert(resp.message);
					}
				}
			});
		});

		$("#dlgEditOrDeleteService button[data-action='delete-service']").click(function(){
			var id = $(this).closest("form").find("input#id").val();

			$.ajax({
				url: "check_and_delete_service.php",
				data: {
					id: id
				},
				success: function(resp){
					if(typeof(resp)=="string"){
						resp = JSON.parse(resp);
					}

					if(resp.status==true){
						$("div.db-main-table a[data-serviceid="+
							id +"]+span").remove();
						
						$("div.db-main-table a[data-serviceid="+
							id +"]").remove();
						$("#dlgEditOrDeleteService").dialog("close");
					}
					else{
						alert(resp.message);
					}
				}
			});
		});
	});
</script>


</div>

<?php include_once "footer.php"; ?>
