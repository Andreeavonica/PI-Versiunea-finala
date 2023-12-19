<?php

include 'config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';


function sendVerificationEmail($email, $verificationCode) {
   $mail = new PHPMailer(true);

   try {
       // Server settings
       $mail->isSMTP();
       $mail->Host = 'smtp.gmail.com'; // SMTP server
       $mail->SMTPAuth = true;
       $mail->Username = 'andreea.vonica03@e-uvt.ro'; // SMTP username
       $mail->Password = 'tpzh nnot lagi ywwa'; // SMTP password
       $mail->Port = 587; // Change to the appropriate port

       // Recipients
       $mail->setFrom('andreea.vonica03@e-uvt.ro', 'Andreea Vonica');
       $mail->addAddress($email); // Recipient email

       // Content
       $mail->isHTML(true);
       $mail->Subject = 'Account Verification';
       $mail->Body = 'Your verification code is: ' . $verificationCode;

       $mail->send();
       return true;
   } catch (Exception $e) {
       return false;
   }
}


if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
   $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
   $user_type = $_POST['user_type'];

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select_users) > 0){
      $message[] = 'user already exist!';
   }else{
      if($pass != $cpass){
         $message[] = 'confirm password not matched!';
      }else{
         mysqli_query($conn, "INSERT INTO `users`(name, email, password, user_type) VALUES('$name', '$email', '$cpass', '$user_type')") or die('query failed');
         function generateVerificationCode() {
            $verificationCode = mt_rand(100000, 999999); // Generates a random 6-digit number
            return $verificationCode;
        }
          $verificationCode = generateVerificationCode(); // Implement your code generation logic here

    // Store the verification code in the database with the user's data
    $updateVerificationCode = mysqli_query($conn, "UPDATE `users` SET verification_code = '$verificationCode' WHERE email = '$email'");

    if ($updateVerificationCode) {
        // Send the verification email
        if (sendVerificationEmail($email, $verificationCode)) {
            $message[] = 'Registered successfully! Please check your email for verification.';
            header('location: verify.html');
        } else {
            $message[] = 'Failed to send verification email. Please try again.';
        }
    } else {
        $message[] = 'Failed to update verification code. Please try again.';
    }
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>



<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>
   
<div class="form-container">

   <form action="" method="post">
      <h3>register now</h3>
      <input type="text" name="name" placeholder="enter your name" required class="box">
      <input type="email" name="email" placeholder="enter your email" required class="box">
      <input type="password" name="password" placeholder="enter your password" required class="box">
      <input type="password" name="cpassword" placeholder="confirm your password" required class="box">
      <select name="user_type" class="box">
         <option value="user">user</option>
         <option value="admin">admin</option>
      </select>
      <input type="submit" name="submit" value="register now" class="btn">
      <p>already have an account? <a href="login.php">login now</a></p>
   </form>

</div>

</body>
</html>