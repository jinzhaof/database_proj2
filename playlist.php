<?php
require 'lib/site.inc.php';
if(isset($_GET['id'])){
    $playlist_table = new \project\Playlists($site);
    $playlist = $playlist_table->get($_GET['id']);
}
$username = $_SESSION['user']->getUsername();?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <link href="style.css" type="text/css" rel="stylesheet">
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

    <?php $ptitle = $playlist->getPtitle(); echo "<title>$ptitle</title>";?>
</head>
<body>
<header><?php echo "<h1>$ptitle</h1>";?></header>
<article>
    <h2><a href="index.php">Log Out</a>       <a href="profile.php">My Profile</a></h2>
    <form method="POST" action="post/playlist.php">
        <input type="hidden" value=<?php echo $_GET['id']?> name="pid" />
        <input type="hidden" value=<?php echo $username?> id="user" />

    <?php
    $releasedate = $playlist->getReleasedate();
    $creator = $playlist->getUser();
    echo "<h2>Releasedate: $releasedate</h2>";
    echo "<h2>Creator: $creator</h2>";
    echo "<table style='width:100%'>";
    echo "<tr><th>Title</th><th>Duration</th><th>Artist</th><th>Album</th><th>Play</th><th>Rate</th></tr>";

    $include_table = new \project\Includes($site);
    $preview_table = new \project\Preview($site);
    $tracks = $include_table->get($_GET['id']);
    $album_table = new \project\Albums($site);
    $rate_table = new \project\Rates($site);
    if(count($tracks)){
        foreach($tracks as $t){
            echo "<tr>";
            $title = $t->getTrackName();
            $tid = $t->getTrackId();
            $duration = $t->getDuration();
            $artist = $t->getArtist();
            $id = $t->getAlbum();
            $album = $album_table->get($id);
            $url = $preview_table->get($tid);
            $albname = $album->getAlbname();

            echo "<th>$title</th>";
            echo "<th>$duration</th>";
            echo "<th><a href='artlist.php?name=$artist'>$artist</a></th>";
            echo "<th>$albname</th>";
            if($url){
                echo "<th><button name='music' type='button' id='$tid' value='$url'>Play</button></th>";
            }
            else{
                echo "<th>Sorry</th>";
            }

//            echo "<th><iframe src=\"https://open.spotify.com/embed?uri=spotify:track:$tid\"
//        frameborder=\"0\" allowtransparency=\"true\"></iframe></th>";
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
    ?>
    </form>

</article>
</body>
</html>
