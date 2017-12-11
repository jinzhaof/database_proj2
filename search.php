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
    <form method="POST" action="stay.php">
        <h2><input type="text" size="37" name="search"><button name='s' type='submit'>Search</button></h2>
        <?php
        if(isset($_GET["k"])){
            echo "<h2>Please enter the keyword!</h2>";
        }
        $pl_result = $playlist_table->search($keyword);
        echo "<h2>Search Results of Playlists:</h2>";
        echo "<table style='width:100%'>";
        echo "<tr><th>Playlist Title</th><th>creator</th><th>Releasedate</th><th>Follow the creator</th></tr>";
        if(count($pl_result)){
            foreach($pl_result as $pl){
                $title = $pl->getPtitle();
                $creator = $pl->getUser();
                $releasedate = $pl->getReleasedate();
                echo "<tr>";
                echo "<th>$title</th>";
                echo "<th>$creator</th>";
                echo "<th>$releasedate</th>";
                if($follow_table->exists($username, $creator)){
                    echo "<th><button name='unfollow' type='submit' value='$creator'>Unfollow</button></th>";
                }else{
                    echo "<th><button name='follow' type='submit' value='$creator'>Follow</button></th>";
                }
                echo "</tr>";
            }
        }
        echo "</table>";

        $t_result = $track_table->search($keyword);
        echo "<h2>Search Results of Tracks:</h2>";
        echo "<table style='width:100%'>";
        echo "<tr><th>Track Name</th><th>Duration</th><th>Artist</th><th>Album</th><th>Play</th><th>Rate</th></tr>";
        if(count($t_result)){
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
                echo "<th>$artist</th>";
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
        }

        echo "</table>";

        $a_result = $artist_table->search($keyword);
        $love_table = new \project\Love($site);
        echo "<h2>Search Results of Artists:</h2>";
        echo "<table style='width:100%'>";
        echo "<tr><th>Artist Name</th><th>Description</th><th>Like</th></tr>";
        if(count($a_result)){
            foreach($a_result as $a){
                echo "<tr>";
                $name = $a->getAname();
                $description = $a->getDescription();
                echo "<th>$name</th>";
                echo "<th>$description</th>";
                if($love_table->exists($username,$name)){
                    echo "<th><button name='unlike' type='submit' value=$name>Unlike</button></th>";
                }
                else{
                    echo "<th><button name='like' type='submit' value=$name>Like</button></th>";
                }
                echo "</tr>";
            }
        }

        echo "</table>";




//        $description = $artist->getDecription();
//
//        $username = $_SESSION['user']->getUsername();
//        echo "<h2>Description: $description</h2>";
//       {
//            echo "<h2>You liked the Artist! <button name='like' type='submit' value=0>Unlike</button></h2>";
//        }
//        else{
//            echo "<h2>Do you want to like the Artist? <button name='like' type='submit' value=1>Like</button></h2>";
//        }
//        echo "<table style='width:100%'>";
//        echo "<tr><th>Title</th><th>Duration</th><th>Album</th><th>Play</th><th>Rate</th></tr>";
//
//        $track_table = new \project\Tracks($site);
//        $tracks = $track_table->getTracks($aname);
//        $album_table = new \project\Albums($site);
//        $rate_table = new \project\Rates($site);
//        foreach($tracks as $t){
//            echo "<tr>";
//            $title = $t->getTrackName();
//            $tid = $t->getTrackId();
//            $duration = $t->getDuration();
//            $artist = $t->getArtist();
//            $id = $t->getAlbum();
//            $album = $album_table->get($id);
//            $albname = $album->getAlbname();
//
//
//            echo "<th>$title</th>";
//            echo "<th>$duration</th>";
//            echo "<th>$albname</th>";
//            echo "<th><button name='play' type='submit' value=$tid>Play</button></th>";
//            echo "<th><select name=$tid>";
//            $selected = 0;
//            if($rate_table->exists($username,$tid)){
//                $selected = $rate_table->get($username,$tid);
//            }
//            foreach(range(0,5) as $i){
//                if($selected == $i){
//                    echo "<option selected value=$i>$i</option>";
//                }
//                else{
//                    echo "<option value=$i>$i</option>";
//                }
//
//            }
//            echo "</select><button name='update' type='submit' value=$tid>Update</button></th>";
//            echo "</tr>";
//        }
//        echo "</table>";
        ?>
    </form>
</article>
</body>
</html>