<?php include_once "header.php" ?>
<?php include_once "menu.php" ?>

<script type="text/javascript">
	$(function(){
		var options = {
			// dateFormat: 'yy-mm-dd'
			dateFormat: 'dd/mm/yy'
		};
		$(".date").datepicker(options);
	});
</script>

		<div id="advanced_search_container">
			<div class="advanced_search_header">
				<h1>Advanced Search</h1>
			</div>
			<form class="uiv2-form" action="view_profiles.php">
				<input type="hidden" name="search_type" value="advanced">
				<fieldset>
				    <div class="legend">You can search for specific people by filling in one or more of the following</div>

				    <div class="uiv2-form-row">
				    	<span class="uiv2-form-label">Date</span>
				        <div class="uiv2-form-input">
				        	<span>
				        		<input type="text" id="date" name="date" size="15"
				        			class="date" />
				        	</span>
				        	<span class="error" id="error_date"></span>
				        </div>
				    </div>

				    <div class="uiv2-form-row">
				    	<span class="uiv2-form-label">Place</span>
				        <div class="uiv2-form-input">
				        	<span>
				        		<input type="text" id="place" name="place" size="15" />
				        	</span>
				        	<span class="error" id="error_place"></span>
				        </div>
				    </div>


				    <div class="uiv2-form-row">
				    	<script type="text/javascript">
							var usertypeFields = {};
						</script>
				    	<span class="uiv2-form-label">Category</span>
				        <div class="uiv2-form-input">
				        	<span>
				        		<select name="usertype" id="type" class="dropdown">
									<option value="-1"></option>

									<?php
										include_once "config.php";
										$usertypes = R::getAll("select * from usertypes order by typename");
										
										foreach($usertypes as $usertype){
											echo "<option value='{$usertype['id']}'>{$usertype['typename']}</option>";

											?>
											<script type="text/javascript">
												usertypeFields["<?php echo $usertype['id']; ?>"] = "<?php echo $usertype['fields']; ?>";
											</script>
											<?php
										}
									?>
								</select>
				        	</span>
				        	<span class="error" id="error_category"></span>
				        </div>
				    </div>
				    <div class="gap"></div>
				    <div class="uiv2-form-row">
				    	<span class="uiv2-form-label">&nbsp;</span>
				        <div class="uiv2-form-input">
				        	<span>
				        		<button class="submit">Search</button>
				        	</span>
				        </div>
				    </div>
				    
				</fieldset>
			</form>
		</div>

<?php include_once "footer.php" ?>