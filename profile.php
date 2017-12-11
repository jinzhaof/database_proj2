<?php
require 'lib/site.inc.php'; ?>
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
    <form method="POST" action="update.php">
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
        <h2>username: <?php echo $user->getUsername()?></h2>
        <h2>Name: <input type="text" size="37" name="name" value="<?php echo $user->getName();?>"</h2>
        <h2>Password: <input type="password" size="37" name="password" value="<?php echo $user->getPassword();?>"</h2>
            <h2>Email: <input type="text" size="37" name="email" value="<?php echo $user->getEmail();?>"</h2>
                <h2>City: <input type="text" size="37" name="city" value="<?php echo $user->getCity();?>"</h2>
        <h2><input type="submit" value="Update"> <input type="reset"></h2>
    </form>
    <div>
        <h2>Playlists From Your Follows:</h2>
        <?php
        $follow_table = new \project\Follows($site);
        $follows = $follow_table->get($user->getUsername());
        $playlist_table = new \project\Playlists($site);
        $followed_playlist = array();
        foreach($follows as $f){
            $lists = $playlist_table->getPlaylists($f);
            foreach($lists as $l){
                array_push($followed_playlist,$l);
            }
        }
        foreach($followed_playlist as $fp){
            $ptitle = $fp->getPtitle();
            $pid = $fp->getPid();
            echo "<h3><a href=\"playlist.php?id=$pid\">$ptitle</a></h3>";
        }
        ?>
    </div>
</article>
</body>
</html>