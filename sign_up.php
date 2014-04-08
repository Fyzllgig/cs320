<?php
    include_once('dbconnect.php');
    ?>


<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="utf-8">
<title>Register New Employer</title>
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
                    //We check if there is no other user using the same username
                    $dn = mysqli_num_rows(mysqli_query($con, 'SELECT id FROM members WHERE username="'.$username.'"'));
                    if($dn==0)
                    {
                        //We count the number of users to give an ID to this one
                        $dn2 = mysqli_num_rows(mysqli_query($con, 'select id from members'));
                        $id_1 = $dn2+1;
                        //We save the informations to the databse
                        $is_m = 1;
                        $query = "CREATE TABLE ".$username."_members
                        (
                         id INT NOT NULL,
                         PRIMARY KEY (id),
                         username VARCHAR(255) NOT NULL,
                         first_name TEXT NOT NULL,
                         last_name TEXT NOT NULL,
                         email VARCHAR(255) NOT NULL,
                         phone VARCHAR(12) NOT NULL,
                         address VARCHAR(255) NOT NULL,
                         password VARCHAR(255) NOT NULL,
                         notes TEXT,
                         checked TINYINT(1) NOT NULL,
                         is_manager TINYINT(1) NOT NULL
                         )";
                        if(mysqli_query($con, $query))
                        {
                            echo "Members table created";
                        }
                        else
                        {
                            echo "Error creating members table".mysqli_error($con);
                        }
                        if(mysqli_query($con, 'insert into '.$username.'_members(id, username, first_name, last_name, email, phone, address, password, is_manager) values ("'.$is_m.'", "'.$username.'", "'.$first_name.'", "'.$last_name.'", "'.$email.'", "'.$phone.'", "'.$address.'", "'.$password.'", "'.$is_m.'")'))
                        {
                            //We dont display the form
                            $form = false;
                            if(mysqli_query($con, 'insert into members(id, username, first_name, last_name, email, phone, address, password, notes, is_manager) values ('.$id_1.', "'.$username.'", "'.$first_name.'", "'.$last_name.'", "'.$email.'", "'.$phone.'", "'.$address.'", "'.$password.'", "'.$notes.'", "'.$is_m.'")'))
                            {
                                $form = false;

                            ?>
<div class="message">You have successfuly been signed up. You can log in.<br />
<a href="http://www.schedulecreator.net">Log in</a></div>
<?php
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
                            $message = 'An error occurred while signing up.';
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
<div class="cspan10">
<form action="sign_up.php" method="post">
Please fill the following form to sign up:<br />
<div class="center">
<label for="username">Username</label><input type="text" name="username" value="<?php if(isset($_POST['username'])){echo htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8');} ?>" /><br />
<label for="password">Password<span class="small">(6 characters min.)</span></label><input type="password" name="password" /><br />
<label for="passverif">Password<span class="small">(verification)</span></label><input type="password" name="passverif" /><br />
<label for="email">Email</label><input type="text" name="email" value="<?php if(isset($_POST['email'])){echo htmlentities($_POST['email'], ENT_QUOTES, 'UTF-8');} ?>" /><br />
<label for="first_name">First Name</label><input type="text" name="first_name" value="<?php if(isset($_POST['first_name'])){echo htmlentities($_POST['first_name'], ENT_QUOTES, 'UTF-8');} ?>" /><br />
<label for="last_name">Last Name</label><input type="text" name="last_name" value="<?php if(isset($_POST['last_name'])){echo htmlentities($_POST['last_name'], ENT_QUOTES, 'UTF-8');} ?>" /><br />
<label for="phone">Phone Number</label><input type="text" name="phone" value="<?php if(isset($_POST['phone'])){echo htmlentities($_POST['phone'], ENT_QUOTES, 'UTF-8');} ?>" /><br />
<label for="address">Address</label><input type="text" name="address" value="<?php if(isset($_POST['address'])){echo htmlentities($_POST['address'], ENT_QUOTES, 'UTF-8');} ?>" /><br />
<input type="submit" value="Sign up" />
</div>
</form>
</div>
<?php
    }
    ?>

</body>
</html>