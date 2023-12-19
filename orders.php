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
   <title>orders</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>My orders</h3>
</div>

<section class="placed-orders">

   <h1 class="title">placed orders</h1>

   <div class="box-container">
   <table>
      <tr>
         <th>Placed On</th>
         <th>Name</th>
         <th>Number</th>
         <th>Email</th>
         <th>Address</th>
         <th>Payment Method</th>
         <th>Your Orders</th>
         <th>Total Price</th>
         <th>Payment Status</th>
      </tr>

      <?php
         $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = '$user_id'") or die('query failed');
         if(mysqli_num_rows($order_query) > 0){
            while($fetch_orders = mysqli_fetch_assoc($order_query)){
      ?>
      <tr>
         <td><?php echo $fetch_orders['placed_on']; ?></td>
         <td><?php echo $fetch_orders['name']; ?></td>
         <td><?php echo $fetch_orders['number']; ?></td>
         <td><?php echo $fetch_orders['email']; ?></td>
         <td><?php echo $fetch_orders['address']; ?></td>
         <td><?php echo $fetch_orders['method']; ?></td>
         <td><?php echo $fetch_orders['total_products']; ?></td>
         <td>$<?php echo $fetch_orders['total_price']; ?></td>
         <td style="color:<?php if($fetch_orders['payment_status'] == 'pending'){ echo 'red'; }else{ echo 'green'; } ?>;"><?php echo $fetch_orders['payment_status']; ?></td>
      </tr>
      <?php
         }
      } else {
         echo '<tr><td colspan="9" class="empty">No orders placed yet!</td></tr>';
      }
      ?>
   </table>
</div>

</section>








<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>