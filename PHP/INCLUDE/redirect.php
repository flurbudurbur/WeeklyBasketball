<?php
session_start();

$user = $_GET['user'];
if (isset($_SESSION['redirect_user'])) {
    $_SESSION['redirect_user'] = $user;
    header("Location: ../../user/");
} else {
    unset($_SESSION['redirect_user']);
    header('Location: ../../');
}
