<?php
require '../lib/site.inc.php';
$user = $_SESSION['user'];
$include_table = new \project\Includes($site);
$username = $user->getUsername();
$rtime = date("Y-m-d H:i:s");
$pid = $_POST['pid'];

if(isset($_POST['update'])){
    $rate_table = new project\Rates($site);
    $tid = $_POST['update'];
    $pid = $_POST['pid'];
    $score = $_POST[$tid];
    if($rate_table->update($username,$tid,$score,$rtime)){
        header("Location: ../manage.php?id=$pid");
        exit;
    }
}
else if(isset($_POST['delete'])){
    $tid = $_POST['delete'];
    if($include_table->delete($pid,$tid)){
        header("Location: ../manage.php?id=$pid");
        exit;
    }
}
else if(isset($_POST['s'])){
    $keyword = strip_tags($_POST['search']);
    if($keyword != null){
        header("Location: ../addtrack.php?id=$pid&key=$keyword");
        exit;
    }
    else{
        header("Location: ../manage.php?id=$pid");
        exit;
    }
}

?>