<?php
require 'lib/site.inc.php';
if(isset($_GET['id'])){
    $artist_table = new \project\Artists($site);
    $aid = $_GET['id'];
    $artist = $artist_table->get($aid);
    $username = $user->getUsername();
}?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <link href="style.css" type="text/css" rel="stylesheet">
    <?php $aname = $artist->getAname(); echo "<title>$aname</title>";?>
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
<header><?php echo "<h1>$aname</h1>";?></header>
<article>
    <h2><a href="index.php?l">Log Out</a>       <a href="profile.php">My Profile</a></h2>
    <form method="POST" action="post/artlist.php">
        <input type="hidden" value=<?php echo $_GET['id']?> name="id" />
        <input type="hidden" value=<?php echo $username?> id="user" />
    <?php
    $description = $artist->getDescription();
    $love_table = new \project\Love($site);
    $username = $user->getUsername();
    echo "<h2>Description: $description</h2>";
    if($love_table->exists($username,$aid)){
        echo "<h2>You liked the Artist! <button name='like' type='submit' value=0>Unlike</button></h2>";
    }
    else{
        echo "<h2>Do you want to like the Artist? <button name='like' type='submit' value=1>Like</button></h2>";
    }


    $track_table = new \project\Tracks($site);
    $tracks = $track_table->getTracks($aname);
    $album_table = new \project\Albums($site);
    $rate_table = new \project\Rates($site);
    $preview_table = new \project\Preview($site);
    if(count($tracks)){
        echo "<table style='width:100%'>";
        echo "<tr><th>Title</th><th>Duration</th><th>Album</th><th>Play</th><th>Rate</th></tr>";
        foreach($tracks as $t){
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
            echo "<th>$albname</th>";
            if($url){
                echo "<th><button name='music' type='button' id='$tid' value='$url'>Play</button></th>";
            }
            else{
                echo "<th>Sorry</th>";
            }
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
    else{
        echo "<h2>Sorry, $aname does not have any tracks in database.</h2>";
    }

    ?>
</form>
</article>
</body>
</html>