<?php
	$sql = "select count(*) dd from users where datediff(sysdate(), date_of_registration) <= ?";

	$days = array(7, 15, 30, 60);
	
?>

<form class="uiv2-form">
<fieldset>
	<div class="legend">New registrations since last</div>
	<div class="uiv2-form-row">
		<ul>
		<?php
			foreach($days as $d){
				$data = R::getCell($sql, array($d));
				echo "<li><a href='view_profiles.php?search_type=report_2&days={$d}'>{$d} days</a> ({$data})</li>";
			}
		?>
		</ul>
	</div>
</fieldset>
</form>