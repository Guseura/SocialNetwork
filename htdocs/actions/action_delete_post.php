<?php
require "../includes/db.php";

if(!$_SESSION['logged_user']) {
    header("Location: index.php");
} else {

    $id = $_GET['post_id'];
    $post = R::load('post', $id);
    $current_user_id = $_SESSION['logged_user']->id;
    if($post->id_user == $current_user_id ) {
        R::trash($post);

        $user = R::load('users', $current_user_id);
        $user->post_count -= 1;
        R::store($user);

        header("Location: ../index.php?id=" . $_SESSION['logged_user']->id);
    } else {
        header("Location: ../index.php?id=" . $_SESSION['logged_user']->id);
    }
}