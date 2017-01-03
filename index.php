<?php
ini_set('display_errors', 1);
	require_once 'classes/Authenticate.php';
	/*
	//// LOGIN SETUP ////
	$authentication = new Authenticate();
	$authentication->confirmMember();
	*/
	//// ON NO POST SET THE DATE TO TODAY ////
	$date = date('Y-m-d');

	require_once 'includes/postHandlers.php';
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Accent Schedule</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=1400" />
		<link rel="stylesheet" type="text/css" href="css/schedule_header.css">
		<link rel="stylesheet" type="text/css" href="css/schedule.css">
		<link rel="stylesheet" type="text/css" href="css/schedule_editOverlay.css">
		<link rel="stylesheet" type="text/css" href="css/footer.css">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<script type="text/javascript" src="js/schedule.js"></script>
		<script>

			function login() {
				if(document.getElementById('pass').value == "2010") {
					document.getElementById('overlay').style.display = "none"
				}
			}
		</script>

		<style>
		div.backgrounddiv {
			opacity:    0.9;
			background: #333;
			width:      100%;
			height:     100%;
			z-index:    10000;
			top:        0;
			left:       0;
			position:   fixed;
		}

		#pass {
			border-radius:3px;
			padding: 5px;
			width: 125px;
			height: 30px;
			display:block;
			margin:auto;
			margin-top:300px;
		}

		#submit {
			border-radius:3px;
			width: 125px;
			height: 30px;
			display:block;
			margin:auto;
			margin-top: 10px;
			cursor: pointer;
		}

		</style>
	</head>
	<body>
		<?php if ($_SERVER['REQUEST_METHOD'] === 'GET') { ?>
			<div id="overlay" class="backgrounddiv">
				<input id="pass" type="password" autofocus>
				<button id="submit" onclick="login()">Submit</button>
			</div>
		<?php } ?>

		<?php require_once 'includes/editAppointment.php'; ?>
		<header>
			<form class="headerForm" action="" method="post">
				<a class="headerLeft" href="">
					<img class="logoLeft" src="images/logoHeader.jpg" alt="Accent Logo" />
				</a>
				<div class="headerCenter">
					<input class="leftArrow" type="submit" name="leftArrow" value="<" />
					<div class="dateCenter">
						<p class="dateHeader"><?php echo date("l, F j, Y", strtotime($date)); ?></p>
						<input class="dateInput" name="date" type="date" style="display:none" value="<?php echo $date ?>" />
						<input class="dateSubmit" type="submit" name="dateSubmit" value="Change Date" style="display:none" />
					</div>
					<input class="rightArrow" type="submit" name="rightArrow" value=">" />
				</div>
				<a class="headerRight" href="">
					<img class="logoRight" src="images/logoHeader.jpg" alt="Accent Logo" />
				</a>
			</form>
		</header>

		<input type="hidden" name="date" value="<?php echo $date ?>" />
		<table>
			<tbody>
				<tr>
					<?php $mysql->getEmployeeHeader(1, $date); ?>
					<th></th>
					<?php $mysql->getEmployeeHeader(2, $date); ?>
					<?php $mysql->getEmployeeHeader(3, $date); ?>
					<th></th>
					<?php $mysql->getEmployeeHeader(4, $date); ?>
					<?php $mysql->getEmployeeHeader(5, $date); ?>
					<th></th>
					<?php $mysql->getEmployeeHeader(6, $date); ?>
					<?php $mysql->getEmployeeHeader(7, $date); ?>
					<th></th>
					<?php $mysql->getEmployeeHeader(8, $date); ?>
				</tr>
				<?PHP
					// loops through each hour and ouputs the cells
					for($hour = 8; $hour < 18; $hour+=1)
					{
						for($min = 0; $min < 60; $min+=15)
						{
							$time = ($hour < 10 ? '0'.$hour : $hour).':'.($min < 10 ? '0'.$min : $min).":00";
							echo "<tr>\n";
							echo $mysql->getCell(1,$date,$time,'right');
							if($min == 0) echo $mysql->getCellHour($hour);
							echo $mysql->getCell(2,$date,$time,'left');
							echo $mysql->getCell(3,$date,$time,'right');
							if($min == 0) echo $mysql->getCellHour($hour);
							echo $mysql->getCell(4,$date,$time,'left');
							echo $mysql->getCell(5,$date,$time,'right');
							if($min == 0) echo $mysql->getCellHour($hour);
							echo $mysql->getCell(6,$date,$time,'left');
							echo $mysql->getCell(7,$date,$time,'right');
							if($min == 0) echo $mysql->getCellHour($hour);
							echo $mysql->getCell(8,$date,$time,'left');
							echo "</tr>\n";
						}
					}

				?>
			</tbody>
		</table>
		<div class="spacer"></div>
		<footer>
			<ul>
				<!--<li><a href="mobile.php">Mobile</a></li>|-->
				<li><a href="employee.php">Employee Manager</a></li>|
				<li><a href="login.php?status=loggedout">Log Out</a></li>
			</ul>
		</footer>
	</body>
</html>
