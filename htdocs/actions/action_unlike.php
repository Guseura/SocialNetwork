<?php
require "../includes/db.php";

if(!$_SESSION['logged_user']){
    header("Location: ../index.php");
} else {
    $unliker_id = $_SESSION['logged_user']->id;
    if(isset($_POST['id2'])){
        $unliked_post_id = $_POST['id2'];

        $likes = R::findOne('likes',
            ' id_user = ? AND id_post = ?',
            array(
                $unliker_id, $unliked_post_id
            )
        );

        R::trash($likes);



        $post = R::load('post', $unliked_post_id);
        $id = $post->id_user;
        $post->like_count -= 1;
        R::store($post);

        header("Location: ../index.php?id=".$id);
    } else {
        header("Location: ../news.php");
    }
}