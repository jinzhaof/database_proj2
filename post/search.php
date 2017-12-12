<?php
require '../lib/site.inc.php';
$follow_table = new project\Follows($site);
$love_table = new \project\Love($site);
$user = $_SESSION['user'];
$username = $user->getUsername();
$rtime = date("Y-m-d H:i:s");
$keyword = $_POST['key'];

if(isset($_POST['s'])){
    $key = strip_tags($_POST['search']);
    if($key != null){
        header("Location: ../search.php?key=$key");
        exit;
    }
    else{
        header("Location: ../search.php?k");
        exit;
    }
}
else if(isset($_POST['update'])){
    $rate_table = new project\Rates($site);
    $tid = $_POST['update'];
    $score = $_POST[$tid];
    if($rate_table->update($username,$tid,$score,$rtime)){
        header("Location: ../search.php?key=$keyword");
        exit;
    }
}

else if(isset($_POST['like'])){
    if($love_table->add($username,$_POST['like'],$rtime)){
        header("Location: ../search.php?key=$keyword");
        exit;
    }

}
else if(isset($_POST['unlike'])){
    if($love_table->delete($username,$_POST['unlike'])){
        header("Location: ../search.php?key=$keyword");
        exit;
    }
}

else if(isset($_POST['follow'])){
    if($follow_table->add($username,$_POST['follow'],$rtime)){
        header("Location: search.php?key=$keyword");
        exit;
    }

}
else if(isset($_POST['unfollow'])){
    if($follow_table->delete($username,$_POST['unfollow'])){
        header("Location: search.php?key=$keyword");
        exit;
    }
}





?>