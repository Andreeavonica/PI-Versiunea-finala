<?php
include 'config.php';
session_start();
if(isset($_POST['submit_verification'])) {
    $inputVerificationCode = mysqli_real_escape_string($conn, $_POST['verification_code']);
    $email = $_SESSION['user_email']; // Retrieve the user's email from the session

    $checkVerificationCode = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND verification_code = '$inputVerificationCode'");

    if(mysqli_num_rows($checkVerificationCode) > 0) {
        header('location: login.php');
    } else {
        header('location: login.php');
    }
}
?>
