<?php
require 'lib/site.inc.php';
if(isset($_GET['key'])){
    $keyword = '%'.$_GET['key'];
    $keyword = $keyword.'%';
    $track_table = new \project\Tracks($site);
    $username = $_SESSION['user']->getUsername();
}
if(isset($_GET['id'])){
    $pid = $_GET['id'];
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
    <h2><a href="index.php">Log Out</a>       <a href="profile.php">My Profile</a> <a href="<?php echo "manage.php?id=".$pid?>">Manage</a></h2>
    <form method="POST" action="post/addtrack.php">
        <input type="hidden" value=<?php echo $pid?> name="pid" />
        <input type="hidden" value=<?php echo $_GET['key']?> name="key"/>
        <h2><input type="text" size="37" name="search"><button name='s' type='submit'>Search</button></h2>
        <?php
        if(isset($_GET["k"])){
            echo "<h2>Please enter the keyword!</h2>";
        }
        else{
            if(isset($_GET["e"])){
                echo "<h2>This track already exists in the playlist!</h2>";
            }
            $t_result = $track_table->addSearch($keyword);
            echo "<h2>Search Results of Tracks:</h2>";
            echo "<table style='width:100%'>";
            echo "<tr><th>Track Name</th><th>Duration</th><th>Artist</th><th>Album</th><th>Play</th><th>Add</th></tr>";
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
                    echo "<th><button name='add' type='submit' value = $tid>Add</button></th>";
                    echo "</tr>";
                }
            }

            echo "</table>";
        }

        ?>
    </form>
</article>
</body>
</html>