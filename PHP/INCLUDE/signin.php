<?php
session_start();
require_once '../DB/_conn.php';
require_once 'functions.php';

$_POST = validate($_POST);

if (isset($_POST['si_mail']) && isset($_POST['si_pass'])) {
    $email = $_POST['si_mail'];
    $password = $_POST['si_pass'];

    // Hash the password before comparing it to the database
    // You should also retrieve the hashed password from the database for comparison
    // $hashedPasswordFromDatabase = retrieveHashedPasswordFromDatabase($email);
    
    // Check if the provided password matches the hashed password from the database
    // if (password_verify($password, $hashedPasswordFromDatabase)) {
    
    // Use prepared statements to avoid SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE users_mail = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        if (password_verify($password, $result->fetch_assoc()['users_password'])) {
            $_SESSION['login_status'] = "login successful!";
            $_SESSION['logged_in'] = true;
            $_SESSION['email'] = $email;
            header("Location: ../../index.php");
        } else {
            $_SESSION['login_status'] = "Email and/or password is incorrect.";
            header("Location: ../../index.php");
        }
    } else {
        $_SESSION['login_status'] = "Email and/or password is incorrect.";
        header("Location: ../../index.php");
    }
} else {
    $_SESSION['login_status'] = "Email and/or password is incorrect.";
    header("Location: ../../index.php");
}
?>
