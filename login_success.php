<?php
    session_start();
    if(!session_is_registered(myusername)){
        header("location:index.php");
    }
    require_once('dbconnect.php');
    $user = $_SESSION['myusername'];
    $query = "SELECT is_manager FROM members WHERE username = '$user'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_row($result);
    
    if($row[0] == 0){
        header('Refresh: 1; URL=./Schedulescreen.php');
    }
    else{
        header('Refresh: 1; URL=./M_Schedulescreen.php');
    }
    ?>

<html>
<body>
Login Successful
<br><a href="./Schedulescreen.php">If your page does not refresh click here</a></br>

</body>
</html>