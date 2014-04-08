<?php
    $con = mysqli_connect("scheduler.db","scheduler","9mFqpczdMAsAKZEL","test");
    if(mysqli_connect_errno($con)){
        echo "failed to connect to MySQL: " . mysqli_connect_error();
    }
    $m_host = "scheduler.db";
    $m_user = "scheduler";
    $m_pass = "9mFqpczdMAsAKZEL";
    $m_data = "information_schema";
    $con2 = mysqli_connect( $m_host, $m_user, $m_pass, $m_data);
    if(mysqli_connect_errno($con2)){
        echo "failed to connect to Database: " . mysqli_connect_error();
    }
?>