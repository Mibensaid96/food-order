<?php 
	include '../admin/config/constants.php';


	// checker si les val de id et image_name sont envoyer
	if ($_GET['id'] AND isset($_GET['image_name'])) {

		// get the value and delete
		$id = $_GET['id'];
		$image_name = $_GET['image_name'];

		// Remove the physical img file if available
		if ($image_name != "") { // s'il ya bien une img 

			$path = "../images/category/".$image_name;
			$remove = unlink($path); // supprimer l'img (cette fct retourne un booleen
			
			if ($remove == false) { 
				// si la suppression echoue ajouter un msg et arreter le processus
				$_SESSION['remove'] = "<div class='error'>Failed to Remove Category Image.</div>";
                header('location:'.SITEURL.'admin/manage-category.php');
				die();
			}

		}

		// Delete data from DB
		$sql = "DELETE FROM tbl_category WHERE id=$id";
		$res = mysqli_query($conn, $sql);

		// rediriger a Manage Category avec un msg
		if ($res == true) {
			// set success msg and redirect
			$_SESSION['remove'] = "<div class='success'>Category Deleted Successfully.</div>";
            header('location:'.SITEURL.'admin/manage-category.php');
		} else {
			// set success msg and redirect
			$_SESSION['delete'] = "<div class='error'>Failed to Remove Category.</div>";
			header('location:'.SITEURL.'admin/manage-category.php');
		}


	} else {

		// rediriger a la page Manage Category
		header('location:'.SITEURL.'admin/manage-category.php');
	}


?>