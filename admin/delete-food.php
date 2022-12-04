<?php
include '../admin/config/constants.php';


if (isset($_GET['id']) && isset($_GET['image_name'])) {
	// process delete
	// get Id and image_name
	$id = $_GET['id'];
	$image_name = $_GET['image_name'];

	// remove the img if available
	if ($image_name != "") {

        // remove from folder
        $path = "../images/food/".$image_name; // get img path
        $remove = unlink($path);  // remove img file 

        if ($remove == false) { // if img don't delete, display session msg and stop process
            $_SESSION['delete'] = "<div class='error'>Failed to Remove Image.</div>"; // .print_r($image_name)
            header('location:'.SITEURL.'admin/manage-food.php');
            die();
        }

    }
    
    // Delete food from DB
    $sql = "DELETE FROM tbl_food WHERE id=$id";
    
    $res = mysqli_query($conn, $sql);
    
    if($res == true) {
        $_SESSION['delete'] = "<div class='success'>Food Deleted Successfully.</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    } else {
        $_SESSION['delete'] = "<div class='error'>Failed to Deleted Food.</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }

	// redirect to Manage Food with msg
    

} else {
	// redirect to Manage Food Page
	$_SESSION['unauthorize'] = "<div class='error'>Unauthorized Access.</div>";
    header('location:'.SITEURL.'admin/manage-food.php');

}



?>