<?php
require '../lib/site.inc.php';
$play_table = new project\Play($site);

if(isset($_POST['username'])&&isset($_POST['tid'])){
    $user = $_POST['username'];
    $tid = $_POST['tid'];
    $ptime = date("Y-m-d H:i:s");

    if($play_table->add($user,$tid,$ptime)){
        echo "You do post";
    }
    else{
        echo false;
    }
}
else{
    echo false;
}