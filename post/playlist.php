<?php
require '../lib/site.inc.php';
$user = $_SESSION['user'];
$username = $user->getUsername();
$rtime = date("Y-m-d H:i:s");

if(isset($_POST['update'])){
    $rate_table = new project\Rates($site);
    $tid = $_POST['update'];
    $pid = $_POST['pid'];
    $score = $_POST[$tid];
    if($rate_table->update($username,$tid,$score,$rtime)){
        header("Location: ../playlist.php?id=$pid");
        exit;
    }
}

?>