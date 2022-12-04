<?php include 'partials/menu.php'; ?>

<div class="main-content">
    
    <div class="wrapper">
        <h1>Update Category</h1>
        
        <br /><br>
        
        <?php

        if (isset($_GET['id'])) {
	        // get id and other details
            $id = $_GET['id'];

            // Query to get all other details
            $sql = "SELECT * FROM tbl_category WHERE id=$id";

            $res = mysqli_query($conn, $sql);

            $count = mysqli_num_rows($res);

            if ($count == 1) {

	            // get the data
                $rows = mysqli_fetch_assoc($res);
                $title = $rows['title'];
                $current_image = $rows['image_name'];
                $featured = $rows['featured'];
                $active = $rows['active'];

            } else {
	            // Redirect to Manage Category with msg
                $_SESSION['no-category-found'] = "<div class='error'>Category not Found.</div>"; 
                header('location:'.SITEURL.'admin/add-category.php');
            }



        } else {
	        // Redirect to Manage Category
            header('location:'.SITEURL.'admin/manage-category.php');
        }


        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Current Image:</td>
                    <td>
                        <?php
                            if ($current_image != "") {
	                            // Display img
                                ?>

                                <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" width="150px">


                                <?php
                            } else {
	                            // Display msg
                                echo "<div class='error'>Image Not Added.</div>";
                            }

                        ?>
                    </td>
                </tr>
                <tr>
                    <td>New Image: </td>
                    <td>
                        <input type="file" name="image" >
                    </td>
                </tr>
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input <?php if($featured=="Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes">Yes
                        <input <?php if($featured=="No"){echo "checked";} ?>  type="radio" name="featured" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if($active=="Yes"){echo "checked";} ?>  type="radio" name="active" value="Yes">Yes
                        <input <?php if($active=="No"){echo "checked";} ?>  type="radio" name="active" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
            
        </form>

        <?php
            if (isset($_POST['submit'])) {
	            
                // get the values from our form
                $id = $_POST['id'];
                $title = $_POST['title'];
                $current_image = $_POST['current_image'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];

                // Updating new Img if selected
                if (isset($_FILES['image']['name'])) {
	                
                    // get the img details
                    $image_name = $_FILES['image']['name'];

                    if ($image_name !="") { // if img available
                        
                        // A. Upload new Img
                        // Renommer l'img automatiquement
                        $ext = end(explode('.', $image_name)); // get extension of our img (jpg, png, gif, ect)
                        $image_name = "Food_Category_".rand(000, 999).'.'.$ext; // new name 

                        $source_path = $_FILES['image']['tmp_name'];
                        $destination_path = "../images/category/".$image_name;

                        // Upload the img
                        $upload = move_uploaded_file($source_path, $destination_path);

                        // Checker si l'img est envoyer ou non
                        if ($upload == false) { // si elle n'est pas envoyee
	                        // set msg
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
                            // sur cette page 
                            header('location:'.SITEURL.'admin/manage-category.php');
                            // arreter le processus
                            die();
                        }

                        // B. Remove the current_image
                        if($current_image !="") {
                            $remove_path = "../images/category/".$current_image;
                            $remove = unlink($remove_path);

                            //Checker si l'img est supprimee ou non
                            if($remove == false) {
                                $_SESSION['failed-remove'] = "<div class='error'>Failed to Remove Image.</div>"; 
                                header('location:'.SITEURL.'admin/manage-category.php');
                                die();
                            }
                        }
                        
                    } else { // sinon garder l'img actuel
                        $image_name = $current_image;
                    }

                } else {
                     $image_name = $current_image;

                }


                // Update the DB
                $sql2 = "UPDATE tbl_category SET
                         title='$title',
                         image_name = '$image_name',
                         featured='$featured',
                         active='$active'
                         WHERE id=$id";

                $res2 = mysqli_query($conn, $sql2);

                // Redirect to Manage Category with msg
                if ($res2 == true) {

	                // Category Update
                    $_SESSION['update'] = "<div class='success'>Category Updated Successfully.</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                } else {
	                // failed to update Category
                    $_SESSION['update'] = "<div class='error'>Failed to Updated Category.</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }


            }

        ?>

    </div>
    
</div>



<?php include 'partials/footer.php'; ?>