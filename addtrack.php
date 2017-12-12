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
    <title>Search</title>
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
<header><h1>Search</h1></header>
<article>
    <h2><a href="index.php">Log Out</a>       <a href="profile.php">My Profile</a> <a href="<?php echo "manage.php?id=".$pid?>">Manage</a></h2>
    <form method="POST" action="post/addtrack.php">
        <input type="hidden" value=<?php echo $pid?> name="pid" />
        <input type="hidden" value=<?php echo $_GET['key']?> name="key"/>
        <input type="hidden" value=<?php echo $username?> id="user" />
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
            echo "<table align='center'>";
            echo "<tr><th>Track Name</th><th>Duration</th><th>Artist</th><th>Album</th><th>Play</th><th>Add</th></tr>";
            if(count($t_result)){
                $album_table = new \project\Albums($site);
                $rate_table = new \project\Rates($site);
                $preview_table = new \project\Preview($site);
                foreach($t_result as $t){
                    echo "<tr>";
                    $title = $t->getTrackName();
                    $tid = $t->getTrackId();
                    $duration = $t->getDuration();
                    $artist = $t->getArtist();
                    $id = $t->getAlbum();
                    $album = $album_table->get($id);
                    $albname = $album->getAlbname();
                    $url = $preview_table->get($tid);

                    echo "<th style='width:50%'>$title</th>";
                    echo "<th>$duration</th>";
                    echo "<th>$artist</th>";
                    echo "<th>$albname</th>";
                    if($url){
                        echo "<th><button name='music' type='button' id='$tid' value='$url'>Play</button></th>";
                    }
                    else{
                        echo "<th>Sorry</th>";
                    }
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