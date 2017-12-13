<?php
require 'lib/site.inc.php';
$username = $user->getUsername()?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <link href="style.css" type="text/css" rel="stylesheet">
    <title>Update Profile</title>
</head>
<body>

<header><h1>Update Profile</h1></header>
<article>
    <h2><a href="index.php?l">Log Out</a>    <a href="profile.php">Back to Homepage</a></h2>
    <form method="POST" action="post/update.php">
        <input type="hidden" value="<?php echo $username;?>" name="username" />
        <?php
        if(isset($_GET["m"])){
            echo "<h2>Name or Password can't be null!</h2>";
        }
        echo "<h2>$username, Update Your Information:</h2>";
        $name = $user->getName();
        $email = $user->getEmail();
        $city = $user->getCity();
        $password = $user->getPassword();
        echo "<table align='center'>";
        echo "<tr><th>Full Name:</th><th><input type=\"text\" size=\"37\" name=\"name\" value=\"$name\"></th></tr>";
        echo "<tr><th>Email:</th><th><input type=\"text\" size=\"37\" name=\"email\" value=\"$email\"></th></tr>";
        echo "<tr><th>City:</th><th><input type=\"text\" size=\"37\" name=\"city\" value=\"$city\"></th></tr>";
        echo "<tr><th>Password:</th><th><input type=\"password\" size=\"37\" name=\"password\" value=\"$password\"></th></tr>";
        echo "</table>";
        echo "<h2><button name='update' type='submit'>Update</button> <input type=\"reset\"> <button name='update' type='submit'>Cancel</button></h2>";
        ?>

    </form>
</article>
</body>
</html>