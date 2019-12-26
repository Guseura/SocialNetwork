<?php
require "../includes/db.php";

if(!$_SESSION['logged_user']){
    header("Location: ../index.php");
} else {
    $unfollower = $_SESSION['logged_user']->id;
    if(isset($_POST['id2'])){
        $unfollow_from = $_POST['id2'];

        $friends = R::findOne('friends',
            ' id_user = ? AND id_user2 = ?',
            array(
                $unfollower, $unfollow_from
            )
        );

        R::trash($friends);



        $user = R::load('users', $unfollower);
        $user->following_count -= 1;
        R::store($user);

        $user = R::load('users', $unfollow_from);
        $user->followers_count -= 1;
        R::store($user);

        header("Location: ../index.php?id=".$unfollow_from);
    } else {
        header("Location: ../index.php?id=".$unfollow_from);
    }
}
