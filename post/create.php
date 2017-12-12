<?php
require '../lib/site.inc.php';
$playlist_table = new project\Playlists($site);
$username = $_SESSION['user']->getUsername();


$row = array();

if(isset($_POST['create'])){
    $title = strip_tags($_POST['title']);
    if($title != null){
        $ctime = date("Y-m-d H:i:s");
        $id = $playlist_table->add($title,$ctime,$username);
        if($id != null){
            header("Location: ../manage.php?id=$id");
            exit;
        }
    }
    else{
        header("Location: ../create.php?m");
        exit;
    }
}


else if (isset($_POST['cancel'])){
    header("Location: ../profile.php");
    exit;
}