<?php
require 'lib/site.inc.php';
if(isset($_GET['id'])){
    $playlist_table = new \project\Playlists($site);
    $playlist = $playlist_table->get($_GET['id']);
}?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <link href="style.css" type="text/css" rel="stylesheet">
    <?php $ptitle = $playlist->getPtitle(); echo "<title>$ptitle</title>";?>
</head>
<body>
<header><?php echo "<h1>$ptitle</h1>";?></header>
<article>
    <?php
    $releasedate = $playlist->getReleasedate();
    $creator = $playlist->getUser();
    echo "<h2>Releasedate: $releasedate</h2>";
    echo "<h2>Creator: $creator</h2>";
    echo "<table style='width:100%'>";
    echo "<tr><th>Title</th><th>Duration</th><th>Artist</th><th>Album</th></tr>";

    $include_table = new \project\Includes($site);
    $tracks = $include_table->get($_GET['id']);
    $album_table = new \project\Albums($site);
    foreach($tracks as $t){
        echo "<tr>";
        $title = $t->getTrackName();
        $duration = $t->getDuration();
        $artist = $t->getArtist();
        $id = $t->getAlbum();
        $album = $album_table->get($id);

        $albname = $album->getAlbname();

        echo "<th>$title</th>";
        echo "<th>$duration</th>";
        echo "<th><a href='artlist.php?name=$artist'>$artist</a></th>";
        echo "<th>$albname</th>";
        echo "</tr>";
    }
    echo "</table>";
    ?>

</article>
</body>
</html>
