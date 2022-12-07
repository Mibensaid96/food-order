<?php include_once 'partials-front/menu.php'; ?>

<?php 

if (isset($_GET['category_id'])) { 
    // if category_id is set get the id
	$category_id = $_GET['category_id'];
    
    // get category title based on category_id
    $sql = "SELECT title FROM tbl_category WHERE id=$category_id";

    $res = mysqli_query($conn, $sql);
    
    // get values from DB
    $row = mysqli_fetch_assoc($res);
    
    $category_title = $row['title'];
    
} else {
	//Redirect to Home page
    header('location:'.SITEURL); 
}


 ?>


    <!-- fOOD SEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <h2>Foods on <a href="#" class="text-white">"<?php echo $category_title; ?>"</a></h2>

        </div>
    </section>
    <!-- fOOD SEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php 
            
            // query to get foods based on Selected category
            $sql2 = "SELECT * FROM tbl_food WHERE category_id=$category_id";

            $res2 = mysqli_query($conn, $sql2);

            $count2 = mysqli_num_rows($res2);

            if($count2 > 0){
                //
                while($row2 = mysqli_fetch_assoc($res2)){
                    $id = $row2['id'];
                    $title = $row2['title'];
                    $price = $row2['price'];
                    $description = $row2['description'];
                    $image_name = $row2['image_name'];
                ?>

            <div class="food-menu-box">
                <div class="food-menu-img">
                <?php 
                
                if($image_name == ""){
                    // display msg
                    echo "<div class='error'>Image not Available.</div>";
                } else {
	                
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
                // display msg
                echo "<div class='error'>Food not Available.</div>";
            }
            
            ?>
            

            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

    <?php include 'partials-front/footer.php'; ?>
