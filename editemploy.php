<?php
session_start();
if(!session_is_registered(myusername)){
        header("Location: index.html");
}
require_once('dbconnect.php');
	$user = $_SESSION['myusername'];
        $result = mysqli_query($con, "SELECT * FROM members WHERE username='$user'");
        $info = array();
        $i = 0;
        while($row = mysqli_fetch_array($result, MYSQL_ASSOC)){
                   $info[$i] = $row;
        }
        mysqli_close($con);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <script type="text/javascript">
  function Populate(){
    document.empinfo.First.value = "<?php echo $info[0]['first_name']; ?>";
    document.empinfo.Last.value = "<?php echo $info[0]['last_name']; ?>";
    document.empinfo.Email.value = "<?php echo $info[0]['email']; ?>";
    document.empinfo.Phone.value = "<?php echo $info[0]['phone']; ?>";
    document.empinfo.Address.value = "<?php echo $info[0]['address']; ?>";
    document.empinfo.Notes.value = "<?php echo $info[0]['notes']; ?>";
}

function checkAndReturn(){
	 if(document.empinfo.First.value == "<?php echo $info[0]['first_name']; ?>" && document.empinfo.Last.value == "<?php echo $info[0]['last_name']; ?>" && document.empinfo.Email.value == "<?php $info[0]['email'] ?>" && document.empinfo.Phone.value == "<?php echo $info[0]['phone']; ?>" && document.empinfo.Address.value == "<?php echo $info[0]['address']; ?>" && document.empinfo.Notes.value == "<?php echo $info[0]['notes']; ?>" ){
	 
         alert("No changes Made")
	 }
  window.location="employ.php";
}
</script>
 
  <meta charset="utf-8">
  <title>Information (edit)</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">

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

<body onload="Populate()">
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span2">
			<ul class="nav nav-tabs nav-stacked">
				<li>
					<a href="Schedulescreen.php">Schedules</a>
				</li>
				<li>
					<a href="employ.php">Info</a>
				</li>
				<li>
				        <a href="logout.php">Logout</a>
				</li>
			</ul>
		</div>
		<div class="span10">
			<form name="empinfo">
				<fieldset>
					 <legend>Employee Information (editing)</legend> <label>First Name</label><input type="text" value="" id="First" name="First"> <span class="help-block">Example block-level help text here.</span>
<label>Last Name</label><input type="text" value="" id="Last" name="Last"> <span class="help-block">Example block-level help text here.</span></br>
<label>Email</label><input type="text" value="" id="Email" name="Email"> <span class="help-block">Example block-level help text here.</span></br>
<label>Phone Number</label><input type="text" value="" id="Phone" name="Phone"> <span class="help-block">Example block-level help text here.</span></br>
<label>Address</label><input type="text" value="" id="Address" name="Address"> <span class="help-block">Example block-level help text here.</span>
<label>Notes</label><input type="text" value="" id="Notes" name="Notes"> <span class="help-block">Example block-level help text here.</span>
 <button type="button" class="btn" onclick="checkAndReturn()">Submit Changes</button>
 <button type="button" class="btn" onclick="location.href='employ.php'">Cancel</button>
				</fieldset>
			</form>
		</div>
	</div>
</div>
</body>
</html>
