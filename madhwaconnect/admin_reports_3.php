<?php
	$sql = "select trim(city) as city, count(*) as user_count from users group by city order by city";
	$data = R::getAll($sql);
?>

<form class="uiv2-form">
<fieldset>
	<div class="legend">User count based on city and type of users</div>
	<div class="uiv2-form-row">
		<ul>
		<?php
			foreach($data as $d){
				$city = $d["city"];
				if($city==null || $city==""){
					$city = "Others";
				}
				$user_count = $d["user_count"];

				echo "<li><a href='view_profiles.php?search_type=report_3&city={$city}'>{$city}</a> ({$user_count})</li>";

				$sql = "select ut.id as id, typename, count(u.id) as user_count from usertypes ut join users u on ut.id = u.usertype where u.city = ? group by ut.id, typename;";
				if($city=="Others"){
					$city = "";
				}
				$data1 = R::getAll($sql, array($city));
				echo "<ul>";
				foreach ($data1 as $d1) {
					$id = $d1["id"];
					$typename = $d1["typename"];
					$user_count = $d1["user_count"];

					echo "<li><a href='view_profiles.php?search_type=report_3&usertype={$id}&city={$city}&typename={$typename}'>{$typename}</a> ({$user_count})</li>";
				}
				echo "</ul>";
			}
		?>
		</ul>
	</div>
</fieldset>
</form>