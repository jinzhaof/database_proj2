<?php
require '../lib/site.inc.php';
$rate_table = new project\Rates($site);
$user = $_SESSION['user'];
$username = $user->getUsername();
$aid =  $_POST['id'];
$rtime = date("Y-m-d H:i:s");
if(isset($_POST['update'])){
    $tid = $_POST['update'];
    $score = $_POST[$tid];
    if($rate_table->update($username,$tid,$score,$rtime)){
        header("Location: ../artlist.php?id=$aid");
        exit;
    }
}
else if(isset($_POST['play'])){
    echo "play";
}
else if(isset($_POST['like'])){
    $love_table = new \project\Love($site);
    if($_POST['like']){
        if($love_table->add($username,$aid,$rtime)){
            header("Location: ../artlist.php?id=$aid");
            exit;
        }

    }
    else{
        if($love_table->delete($username,$aid)){
            header("Location: ../artlist.php?id=$aid");
            exit;
        }
    }

}



?>