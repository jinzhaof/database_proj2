<?php
require 'lib/site.inc.php';
$username = $user->getUsername()?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <link href="style.css" type="text/css" rel="stylesheet">
    <title>My Profile</title>
    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $("button[name=music]").click(function(){
                var button = this;
                var music = new Audio(button.value);
                music.play();
                var user = $("#user").val();
                var tid = button.id;
                $.post("post/play.php",
                    {
                        username:user,
                        tid:tid
                    },
                    function (data) {
                        console.log(data);
                    });
            });
        });
    </script>
</head>
<body>

<header><h1>My Profile</h1></header>
<article>
    <h2><a href="index.php?l">Log Out</a></h2>
    <form method="POST" action="post/profile.php">
        <input type="hidden" value="<?php echo $user->getUsername();?>" name="username" />
        <input type="hidden" value=<?php echo $username?> id="user" />
        <h2><input type="text" size="37" name="search"><button name='s' type='submit'>Search</button></h2>
        <?php
        if(isset($_GET["m"])){
            echo "<h2>Name or Password can't be null!</h2>";
        }
        else if(isset($_GET["k"])){
            echo "<h2>Please enter the keyword!</h2>";
        }
        ?>

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
        $artist_table = new \project\Artists($site);
        if(count($loves)){
            echo "<table  align='center'>";
            echo "<tr><th>Artist</th></tr>";
            foreach($loves as $l){
                $aname = $artist_table->get($l)->getAname();
                echo "<tr><th><a href='artlist.php?id=$l'>$aname</a></th></tr>";
            }
            echo "</table>";
        }
        else{
            echo "<h3>You don't like any artists</h3>";
        }
        ?>
        <h2>Recent Release Track From The Artists You Like:</h2>
        <?php
        $tracks = $love_table->getRecent($username);
        $track_table = new \project\Tracks($site);
        $preview_table = new \project\Preview($site);
        $album_table = new \project\Albums($site);
        if(count($tracks)){
            echo "<table style='width:100%'>";
            echo "<tr><th>Title</th><th>Duration</th><th>Artist</th><th>Album</th><th>Play</th></tr>";
            foreach($tracks as $track){
                $t = $track_table->get($track);
                echo "<tr>";
                $title = $t->getTrackName();
                $tid = $t->getTrackId();
                $duration = $t->getDuration();
                $artist = $t->getArtist();
                $albid = $t->getAlbum();
                $album = $album_table->get($albid);
                $albname = $album->getAlbname();
                $url = $preview_table->get($tid);

                echo "<th>$title</th>";
                echo "<th>$duration</th>";
                echo "<th>$artist</th>";
                echo "<th>$albname</th>";
                if($url){
                    echo "<th><button name='music' type='button' id='$tid' value='$url'>Play</button></th>";
                }
                else{
                    echo "<th>Sorry</th>";
                }
                echo "</tr>";
            }
            echo "</table>";
        }
        else{
            echo "<h3>Nothing New From Your Favorite Artists</h3>";
        }

        ?>
    </div>
    </form>
</article>
</body>
</html>