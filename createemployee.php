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
    $manager_id = $user;
    
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
    ?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <title>Add New Employee</title>
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

<div class="container-fluid">
    <div class="row-fluid">
        <div class="span2">
            <ul class="nav nav-tabs nav-stacked">
                <li>
                    <a href="M_Schedulescreen.php">Schedules</a>
                </li>
                <li>
                    <a href="M_employ.php">Info</a>
                </li>
                <li>
                    <a href="pseudocode.html">Messages</a>
                </li>
                <li>
                    <a href="logout.php">Logout</a>
                </li>
                <li class="dropdown pull-right">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle">Dropdown<strong class="caret"></strong></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#">Action</a>
                        </li>
                        <li>
                            <a href="#">Another action</a>
                        </li>
                        <li>
                            <a href="#">Something else here</a>
                        </li>
                        <li class="divider">
                        </li>
                        <li>
                            <a href="#">Separated link</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>



<?php
    //We check if the form has been sent
    if(isset($_POST['username'], $_POST['password'], $_POST['passverif'], $_POST['email'], $_POST['first_name'], $_POST['last_name']) and $_POST['username']!='')
    {
        //We remove slashes depending on the configuration
        if(get_magic_quotes_gpc())
        {
            $_POST['username'] = stripslashes($_POST['username']);
            $_POST['password'] = stripslashes($_POST['password']);
            $_POST['passverif'] = stripslashes($_POST['passverif']);
            $_POST['email'] = stripslashes($_POST['email']);
            $_POST['first_name'] = stripslashes($_POST['first_name']);
            $_POST['last_name'] = stripslashes($_POST['last_name']);
            $_POST['phone'] = stripslashes($_POST['phone']);
            $_POST['address'] = stripslashes($_POST['address']);
            $_POST['notes'] = stripslashes($_POST['notes']);
        }
        //We check if the two passwords are identical
        if($_POST['password']==$_POST['passverif'])
        {
            //We check if the password has 6 or more characters
            if(strlen($_POST['password'])>=6)
            {
                //We check if the email form is valid
                if(preg_match('#^(([a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+\.?)*[a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+)@(([a-z0-9-_]+\.?)*[a-z0-9-_]+)\.[a-z]{2,}$#i',$_POST['email']))
                {
                    //We protect the variables
                    $username = mysqli_real_escape_string($con, $_POST['username']);
                    $password = mysqli_real_escape_string($con, $_POST['password']);
                    $email = mysqli_real_escape_string($con, $_POST['email']);
                    $first_name = mysqli_real_escape_string($con, $_POST['first_name']);
                    $last_name = mysqli_real_escape_string($con, $_POST['last_name']);
                    $phone = mysqli_real_escape_string($con, $_POST['phone']);
                    $address = mysqli_real_escape_string($con, $_POST['address']);
                    $notes = mysqli_real_escape_string($con, $_POST['notes']);
                    //We check if there is no other user using the same username
                    $dn = mysqli_num_rows(mysqli_query($con, 'SELECT id FROM members WHERE username="'.$username.'"'));
                    if($dn==0)
                    {
                        //We count the number of users to give an ID to this one
                        $dn2 = mysqli_num_rows(mysqli_query($con, 'select id from members'));
                        $id_1 = $dn2+1;
                        $dn3 = mysqli_num_rows(mysqli_query($con, 'select id from '.$manager_id.'_members'));
                        $id_2 = $dn3+1;
                        //We save the informations to the databse
                        $is_m = 0;
                        if(mysqli_query($con, 'insert into '.$manager_id.'_members(id, username, first_name, last_name, email, phone, address, password, notes, is_manager) values ("'.$id_2.'",  "'.$username.'", "'.$first_name.'", "'.$last_name.'", "'.$email.'", "'.$phone.'", "'.$address.'", "'.$password.'", "'.$notes.'", "'.$is_m.'")'))
                        {
                            //We dont display the form
                            $form = false;
                            if(mysqli_query($con, 'insert into members(id, username, first_name, last_name, email, phone, address, password, notes, is_manager) values ('.$id_1.', "'.$username.'", "'.$first_name.'", "'.$last_name.'", "'.$email.'", "'.$phone.'", "'.$address.'", "'.$password.'", "'.$notes.'", "'.$is_m.'")'))
                            {
                                $form = false;
                                $k = 0;
                                $values = $_POST['sched_select'];
                                foreach($values as $s)
                                {
                                    $dn4 = mysqli_num_rows(mysqli_query($con, 'select id from '.$s.''));
                                    $id_3 = $dn4+1;
                                    if(mysqli_query($con, 'insert into '.$s.'(id, name, day, start_time, end_time, username) values("'.$id_3.'", "'.$first_name.'", NULL, NULL, NULL, "'.$username.'")'))
                                    {
                                        $form = false;
                                        ?>
                                        <div class="message">Employee sucessfully added to your database<br />
                                        <a href="createemployee.php">Create another Employee</a></div>
<?php
                                    }
                                    else
                                    {
                                        $form = true;
                                        $message = 'could not add to schedule';
    
                                    }
                                
    
                                }
    
                            }
                            else
                            {
                                $form = true;
                                $message = 'Failed insert into members';
                            }
                        }
                        else
                        {
                            //Otherwise, we say that an error occured
                            $form = true;
                            $message = 'Failed insert into manager_mambers';
                        }
                    }
                    else
                    {
                        //Otherwise, we say the username is not available
                        $form = true;
                        $message = 'The username you want to use is not available, please choose another one.';
                    }
                }
                else
                {
                    //Otherwise, we say the email is not valid
                    $form = true;
                    $message = 'The email you entered is not valid.';
                }
            }
            else
            {
                //Otherwise, we say the password is too short
                $form = true;
                $message = 'Your password must contain at least 6 characters.';
            }
        }
        else
        {
            //Otherwise, we say the passwords are not identical
            $form = true;
            $message = 'The passwords you entered are not identical.';
        }
    }
    else
    {
        $form = true;
    }
    if($form)
    {
        //We display a message if necessary
        if(isset($message))
        {
            echo '<div class="message">'.$message.'</div>';
        }
        //We display the form
        ?>

<div class="span10">
<form action="createemployee.php" method="post">
<fieldset>
<legend>Enter New Employee Information</legend>
<label>Select Schedules to Add Employee to</label>
    <select multiple="multiple" name="sched_select[]">
<?php
    for($j = 0; $j < $table_count; $j++)
    {
        $trimmed = str_replace($user.'_schedule_','', $user_tables[$j]);
        echo '<option value="'.$user_tables[$j].'">'.$trimmed.'</option>';
    }
    ?>
    </select>
<label>Username</label><input type="text" value="<?php if(isset($_POST['username'])){echo htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8');} ?>" id="username" name="username"> <span class="help-block">Example block-level help text here.</span></br>

<label>First Name</label><input type="text" value="<?php if(isset($_POST['first_name'])){echo htmlentities($_POST['first_name'], ENT_QUOTES, 'UTF-8');} ?>" id="first_name" name="first_name"> <span class="help-block">Example block-level help text here.</span>

<label>Last Name</label><input type="text" value="<?php if(isset($_POST['last_name'])){echo htmlentities($_POST['last_name'], ENT_QUOTES, 'UTF-8');} ?>" id="last_name" name="last_name"> <span class="help-block">Example block-level help text here.</span></br>

<label>Email</label><input type="text" value="<?php if(isset($_POST['email'])){echo htmlentities($_POST['email'], ENT_QUOTES, 'UTF-8');} ?>" id="email" name="email"> <span class="help-block">Example block-level help text here.</span></br>

<label>Phone Number</label><input type="text" value="<?php if(isset($_POST['phone'])){echo htmlentities($_POST['phone'], ENT_QUOTES, 'UTF-8');} ?>" id="phone" name="phone"> <span class="help-block">Example block-level help text here.</span></br>

<label>Address</label><input type="text" value="<?php if(isset($_POST['address'])){echo htmlentities($_POST['address'], ENT_QUOTES, 'UTF-8');} ?>" id="address" name="address"> <span class="help-block">Example block-level help text here.</span>

<label>Notes</label><input type="text" value="<?php if(isset($_POST['notes'])){echo htmlentities($_POST['notes'], ENT_QUOTES, 'UTF-8');} ?>" id="notes" name="notes"> <span class="help-block">Example block-level help text here.</span>
<label>Password</label><input type="password" value="" id="password" name="password"> <span class="help-block">Example block-level help text here.</span>
<label>Verify Password</label><input type="password" value="" id="passverif" name="passverif"> <span class="help-block">Example block-level help text here.</span>

<input type="submit" class="btn" value="Submit" />
<button type="button" class="btn" onclick="location.href='employ.php'">Cancel</button>
</fieldset>
</form>
</div>
</div>
</div>

<?php
    }
    ?>

</body>
</html>