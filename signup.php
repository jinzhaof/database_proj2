<?php
/**
 * Created by PhpStorm.
 * User: Zhaofeng
 * Date: 12/10/17
 * Time: 11:24 PM
 * jinzhaofeng*/?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <link href="style.css" type="text/css" rel="stylesheet">
    <title>Sign Up</title>
</head>
<body>
<header><h1>Register Your New Account</h1></header>
<article>
    <form method="POST" action="signupvalidate.php">
        <?php
        if(isset($_GET["m"])){
            echo "<h2>Please fill all information</h2>";
        }
        else if(isset($_GET["p"])){
            echo "<h2>Passwords do not match</h2>";
        }
        else if(isset($_GET["u"])){
            echo "<h2>Username Already Exists!</h2>";
        }
        ?>
        <h2>Enter an username: <input type="text" size="38" name="username"></h2>
        <h2>Enter your name: <input type="text" size="38" name="name"></h2>
        <h2>Enter your password: <input type="password" size="37" name="password1"></h2>
        <h2>Re-Enter your password: <input type="password" size="36" name="password2"></h2>
        <h3><a href="index.php">Already have an account? Sing In!</a></h3>
        <h2><input type="submit" value="Submit"> <input type="reset"></h2>




    </form>
</article>
</body>
</html>