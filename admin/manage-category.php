<?php include 'partials/menu.php'; ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage Category</h1>
        
        <br><br>
        
        <?php

            if (isset($_SESSION['add'])) {
	            echo $_SESSION['add'];
                unset($_SESSION['add']);
            }

            if (isset($_SESSION['remove'])) {
	            echo $_SESSION['remove'];
                unset($_SESSION['remove']);
            }
            
            if (isset($_SESSION['delete'])) {
	            echo $_SESSION['delete'];
                unset($_SESSION['delete']);
            }
            
            if (isset($_SESSION['no-category-found'])) {
	            echo $_SESSION['no-category-found'];
                unset($_SESSION['no-category-found']);
            }
            
            if (isset($_SESSION['update'])) {
	            echo $_SESSION['update'];
                unset($_SESSION['update']);
            }
            
            if (isset($_SESSION['upload'])) {
	            echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }

        ?>
        <br><br>
                
                <!-- Button to Add Category    -->
                <a href="<?php echo SITEURL; ?>admin/add-category.php" class="btn-primary">Add Category</a>
                
                <br /><br />
                
                <table class="tbl-full">
                    <tr>
                        <th>S.N</th>
                        <th>Title</th>
                        <th>Image</th>
                        <th>Featured</th>
                        <th>Active</th>
                        <th>Actions</th>
                    </tr>

                    <?php
                    // Query to get all Categories in DB
                    $sql = "SELECT * FROM tbl_category";

                    // Execution
                    $res = mysqli_query($conn, $sql);

                    // count rows
                    $count = mysqli_num_rows($res);

                    $sn = 1; // pour enumerer les Categories dans la table

                    if ($count > 0) { // on a des donnees dans la DB
	                    // Get the data and display
                        while($rows = mysqli_fetch_assoc($res)) {
                            $id = $rows['id'];
                            $title = $rows['title'];
                            $image_name = $rows['image_name'];
                            $featured = $rows['featured'];
                            $active = $rows['active'];

                    ?>
                    
                    <tr>
                        <td><?php echo $sn++; ?></td>
                        <td><?php echo $title; ?></td>
                        <td>
                            <?php 
                                if ($image_name != "") {

	                                // afficher l'img
                                    ?>
                                    <img src="<?php echo SITEURL; ?>Images/category/<?php echo $image_name; ?>" width="100px" >
                                    <?php

                                } else {
	                                echo "<div class='error' >No Image not Added.</div>";
                                }

                            ?>
                        </td>
                        <td><?php echo $featured; ?></td>
                        <td><?php echo $active ?></td>
                        <td>
                            <a href="<?php echo SITEURL; ?>admin/update-category.php?id=<?php echo $id; ?>" class="btn-secondary">Update Category</a>
                            <a href="<?php echo SITEURL; ?>admin/delete-category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Delate Category</a>
                        </td>
                    </tr>
                    

                    <?php
                        }

                    } else {
	                    // afficher le msg suivant dans la table>
                    ?>

                    <tr>
                        <td colspan="6"><div class="error" >No Categry Added.</div></td>
                    </tr>
                    
                    <?php

                    }

                    ?>

                </table>
        
    </div>
</div>



<?php include 'partials/footer.php'; ?>
