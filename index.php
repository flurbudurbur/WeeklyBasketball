<?php
session_start();
require_once("PHP/DB/_conn.php");
require_once("PHP/INCLUDE/functions.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weekly Basketball</title>
    <link rel="shortcut icon" href="./img/basketball.png" type="image/x-icon">
    <link rel="stylesheet" href="./css/main.css">
</head>

<body>
    <?php
    if (sessionCheck('login_status')) {
        sessionSet('login_status');
    }

    if (!sessionCheck('logged_in')) {
    ?>
        <form action="./PHP/INCLUDE/signin.php" method="post">
            <input type="email" name="si_mail" id="si_mail" placeholder="Email">
            <input type="password" name="si_pass" id="si_pass" placeholder="Password">
            <input type="submit" value="Sign In!">
        </form>
    <?php
    }
    ?>

    <form action="./PHP/INCLUDE/signup.php" method="post">
        <input type="email" name="su_mail" id="su_mail" placeholder="Email">
        <input type="text" name="su_user" id="su_user" placeholder="Username">
        <input type="password" name="su_pass" id="su_pass" placeholder="Password">
        <input type="password" name="su_pass_check" id="su_pass_check" placeholder="Password Confirmation">
        <input type="submit" value="Sign Up!">
    </form>

    <?php
    if (sessionCheck('logged_in')) {
        echo '<a href="./PHP/INCLUDE/signout.php">Sign Out</a>';
        include 'PHP/INCLUDE/dropfiles.php';
    ?>
        <form action="./PHP/INCLUDE/fileupload.php" method="post" enctype="multipart/form-data" class="max-w-md">
            <div class="grid grid-cols-2">
                <label for="fl_file">File: </label>
                <input type="file" name="fl_file" id="fl_file" />
                <label for="fl_title">Title: </label>
                <input type="text" name="fl_title" id="fl_title" placeholder="Title" />
                <label for="fl_player">Player: </label>
                <input type="text" name="fl_player" id="fl_player" placeholder="Player" />
                <label for="fl_date">Date: </label>
                <input type="date" name="fl_date" id="fl_date" value="<?php echo date("Y-m-d") ?>" />
                <label for="fl_club">Club: </label>
                <input type="text" name="fl_club" id="fl_club" placeholder="Coach Cowards" />
                <label for="fl_points">Points after goal: </label>
                <input type="text" name="fl_points" id="fl_points" placeholder="31-12" />
            </div>
            <input type="submit" value="Submit" class="bg-orange-400 w-full" />
        </form>
    <?php
    }


    $stmt = $conn->prepare("SELECT users.users_mail, users.users_username, posts.posts_from_user, posts.* from users INNER JOIN posts ON users.users_mail = posts.posts_from_user ORDER BY posts.posts_curated_likes DESC");
    $stmt->execute();
    $result = $stmt->get_result();


    include 'PHP/INCLUDE/entries.php';
    ?>
</body>

</html>