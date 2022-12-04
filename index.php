<?php include_once 'partials-front/menu.php'; ?>
    
    
    <!-- fOOD SEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container search-container">
            
            <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Food.." required>
                <input type="submit" id="submit" name="submit" value="Search" class="btn btn-primary">
            </form>
            
        </div> 
    </section>
    <!-- fOOD SEARCH Section Ends Here -->


    <?php 
        if(isset($_SESSION['order'])){
            echo $_SESSION['order'];
            unset($_SESSION['order']);
        }
        require_once 'config/functions.php';
//        debug($_SESSION['auth']);
    ?>
    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div id="" class="container orange">
            <h2 class="text-center">Explore Foods</h2>
            
            <?php
                // Query to display Categories
                $sql = "SELECT * FROM tbl_category WHERE active='Yes' AND featured='Yes' LIMIT 3";

                $res = mysqli_query($conn, $sql);

                // check whether Category is available
                $count = mysqli_num_rows($res);
            
                if($count > 0) {
                    // get values : id, title, image_name
                    while($row = mysqli_fetch_assoc($res)) {
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];
            ?>
            
            
                    
            <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>" class="link-container">
            <div id="div-cat" class="box-3 float-container">
                <?php
                    if($image_name == "") { // if img not available

                        echo "<div class='error'>Category not Added.</div>";

                    } else {
                        // display img
                        ?>

                <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="Pizza" class="img-responsive img-curve">

                        <?php
                    }
                ?>

                <h3 class="float-text alignement"><?php echo $title; ?></h3>
            </div>
            </a>

                    <?php
                    }
                } else {
                    // 
                    echo "<div class='error'>Category not Added.</div>";
                }
            
            ?>


            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->

    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>
            
            <?php
            
            // get foods from DB that are active and featured
            $sql2 = "SELECT * FROM tbl_food WHERE active='Yes' AND featured='Yes' LIMIT 6"; 
            // featured pour les item a afficher a l'accueil 
            // et active pour ceux qui seront afficher dans food.php
            
            
            $res2 = mysqli_query($conn, $sql2);
            
            // count rows
            $count2 = mysqli_num_rows($res2);

            if ($count2 > 0) {
	            // get all values
                while($row2 = mysqli_fetch_assoc($res2)){
                    $id = $row2['id'];
                    $title = $row2['title'];
                    $price = $row2['price'];
                    $image_name = $row2['image_name'];
                    $description = $row2['description'];
                
            ?>
            
            <div class="food-menu-box">
                <div class="food-menu-img">

                <?php
                    if($image_name == "") {

                        echo "<div class='error'>Image not available.</div>";
                    } else {

                        // img available
                        ?>

                    <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">

                        <?php
                    }

                ?>
                </div>

                <div class="food-menu-desc">
                    <h4><?php echo $title; ?></h4>
                        <p class="food-price">$<?php echo $price; ?></p>
                        <p class="food-detail">
                            <?php echo $description; ?>
                        </p>
                        <br>
                        
                            <form method="POST" action="order.php">
                                <input type="hidden" name="product_id" value="<?php echo $id; ?>"/>
                                <input type="hidden" name="product_name" value="<?php echo $title; ?>"/>
                                <input type="hidden" name="product_price" value="<?php echo $price; ?>">
                                <!-- <input type="hidden" name="product_special_offer" value="<?php echo $product['product_special_offer']; ?>"/> -->
                                <input type="hidden" name="product_image" value="<?php echo $image_name; ?>"/>
                                <input type="hidden" name="product_quantity" value="1"/>
                                <button type="submit" name="add_to_order"  class="btn btn-primary">
                                    Order Now                    
                                </button>
                            </form>
                </div>
            </div>

            <?php

                }
                
            } else {
                echo "<div class='error'>Food not available.</div>";
            }

            
            ?>


            <div class="clearfix"></div>

            

        </div>

        <p class="text-center">
            <a id="Mylink" href="<?php echo SITEURL; ?>foods.php">See All Foods</a>
        </p>
    </section>
    <!-- fOOD Menu Section Ends Here -->

<?php include 'partials-front/footer.php'; ?>
