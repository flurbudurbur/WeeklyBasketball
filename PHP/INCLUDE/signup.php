<?php
session_start();
require_once '../DB/_conn.php';
require_once 'functions.php';

$_POST = validate($_POST);

$email = $_POST["su_mail"];
$username = $_POST["su_user"];
$password = $_POST["su_pass"];
$confirmpassword = $_POST["su_pass_check"];
$duplicate = mysqli_query($conn, "SELECT * From users WHERE users_mail = '$email'");

// $potato = mysqli_query($conn, "SELECT * FROM users");
// echo mysqli_num_rows($potato);
// exit;

if (mysqli_num_rows($duplicate) > 0) {
    echo "<script> alert('Gebruikersnaam of E-Mail zijn al in gebruik')</script>";
} else {
    if ($password == $confirmpassword) {
        $hash = password_hash($password, PASSWORD_DEFAULT, ['cost' => 10]);
        $query = "INSERT INTO users (`users_username`, `users_mail`, `users_password`) VALUES ('$username', '$email', '$hash')";
        mysqli_query($conn, $query);
        if (mysqli_error($conn)) {
            // Check for any errors in the query
            echo "Error: " . mysqli_error($conn);
        } else {
            // You can redirect the user to another page after successful insertion
            header("Location: ../../index.php");
        }
    } else {
        echo
        "<script> alert('Wachtworden komen niet evereen')</script>";
    }
}
?>