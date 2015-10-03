<?php
// calendar.php

	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	if (!isset($_SESSION["current_user"])) {
		$_SESSION["message"] = "You need to login for accessing this page";
		header("Location: ./index.php");
		return;
	}
?>
<?php include_once "header.php"; ?>
<?php include_once "menu.php"; ?>
<?php
	// dashboard.php

	include_once "config.php"; 



?>

	<div class="calendar_header">
		<h1>Calendar</h1>
	</div>
	<div>
		<p>You can mark the dates in the calendar with your availabilty. Clicking once will mark the date in red, indicating that you are not available on that day for any services.
		</p>
		<p>You can click the same to unblock.</p>
		<p>Note that you can only change the status of dates from the current day onwards.</p>
	</div>
<?php
	
	$m = "m";
	$y = "Y";

	if(isset($_REQUEST["selected_month"])){
		$m = $_REQUEST["selected_month"];
	}
	if(isset($_REQUEST["selected_year"])){
		$y = $_REQUEST["selected_year"];
	}

	$dt = date("{$y}-{$m}-1");
	$dow = date("w", strtotime($dt));
	$max = date("t", strtotime($dt));
?>	


<form class="classic">
<div class="calendar">
	<div>
		<select id="selected_month" name="selected_month" onchange="this.form.submit()">
			<?php
				$cm = $m=="m"?date("n"):$m;
				for($i=1; $i<=12; $i++){
					$dt = date("Y-".$i.+"-1");
					$m = date("F", strtotime($dt));

					if($i==$cm){
						echo "<option selected=\"selected\" value=\"{$i}\">{$m}</option>";
					}
					else{
					?>
					<option value="<?php echo $i; ?>"><?php echo $m; ?></option>
					<?php	
					}
					
				}
			?>
		</select>
		<select id="selected_year" name="selected_year" onchange="this.form.submit()">
			<?php
			$i = $cy = date("Y");
			$cy += 10;
			for(; $i<$cy; $i++){
				if($y!="Y" && $i==$y){
					echo "<option selected=\"selected\" value=\"{$i}\">{$i}</option>";
				}
				else{
					echo "<option value=\"{$i}\">{$i}</option>";
				}
			}
			?>
		</select>
	</div>

	<div class="header_div">
		<div>Sun</div>
		<div>Mon</div>
		<div>Tue</div>
		<div>Wed</div>
		<div>Thu</div>
		<div>Fri</div>
		<div>Sat</div>
	</div>

	<div>
		<?php 
		for($i=0; $i<$dow; $i++){
		?>
		<div>&nbsp;</div>
		<?php 
		}
		
		for($i=1; $i<=$max; $i++){
		?>
		<div data-day="<?php echo $i; ?>" class="clickable dt_available"><?php echo $i; ?></div>
		<?php 
		}

		$rem = 7-(($dow+$max)%7);
		$rem = $rem % 7;
		for($i=0; $i<$rem; $i++){
		?>
		<div>&nbsp;</div>
		<?php 
		}
		?>
	</div>
	<div><span class="blocked_date"></span> Not available &nbsp;&nbsp;&nbsp;
		<span class="unblocked_date"></span> Available</div>
</div>

</form>

<script type="text/javascript">
	$(function(){
		var selectedYear, selectedMonth, selectedDate;

		selectedDate = $(this).text();
		selectedMonth = $("#selected_month").val();
		selectedYear = $("#selected_year").val();

		// get blocked dates information
		// and update the UI
		$.ajax({
			url: "get_blocked_dates.php",
			data: {
				selected_month: selectedMonth,
				selected_year: selectedYear
			},
			success: function(data){
				data = JSON.parse(data);
				console.log(data);
				for (var i = data.days.length - 1; i >= 0; i--) {
					var d = data.days[i];
					$("div.clickable[data-day="+d+"]")
						.removeClass("dt_available")
						.addClass("dt_not_available");
				};
				
			}
		});


		$("div.clickable").click(function(){

			var selectedYear, selectedMonth, selectedDate;

			selectedDate = $(this).text();
			selectedMonth = $("#selected_month").val();
			selectedYear = $("#selected_year").val();

			var date1 = new Date();
			date1 = new Date(date1.getFullYear(), date1.getMonth(), date1.getDate());
			var date2 = new Date(selectedYear, selectedMonth-1, selectedDate);

			if(date2 < date1){
				alert("Cant update dates older than today");
				return;
			}

			var dt = selectedYear + "-" 
				+ selectedMonth + "-" 
				+ (selectedDate<10?"0"+selectedDate:selectedDate);
			
			var action;
			if($(this).hasClass("dt_available")){
				$(this).addClass("dt_not_available")
					.removeClass("dt_available");
				action = "block";
			}
			else {
				$(this).addClass("dt_available")
					.removeClass("dt_not_available");
				action = "unblock";
			}

			$.ajax({
				url: "update_calendar.php",
				data: {
					action: action,
					date: dt
				},
				success: function(data){
					data = JSON.parse(data);
					if(data.status == false){
						alert("Something went wrong");
					}
				}
			});
		});

	});
</script>

<?php include_once "footer.php"; ?>
