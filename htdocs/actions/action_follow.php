<?php
require "../includes/db.php";

if(!$_SESSION['logged_user']){
    header("Location: ../index.php");
} else {
    $following = $_SESSION['logged_user']->id;
    if(isset($_POST['id2'])){
        $follow_to = $_POST['id2'];

        $friends = R::dispense('friends');

        $friends->id_user = $following;
        $friends->id_user2 = $follow_to;

        R::store($friends);

        $user = R::load('users', $following);
        $user->following_count += 1;
        R::store($user);

        $user = R::load('users', $follow_to);
        $user->followers_count += 1;
        R::store($user);

        header("Location: ../index.php?id=".$follow_to);
    } else {
        header("Location: ../index.php?id=".$following);
    }
}
