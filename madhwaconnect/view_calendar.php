<?php
	// view_calendar.php
	
	$m = "m";
	$y = "Y";
	$for_user = null;

	if(isset($_REQUEST["selected_month"])){
		$m = $_REQUEST["selected_month"];
	}
	if(isset($_REQUEST["selected_year"])){
		$y = $_REQUEST["selected_year"];
	}
	if(isset($_REQUEST["for_user"])){
		$for_user = $_REQUEST["for_user"];
	}

	$dt = date("{$y}-{$m}-1");
	$dow = date("w", strtotime($dt));
	$max = date("t", strtotime($dt));

	
?>	
<html>
<head>
	<style type="text/css">
		@import "css/default.css";
	</style>
</head>
<body>
<script type="text/javascript">
	$(function(){
		$(".closedialog").css({
			cursor: "pointer"
		}).click(function(){
			$("#dlg_view_calendar").dialog("close");
		});
	});
</script>
<h3 style="padding-bottom: 20px; margin-top: 0px; ">
	<span style="float: left">View calendar</span>
	<span style="float: right" class="closedialog" title="Close">[x]</span></h3>
<div id="user_calendar" style="clear: both;">
	<div class="calendar_small">
		<div style="text-align: center">
			<button onclick="fnChangeCalendar(-1)">&lt;&lt;</button>
			<select id="selected_month" name="selected_month" onchange="fnChangeCalendar()">
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
			<select id="selected_year" name="selected_year" onchange="fnChangeCalendar()">
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
			<button onclick="fnChangeCalendar(1)">&gt;&gt;</button>
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
			<div data-day="<?php echo $i; ?>" style="cursor: auto !impmortant"
				class="clickable dt_available"><?php echo $i; ?></div>
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
	<script type="text/javascript">
		
		$(function(){

			
			var selectedYear, selectedMonth, selectedDate;

			selectedDate = $(this).text();
			selectedMonth = $("#selected_month").val();
			selectedYear = $("#selected_year").val();

			$.ajax({
				url: "get_blocked_dates.php",
				data: {
					selected_month: selectedMonth,
					selected_year: selectedYear,
					for_user: <?php echo $for_user; ?>
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
				},
				async: false
			});	
		});

		var fnChangeCalendar = function(val){
			var selectedYear, selectedMonth;

			selectedMonth = $("#selected_month").val();
			selectedYear = $("#selected_year").val();	

			if(val){
				if(val==-1){
					selectedMonth--;
				}
				else{
					selectedMonth++;
				}
				if(selectedMonth==13){
					selectedMonth=1;
					selectedYear++;
				}
				if(selectedMonth==0){
					selectedMonth=12;
					selectedYear--;
				}
			}
			$.ajax({
				url: "view_calendar.php",
				data: {
					selected_month: selectedMonth,
					selected_year: selectedYear,
					for_user: <?php echo $for_user; ?>
				},
				success: function(data){
					$("#user_calendar").html(data);
				},
				async: false
			});	
		}

		$(function(){
			$(".calendar_small button:first").focus();
		});
	</script>
</div>


</body>
</html>