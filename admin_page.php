<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin panel</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<!-- admin dashboard section starts  -->

<?php
// Assuming $conn is the database connection

// Calculate total pending amount
$total_pendings = 0;
$select_pending = mysqli_query($conn, "SELECT total_price FROM `orders` WHERE payment_status = 'pending'") or die('query failed');
if(mysqli_num_rows($select_pending) > 0){
    while($fetch_pendings = mysqli_fetch_assoc($select_pending)){
        $total_price = $fetch_pendings['total_price'];
        $total_pendings += $total_price;
    }
}

// Calculate total completed payments
$total_completed = 0;
$select_completed = mysqli_query($conn, "SELECT total_price FROM `orders` WHERE payment_status = 'completed'") or die('query failed');
if(mysqli_num_rows($select_completed) > 0){
    while($fetch_completed = mysqli_fetch_assoc($select_completed)){
        $total_price = $fetch_completed['total_price'];
        $total_completed += $total_price;
    }
}

// Count the number of orders, products, users, admins, accounts, and messages
$select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
$number_of_orders = mysqli_num_rows($select_orders);

$select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
$number_of_products = mysqli_num_rows($select_products);

$select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'user'") or die('query failed');
$number_of_users = mysqli_num_rows($select_users);

$select_admins = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'admin'") or die('query failed');
$number_of_admins = mysqli_num_rows($select_admins);

$select_account = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed');
$number_of_account = mysqli_num_rows($select_account);

$select_messages = mysqli_query($conn, "SELECT * FROM `message`") or die('query failed');
$number_of_messages = mysqli_num_rows($select_messages);
?>

<section class="dashboard">
   <h1 class="title">Dashboard</h1>

   <table class="custom-table">
       <tr>
           <th class="table-header">Metric</th>
           <th class="table-header">Result</th>
       </tr>

       <tr>
           <td class="table-data">Total Pendings</td>
           <td class="table-data"><?php echo '$' . $total_pendings ; ?></td>
       </tr>

       <tr>
           <td class="table-data">Completed Payments</td>
           <td class="table-data"><?php echo '$' . $total_completed ; ?></td>
       </tr>

       <tr>
           <td class="table-data">Order Placed</td>
           <td class="table-data"><?php echo $number_of_orders; ?></td>
       </tr>

       <tr>
           <td class="table-data">Products Added</td>
           <td class="table-data"><?php echo $number_of_products; ?></td>
       </tr>

       <tr>
           <td class="table-data">Normal Users</td>
           <td class="table-data"><?php echo $number_of_users; ?></td>
       </tr>

       <tr>
           <td class="table-data">Admin Users</td>
           <td class="table-data"><?php echo $number_of_admins; ?></td>
       </tr>

       <tr>
           <td class="table-data">Total Accounts</td>
           <td class="table-data"><?php echo $number_of_account; ?></td>
       </tr>

       <tr>
           <td class="table-data">New Messages</td>
           <td class="table-data"><?php echo $number_of_messages; ?></td>
       </tr>
   </table>
</section>

<!-- admin dashboard section ends -->









<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>