<?php
    require "includes/db.php";
?>

<?php if( isset($_SESSION['logged_user']) ) : ?>

<?php
    $user_page = R::findOne('users', 'id = ?', array($_GET['id']));
    $isMy = ($_SESSION['logged_user']->id == $user_page->id);
    $initial = strtoupper($user_page->login{0});
?>

<html>

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <title>Dreamer - <?php echo $user_page->login; ?></title> <!-- USER PAGE LOGIN -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link type="text/css" rel="stylesheet" href="css/profile.css">
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
                <p><b>Dreamer</b></p>
                <a href="actions/action_logout.php">Log out</a>
            </div>
        </header>

        <div class="main_info">
            <div class="top_main_info">
                <div class="image">
                    <p><b><?php echo $initial ?></b></p>
                </div> <!-- USER PAGE IMAGE -->
                <div class="top_main_right_info">
                    <h1 class="login_name"><?php echo $user_page->login; ?></h1> <!-- USER PAGE LOGIN -->
                    <p class="name_surname"> <?php echo $user_page->name_surname ?> </p> <!-- USER PAGE NAME_SURNAME -->

                    <?php if( $isMy )  : ?>

                    <a href="#">Change Photo</a>
                    <a href="#">Settings</a>

                    <?php else : ?>

                    <!-- UNFOLLOWED -->

                    <?php
                            $followed = R::findLike('friends', array(
                                'id_user' => array($_SESSION['logged_user']->id), 'id_user2' => array($user_page->id)
                            ));
                            if(empty($followed)) :
                        ?>
                    <form action="actions/action_follow.php" method="post" class="follow_form">
                        <input type="hidden" name="id2" value="<?php echo $user_page->id ?>">
                        <input type="submit" name="enter" value="Follow" class="button_follow">
                    </form>

                    <?php else: ?>

                    <!-- FOLLOWED -->
                    <form action="actions/action_unfollow.php" method="post" class="follow_form">
                        <input type="hidden" name="id2" value="<?php echo $user_page->id ?>">
                        <input type="submit" name="enter" value="Followed" class="unfollow_button">
                    </form>

                    <?php endif; ?>

                    <a href="#">Message</a>

                    <?php endif; ?>
                    <div class="bottom_main_info">
                        <div class="info_item">
                            <h2><?php echo $user_page->post_count; ?></h2>
                            <p>Posts</p>
                        </div> <!-- USER PAGE post_count  -->
                        <a href="followers.php" class="info_item">
                            <h2><?php echo $user_page->followers_count; ?></h2>
                            <p>Followers</p>
                        </a> <!-- USER PAGE followers_count  -->
                        <a href="following.php" class="info_item">
                            <h2><?php echo $user_page->following_count; ?></h2>
                            <p>Following</p>
                        </a> <!-- USER PAGE following_count  -->
                    </div>
                </div>
            </div>

        </div>

        <?php if ( $isMy ) : ?>

        <div class="new_post">
            <div class="new_post_container"><i class="fas fa-pencil-alt prefix"></i>
                <p>Tell something to your followers!</p>
            </div>
            <form method="post" action="actions/action_post.php">
                <textarea class="txta" name="text" placeholder="Hello!"></textarea>
                <input type="submit" name="post_this" value="Post" class="new_post_button">
            </form>
        </div>

        <?php endif; ?>

        <?php
            $posts = R::find('post', "id_user = ? ORDER BY id DESC", array($_GET['id']) );
            if (!empty($posts)) :
        ?>

        <div class="content">
            <div class="under_post"></div>
            <?php foreach ($posts as $post) : ?>

            <div class="post">

                <div class="top_post_container">

                    <div class="top_post">
                        <div class="min_image">
                            <p><?php echo $initial ?></p>
                        </div>
                        <div class="post_info">
                            <h2><?php echo $user_page->login; ?></h2>
                            <p>posted: <?php echo $post->data." at ".$post->time; ?></p>
                        </div>
                    </div>
                    <?php if ($isMy) : ?>
                    <div class="dropdown">
                        <button class="dropbtn"><i class="fas fa-ellipsis-v"></i></button>
                        <div class="dropdown-content">
                            <a href="actions/action_delete_post.php?post_id=<?php echo $post->id ?>">Delete post</a>
                        </div>
                    </div>
                    <?php endif; ?>

                </div>
                <p class="post_text"><?php echo $post->text; ?></p>

                <div class="right_content">
                    <p class="like_counter"><?php echo $post->like_count; ?></p>
                    <?php
                        $liked = R::findLike('likes', array(
                           'id_user' => array($_SESSION['logged_user']->id), 'id_post' => array($post->id)
                        ));
                        if(empty($liked)) :
                    ?>
                    <form action="actions/action_like.php" method="post" class="follow_form">
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

            <?php endif; ?>
        </div>
        <footer></footer>
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

<?php
    $data = $_POST;

    if( isset($_POST['do_login'])){
        $errors = array();
        $user = R::findOne('users', 'login = ?', array($data['login']));

        //MARK: - Якшо користувач існує то ми провіряєм пароль за допомогою password_verify
        if( $user ){
            if(password_verify($data['password'], $user->password)) {
                // All is correct, LOGIN USER
                $_SESSION['logged_user'] = $user;
                header("Location: ".$_SERVER['REQUEST_URI']."?id=".$user->id);
            }
            else {
                $errors[] = 'Password is not correct!';
            }
        } else {
            $errors[] = 'User with that login was not found!';
        }
    }
    ?>

<html>

<head>
    <meta charset="utf-8">
    <link href="css/index.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Dancing+Script:400,700|Roboto+Condensed:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Amatic+SC|Varela+Round&display=swap" rel="stylesheet">
    <title>Dreamer - Login</title>
    <script src="js/index.js"></script>
</head>

<body>
    <main>
        <h1>Dreamer</h1>
        <?php if( !empty($errors) ) { echo '<div> ' .array_shift($errors). '</div><hr>'; } ?>
        <form method="POST" action="index.php">
            <input name="login" type="text" placeholder="Login" class="inputText" value="<?php echo @$data['login']?>">
            <input name="password" type="password" placeholder="Password" class="inputText" id="showPass">
            <p class="checkbox"><input type="checkbox" onclick="myFunction()"> Show Password</p>
            <input name="do_login" type="submit" value="Log in" class="inputButton">
        </form>
        <div class="regText">
            <p>If you don't have an account yet, you can <a href="signup.php">Sign up!</a></p>
        </div>
    </main>
</body>

</html>

<?php endif; ?>
