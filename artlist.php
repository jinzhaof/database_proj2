<?php
require 'lib/site.inc.php';
if(isset($_GET['name'])){
    $aname = $_GET['name'];
    $artist_table = new \project\Artists($site);
    $artist = $artist_table->get($aname);
}?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <link href="style.css" type="text/css" rel="stylesheet">
    <?php $name = $artist->getAname(); echo "<title>$name</title>";?>
</head>
<body>
<header><?php echo "<h1>$name</h1>";?></header>
<article>
    <form method="POST" action="back.php">
        <input type="hidden" value=<?php echo $_GET['name']?> name="aname" />
    <?php
    $description = $artist->getDescription();
    $love_table = new \project\Love($site);
    $username = $_SESSION['user']->getUsername();
    echo "<h2>Description: $description</h2>";
    if($love_table->exists($username,$aname)){
        echo "<h2>You liked the Artist! <button name='like' type='submit' value=0>Unlike</button></h2>";
    }
    else{
        echo "<h2>Do you want to like the Artist? <button name='like' type='submit' value=1>Like</button></h2>";
    }
    echo "<table style='width:100%'>";
    echo "<tr><th>Title</th><th>Duration</th><th>Album</th><th>Play</th><th>Rate</th></tr>";

    $track_table = new \project\Tracks($site);
    $tracks = $track_table->getTracks($aname);
    $album_table = new \project\Albums($site);
    $rate_table = new \project\Rates($site);
    foreach($tracks as $t){
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
        echo "<th>$albname</th>";
        echo "<th><iframe src=\"https://open.spotify.com/embed?uri=spotify:track:$tid\"
        frameborder=\"0\" allowtransparency=\"true\"></iframe></th>";
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
    ?>
</form>
</article>
</body>
</html>