<?php include 'partials/menu.php'; ?>

<?php

    if (isset($_GET['id'])) { // notre page ne sera afficher que si 
	    $id = $_GET['id']; // un id d'un item a modifier est transmis
        
        $sql2 = "SELECT * FROM tbl_food WHERE id=$id"; // demande de l'item selectionner
        $res2 = mysqli_query($conn, $sql2);

        $row2 = mysqli_fetch_assoc($res2); // prenez tous les val recues de la req 

        $title = $row2['title'];
        $description = $row2['description'];
        $price = $row2['price'];
        $current_image = $row2['image_name'];
        $current_category = $row2['category_id'];
        $featured = $row2['featured'];
        $active = $row2['active'];

    } else {
        header('location:'.SITEURL.'admin/manage-food.php');
    }
            
            
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        
        <br><br>
        
        <?php

            
        ?>
        <br><br>
        
        <form action="" method="POST" enctype="multipart/form-data">
            
            <table class="tbl-30">
                
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" value="<?= $title; ?>">
                    </td>
                </tr>
                
                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5" ><?= $description; ?></textarea>
                    </td>
                </tr>
                
                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price" value="<?= $price; ?>" >
                    </td>
                </tr>
                
                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php
                            if($current_image == "") {
                                // img not Available
                                echo "<div class='error'>Image not Available.</div>";
                            } else {
	                            // img Available
                                ?>
                                <img src="<?= SITEURL; ?>images/food/<?= $current_image; ?>" alt="<?= $title; ?>" width="150px">
                                <?php
                            }

                         
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Select New Image: </td>
                    <td>
                        <input type="file" name="image" >
                    </td>
                </tr>
                
                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">
                            
                            <?php
                            // Query to get active categories
                            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                            $res = mysqli_query($conn, $sql);

                            $count = mysqli_num_rows($res);

                            if($count > 0) {
                                while($rows = mysqli_fetch_assoc($res)) {
                                    $category_title = $rows['title'];
                                    $category_id = $rows['id'];

                                    
                                    ?>
                            <option <?php if($current_category == $category_id) {echo "selected";} ?> value="<?php echo $category_id; ?>"> <?= $category_title; ?> </option>
                                    <?php
                                }
                            } else {
	                            // pas de category
                                echo "<option value='0'>Category Not Available.</option>";
                            }

                            
                            ?>
                            
                        </select>
                    </td>
                </tr>
                
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input <?php if($featured == "Yes") {echo "checked";} ?> type="radio" name="featured" value="Yes"> Yes
                        <input <?php if($featured == "No") {echo "checked";} ?> type="radio" name="featured" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if($active == "Yes") {echo "checked";} ?> type="radio" name="active" value="Yes"> Yes
                        <input <?php if($active == "No") {echo "checked";} ?> type="radio" name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="hidden" name="id" value="<?= $id; ?>">
                        <input type="hidden" name="current_image" value="<?= $current_image; ?>">
                        <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                    </td>
                </tr>
                
            </table>
            
        </form>
        
        <?php
            
            if(isset($_POST['submit'])) {
                
                // get all details from the Form
                $id = $_POST['id'];
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $current_image = $_POST['current_image'];
                $category = $_POST['category'];
                
                $featured = $_POST['featured'];
                $active = $_POST['active'];
                
                // upload the img if selected
                if($_FILES['image']['name']){
                    
                    $image_name = $_FILES['image']['name'];

                    if($image_name != "") { // if img available 
                        //A. Uploading New Image
                        $ext = end(explode('.', $image_name)); // get the extension of image_name
                        $image_name = "Food-Name-".rand(0000, 9999).'.'.$ext; // rename img
                        
                        $src_path = $_FILES['image']['tmp_name'];
                        $dest_path = "../images/food/".$image_name;
                        
                        $upload = move_uploaded_file($src_path, $dest_path);
                        
                        if($upload == false) {
                            // Failed to upload
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload New Image.</div>"; 
                            header('location:'.SITEURL.'admin/manage-food.php');
                            die();
                        }
                        
                        // Remove img if new img uploaded
                        
                        //B. Remove current Img if Available
                        if($current_image !=""){
                            // current Img
                            $remove_path = "../images/food/".$current_image;

                            $remove = unlink($remove_path);
                            
                            if($remove == false) {
                                // Failed to upload
                                $_SESSION['remove-failed'] = "<div class='error'>Failed to Remove Current Image.</div>"; 
                                header('location:'.SITEURL.'admin/manage-food.php');
                                die();
                            }
                        
                        }
                        
                    } else {
                        $image_name = $current_image; // img par defaut si une img n'est pas selectionnee
                    }
                    
                } else {
                    $image_name = $current_image; // img par defaut si le btn n'est pas cliquer
                }
                
                // update food inDB
                $sql3 = "UPDATE tbl_food SET
                         title = '$title',
                         description = '$description',
                         price = '$price',
                         image_name = '$image_name',
                         category_id = '$category',
                         featured = '$featured',
                         active = '$active'
                         WHERE id=$id";

                $res3 = mysqli_query($conn, $sql3);

                if($res3 == true){ // if query executed and food Updated
                    $_SESSION['update'] = "<div class='success'>Food Updated Successfully</div>"; 
                    header('location:'.SITEURL.'admin/manage-food.php');
                } else {
	                $_SESSION['remove-failed'] = "<div class='error'>Failed to Update Food.</div>"; 
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                
                // redirect to manage food with session msg
            }
        ?>
        
    </div>
</div>

<?php include 'partials/footer.php'; ?>