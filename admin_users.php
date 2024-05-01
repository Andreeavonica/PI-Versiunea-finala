<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `users` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_users.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>users</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="users">
   <h1 class="title">User Accounts</h1>
   <div class="table-container">
      <table>
         <thead>
            <tr>
               <th>User ID</th>
               <th>Username</th>
               <th>Email</th>
               <th>User Type</th>
               <th>Delete User</th>
            </tr>
         </thead>
         <tbody>
            <?php
            $select_users = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed');
            while($fetch_users = mysqli_fetch_assoc($select_users)){
               echo '<tr>';
               echo '<td>' . $fetch_users['id'] . '</td>';
               echo '<td>' . $fetch_users['name'] . '</td>';
               echo '<td>' . $fetch_users['email'] . '</td>';
               echo '<td style="color:' . (($fetch_users['user_type'] == 'admin') ? 'var(--orange)' : 'inherit') . '">' . $fetch_users['user_type'] . '</td>';
               echo '<td><a href="admin_users.php?delete=' . $fetch_users['id'] . '" onclick="return confirm(\'Delete this user?\');" class="delete-btn">Delete User</a></td>';
               echo '</tr>';
            }
            ?>
         </tbody>
      </table>
   </div>
</section>









<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>