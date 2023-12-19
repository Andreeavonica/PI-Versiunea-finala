<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['send'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $msg = mysqli_real_escape_string($conn, $_POST['message']);
   $stars = mysqli_real_escape_string($conn, $_POST['stars']);


   $select_message = mysqli_query($conn, "SELECT * FROM `message` WHERE name = '$name' AND email = '$email'  AND message = '$msg' AND stars='$stars'") or die('query failed');

   if(mysqli_num_rows($select_message) > 0){
      $message[] = 'message sent already!';
   }else{
      mysqli_query($conn, "INSERT INTO `message`(user_id, name, email, message, stars) VALUES('$user_id', '$name', '$email', '$msg', '$stars')") or die('query failed');

      $message[] = 'message sent successfully!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>contact</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>your feedback is important to us!</h3>
</div>

<section class="contact">

   <form action="" method="post">
      <h3>say something!</h3>
      <input type="text" name="name" required placeholder="enter your name" class="box">
      <input type="email" name="email" required placeholder="enter your email" class="box">
      
      <textarea name="message" class="box" placeholder="enter your review" id="" cols="30" rows="10"></textarea>
      <p class="rate-services">Rate your experience:</p>

      <div class="rating">
         <input type="radio" id="star1" name="stars" value="1">
         <label for="star1"><i class="fas fa-star"></i></label><br>
         
         <input type="radio" id="star2" name="stars" value="2">
         <label for="star2"><i class="fas fa-star"></i><i class="fas fa-star"></i></label>
         
         <input type="radio" id="star3" name="stars" value="3">
         <label for="star3"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></label><br>
         
         <input type="radio" id="star4" name="stars" value="4">
         <label for="star4"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></label><br>
         
         <input type="radio" id="star5" name="stars" value="5">
         <label for="star5"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></label><br>
      </div>
      
      
      <input type="submit" value="send review" name="send" class="btn">
     
    
   </form>

</section>




<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>