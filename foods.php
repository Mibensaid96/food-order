<?php include_once 'partials-front/menu.php'; ?>


    <!-- fOOD SEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Food.." required>
                <input type="submit" id="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
    </section>
    <!-- fOOD SEARCH Section Ends Here -->

    <?php 
        if(isset($_SESSION['error'])){
            echo $_SESSION['error'];
            unset($_SESSION['error']);
        }
        require_once 'config/functions.php';
//        debug($_SESSION['auth']);
    ?>

    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php
                // Display foods that are active
                $sql = "SELECT * FROM tbl_food WHERE active='Yes'";

                $res = mysqli_query($conn, $sql);

                $count = mysqli_num_rows($res);

                if($count > 0) {
                    //
                    while($rows = mysqli_fetch_assoc($res)) {
                        // get values
                        $id = $rows['id'];
                        $title = $rows['title'];
                        $description = $rows['description'];
                        $price = $rows['price'];
                        $image_name = $rows['image_name'];
                    ?>

                    
            <div class="food-menu-box">
                <div class="food-menu-img">

                <?php 
                    if($image_name == "") {

                        echo "<div class='error'>Image not Available.</div>";

                    } else {
                        // Img Available
                        ?>

                    <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="<?php echo $title; ?>" class="img-responsive img-curve">

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
                        <button type="submit" name="add_to_order"  class="btn btn-primary">Order Now</button>
                    </form>
                </div>
            </div>

                    <?php

                    }
                } else {
                    // 
                    echo "<div class='error'>Food not found.</div>";
                }

            ?>

            

            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

    <?php include 'partials-front/footer.php'; ?>
