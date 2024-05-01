<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>about us</h3>
</div>

<section class="about">

   <div class="flex">

      <div class="image">
         <img src="images/about-img.jpg" alt="">
      </div>

      <div class="content">
         <h3>why choose us?</h3>
         <p>  Founded by passionate artisans with a shared devotion to craftsmanship, our journey began with a vision to redefine the experience of selecting and owning the perfect ring. Each piece in our collection is a testament to our commitment to unparalleled quality and meticulous attention to detail.</p>
         <p>We take pride in offering a diverse range of rings, from classic designs that capture tradition to modern creations that embrace innovation. Our dedication to sourcing ethically and using the finest materials ensures that every ring tells a unique story, resonating with the emotions and aspirations of those who wear them.</p>
         <a href="contact.php" class="btn">contact us</a>
      </div>

   </div>

</section>
<section class="messages">
   <h1>Reviews</h1>
   <?php
   $sql = "SELECT * FROM message";
   $result = mysqli_query($conn, $sql);
   while ($row = mysqli_fetch_assoc($result)) {
      ?>
      <div class="message-box">
         <p><strong>Username:</strong> <?php echo $row['name']; ?></p>
         <p><strong>Email:</strong> <?php echo $row['email']; ?></p>
         <p><strong>Review:</strong> <?php echo $row['message']; ?></p>
         <p><strong>Rating:</strong>
            <?php
            $stars = $row['stars'];
            for ($i = 1; $i <= 5; $i++) {
               if ($i <= $stars) {
                  echo '<i class="fas fa-star"></i>';
               } else {
                  echo '<i class="far fa-star"></i>';
               }
            }
            ?>
         </p>

      </div>
      <?php
   }
   ?>
</section>








<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>