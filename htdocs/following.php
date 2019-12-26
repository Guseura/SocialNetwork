<?php
require "includes/db.php";
?>

<?php
if(isset($_SESSION['logged_user']) ) : ?>

    <html>
    <head>
        <title>Dreamer - Followers </title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link type="text/css" rel="stylesheet" href="css/find_friends.css">
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
                <p><b>Following</b></p>
                <a href="actions/action_logout.php">Log out</a>
            </div>
        </header>

        <div class="main_info">
            <h1 class="followers_h1"></h1>
            <?php
            $followed = R::findLike('friends', array(
                'id_user' => array($_SESSION['logged_user']->id)
            ));
            if(!empty($followed)) :
                ?>

                <!-- FOREACH START -->

                <?php foreach ($followed as $followed_user) : ?>
                <?php $user = R::load('users', $followed_user->id_user2);
                $initial = strtoupper($user->login{0});
                ?>
                <div class="result_user">

                    <div class="user_info">
                        <div class="user_image"><p><?php echo initial; ?></p></div>
                        <div class="user_login">
                            <h2><?php echo $user->login ?></h2>
                            <p class="status"><?php echo $user->name_surname ?></p>
                        </div>
                    </div>

                    <a href="index.php?id=<?php echo $user->id ?>" class="subscribe_button">Profile</a>

                </div>
                <div class="line"></div>

            <?php endforeach; ?>
            <?php endif; ?>
            <!-- FOREACH END -->

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
    <?php  header("Location: index.php"); ?>
<?php endif; ?>