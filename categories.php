<?php include_once 'partials-front/menu.php'; ?>



    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <h2 class="text-center">Explore Categories</h2>
        <div class="container orange">
            
            <?php
            
            // Display all categories
            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
            
            $res = mysqli_query($conn, $sql);
            
            $count = mysqli_num_rows($res);
            
            if($count > 0) {
                
                while($rows = mysqli_fetch_assoc($res)) {
                    // get the values
                    $id = $rows['id'];
                    $title = $rows['title'];
                    $image_name = $rows['image_name'];
                ?>

                
            <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>">
                <div class="box-4 float-container">

                    <?php
                        if($image_name == ""){
                            echo "<div class='error'>Category not found.</div>";
                        } else {
                            // img available
                        ?>

                    <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="Pizza" class="img-responsive img-curve">

                            <?php
                        }

                    ?>

                    <h3 class="float-text text-black"><?php echo $title; ?></h3>
                </div>
            </a>


                <?php

                }
            } else {
                
                echo "<div class='error'>Category not found.</div>";
            }
            
            ?>
            
            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->

<?php include 'partials-front/footer.php'; ?>
