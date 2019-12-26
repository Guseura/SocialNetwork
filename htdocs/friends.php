<?php
require "includes/db.php";
?>

<?php if( isset($_SESSION['logged_user']) ) : ?>
    <html>
    <head>
        <title>Dreamer - Find</title>
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
                <p>Search</p>
                <a href="actions/action_logout.php">Log out</a>
            </div>
        </header>

        <form method="get" action="friends.php">
            <div class="find">
                <div class="search">
                    <input name="login_search" type="text" class="searchTerm" placeholder="Who are you looking for?">
                    <button type="submit" class="searchButton">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
        </form>

        <?php

        if(!empty($_GET['login_search'])){

            $searched = $_GET['login_search'];
            $user = R::find('users',' login LIKE :login OR name_surname LIKE :name_surname ',
                array(
                        ':login' => '%' . $searched . '%',
                        ':name_surname' => '%' . $searched . '%'
                )
            );

        }
        if(!empty($user)) : ?>

        <div class="main_info">
            <div class="space"></div>

            <?php foreach ($user as $searched_user) : ?>

            <div class="result_user">

                <div class="user_info">
                    <div class="user_image"><p>G</p></div>
                    <div class="user_login">
                        <h2><?php echo $searched_user->login ?></h2>
                        <p class="status">
                            <?php echo $searched_user->name_surname  ?>

                        </p>
                    </div>
                </div>

                <a href="index.php?id=<?php echo $searched_user->id ?>" class="subscribe_button">Profile</a>
            </div>
            <div class="line"></div>

            <?php endforeach;?>

        </div>

        <?php endif;?>

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

<? else: ?>
    <?php header("Location: index.php"); ?>
<?endif;?>
