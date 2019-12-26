<?php
require "includes/db.php";
?>

<?php if( isset($_SESSION['logged_user']) ) : ?>

    <html>
    <head>
        <title>Dreamer - Followers </title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link type="text/css" rel="stylesheet" href="css/news.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Dancing+Script:400,700|Roboto+Condensed:400,700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Amatic+SC|Varela+Round&display=swap" rel="stylesheet">
        <script src="js/index.js"></script>
    </head>

    <body>
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="index.php?id=<?php echo $_SESSION['logged_user']->id ?>">Profile</a>
        <a href="news.php">News</a>
        <a href="followers.php">Followers</a>
        <a href="following.php">Following</a>
        <a href="friends.php">Search</a>
        <a href="#">Settings</a>
    </div>

    <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->

    <div id="main">

        <header>
            <div class="inside_header">
                <span onclick="openNav()" class="menu_button"><i class="fas fa-bars"></i></span>
                <p><b>News</b></p>
                <a href="actions/action_logout.php">Log out</a>
            </div>
        </header>

        <div class="content">
            <div class="under_post"></div>

        <?php

        define('MYSQL_SERVER', 'localhost');
        define('MYSQL_USER', 'root');
        define('MYSQL_PASSWORD', '');
        define('MYSQL_DB', 'Dreamer');

            $link = mysqli_connect(MYSQL_SERVER, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
            $query = sprintf("SELECT id_user2 FROM friends WHERE id_user=%d ORDER BY id ASC", (int)$_SESSION['logged_user']->id);
            $result = mysqli_query($link, $query);

            $n = mysqli_num_rows($result);
            $ids = array();

            for($i = 0; $i < $n; $i++)
            {
                $row = mysqli_fetch_assoc($result);
                $ids[] = $row;
            }
            $users_ids = array();
            for($i = 0; $i < $n; $i++){
                $users_ids[$i] = $ids[$i]['id_user2'];
            }

            $posts = R::find( 'post',
                ' id_user IN ('.R::genSlots( $users_ids ).') ORDER BY id DESC',
                $users_ids );
        ?>

            <!-- FOREACH START -->
            <?php foreach ($posts as $post) :?>
            <div class="post">

                <a href="index.php?id=<?php echo $post->id_user ?>" class="top_post_container">

                    <div class="top_post">
                        <div class="min_image"><p><?php echo strtoupper($post->login{0}); ?></p></div>
                        <div class="post_info">
                            <h2><?php echo $post->login ?></h2>
                            <p>posted: <?php echo $post->data." at ".$post->time; ?></p>
                        </div>
                    </div>

                </a>
                <p class="post_text"><?php echo $post->text?></p>

                <div class="right_content">
                    <p class="like_counter"><?php echo $post->like_count; ?></p>
                    <?php
                        $liked = R::findLike('likes', array(
                           'id_user' => array($_SESSION['logged_user']->id), 'id_post' => array($post->id)
                        ));
                        if(empty($liked)) :
                    ?>
                        <form action="actions/action_like.php" method="post">
                            <input type="hidden" name="id2" value="<?php echo $post->id ?>">
                            <input type="submit" name="enter" value="Like" class="like_button">
                        </form>

                    <?php else: ?>

                        <!-- LIKED -->
                        <form action="actions/action_unlike.php" method="post" class="follow_form">
                            <input type="hidden" name="id2" value="<?php echo $post->id ?>">
                            <input type="submit" name="enter" value="Dislike" class="unlike_button">
                        </form>

                    <?php endif; ?>
                </div>


                <div class="line"></div>
            </div>
            <?php endforeach; ?>
            <!-- FOREACH END -->
            


        </div>



    </div>
    <div class="bottom_menu_fixed">
        <a href="news.php"><i class="fas fa-newspaper"></i></a>
        <a href="index.php?id=<?php echo $_SESSION['logged_user']->id ?>"><i class="fas fa-user"></i></a>
        <a href="friends.php"><i class="fas fa-search"></i></a>
        <a href="#"><i class="fas fa-cog"></i></a>
    </div>
    </body>
    </html>



<?php else : ?>
    <?php  header("Location: index.php"); ?>
<?php endif; ?>