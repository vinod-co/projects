<?php
	$sql = "select ut.id as id, ut.typename as typename, count(u.id) as user_count from usertypes ut join users u on ut.id = u.usertype group by ut.id, ut.typename order by ut.typename";

	$data = R::getAll($sql);
?>

<form class="uiv2-form">
<fieldset>
	<div class="legend">User count based on type of users</div>
	<div class="uiv2-form-row">
		<ul>
		<?php
			foreach($data as $d){
				echo "<li><a href='view_profiles.php?type=" . $d["id"] . "'>" . $d["typename"] . "</a> (" . $d["user_count"] . ")</li>";
			}
		?>
		</ul>
	</div>
</fieldset>
</form>