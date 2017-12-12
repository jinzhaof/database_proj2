<?php
require 'lib/site.inc.php';
if(isset($_GET['key'])){
    $keyword = '%'.$_GET['key'];
    $keyword = $keyword.'%';
    $artist_table = new \project\Artists($site);
    $track_table = new \project\Tracks($site);
    $playlist_table = new \project\Playlists($site);
    $follow_table = new \project\Follows($site);
    $username = $_SESSION['user']->getUsername();
}?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <link href="style.css" type="text/css" rel="stylesheet">
    <title>Search</title>"
</head>
<body>
<header><h1>Search</h1></header>
<article>
    <h2><a href="index.php">Log Out</a>       <a href="profile.php">My Profile</a></h2>
    <form method="POST" action="post/search.php">
        <h2><input type="text" size="37" name="search"><button name='s' type='submit'>Search</button></h2>
        <input type="hidden" value=<?php echo $_GET['key']?> name="key" />
        <?php
        if(isset($_GET["k"])){
            echo "<h2>Please enter the keyword!</h2>";
        }
        else{
            $pl_result = $playlist_table->search($keyword);

            if(count($pl_result)){
                echo "<h2>Search Results of Playlists:</h2>";
                echo "<table style='width:100%'>";
                echo "<tr><th>Playlist Title</th><th>creator</th><th>Releasedate</th><th>Follow the creator</th></tr>";
                foreach($pl_result as $pl){
                    $title = $pl->getPtitle();
                    $creator = $pl->getUser();
                    $releasedate = $pl->getReleasedate();
                    echo "<tr>";
                    echo "<th>$title</th>";
                    echo "<th>$creator</th>";
                    echo "<th>$releasedate</th>";
                    if($username === $creator){
                        echo "<th>It's you!</th>";
                    }

                    else if($follow_table->exists($username, $creator)){
                        echo "<th><button name='unfollow' type='submit' value='$creator'>Unfollow</button></th>";
                    }else{
                        echo "<th><button name='follow' type='submit' value='$creator'>Follow</button></th>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            }


            $t_result = $track_table->search($keyword);
            if(count($t_result)){
                echo "<h2>Search Results of Tracks:</h2>";
                echo "<table style='width:100%'>";
                echo "<tr><th>Track Name</th><th>Duration</th><th>Artist</th><th>Album</th><th>Play</th><th>Rate</th></tr>";
                $album_table = new \project\Albums($site);
                $rate_table = new \project\Rates($site);
                foreach($t_result as $t){
                    echo "<tr>";
                    $title = $t->getTrackName();
                    $tid = $t->getTrackId();
                    $duration = $t->getDuration();
                    $artist = $t->getArtist();
                    $id = $t->getAlbum();
                    $album = $album_table->get($id);
                    $albname = $album->getAlbname();


                    echo "<th>$title</th>";
                    echo "<th>$duration</th>";
                    echo "<th><a href='artlist.php?name=$artist'>$artist</a></th>";
                    echo "<th>$albname</th>";
                    echo "<th><iframe src=\"https://open.spotify.com/embed?uri=spotify:track:$tid\"
        frameborder = \"0\" allowtransparency = \"true\" ></iframe ></th>";
                    echo "<th><select name=$tid>";
                    $selected = 0;
                    if($rate_table->exists($username,$tid)){
                        $selected = $rate_table->get($username,$tid);
                    }
                    foreach(range(0,5) as $i){
                        if($selected == $i){
                            echo "<option selected value=$i>$i</option>";
                        }
                        else{
                            echo "<option value=$i>$i</option>";
                        }

                    }
                    echo "</select><button name='update' type='submit' value=$tid>Update</button></th>";
                    echo "</tr>";
                }
                echo "</table>";
            }



            $a_result = $artist_table->search($keyword);
            $love_table = new \project\Love($site);
            if(count($a_result)){
                echo "<h2>Search Results of Artists:</h2>";
                echo "<table style='width:100%'>";
                echo "<tr><th>Artist Name</th><th>Description</th><th>Like</th></tr>";
                foreach($a_result as $a){
                    echo "<tr>";
                    $name = $a->getAname();
                    $description = $a->getDescription();
                    echo "<th><a href='artlist.php?name=$name'>$name</a></th>";
                    echo "<th>$description</th>";
                    if($love_table->exists($username,$name)){
                        echo "<th><button name='unlike' type='submit' value=$name>Unlike</button></th>";
                    }
                    else{
                        echo "<th><button name='like' type='submit' value=$name>Like</button></th>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            }
        }

        ?>
    </form>
</article>
</body>
</html>