<?php
require '../lib/site.inc.php';
$users = new \project\Users($site);
$playlist_table = new \project\Playlists($site);
$include_table = new \project\Includes($site);

if(isset($_POST['s'])){
    $keyword = strip_tags($_POST['search']);
    if($keyword != null){
        header("Location: ../search.php?key=$keyword");
        exit;
    }
    else{
        header("Location: ../profile.php?k");
        exit;
    }
}
else if(isset($_POST['delete'])){
    $pid = $_POST['delete'];
    if($playlist_table->delete($pid) && $include_table->deletePlaylist($pid)){
        header("Location: ../profile.php");
        exit;
    }
}
else if(isset($_POST['manage'])){
    $pid = $_POST['manage'];
    header("Location: ../manage.php?id=$pid");
    exit;
}

else if(isset($_POST['update'])){
    header("Location: ../update.php");
    exit;
}