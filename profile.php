<?php
require 'lib/site.inc.php';
$username = $user->getUsername()?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <link href="style.css" type="text/css" rel="stylesheet">
    <title>My Profile</title>
</head>
<body>

<header><h1>My Profile</h1></header>
<article>
    <h2><a href="index.php">Log Out</a></h2>
    <form method="POST" action="post/profile.php">
        <input type="hidden" value="<?php echo $user->getUsername();?>" name="username" />
        <h2><input type="text" size="37" name="search"><button name='s' type='submit'>Search</button></h2>
        <?php
        if(isset($_GET["m"])){
            echo "<h2>Name or Password can't be null!</h2>";
        }
        else if(isset($_GET["k"])){
            echo "<h2>Please enter the keyword!</h2>";
        }
        ?>
<!--        <h2>username: --><?php //echo $user->getUsername()?><!--</h2>-->
<!--        <h2>Name: <input type="text" size="37" name="name" value="--><?php //echo $user->getName();?><!--"</h2>-->
<!--        <h2>Password: <input type="password" size="37" name="password" value="--><?php //echo $user->getPassword();?><!--"</h2>-->
<!--            <h2>Email: <input type="text" size="37" name="email" value="--><?php //echo $user->getEmail();?><!--"</h2>-->
<!--                <h2>City: <input type="text" size="37" name="city" value="--><?php //echo $user->getCity();?><!--"</h2>-->
<!--        <h2><input type="submit" value="Update"> <input type="reset"></h2>-->

    <div>
        <h2>Personal Information:</h2>
        <?php
        $name = $user->getName();
        $email = $user->getEmail();
        $city = $user->getCity();
        echo "<table align='center'>";
        echo "<tr><th>Username:</th><th>$username</th></tr>";
        echo "<tr><th>Full Name:</th><th>$name</th></tr>";
        echo "<tr><th>Email:</th><th>$email</th></tr>";
        echo "<tr><th>City:</th><th>$city</th></tr>";
        echo "</table>";
        echo "<h2><button name='update' type='submit' value=$username>Update</button></h2>";
        ?>
        <h2>Playlists Created By Your:</h2>
        <?php
        $playlist_table = new \project\Playlists($site);
        $playlists = $playlist_table->getPlaylists($username);
        if(count($playlists)){
            echo "<table  align='center'>";
            echo "<tr><th>Title</th><th>Manage</th><th>Delete</th></tr>";
            foreach($playlists as $p){
                echo "<tr>";
                $ptitle = $p->getPtitle();
                $pid = $p->getPid();
                echo "<th style='width:50%'>$ptitle</th>";
                echo "<th><button name='manage' type='submit' value=$pid>Manage</button></th>";
                echo "<th><button name='delete' type='submit' value=$pid>Delete</button></th></tr>";
            }
            echo "</table>";

        }


        echo "<h2><a href=\"create.php\">Create A New Playlist</a></h2>"
        ?>
        <h2>Playlists From Your Follows:</h2>
        <?php
        $follow_table = new \project\Follows($site);
        $follows = $follow_table->get($user->getUsername());
        $playlist_table = new \project\Playlists($site);
        $followed_playlist = array();
        if(count($follows)){
            foreach($follows as $f){
                $lists = $playlist_table->getPlaylists($f);
                foreach($lists as $l){
                    array_push($followed_playlist,$l);
                }
            }
            echo "<table  align='center' style='width:50%'>";
            echo "<tr><th>Title</th><th>Creator</th></tr>";
            foreach($followed_playlist as $fp){
                $ptitle = $fp->getPtitle();
                $pid = $fp->getPid();
                $creator = $fp->getUser();
                echo "<tr>";
                echo "<th><a href=\"playlist.php?id=$pid\">$ptitle</a></th>";
                echo "<th>$creator</th>";
                echo "</tr>";
            }
            echo "</table>";
        }
        else{
            echo "<h3>You don't follow anyone</h3>";
        }
        ?>

        <h2>Artists That Your Like:</h2>
        <?php
        $love_table = new \project\Love($site);
        $loves = $love_table->get($username);
        if(count($loves)){
            echo "<table  align='center'>";
            echo "<tr><th>Artist</th></tr>";
            foreach($loves as $l){
                echo "<tr><th><a href='artlist.php?name=$l'>$l</a></th></tr>";
            }
            echo "</table>";
        }
        else{
            echo "<h3>You don't like any artists</h3>";
        }

        ?>
    </div>
    </form>
</article>
</body>
</html>