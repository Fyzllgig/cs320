<?php
    session_start();
    if(!session_is_registered(myusername)){
        header("Location: index.html");
    }
    require_once('dbconnect.php');
    $user = $_SESSION['myusername'];
    $query = "SELECT is_manager FROM members WHERE username = '$user'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_row($result);
    
    if($row[0] == 0){
        header('URL=./Schedulescreen.php');
    }
    elseif($row[0] == 1)
    {
        header('URL=./M_Schedulescreen.php');
    }
    else
    {
        header('URL=./index.html');
    }
    if(!isset($cur_schedule))
    {
        $cur_schedule = 'blank';
    }
    
    $query = "SELECT * FROM members WHERE username = '.$user.'";
    $result = mysqli_query($con, $query);
    $m = mysqli_fetch_array($result, MYSQL_ASSOC);
    $manager = $m['manager'];
    
    $query = "SELECT table_name FROM information_schema.tables WHERE table_type = 'BASE TABLE' AND table_schema='test'";
    $result = mysqli_query($con2, $query);
    $user_tables = array();
    $i = 0;
    $test_string = $manager.'_schedule';
    while($row = mysqli_fetch_array($result, MYSQL_ASSOC)){
        if(strpos($row['table_name'], $test_string) !== false){
            $user_tables[$i] = $row['table_name'];
            //echo $user_tables[$i];
            $i++;
        }
    }
    $table_count = count($user_tables);
    //echo $table_count;
    
    $result = mysqli_query($con, "SELECT first_name FROM members WHERE username='$user'");
	$name = mysqli_fetch_array($result);
    
    if(isset($_POST['sched_select']))
    {
        $cur_schedule = $_POST['sched_select'];
        $user_end = array(7);
        for($i=0;$i<7;$i++){
            $user_end[$i] = 0;
            $result = mysqli_query($con, "SELECT end_time FROM $cur_schedule WHERE name='$name[0]' AND day='$i'");
            $j = 0;
            $temp = array();
            while($row = mysqli_fetch_array($result, MYSQL_ASSOC)){
                $temp[$j] = $row['end_time'];
                $j++;
            }
            if(!empty($temp)){
                $user_end[$i] = $temp;
            }
        }
        $user_start = array(7);
        for($i=0;$i<7;$i++){
            $user_start[$i] = 0;
            $result = mysqli_query($con, "SELECT start_time FROM $cur_schedule WHERE name='$name[0]' AND day='$i'");
            $j = 0;
            $temp = array();
            while($row = mysqli_fetch_array($result, MYSQL_ASSOC)){
                $temp[$j] = $row['start_time'];
                $j++;
            }
            if(!empty($temp)){
                $user_start[$i] = $temp;
            }
        }
    }
    ?>

<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <title>Schedules</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Screen that displays the employees and list of schedules the user is on. Displays the current selected schedule, defaults to the most recent">
  <meta name="author" content="Brett Carter and David Parrott">

	<!--link rel="stylesheet/less" href="less/bootstrap.less" type="text/css" /-->
	<!--link rel="stylesheet/less" href="less/responsive.less" type="text/css" /-->
	<!--script src="js/less-1.3.3.min.js"></script-->
	<!--append ‘#!watch’ to the browser URL, then refresh the page. -->
	
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">

  <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
  <![endif]-->

  <!-- Fav and touch icons -->
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="img/apple-touch-icon-144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/apple-touch-icon-114-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/apple-touch-icon-72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="img/apple-touch-icon-57-precomposed.png">
  <link rel="shortcut icon" href="img/favicon.png">
  
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/scripts.js"></script>
</head>

<body>
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span2">
			<ul class="nav nav-tabs nav-stacked">
				<li class="active">
					<a href="#">Schedules</a>
				</li>
				<li>
					<a href="employ.php">Info</a>
				</li>
				<li>
				        <a href="logout.php">Logout</a>
				</li>
			</ul>
		</div>
		<div class="span2">
			<!--div class="btn-group"-->
            <form action="./Schedulescreen.php" method="post">
            <fieldset>
            <label>Select Schedule to View</label>
                <select name="sched_select">
<?php
    for($j = 0; $j < $table_count; $j++)
    {
        $trimmed = preg_replace('/.*?_schedule_/','', $user_tables[$j]);
        if($cur_schedule != 'blank' && $cur_schedule == $user_tables[$j])
        {
            echo '<option selected="selected" value="'.$user_tables[$j].'">'.$trimmed.'</option>';
        }
        else
        {
            echo '<option value="'.$user_tables[$j].'">'.$trimmed.'</option>';
        }
        
    }
    ?>
</select>
<input type="submit" value="View">
</form>
<?php echo $manager; ?>
            </fieldset>
				</ul>
			<!--/div-->
			<p>
				<strong>Employees:</strong>
			</p>
			<ul>

<?php
    
    if($cur_schedule != 'blank')
    {
        $result = mysqli_query($con, "SELECT DISTINCT name FROM $cur_schedule");
        $names = array();
        $j=0;
        while($row = mysqli_fetch_array($result, MYSQL_ASSOC)){
            $names[$j] = $row['name'];
            $j++;
        }


        for($count=0;$count<count($names);$count++){
            echo "<li>".$names[$count]."</li>";
        }
    }

?>
			</ul>
		</div>
		<div class="span8">
			<h3 class="text-center">
<?php
    $trimmed = preg_replace('/.*?_schedule_/','', $cur_schedule);
    if($trimmed == 'blank'){
        echo "<--- Select Schedule from Menu";
    }
    else
    {
        echo $trimmed;
    }
    ?>
			</h3>
			<table class="table table-hover table-condensed table-bordered">
				<thead>

					<tr class="headers">
						<th>
							Time:
						</th>
						<th>
							Sunday:
						</th>
						<th>
							Monday:
						</th>
						<th>
							Tuesday:
						</th>
						<th>
							Wednesday:
						</th>
						<th>
							Thursday:
						</th>
						<th>
							Friday:
						</th>
						<th>
							Saturday:
						</th>
					</tr>
				</thead>
				<tbody>

<?php
	$next_start = array(7);
	$next_end = array(7);
	for($i=0;$i<7;$i++){
		if(!empty($user_start[$i])){
			$next_start[$i] = $user_start[$i][0];
			$next_end[$i] = $user_end[$i][0];
		}else{
			$next_start[$i] = 0;
			$next_end[$i] = 0;
		}
	}
	for($row=0;$row<24;$row++){
		echo "<tr>";
		echo "<td>";
		if($row < 12 && $row != 0){
			echo "".$row."am";
		}elseif($row == 0){
			echo "12am";
		}else{
			if($row == 12){
				echo "12pm";
			}else{
				echo "".($row % 12)."pm";
			}
		}

		echo "</td>";
        
        if(isset($cur_schedule))
        {
		for($col=0;$col<7;$col++){
			$query = "SELECT name FROM $cur_schedule WHERE day='$col' AND start_time='$row'";
			$result = mysqli_query($con, $query);
			$display = mysqli_fetch_array($result);
			
			$query = "SELECT username FROM members WHERE first_name='$display[0]'";
			$result = mysqli_query($con, $query);
			$scheduled_username = mysqli_fetch_array($result);

			if($row >= $next_start[$col] && $row < $next_end[$col]){
				echo "<td style='background-color:#FAFA25'>";
			}else{
				echo "<td>";
			}
			echo $display[0];
			echo "</td>";

			if($row > $next_end[$col] && !empty($user_end[$col])){
				array_shift($user_start[$col]);
				$next_start[$col] = $user_start[$col][0];
				array_shift($user_end[$col]);
				$next_end[$col] = $user_end[$col][0];
			}
		}
        }
		echo "</tr>";
	}
?>
					
				</tbody>
			</table>
		</div>
	</div>
</div>
</body>
</html>
