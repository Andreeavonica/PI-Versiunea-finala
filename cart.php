<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['update_cart'])){
   $cart_id = $_POST['cart_id'];
   $cart_quantity = $_POST['cart_quantity'];
   mysqli_query($conn, "UPDATE `cart` SET quantity = '$cart_quantity' WHERE id = '$cart_id'") or die('query failed');
   $message[] = 'cart quantity updated!';
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$delete_id'") or die('query failed');
   header('location:cart.php');
}

if(isset($_GET['delete_all'])){
   mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
   header('location:cart.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>cart</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>shopping cart</h3>
</div>

<section class="shopping-cart">

   <!-- ... existing code ... -->

   <table class="products-table">
    <thead>
        <tr>
            <th></th>
            <th>Product</th>
            <th>Quantity</th>
            <th>Sub Total</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $grand_total = 0;
            $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
            if(mysqli_num_rows($select_cart) > 0){
                while($fetch_cart = mysqli_fetch_assoc($select_cart)){   
                    $sub_total = ($fetch_cart['quantity'] * $fetch_cart['price']);
                    $grand_total += $sub_total;
        ?>
        <tr>
            <td>
                <a href="cart.php?delete=<?php echo $fetch_cart['id']; ?>" class="fas fa-times" onclick="return confirm('Delete this from cart?');"></a>
            </td>
            <td>
            <img src="images/<?php echo $fetch_cart['image']; ?>" alt="">
                <div><?php echo $fetch_cart['name']; ?></div>
                <div>$<?php echo $fetch_cart['price']; ?></div>
            </td>
            <td>
                <form action="" method="post">
                    <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
                    <input type="number" min="1" name="cart_quantity" value="<?php echo $fetch_cart['quantity']; ?>" style="width: 70px; padding: 8px; font-size: 16px;">
                    <input type="submit" name="update_cart" value="Update" class="option-btn">
                </form>
            </td>
            <td>
                $<?php echo $sub_total; ?></td>
            </td>
        </tr>
        <?php
                }
            } else {
                echo '<tr><td colspan="4" class="empty">Your cart is empty</td></tr>';
            }
        ?>
    </tbody>
</table>



   <div class="cart-total">
      <p>Total : <span>$<?php echo $grand_total; ?></span></p>
      <p>Add promotional code:</p>
      <form action="" method="post">
         <input type="text" name="promo_code" placeholder="Enter promotional code">
         <input type="submit" name="apply_code" value="Apply" class="option-btn">
      </form>
      <?php
      // Check if the promotional code form is submitted
      if(isset($_POST['apply_code'])){
         // Get the entered code
         $entered_code = $_POST['promo_code'];

         // Define your expected code
         $expected_code = "ABC123"; // Replace with your actual code

         // Check if the entered code matches the expected code
         if($entered_code === $expected_code){
            // Apply a 10% discount
            $grand_total *= 0.9; // 10% discount

            // Display the updated total after the discount
            echo '<p>Congratulations! You got a 10% discount. <br>New total: $' . number_format($grand_total, 2) . '</p>';
         } else {
            // Display a message for an incorrect code
            echo '<p>Invalid promotional code. Please try again.</p>';
         }
      }
   ?>
      <div class="flex">
         <a href="shop.php" class="option-btn">continue shopping</a>
         <a href="checkout.php" class="btn <?php echo ($grand_total > 1)?'':'disabled'; ?>">proceed to checkout</a>
      </div>
   </div>

   <!-- ... existing code ... -->

</section>








<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>