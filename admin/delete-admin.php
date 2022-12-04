<?php

include'../admin/config/constants.php';

// 1. get the ID of Admin to be deleted
$id = $_GET['id'];

// 2. create SQL Query to delete Admin
$sql = "DELETE FROM tbl_admin WHERE id=$id";

$res = mysqli_query($conn, $sql);

// 3. check whether the query executed or not
if($res == true){
    // 4. redirect to Manage Admin page with msg (success/error)
    
    // create session variable to display msg
    $_SESSION['delete'] = "<div class='success'>Admin Deleted Successfully</div>";
    header('location:'.SITEURL.'admin/manage-admin.php'); 
    
    
} else {
    $_SESSION['delete'] = "<div class='error'>Failed to Delete Admin. Try again later.</div>";
    header('location:'.SITEURL.'admin/manage-admin.php'); 
}




?>
