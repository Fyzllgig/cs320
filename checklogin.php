<?php
session_start();

if(!empty($_SESSION['myusername'])){
header("location: login_success.php");
}

$host="scheduler.db"; // Host name 
$username="scheduler"; // Mysql username 
$password="9mFqpczdMAsAKZEL"; // Mysql password 
$db_name="test"; // Database name 
$tbl_name="members"; // Table name 

// Connect to server and select databse.
mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
mysql_select_db("$db_name")or die("cannot select DB");

// Define $myusername and $mypassword 
$myusername=$_POST['myusername']; 
$mypassword=$_POST['mypassword']; 

// To protect MySQL injection (more detail about MySQL injection)
$myusername = stripslashes($myusername);
$mypassword = stripslashes($mypassword);
$myusername = mysql_real_escape_string($myusername);
$mypassword = mysql_real_escape_string($mypassword);
$sql="SELECT * FROM $tbl_name WHERE username='$myusername' and password='$mypassword'";
$result=mysql_query($sql);
	
// Mysql_num_row is counting table row
$count=mysql_num_rows($result);
	
// If result matched $myusername and $mypassword, table row must be 1 row
if($count==1){
	
//Register $myusername, $mypassword and redirect to file "login_success.php"
$_SESSION['myusername']=$_POST['myusername'];
header("location:login_success.php");
}
else {
header('Refresh: 5; URL=./index.html');
echo "Wrong Username or Password";
}
?>
<html>
<body>
<br><a href="./index.html">If your page does not refresh click here</a></br>
</body>
</html>


