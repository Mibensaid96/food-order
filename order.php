<?php 
include_once 'partials-front/menu.php'; 

require 'config/functions.php'; // pr calculateTotalCart()

if (isset($_POST['add_to_order'])) { // si l'utilisateur avait bien cliquer sur le btn add_to_cart
    
    if (isset($_SESSION['order'])) { // s'il ya deja un produit dans la carte de commande

        // On recupere tous les ids des items ajoutes pr verifier si le nouveau item n'est pas deja ajoutE
        $products_array_ids = array_column($_SESSION['order'],"product_id"); 


        if (!in_array($_POST['product_id'], $products_array_ids)) { // Si le produit n'est pas encore ajoutE
    
            // Ajouter l'item
            $product_id = $_POST['product_id'];

            $product_array = array(
                'product_id'=>$product_id,
                'product_name'=>$_POST['product_name'],
                'product_price'=>$_POST['product_price'],
                'subtotal'=>$_POST['product_price'],
                'product_image'=>$_POST['product_image'],
                //'product_special_offer'=>$_POST['product_special_offer'],
                'product_quantity'=>$_POST['product_quantity']
            );
            
            
            // Calculer sous total de l'item
            $product_array['subtotal'] = calculateTotalItem($product_array['product_quantity'], $product_array['product_price']);
            
            $_SESSION['order'][$product_id] = $product_array;
            
            // Calcul du total de la carte 
            calculateTotalCart();


        } else {
            echo "<script>alert('product has already been added to cart')</script>";
        }


    } else { // Si c'est le 1er produit a ajouter 
            // Ajouter l'item
            $product_id = $_POST['product_id']; 

            $product_array = array(
                'product_id'=>$product_id,
                'product_name'=>$_POST['product_name'],
                'product_price'=>$_POST['product_price'],
                'subtotal'=>$_POST['product_price'],
                'product_image'=>$_POST['product_image'],
                //'product_special_offer'=>$_POST['product_special_offer'],
                'product_quantity'=>$_POST['product_quantity']
            );
            
            // Calculer sous total de l'item
            $product_array['subtotal'] = calculateTotalItem($product_array['product_quantity'], $product_array['product_price']);
            
            $_SESSION['order'][$product_id] = $product_array;

            // Calcul du total de la carte 
            calculateTotalCart();
    }

} elseif (isset($_POST['remove_btn'])) { // suppression de l'item si l'on clique sur le btn remove
    
    $product_id = $_POST['product_id'];
    unset($_SESSION['order'][$product_id]);

    // Calculer total cart
    calculateTotalCart();

} elseif (isset($_POST['decrease_quantity_btn'])) { // modfication de la quantite de l'item 
    
    $product_id = $_POST['product_id'];
    $product_quantity = $_POST['product_quantity']; // quantite definie par l'utilisateur

    $product = $_SESSION['order'][$product_id];

    $product['product_quantity'] = $product_quantity - 1;
    
//    $_SESSION['order'][$product_id] = $product; // assigner la nvlle qutite dans la session  
    
    if ($product['product_quantity'] <= 0) { // si la quantite est < 1 on retitre l'item
        $product_id = $_POST['product_id'];
        unset($_SESSION['order'][$product_id]); 
    } else {
        
        // Calculer sous total de l'item
        $product['subtotal'] = calculateTotalItem($product['product_quantity'], $product['product_price']);
        
        $_SESSION['order'][$product_id] = $product; // assigner la nvlle qutite dans la session  
        
    }
    
    // Calculer total cart
    calculateTotalCart();

}elseif (isset($_POST['increase_quantity_btn'])) { // modfication de la quantite de l'item 
    
    $product_id = $_POST['product_id'];
    $product_quantity = $_POST['product_quantity']; // quantite definie par l'utilisateur

    $product = $_SESSION['order'][$product_id];

    $product['product_quantity'] = $product_quantity + 1;
    
    if ($product['product_quantity'] <= 0) {
        $product_id = $_POST['product_id'];
        unset($_SESSION['order'][$product_id]); 
    } else {
        // Calculer sous total de l'item
        $product['subtotal'] = calculateTotalItem($product['product_quantity'], $product['product_price']);
        // debug($product['subtotal']);
        $_SESSION['order'][$product_id] = $product; // assigner la nvlle qutite dans la session  
    }

    // Calculer total cart
    calculateTotalCart();


} elseif(isset($_POST['checkout'])){ // APRES VALIDATION DE LA FORMULAIRE
        
        $username = $_POST['username'];
        
        $order_date = date("Y-m-d h:i:sa");
        
        foreach($_SESSION['order'] as $id=>$product) {
            $product = $_SESSION['order'][$id];
            $product_id = $product['product_id'];
            $product_name = $product['product_name'];
            $product_image = $product['product_image'];
            $product_price = $product['product_price'];
            $product_quantity = $product['product_quantity'];
            //$total = $product_price * $product_quantity;
            
            /* Insert details order into order_items */
            
            // Inserer tous les datas dans order_items
            // utiliser prepare() et bind_param() user-login.php ligne 16 et 18
                    
            $sql1 = $conn->prepare("INSERT INTO order_items 
                    (product_id, product_name, product_image, product_price, product_quantity, user_name, order_date)
                    VALUES (?,?,?,?,?,?,?)
                    ");
            $sql1->bind_param("issiiss", $product_id,$product_name,$product_image,$product_price,$product_quantity,$username,$order_date);
            
            $res1 = $sql1->execute();
            debug($res1);
        }
        
        if($res1 == true){ // $res2 == true && $res3 == true
            // order saved
            $_SESSION['order'] = "<div class='success text-center'>Food Ordered Successfully.</div>";
            header('location:user/user-checkout.php');
        } else {
            $_SESSION['order'] = "<div class='error text-center'>Failed to Order Food.</div>";
            header('location:'.SITEURL);
        }
           
            
     } else {
     // Redirect to home page
     $_SESSION['error'] = "echec de la condition sur 1er btn checkout :" . debug($_POST['checkout']);
     header('location: http://localhost:8090/fo/foods.php');
 }


?>


 </div>

    <!-- fOOD SEARCH Section Starts Here --> 
    <section class="food-search">
    <div class="container">
        <h2 class="text-center text-white">Your Order</h2>
        <div class="container2">
            
            <div class="col-75">
                
                <div class="col-25 ">
                
                    <h3 class="text-white">Cart :</h3>
                
                    <?php if (isset($_SESSION['order'])) { ?>
                        <?php foreach($_SESSION['order'] as $key => $value) { 
                                // debug($value);
                    ?>
                    <div class="container2 ">
                    
                    <div class="col-75 food-add container2 transbox1">

                        <div class="col-60 food-order-img ">

                            <?php 

                            if($value['product_image'] == ""){
                                // Img not available
                                echo "<div class='error'>Image not available.</div>";
                            } else {
                                // Img available
                            ?>
                                <br>
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $value['product_image']; ?>" alt="<?php echo $title; ?>" class="img-responsive img-curve">
                                
                                <input type="hidden" name="product_image" value="<?php echo $value['product_image']; ?>">
                            <?php
                            }
                            ?>

                        </div> 

                        <div class="col-40 food-order-desc "> <!-- class="" -->

                            <form action="user/user-checkout.php" method="POST" id="checkoutForm" class=""> <!-- class="order" -->

                                <h3 class="text-white"><?php echo $value['product_name']; ?></h3>
                                <input type="hidden" name="food" value="<?php echo $value['product_name']; ?>">

                                <p class="food-price text-white">$<?php echo $value['product_price']; ?></p>
                                <input type="hidden" name="price" value="<?php echo $value['product_price']; ?>">

                                <input type="hidden" name="username" value="<?php if(isset($_SESSION['auth'])) {echo $_SESSION['auth']['username'];} ?>">
                                
                            </form>         
                            
                            <!--  Quantity-->
                            <form action="order.php" method="POST">
                                 
                                 <input type="submit" value="+" class="edit-btn" name="increase_quantity_btn">
                                 <input type="text" readonly name="product_quantity" value="<?php echo $value['product_quantity']; ?>" >
                                 <input type="hidden" name="product_id" value="<?php echo $value['product_id']; ?>">
                                <input type="submit" value="-" class="edit-btn" name="decrease_quantity_btn">
                            </form>
                            
                            <!--  Remove item-->
                            <form action="order.php" method="POST"> 
                               <input type="hidden" name="product_id" value="<?php echo $value['product_id']; ?>">
                               
                               <input type="submit" name="remove_btn" class="btn" id="" value="remove">
                            </form>  

                        </div>
                        
                        </div>
                        <div class="col-25">
                            <br>
                            <h4 class="text-white">Subtotal:</h4>
                            <p class="text-white">
                                $<?php 
                                echo $value['subtotal'];
                                /*if (isset($_SESSION['order'])) {
                                    echo "$".$_SESSION['total'];
                                } */
                                ?>
                            </p>
                            
                        </div>
                        
                </div>
                <?php } ?>

                <?php } ?>

                    


                </div>
                
                <!--  Checkout-->
                <div class="container">
                    <button type="submit" form="checkoutForm" class="btn checkout-btn" value="Checkout" name="checkout">Checkout</button>
                </div>
                <div class="container">
                  <a href="foods.php">
                    <button class="btn checkout-btn" >Return to the menu</button>
                  </a> 
                </div>
                
            
        </div>
        <div class="">
                <p class=""></p>
            </div>
        </div>
    </div>
</section>
    <!-- fOOD sEARCH Section Ends Here -->


<?php
    
 /*
            = '$food',
                      = '$product_image',
                      = '$price',
                      = '$qty',
                     order_date = '$order_date',
                      = '$username',
                     product_id = 'product_id',
                     order_id = 'order_id'
                     
            */
            
            // donnes supplementaires provenant d'autres table de DB: order_id, order_date, product_id
                    
            // selectionner les id dans tbl_food pour chque item commandé 
            /*"SELECT id AS product_id 
            FROM tbl_food 
                INNER JOIN order_items ON order_items.product_id = tbl_food.id
            WHERE title = $food";
                    */
            // faire une union de req pour selectionner les datas dans les 2 tables
            /*"FROM Animal
                        INNER JOIN tbl_food ON Animal.race_id = Race.id
                        INNER JOIN Espece ON Race.espece_id = Espece.id";
                    */
            /*$sql1 = "SELECT (order_id, order_date, id AS product_id)
                    FROM tbl_order 
                            
                    WHERE order_id = $order_id AND title = $food";*/
//            $res1 = mysqli_query($conn, $sql1);
            
            
                /*$stmt1 = $conn->prepare("INSERT INTO order_items (order_id, product_id,product_name,product_image,product_price,product_quantity,user_name,order_date)
                                        VALUES (?,?,?,?,?,?,?,?)");
                $stmt1->bind_param("iissiiss",$order_id,$product_id,$product_name,$product_image,$product_price,$product_quantity,$name,$order_date);
                $stmt1->execute();*/
        
            /*
            // get all details from the form
            $food = $_POST['food']; // peut-etre un arr de plusieurs items
            $product_image = $_POST['product_image'];
            $price = $_POST['price'];
            $qty = $_POST['qty'];
            $total = $price * $qty;
            $order_date = date("Y-m-d h:i:sa");

            
            $status = "ordered"; // Ordered, On Delivery, Delivered, Cancelled

            $username = $_POST['username'];
                    
            // order_id de la cmd en cours
            $order_id = $_SESSION['order_id'];
                    */ 
            // SQL to save the data
            /*$sql2 = "INSERT INTO tbl_order SET
                     order_cost = '$total',
                     order_date = '$order_date',
                     order_status = '$status',
                     user_name = '$customer_name',
                     user_phone = '$customer_contact',
                     user_email = '$customer_email',
                     user_city = '$customer_address',
                     user_id = '$customer_id'
                     ";
            $res2 = mysqli_query($conn, $sql2);
            */
    ?>
            
    <?php include 'partials-front/footer.php'; ?>