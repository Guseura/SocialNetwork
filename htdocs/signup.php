<?php
    require "includes/db.php";

    $data = $_POST;
    if( isset($data['do_signup']) )
    {
        // Mark: - Check Errors
        $errors = array();
        if( trim($data['login']) == '' ) {
            $errors[] = 'Enter login!';
        }
        if( $data['password'] == '' ) {
            $errors[] = 'Enter legal password!';
        }
        if( trim($data['email']) == '' ) {
            $errors[] = 'Enter legal email!';
        }
        if(trim($data['name_surname']) == '' ) {
            $errors[] = 'Enter your name & surmane';
        }
        if( R::count('users', "login = ?", array($data['login'])) > 0 ){
            $errors[] = "User with this login already exists!";
        }
        if( R::count('users', "email = ?", array($data['email'])) > 0 ){
            $errors[] = "User with this Email already exists!";
        }

        if( empty($errors)) {
            // Mark: - All is good we can register
            $user = R::dispense('users');
            $user->login = $data['login'];
            $user->email = $data['email'];
            $user->password = password_hash($data['password'], PASSWORD_DEFAULT);
            $user->name_surname = $data['name_surname'];
            $user->post_count = 0;
            $user->followers_count = 0;
            $user->following_count = 0;
            R::store($user);
            $errors[] = "REGISTRATION SUCCSESS ";
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
    <script src="js/index.js"></script>
    <title>Dreamer - Registration</title>
</head>
<body>
    <main>
        <h1>Dreamer</h1>
        <?php if(!empty($errors)) { echo '<div style="color: crimson"> '.array_shift($errors). '</div><hr >';}  ?>
        <form method="POST" action="/signup.php">

            <input name="email" type="email" placeholder="E-mail" class="inputText" value="<?php echo @$data['email'] ?>">
            <input name="name_surname" type="text" placeholder="Name Surname" class="inputText" value="<?php echo @$data['name_surname'] ?>">

            <input name="login" type="text" placeholder="Login" class="inputText" value="<?php echo @$data['login'] ?>">
            <input name="password" type="password" placeholder="Password" class="inputText" minlength="6" maxlength="255" >
            <input name="do_signup" type="submit" value="Sign up" class="inputButton">

        </form>
        <a href="index.php" class="enter">Log in</a>
    </main>
</body>
</html>