<?php
require 'lib/site.inc.php';
$username = $_SESSION['user']->getUsername()?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <link href="style.css" type="text/css" rel="stylesheet">
    <title>New Playlist</title>
</head>
<body>
<header><h1>Create Your New Playlist</h1></header>
<article>
    <form method="POST" action="post/create.php">
        <?php
        if(isset($_GET['m'])){
            echo "<h2>Please enter a playlist title!</h2>";
        }
        ?>
        <h2>Title: <input type="text" size="38" name="title"></h2>
        <h2><button name='create' type='submit'>Create</button><button name='cancel' type='submit'>Cancel</button></h2>




    </form>
</article>
</body>
</html>
