<?php include 'partials/menu.php'; ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>
        
        <br><br>
        
        <?php

            if (isset($_SESSION['upload'])) {
	            echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
            
            
        ?>
        <br><br>
        
        <form action="" method="POST" enctype="multipart/form-data">
            
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Title of the Food">
                    </td>
                </tr>
                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Description of the Food"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price" >
                    </td>
                </tr>
                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image" >
                    </td>
                </tr>
                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">
                            
                            <?php
                                // code to display categories from DB
                            
                                // SQL query to get all active categories 
                                $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                            
                                $res = mysqli_query($conn, $sql);

                                // count rows pour checker s'il ya des categories 
                                $count = mysqli_num_rows($res);

                                if($count > 0){

                                    while($row = mysqli_fetch_assoc($res)) {

                                        // get details of categories
                                        $id = $row['id'];
                                        $title = $row['title'];

                                        ?>

                                    <option value="<?php echo $id; ?>"><?php echo $title; ?></option>

                                    <?php
                                    }

                                } else {

                                    ?>

                                    <option value="0">No Category Found</option>

                                    <?php
                                }
                            
                                // Display on Dropdown
                            
                            ?>
                            
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes" > Yes
                        <input type="radio" name="featured" value="No" > No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes" > Yes
                        <input type="radio" name="active" value="No" > No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>
                
            </table>
            
        </form>

        <?php

            if(isset($_POST['submit'])){ // si le btn submit est cliquer Ajouter l'item dans DB

                // get the data from form
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $category = $_POST['category'];

                // checker si les btn radio featured and active sont selectionnes
                if (isset($_POST['featured'])) {
	                $featured = $_POST['featured'];
                } else {
	                $featured = "No";
                }

                if (isset($_POST['active'])) {
	                $active = $_POST['active'];
                } else {
	                $active = "No";
                }

                print_r($_FILES['image']);
                
                // upload the img if selected
                if(isset($_FILES['image']['name'])) {

                    // get details of the selected img
                    $image_name = $_FILES['image']['name'];

                    if($image_name !=""){// if img selected
                        //A. Rename img
                        $ext = end(explode('.', $image_name)); // get extension of img. 
                                                               // end() set the internal pointer of array to its last element
                        
                        $image_name = "Food-Name-".rand(0000,9999).'.'.$ext; // new name for the img

                        //B upload img
                        $src = $_FILES['image']['tmp_name']; // get the src path and destination 
                                                             // src path = the current location of the img
                        $dst = "../images/food/".$image_name; // destination path for the img to be uploaded

                        $upload = move_uploaded_file($src, $dst); // upload food img

                        if($upload == false) { // si l'img n'est pas charger
                            // Redirect to upload to Add Food Page with Error msg
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
                            header('location:'.SITEURL.'admin/add-food.php');
                            // Stop the process
                            die();
                        }
                    }
                } else {
	                $image_name = ""; // setting default value as blank
                }

                // insert into DB
                // query to save or add food
                $sql2 = "INSERT INTO tbl_food SET
                         title = '$title',
                         description = '$description',
                         price = $price,
                         image_name = '$image_name',
                         category_id = $category,
                         featured = '$featured',
                         active = '$active'";   // pour les val numeriques on a pas a les mettre entre '' 
                                                // mais les string c'est necessaire pour qu'ils soient reconnus comme str

                $res2 = mysqli_query($conn, $sql2);
                
                // Redirect with msg to Manage Food page

                if($res2 == true){ // si la req est bien executee
                    $_SESSION['add'] = "<div class='success'>Food Added successfully.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                } else {
                    $_SESSION['add'] = "<div class='error'>Failed to Add Food.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }

            }

        ?>
        
    </div>
</div>


<?php include 'partials/footer.php'; ?>