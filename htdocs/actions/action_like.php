<?php
require "../includes/db.php";

if(!$_SESSION['logged_user']){
    header("Location: ../index.php");
} else {
	$liker_id = $_SESSION['logged_user']->id;

	if(isset($_POST['id2'])) {
		$like = R::dispense('likes');

		$like->id_user = $liker_id;
        $like->id_post = $_POST['id2'];

        R::store($like);

        $post = R::load('post', $_POST['id2']);
        $post->like_count += 1;
        R::store($post);

        header("Location: ../index.php?id=".$post->id_user);

	} else {
		header("Location: ../news.php");
	}

}

?>