<?php
$open = true;
require 'lib/site.inc.php';
unset($_SESSION['user']);?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <link href="style.css" type="text/css" rel="stylesheet">
    <title>Log In</title>
</head>
<body>
<header><h1>Log Into Your Account</h1></header>
<article>
    <form method="POST" action="post/index.php">
        <?php
        if(isset($_GET['e'])){
            echo "<h2>username and password do not match</h2>";
        }
        ?>
        <h2>username: <input type="text" size="38" name="username"></h2>
        <h2>password: <input type="password" size="37" name="password"></h2>
        <h3><a href="signup.php">Don't have an account? Sing Up Now!</a></h3>
        <h2><input type="submit" value="Log In"> <input type="reset"></h2>




    </form>
</article>
</body>
</html>
