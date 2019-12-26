<?php
require "../includes/db.php";

if(!$_SESSION['logged_user']){
    header("Location: ../index.php");
} else {
    if(isset($_POST['post_this'])){
        if(empty($_POST['text'])){
            header("Location: ../index.php?id=".$_SESSION['logged_user']->id);
        } else {
            $text = htmlspecialchars($_POST['text']);
            $date = date("d.m.Y");
            $time = date("h:i a");

            $post = R::dispense('post');
            $id_user = $_SESSION['logged_user']->id;
            $post->id_user = $id_user;
            $post->text = $text;
            $post->data = $date;
            $post->time = $time;
            $post->login = $_SESSION['logged_user']->login;
            R::store($post);

            $user = R::load('users', $id_user);
            $user->post_count += 1;
            R::store($user);

            header("Location: ../index.php?id=".$_SESSION['logged_user']->id);
        }
    }
}
