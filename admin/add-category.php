<?php include'partials/menu.php'; ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>
        
        <br><br>
        
        <?php

            if (isset($_SESSION['add'])) {
	            echo $_SESSION['add'];
                unset($_SESSION['add']);
            }
            
            if (isset($_SESSION['upload'])) {
	            echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }


        ?>
        <br><br>

        <!-- Add category Form -->
        <form action="" method="POST" enctype="multipart/form-data">
            
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title"  placeholder="Category Title">
                    </td>
                </tr>
                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image" >
                    </td>
                </tr>
                
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured"  value="Yes">Yes
                        <input type="radio" name="featured"  value="No">No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active"  value="Yes">Yes
                        <input type="radio" name="active"  value="No">No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit"  value="Add Category" class="btn-secondary">
                    </td>
                </tr>
                
            </table>
            
        </form>
        
        <?php // CONTINUER A 46:00
        
        // Checker si le btn submit est cliquer
        if (isset($_POST['submit'])) {
	        // get the value from Category Form
            $title = $_POST['title'];

            // pour les btn radio on verifie s'ils sont selectinnes ou non
            if (isset($_POST['featured'])) {
	            // get the value
                $featured = $_POST['featured'];
            } else {
	            // le garder a No par defaut
                $featured = "No";
            }

            if (isset($_POST['active'])) {
	            // get the value
                $active = $_POST['active'];
            }  else {
	            // le garder a No par defaut
                $active = "No";
            }

            // Checker si une img est selectionnee ou non et envoyer les valeurs de l'img correspondant
            print_r($_FILES['image']);

            // die(); // interrompre le code ici
            if (isset($_FILES['image']['name'])) {

	            // Upload the img, so we need img name, src path and destination_path
                
                $image_name = $_FILES['image']['name'];
                
                if ($image_name != "") { // Uploader l'img seulement si elle est set selectinnee
	                
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
                        header('location:'.SITEURL.'admin/add-category.php');
                        // arreter le processus
                        die();
                    }
                }

            } else {
	            // Don't upload img and set the image_name value as blank
                $image_name = "";
            }


            // SQL query to insert category into DB
            $sql = "INSERT INTO tbl_category SET
                    title='$title',
                    image_name='$image_name',
                    featured='$featured',
                    active='$active'";

            // Execution
            $res = mysqli_query($conn, $sql);

            // Checker si la req est executee ou non
            if ($res == true) {
	            // afficher ce msg 
                $_SESSION['add'] = "<div class='success'>Category Added Successful.</div>";
                // sur cette page 
                header('location:'.SITEURL.'admin/manage-category.php');
            } else {
	            // afficher ce msg 
                $_SESSION['add'] = "<div class='error'>Failed to Add Category.</div>";
                // sur cette meme page 
                header('location:'.SITEURL.'admin/add-category.php');
            }


        }

        
        ?>
        
        
    </div>
</div>

<?php  include'partials/footer.php'; ?>