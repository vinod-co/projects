<?php

	// user_types.php

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
</style>
<?php include_once "menu.php"; ?>
<div id="usertypes_container">
	<div class="usertypes_header">
		<h1>User types</h1>
	</div>
	<form class="classic" id="form_add_edit_usertype">
		<input type="hidden" id="id" name="id" value="" />
		<fieldset>
			<legend>Add / Edit user type</legend>
				<p>
					<label>User type</label>
					<input id="typename" name="typename" type="text" />
				</p>
				<p>
					<label>Description</label>
					<input type="text" id="description" name="description" style="width: 600px"/>
				</p>
				<p>
					<label>&nbsp;</label>
					<span class="span_for_checkbox_label">
					<input type="checkbox" id="approval_required" name="approval_required" value="1" />
					When a new user is created for this type, admin must approve/decline.
					</span>
				</p>
				<p>
					<label>&nbsp;</label>
					<span class="span_for_checkbox_label">
					<input type="checkbox" id="not_listed_in_search" name="not_listed_in_search" value="1" />
					Users of this type should not be listed in the search results
					</span>
				</p>
				<p>
					<label>&nbsp;</label>
					<span class="span_for_checkbox_label">
					<input type="radio" id="relegious_yesno_1" 
						name="relegious_yesno" value="1"
						checked="checked" />
					Relegious
					<input type="radio" id="relegious_yesno_0" 
						name="relegious_yesno" value="0" />
					Value added
					
					</span>
				</p>
				<p>
					<fieldset>
						<legend>Fields to display during new user registration</legend>

						<div>
							<span class="linkSelectAll">Select all</span> 
							<span class="linkDeselectAll">Deselect all</span> 
						</div>
						<div class="gap"></div>
	<?php
		$fields = array("another_cellphone"=>"Another cellphone", 
			"landline"=>"Landline", 
			"another_landline"=>"Another landline", 
			"another_email"=>"Another email", 
			"company_name"=>"Company Name", 
			"exp_years"=>"Experience (Years)", 
			"exp_months"=>"Experience (Months)", 
			"profession"=>"Profession", 
			"gotra"=>"Gotra", 
			"matha"=>"Mutt", 
			"qualification"=>"Qualification", 
			"additional_info"=>"Additional info");

		foreach($fields as $fk=>$fv){
			?>
				<span class="span_for_checkbox_label field_choices">
					<input type="checkbox" name="fields[]" 
						id="chk_<?php echo $fk; ?>"
						value="<?php echo $fk; ?>" /> <?php echo $fv; ?></span>
			<?php
		}
	?>
					</fieldset>
				</p>
				<p>
					<button type="button" class="submit" id="btnSaveUsertype">Save</button>

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
			<td style="width: 200px">User type</td>
			<td style="width: 400px">Description</td>
		</tr>
		</thead>
		<tbody>
	<?php
		$data = R::getAll("select * from usertypes order by typename");
		$count = count($data);
		foreach($data as $d){

			?>
		<tr class="unread">
			<td>
				<a href="javascript:void()" data-usertypeid="<?php echo $d["id"]; ?>" 
					data-action="edit" style="display: inline-block">
					<img src="images/edit.png" style="width: 20px;"
						title="Edit '<?php echo $d["typename"]; ?>'" />
				</a>
				<span>&nbsp;&nbsp;&nbsp;&nbsp;</span>
				<a href="javascript:void()" data-usertypeid="<?php echo $d["id"]; ?>" 
					data-action="delete" style="display: inline-block">
					<img src="images/trash.png" style="width: 20px;"
						title="Delete '<?php echo $d["typename"]; ?>'" />
				</a>
			</td>
			<td>
					<?php echo $d["typename"]; ?>
			</td>
			<td>
				<div style="width: 700px; text-overflow: ellipsis; white-space: nowrap; overflow: hidden;">
				
				<?php echo $d["description"]; ?>
				</div>
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
			$("a[data-action=edit]").click(function(){
				var id = $(this).attr("data-usertypeid");

				$.ajax({
					async: false,
					url: "get_usertype_info.php",
					data: {
						id: id
					},
					success: function(resp){
						if(typeof(resp)=="string"){
							resp = JSON.parse(resp);
						}
						if(resp.status==true){
							$("input#id").val(id);
							$("input#typename").val(resp.data.typename);
							$("input#description").val(resp.data.description);

							if(resp.data.approval_required==1){
								$("input#approval_required").prop("checked", true);
							}
							else{
								$("input#approval_required").prop("checked", false);	
							}

							if(resp.data.not_listed_in_search==1){
								$("input#not_listed_in_search").prop("checked", true);
							}
							else{
								$("input#not_listed_in_search").prop("checked", false);	
							}

							if(resp.data.relegious_yesno==1){
								$("input#relegious_yesno_1").prop("checked", true)
							}
							else {
								$("input#relegious_yesno_0").prop("checked", true)
							}
							

							$(".field_choices input[type='checkbox']").prop("checked", false);
							$.each(resp.data.fields, function(i, v){
								$("#chk_"+v).prop("checked", true);
							});	

							// bring the screen to the top slowly
							// and the cursor to the first textbox
							$("html, body").animate({ 
								scrollTop: $("body").position().top 
							}, "slow", function(){
								$("#typename").focus();
							});
					
						}
						else{
							alert(resp.message);
						}

					}
				});

			});
		});

		$(function(){
			$("a[data-action=delete]").click(function(){
				var idToDelete = $(this).attr("data-usertypeid");
				// confirm deletion
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
								url: "check_and_delete_usertype.php",
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
										fnShowMessage(resp.message);
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

		$(function(){
			$("#btnSaveUsertype").click(function(){
				$.ajax({
					method: "POST",
					url: "save_usertype.php",
					data: $(this).closest("form").serialize(),
					success: function(resp){
						if(typeof(resp)=="string"){
							resp = JSON.parse(resp);
						}
						if(resp.status==true){
							//window.location.reload();
						}
						else{
							alert(resp.message);
						}
					},

				});
			});

			$("a#cancel").click(function(){
				$("#form_add_edit_usertype")[0].reset();
				$("input#id").removeAttr("value");
				$("#form_add_edit_usertype").find("input[type=checkbox]").prop("checked", false);
				$("input#usertype").focus();
			});

			$(".span_for_checkbox_label").css("cursor", "pointer");
			$(".field_choices").css({width: "250px", display: "inline-block"});

			$(".span_for_checkbox_label").click(function(){
				var val = $(this).find("input[type=checkbox]").prop("checked");
				$(this).find("input[type=checkbox]").prop("checked", !val);
			});

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
</div>
<?php include_once "footer.php"; ?>