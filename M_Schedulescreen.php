<?php
    session_start();
    if(!session_is_registered(myusername)){
        header("Location: index.php");
    }
    require_once('dbconnect.php');
    $user = $_SESSION['myusername'];
    $query = "SELECT is_manager FROM members WHERE username = '$user'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_row($result);
    
    if($row[0] == 0){
        header('URL=./Schedulescreen.php');
    }
    elseif($row[0] == 1){
        header('URL=./createemployee.php');
    }
    else
    {
        header('URL=./');
    }
    
    if(!isset($cur_schedule))
    {
        $cur_schedule = 'blank';
    }
    
    if(isset($_POST['addto_schedule_select']))
    {
        if(isset($_POST['username_select']))
        {
            if(isset($_POST['day_select']))
            {
                if(isset($_POST['start_select']))
                {
                    if(isset($_POST['end_select']))
                    {
                        $selected_s = $_POST['addto_schedule_select'];
                        $selected_u = $_POST['username_select'];
                        $selected_d = $_POST['day_select'];
                        $selected_t = $_POST['start_select'];
                        $selected_e = $_POST['end_select'];
                        
                        $dn1 = mysqli_num_rows(mysqli_query($con, 'select id from '.$selected_s.''));
                        $id_1 = $dn1+1;
                        echo $id_1;

                        
                        $query = "SELECT DISTINCT name FROM $selected_s WHERE username = '$selected_u'";
                        $result = mysqli_query($con, $query);
                        $row = mysqli_fetch_array($result, MYSQL_ASSOC);
                        $selected_n = $row['name'];
                        
                        $query = 'INSERT INTO '.$selected_s.'(id, name, day, start_time, end_time, username) VALUES("'.$id_1.'", "'.$selected_n.'", "'.$selected_d.'", "'.$selected_t.'", "'.$selected_e.'", "'.$selected_u.'")';
                    }
                }
            }
        }
    }
    
    $query = "SELECT table_name FROM information_schema.tables WHERE table_type = 'BASE TABLE' AND table_schema='test'";
    $result = mysqli_query($con2, $query);
    $user_tables = array();
    $i = 0;
    $sep = ':  ';
    $test_string = $user.'_schedule';
    while($row = mysqli_fetch_array($result, MYSQL_ASSOC)){
        if(strpos($row['table_name'], $test_string) !== false){
            $user_tables[$i] = $row['table_name'];
            $i++;
        }
    }
    
    $table_count = count($user_tables);
    $trimmed = str_replace($user.'_schedule_','', $user_tables[$j]);
    $name_lists = array();
    
    for($j = 0; $j < $i; $j++){
        $j_schedule = $user_tables[$j];
        $result = mysqli_query($con, 'SELECT DISTINCT name FROM '.$j_schedule.'');
        ${$j_schedule."_names"} = array();
        $k = 0;
        while($row = mysqli_fetch_array($result, MYSQL_ASSOC)){
            ${$j_schedule."_names"}[$k] = $row['name'];
            //echo $names[$k];
            $k++;
        }
        $name_lists['$j_schedule'] = ${$j_schedule."_names"};
        $result = mysqli_query($con, 'SELECT DISTINCT username FROM '.$j_schedule.'');
            ${$j_schedule."_usernames"} = array();
        $k = 0;
        while($row = mysqli_fetch_array($result, MYSQL_ASSOC)){
            ${$j_schedule."_usernames"}[$k] = $row['username'];
            //echo $names[$k];
            $k++;
        }
    }
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
        $result = mysqli_query($con, "SELECT DISTINCT name FROM $cur_schedule");
        $names = array();
        $j=0;
        while($row = mysqli_fetch_array($result, MYSQL_ASSOC)){
            $names[$j] = $row['name'];
            $j++;
        }
        $result = mysqli_query($con, "SELECT DISTINCT username FROM $cur_schedule");
        $user_names = array();
        $j=0;
        while($row = mysqli_fetch_array($result, MYSQL_ASSOC)){
            $user_names[$j] = $row['username'];
            $j++;
        }
    }

	if(isset($_POST['new_schedule']))
		{
		$query = "CREATE TABLE ".$user."_schedule_".$_POST['new_schedule']."
		(
			id INT NOT NULL,
			name VARCHAR(255) NOT NULL,
			day INT NOT NULL,
			start_time INT,
			end_time INT,
			username VARCHAR(255) NOT NULL
			)";
		mysqli_query($con, $query);
		unset($_POST['new_schedule']);
		header('Refresh: 1; URL=./M_Schedulescreen.php');
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

<script type="text/javascript">


</script>


</script>

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
                    <a href="M_employ.php">Info</a>
                </li>
                <li>
                    <a href="pseudocode.html">Messages</a>
                </li>
                <li>
                    <a href="createemployee.php">Add Employee</a>
                </li>
                <li>
                    <a href="logout.php">Logout</a>
                </li>

            </ul>



<div>
    <form id="newshift" action="M_Schedulescreen.php" method="post">
        <fieldset>
            <legend>New Shift Information</legend>

Schedule to add to
<select name="addto_schedule_select">
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
        }    }
    ?>
</select>

Username of Employee
<select name="username_select">
<?php
    
    for($j = 0; $j<count($user_names); $j++)
    {
        echo '<option value="'.$user_names[$j].'">'.$user_names[$j].'</option>';
    }
    ?>
</select>

Day of Shift
<select name="day_select">
<?php
    if($cur_schedule != 'blank'){
        echo '<option value="0">Sunday</option> <option value="1">Monday</option> <option value="2">Tuesday</option> <option value="3">Wednesday</option> <option value="4">Thursday</option> <option value="5">Friday</option> <option value="6">Satday</option>';
    }
    ?>
</select>

Start Time
<select name="start_select">
<?php
    if($cur_schedule != 'blank')
    {
        for($row=0;$row<24;$row++){
            if($row < 12 && $row != 0){
                echo '<option value="'.$row.'">'.$row.' am</option>';
            }elseif($row == 0){
                echo '<option value="'.$row.'">12 am</option>';
            }else{
                if($row == 12){
                    echo '<option value="'.$row.'">12 pm</option>';
                }else{
                    echo '<option value="'.$row.'">'.($row % 12).' pm</option>';
                }
            }
        }
    }
    ?>
</select>

End Time
<select name="end_select">
<?php
    if($cur_schedule != 'blank')
    {
        for($row=0;$row<24;$row++){
            if($row < 12 && $row != 0){
                echo '<option value="'.$row.'">'.$row.' am</option>';
            }elseif($row == 0){
                echo '<option value="'.$row.'">12 am</option>';
            }else{
                if($row == 12){
                    echo '<option value="'.$row.'">12 pm</option>';
                }else{
                    echo '<option value="'.$row.'">'.($row % 12).' pm</option>';
                }
            }
        }
    }
    ?>
</select>
<input type="hidden" name="sched_select" value="<?php echo $cur_schedule; ?>">
<input type="submit" value="Add"/>
</form>
<form action="M_Schedulescreen.php" method="post">
<div>
<legend>New Schedule Name</legend>
<label for="new_schedule"></label><input type="text" name="new_schedule" value="<?php if(isset($_POST['new_schedule'])){echo htmlentities($_POST['new_schedule'], ENT_QUOTES, 'UTF-8');} ?>" /></br>
<input type="submit" value="Create" />
</form>
</div>
</div>
</div>
<div class="span2">
<!--div class="btn-group"-->
<form action="./M_Schedulescreen.php" method="post">
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
        for($count=0;$count<count($names);$count++){
            echo "<li>".$names[$count]." (".$user_names[$count].")</li>";
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

</body>
</html>
